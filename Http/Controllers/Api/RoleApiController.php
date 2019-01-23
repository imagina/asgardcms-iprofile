<?php

namespace Modules\Profile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Profile\Repositories\RoleApiRepository;
use Modules\Profile\Transformers\RoleTransformer;

class RoleApiController extends BaseApiController
{
  
  private $role;
  
  public function __construct(RoleApiRepository $role)
  {
    $this->role = $role;
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
}
