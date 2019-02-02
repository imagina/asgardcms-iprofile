<?php

namespace Modules\Iprofile\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iprofile\Transformers\AddressTransformer;
use Modules\Iprofile\Http\Requests\CreateAddressRequest;
use Modules\Iprofile\Http\Requests\UpdateAddressRequest;
use Modules\Iprofile\Repositories\AddressRepository;


class AddressApiController extends BaseApiController
{
  
  private $address;
  
  public function __construct(AddressRepository $address)
  {
    $this->address = $address;
  }
  
  /**
   * GET ITEMS
   *
   * @return mixed
   */

  public function index(Request $request)
  {
   // try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $addresses = $this->address->getItemsBy($params);
      //Response
      $response = [
        "data" => AddressTransformer::collection($addresses)
      ];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($addresses)] : false;
   // } catch (\Exception $e) {
     // $status = $this->getStatusError($e->getCode());
      //$response = ["errors" => $e->getMessage()];
    //}

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
      $address = $this->address->getItem($criteria, $params);
      
      //Break if no found item
      if (!$address) throw new Exception('Item not found', 404);
      
      //Response
      $response = ["data" => new AddressTransformer($address)];
      
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($address)] : false;
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
      $this->validateRequestApi(new CreateAddressRequest($data));

      //Create item
      $address=$this->address->create($data);
      
      //Response
      $response = [
          'susses' => [
              'code' => '201',
              "source" => [
                  "pointer" => url($request->path())
              ],
              "title" =>  trans('iprofile::address.messages.create'),
              "detail" => [
                  'id' => $address->id
              ]
          ]
      ];;
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
      $this->validateRequestApi(new CreateAddressRequest($data));
      
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
        $address = $this->address->getItem($criteria, $params);
      //Request to Repository
      $this->address->update($address, $data);
      
      //Response
      $response = ["data" => 'Item Updated'];

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
      $this->address->deleteBy($criteria, $params);
      
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
