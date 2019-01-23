<?php

namespace Modules\Profile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Inotification\Events\StorageBroadcastingEvent;
use Modules\Profile\Http\Requests\CreateDepartmentRequest;
use Modules\Profile\Http\Requests\UpdateDepartmentRequest;
use Modules\Profile\Transformers\DepartmentTransformer;
use Modules\Profile\Repositories\DepartmentRepository;

class DepartmentApiController extends BaseApiController
{
  private $department;
  
  public function __construct(DepartmentRepository $department)
  {
    $this->department = $department;
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
      $departments = $this->department->getItemsBy($params);
      
      //Response
      $response = [
        "data" => DepartmentTransformer::collection($departments)
      ];
      
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($departments)] : false;
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
      $department = $this->department->getItem($criteria, $params);
      
      //Break if no found item
      if (!$department) throw new Exception('Item not found', 404);
      
      //Response
      $response = ["data" => new DepartmentTransformer($department)];
      
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($department)] : false;
    } catch (\Exception $e) {
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
      //Get data
      $data = $request->input('attributes');
      
      //Validate Request
      $this->validateRequestApi(new CreateDepartmentRequest($data));
      
      //Create item
      $this->department->create($data);
  
      event(new StorageBroadcastingEvent("profile.departments"));
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
      //Get data
      $data = $request->input('attributes');
      
      //Validate Request
      $this->validateRequestApi(new UpdateDepartmentRequest($data));
      
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $this->department->updateBy($criteria, $data, $params);
  
      event(new StorageBroadcastingEvent("profile.departments"));
      //Response
      $response = ["data" => ''];
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
   * DELETE A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function delete($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get params
      $params = $this->getParamsRequest($request);
      
      //call Method delete
      $this->department->deleteBy($criteria, $params);
      
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
  
  
  public function getSettings(Request $request)
  {
    
    $status = 200;
    // try {
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
        if(isset($departmentSettings[$key]))
          $defaultSettings[$key]["fields"] = array_replace($setting["fields"], $departmentSettings[$key]["fields"]);
        else
          $departmentSettings[$key]= $setting;
      
    }
    
    $department->settings = $defaultSettings;
    
    $response = [
      "data" => new DepartmentTransformer($department),
    ];
    
    /* } catch (\Exception $e) {
       $status = 400;
       $response = [
         "errors" => $e->getMessage()
       ];
     }*/
    
    return response()->json($response, $status);
    
  }
}
