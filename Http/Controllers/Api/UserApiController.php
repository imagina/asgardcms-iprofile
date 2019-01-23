<?php

namespace Modules\Profile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Inotification\Events\StorageBroadcastingEvent;
use Modules\Profile\Http\Requests\CreateUserApiRequest;
use Modules\Profile\Http\Requests\UpdateUserApiRequest;
use Modules\Profile\Repositories\UserApiRepository;
use Modules\Profile\Transformers\UserTransformer;
use Modules\User\Repositories\UserRepository;

class UserApiController extends BaseApiController
{
  private $user;
  private $field;
  private $address;
  
  public function __construct(FieldApiController $field, AddressApiController $address, UserRepository $user)
  {
    $this->user = $user;
    $this->field = $field;
    $this->address = $address;

  }
  
  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function index(Request $request)
  {
    //try {
    //Get Parameters from URL.
    $params = $this->getParamsRequest($request);
    
    //Request to Repository
    $users = $this->user->getItemsBy($params);
    
    //Response
    $response = [
      "data" => UserTransformer::collection($users)
    ];
    
    //If request pagination add meta-page
    $params->page ? $response["meta"] = ["page" => $this->pageTransformer($users)] : false;
    /* } catch (\Exception $e) {
       $status = $this->getStatusError($e->getCode());
       $response = ["errors" => $e->getMessage()];
     }*/
    
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
      $user = $this->user->getItem($criteria, $params);
      
      //Break if no found item
      if (!$user) throw new \Exception('Item not found', 400);
      
      //Response
      $response = ["data" => new UserTransformer($user)];
      
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($user)] : false;
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
    //try {
    //Get data
    $data = $request->input('attributes');
    
    //Validate Request
    $this->validateRequestApi(new CreateUserApiRequest($data));
    
    $exist = \DB::table('users')->where('email', $data["email"])->first();
    

    if (!$exist) {
      //Create item
      
      $user = $this->userRepository->createWithRoles($data, $data["roles"], $data["status"]);
      
      // sync tables
      $user->departments()->sync(array_get($data, 'departments', []));
      
      
      if (isset($data["status"]) && $data["status"]) {
        $this->userRepository->disableUser($user);
        $this->userRepository->activateUser($user);
      }
      
      //Create fields
      if (isset($data["fields"]))
        foreach ($data["fields"] as $field) {
          $field['user_id'] = $user->id;// Add prelead Id
          $this->validateResponseApi(
            $this->field->create(new Request(['attributes' => (array)$field]))
          );
        }
      
      //Create Addresses
      if (isset($data["addresses"]))
        foreach ($data["addresses"] as $address) {
          $address['user_id'] = $user->id;// Add prelead Id
          $this->validateResponseApi(
            $this->address->create(new Request(['attributes' => (array)$address]))
          );
        }
  
      event(new StorageBroadcastingEvent("profile.users"));
      $response = ['data' => ''];
    } else {
      $status = 400;
      $response = ["error" => $data["email"] . ' | User Name already exist'];
    }
    
    \DB::commit(); //Commit to Data Base
    /* } catch (\Exception $e) {
       \DB::rollback();//Rollback to Data Base
       $status = $this->getStatusError($e->getCode());
       $response = ["errors" => $e->getMessage()];
     }*/
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
    //try {
    //Get data
    $data = $request->input('attributes');
    
    //Validate Request
    $this->validateRequestApi(new UpdateUserApiRequest((array)$data));
    
    $user = $this->user->findByAttributes(["email" => $data["email"]]);
    
    if (!$user || $user->id == $data["id"]) {
      $this->userRepository->updateAndSyncRoles($data["id"], $data, $data["roles"]);
  
      // sync tables
      $user->departments()->sync(array_get($data, 'departments', []));
  
      $user->roles()->sync(array_get($data, 'roles', []));
  
      //Create or Update fields
      if (isset($data["fields"]))
        foreach ($data["fields"] as $field) {
          $field['user_id'] = $user->id;// Add prelead Id
          if (!isset($field["id"]))
            $this->validateResponseApi(
              $this->field->create(new Request(['attributes' => (array)$field]))
            );
          else
            $this->validateResponseApi(
              $this->field->update($field["id"], new Request(['attributes' => (array)$field]))
            );
        }
  
  
      //Create or Update Addresses
      if (isset($data["addresses"]))
        foreach ($data["addresses"] as $address) {
          $address['user_id'] = $user->id;// Add prelead Id
          if (!isset($address['id']))
            $this->validateResponseApi(
              $this->address->create(new Request(['attributes' => (array)$address]))
            );
          else
            $this->validateResponseApi(
              $this->address->update($address['id'], new Request(['attributes' => (array)$address]))
            );
        }
  
      event(new StorageBroadcastingEvent("profile.users"));
      //Response
      $response = ["data" => ''];
    }else{
      $status = 400;
      $response = ["errors" => $data["email"] . ' | User Name already exist'];
    }
    
    
    \DB::commit();//Commit to DataBase
    /* } catch (\Exception $e) {
       \DB::rollback();//Rollback to Data Base
       $status = $this->getStatusError($e->getCode());
       $response = ["errors" => $e->getMessage()];
     }*/
    
    //Return response
    return response()->json($response, $status ?? 200);
  }
}
