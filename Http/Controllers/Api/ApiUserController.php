<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Mockery\CountValidator\Exception;
use Modules\Fhia\Http\Requests\FhiaRequest;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iprofile\Http\Controllers\BaseApiController;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;
use Modules\Iprofile\Repositories\ApiUserRepository;
use Modules\User\Entities\Sentinel\User;
use Modules\Iprofile\Transformers\ApiUserTransformer;
use Illuminate\Http\Request;
use Modules\User\Events\UserEvent;
use Log;


class ApiUserController extends BaseApiController
{
  /**
   * @var Application
   */
  private $app;
  private $user;
  private $role;
  private $userApi;

  public function __construct(
    Application $app,
    RoleRepository $role,
    ApiUserRepository $userApi,
    UserRepository $user)
  {

    $this->app = $app;
    $this->user = $user;
    $this->role = $role;
    $this->userApi = $userApi;
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
    try {
      //Get Parameters from URL.
      $params = $this->parametersUrl(false, false, [], []);

      //Request to Repository
      $users = $this->userApi->index(
        $params->page, $params->take,
        $params->filter, $params->include,
        $params->fields
      );

      $response = [
        "data" => ApiUserTransformer::collection($users),
      ];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($users)] : false;

    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }

  /**
   *  USER SHOW
   *
   * @param $id : require
   * @return {object}
   */
  public function show($id)
  {
    try {
      $authUser = \Auth::user();
      $user = $this->userApi->find($id);
      $response = ["data" => new ApiUserTransformer($user)];

    } catch (\Exception $e) {
      $status = 400;
      $response = ["error" => $e->getMessage()];
    }

    //Return Response
    return response()->json($response, $status ?? 200);
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
  public function update($id, Request $request)
  {
    //try {
    $user = $this->user->find($id);

    /*Change Status (active,disable)*/
    if ($request->status) {
      $this->userApi->disableUser($user);
      $this->userApi->activateUser($user);
    } else {
      $this->userApi->disableUser($user);
    }

    // user and role to update
    $user = $this->user->find($id);
    $role = $user->roles()->first();

    $user->fill($request->all());

    // role get in $request
    if (isset($request->roles)) {
      if(is_array($request->roles)){
        $roleId = $request->roles[0]['id'];
      }else{
        $roleId = $request->roles;
      }
      $role = $this->role->find($roleId);
      $user->roles()->sync($role->id);
    }

    if (isset($request->departments)) {
      foreach ($request->departments as $department){
        $user->departments()->sync($department);
      }
    }

    $data = $request->all();

    // si existe el parametro attributes como parametro en los atributos
    if (isset($data["attributes"])) {
      $attributes = $data["attributes"];
      if (isset($attributes["settings"])) {
        $settings = $attributes["settings"];

        //se buscan los settings que tengo el user guardados
        $userSettings = $user->settings;

        //si el parametro filter viene null significa que debe borrarse ese setting del user
        $deleteSetting = false;
        if ($settings["filter"] == null)
          $deleteSetting = true;

        /* Se crea el assigment segun el estandar para los settings del user*/
        $assignment = [];
        $assignment[$settings["setting"]] = [];
        /* si viene un prefijo para manejar un subnivel dentro del setting */
        if ($settings["prefix"]) {
          $assignment[$settings["setting"]] [$settings["prefix"]] = [];
          $assignment[$settings["setting"]] [$settings["prefix"]][$settings["type"]] = $settings["filter"];
        } else {
          $assignment[$settings["setting"]] [$settings["type"]] = $settings["filter"];
        }

        $user->settings = array_merge((array)$userSettings, $assignment);
      }
    }

    $user->save();

    /*
     event(new UserEvent($user));
     \Log::info("user updated");
     \Log::info($user);
    */
    isset($status) ? false : $response = ["data" => ""];


    //Return Response
    return response()->json($response, $status ?? 200);
  }

  /**
   *  USER CREATE
   *
   * @param $id : require
   * @return {object}
   */
  public function create(Request $request)
  {
    try {
      $data = (object)$request->all();
      $userName = $data->email;
      $exist = \DB::table('users')->where('email', $data->email)->first();

      if(!$exist){
        $data->email = $data->email.'@gmail.com';
        $user = $this->user->createWithRoles($data,$data->roles,$data->status);

        //Add deparmetns
        $user->departments()->sync($data->departments);

        //Update email with user name
        \DB::table('users')
          ->where('id', $user->id)
          ->update(['email' => $userName]);

        $response = ['data' => new ApiUserTransformer($user)];
      }else{
        $status = 400;
        $response = ["error" => $userName.' | User Name already exist'];
      }
    } catch (\Exception $e) {
      $status = 400;
      $response = ["error" => $e->getMessage()];
    }

    //Return Response
    return response()->json($response, $status ?? 200);
  }

}