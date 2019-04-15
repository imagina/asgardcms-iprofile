<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iprofile\Http\Requests\CreateRoleApiRequest;
use Modules\Iprofile\Http\Requests\UpdateRoleApiRequest;
use Modules\Iprofile\Repositories\RoleApiRepository;
use Modules\Iprofile\Transformers\RoleTransformer;

class RoleApiController extends BaseApiController
{

  private $role;
  private $setting;

  public function __construct(
    RoleApiRepository $role,
    SettingApiController $setting
  )
  {
    $this->role = $role;
    $this->setting = $setting;
  }

  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function index(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $roles = $this->role->getItemsBy($params);

      //Response
      $response = [
        "data" => RoleTransformer::collection($roles)
      ];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($roles)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $role = $this->role->getItem($criteria, $params);

      //Break if no found item
      if (!$role) throw new Exception('Item not found', 404);

      //Response
      $response = ["data" => new RoleTransformer($role)];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($role)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * UPDATE ITEM
   *
   * @param $criteria
   * @param Request $request
   * @return mixed
   */
  public function update($criteria, Request $request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      //Validate Permission
      $this->validatePermission($request,'profile.role.edit');

      //Get data
      $data = $request->input('attributes');

      //Validate Request
      $this->validateRequestApi(new UpdateRoleApiRequest((array)$data));

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $role = $this->role->updateBy($criteria, $data, $params);

      //Create or Update Settings
      if (isset($data["settings"]))
        foreach ($data["settings"] as $setting) {
          if (isset($setting["value"]) && !empty($setting["value"])) {
            if (!isset($setting['id'])) {
              $setting['related_id'] = $role->id;// Add role Id
              $setting['entity_name'] = 'role';// Add entity name
              $this->validateResponseApi(
                $this->setting->create(new Request(['attributes' => (array)$setting]))
              );
            } else
              $this->validateResponseApi(
                $this->setting->update($setting['id'], new Request(['attributes' => (array)$setting]))
              );
          } else {
            if (isset($setting['id'])) {
              $this->validateResponseApi(
                $this->setting->delete($setting['id'], new Request(['attributes' => (array)$setting]))
              );
            }
          }
        }

      //Response
      $response = ['data' => ''];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * CREATE A ITEM
   *
   * @param Request $request
   * @return mixed
   */
  public function create(Request $request)
  {
    \DB::beginTransaction();
    try {
      //Validate Permission
      $this->validatePermission($request,'profile.role.create');

      //Get data
      $data = $request->input('attributes');

      //Validate Request
      $this->validateRequestApi(new CreateRoleApiRequest((array)$data));

      //Create item
      $role = $this->role->create($data);

      //Create or Update Settings
      if (isset($data["settings"]))
        foreach ($data["settings"] as $setting) {
          if (isset($setting["value"]) && !empty($setting["value"])) {
            $setting['related_id'] = $role->id;// Add role Id
            $setting['entity_name'] = 'role';// Add entity name
            $this->validateResponseApi(
              $this->setting->create(new Request(['attributes' => (array)$setting]))
            );
          }
        }

      //Response
      $response = ["data" => ""];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response, $status ?? 200);
  }

  /**
   * DELETE A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function delete($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Validate Permission
      $this->validatePermission($request,'profile.role.destroy');

      //Get params
      $params = $this->getParamsRequest($request);

      //call Method delete
      $this->role->deleteBy($criteria, $params);

      //Response
      $response = ["data" => ""];
      \DB::commit();//Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }
}
