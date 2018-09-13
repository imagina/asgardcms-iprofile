<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Mockery\CountValidator\Exception;
use Modules\Fhia\Http\Requests\FhiaRequest;

use Illuminate\Contracts\Foundation\Application;
use Modules\Iprofile\Repositories\DepartmentRepository;
use Modules\Iprofile\Http\Controllers\BaseApiController;
use Modules\User\Entities\Sentinel\User;
use Modules\Iprofile\Transformers\DepartmentTransformer;
use Modules\Fhia\Events\DepartmentBroadcastingEvent;
use Illuminate\Http\Request;
use Log;


class ApiDepartmentsController extends BaseApiController
{
  /**
   * @var Application
   */
  private $app;
  private $department;

  public function __construct(
    Application $app,
    DepartmentRepository $department)
  {

    $this->app = $app;
    $this->department = $department;
  }

  /** INDEX
   * @param Request $request
   *  URL GET:
   * &filter = type object {
   *      settings: type string,
   *      user_id: type number
   *  }
   *  $take = type number
   *  &page = type number
   *  &fields = type string
   *  &include = type string
   */
  public function index(Request $request)
  {
    $user = \Auth::user();

    try {
      //Get Parameters from URL.
      $params = $this->parametersUrl(false, false, ["status" => [1]], []);
      //Request to Repository
      $departments = $this->department->index(
        $params->page, $params->take,
        $params->filter, $params->include,
        $params->fields
      );

      $response = [
        "data" => DepartmentTransformer::collection($departments)
      ];


      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($departments)] : false;

    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response, $status ?? 200);
  }

  /** SHOW
   * @param Request $request
   *  URL GET:
   * &filter = type object {
   *      settings: type string,
   *      user_id: type number
   *  }
   *  $take = type number
   *  &page = type number
   *  &fields = type string
   *  &include = type string
   */
  public function show($id, Request $request)
  {
    $status = 200;
    $user = \Auth::user();
    //$user = User::find(1);
    try {
      //Get Parameters from URL.
      $params = $this->parametersUrl(false, false, [], []);

      //Request to Repository
      $department = $this->department->show($params->filter, $params->include, $params->fields, $id);

      $response = [
        "data" => new DepartmentTransformer($department),
      ];

    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response, $status);
  }


  /** UPDATE
   * @param Request $request
   * URL POST:
   * id           : type number,
   *   attributes : type object {
   *      settings : type object {
   *          type   : type string,
   *          pos    : type string,
   *          filter : type array | null
   *      }
   *      title : type string,
   *   }
   */
  public function update(Request $request)
  {
    $status = 200;
    try {
      $defaultAssignments = config("asgard.fhia.config.department_settings");
      $data = $request->all();
      $attributes = $data["attributes"];
      $department = $this->department->find($data["id"]);

      // si existe el parametro settings como parametro en los atributos
      if (isset($attributes["settings"])) {
        $settings = $attributes["settings"];

        //se buscan los settings que tiene el departamento guardados
        $departmentSettings = $department->settings;

        //si el parametro filter viene null significa que debe borrarse ese setting del departamento
        $deleteSetting = false;
        if ($settings["filter"] == null)
          $deleteSetting = true;

        /* Se crea el assigment segun el default y luego se limpia el setting del default
         * y se añade el nuevo setting que trae el data en la posicion que pertenece*/
        $assignment = [];
        $assignment[$settings["type"]] = $defaultAssignments[$settings["type"]];
        $assignment[$settings["type"]] ["fields"] = [];
        $assignment[$settings["type"]]["fields"][strval($settings["pos"])] = $settings["filter"];

        // si no esta vacio entonces revisa segun el grupo el campo a modificar
        if (!empty($departmentSettings)) {
          $band = 0;
          foreach ($assignment as $key => $groups)
            if (isset($departmentSettings[$key])) {
              // IF no es para eliminar el setting en la consulta entonces se hace el update
              // ELSE se elimina el field del nuevo $departmentSettings
              if (!$deleteSetting) {
                $band = 1;
                $departmentSettings[$key]["fields"][strval($settings["pos"])] = $assignment[$key]["fields"][$settings["pos"]];
              } else {
                if ($settings["pos"] != "default")
                  array_splice($departmentSettings[$key]["fields"], strval($settings["pos"]), 1);
                else
                  if (isset($departmentSettings[$key]["fields"]["default"]))
                    unset($departmentSettings[$key]["fields"]["default"]);
              }
            }
          // si nunca se ha guardado el filtro en el departamento se crea desde la cabecera $key
          if (!$band && !$deleteSetting)
            $departmentSettings[$key] = $assignment[$key];

        } else /* si nunca se han guardado assignments se guarda el nuevo $assingment*/
          if (!$deleteSetting) //solo si no sea un caso de borrado de setting
            $departmentSettings = $assignment;

        // se actualiza el atributo settings en la entidad
        $department->settings = $departmentSettings;
      }

      // si existe el parametro title se actualiza en la entidad
      if (isset($attributes["title"]))
        $department->title = $attributes["title"];

      // UPDATE DEPARTMENT
      $department->save();

      event(new DepartmentBroadcastingEvent($department));
      $response = "";

    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response, $status);

  }

  public function getSettings(Request $request)
  {

    $status = 200;
    try {
      $data = $request->all();
      $department = $this->department->find($data["id"]);

      $settings = explode(",", $data["settings"]);
      $departmentsResult = [];

      $defaultSettings = config("asgard.fhia.config.department_settings");

      //if there are settings filter, the defaultSettings are reformulated
      $defaultSettings = [];
      foreach ($settings as $setting)
        $defaultSettings[$setting] = config("asgard.fhia.config.department_settings." . $setting);


      // if the department already has settings, Merge is made with the defaultSettings
      if ($department->settings) {
        $departmentSettings = $department->settings;
        foreach ($defaultSettings as $key => $setting)
          $defaultSettings[$key]["fields"] = array_replace($setting["fields"], $departmentSettings[$key]["fields"]);

      }
      $department->settings = $defaultSettings;

      $response = [
        "data" => new DepartmentTransformer($department),
      ];

    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response, $status);

  }

  /** DELETE
   * @param $id department
   *
   */
  public function delete($id, Request $request)
  {
    $status = 200;
    $user = \Auth::user();
    try {
      if ($user->hasAccess('fhia.departments.destroy')) {
        $department = $this->department->find($id);
        $department->delete();
        event(new DepartmentBroadcastingEvent(''));
        $response = ["data" => ""];
      } else {
        $response = ["error" => "Permission Denied"];
        $status = 401;
      }
    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response, $status ?? 200);

  }

  /** CREATE
   * @param $request
   *
   */
  public function create(Request $request)
  {
    $status = 200;
    $user = \Auth::user();
    try {
      if ($user->hasAccess('fhia.departments.create')) {
        $data = $request->all();
        $attributes = $data["attributes"];
        $department = $this->department->create($attributes);
        event(new DepartmentBroadcastingEvent($department));
        $response = ["data" => ""];
      } else {
        $response = ["error" => "Permission Denied"];
        $status = 401;
      }
    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response, $status ?? 200);

  }

}