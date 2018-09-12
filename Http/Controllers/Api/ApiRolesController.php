<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Mockery\CountValidator\Exception;

use Illuminate\Contracts\Foundation\Application;
use Modules\Icustom\Http\Controllers\BaseApiController;

use Modules\Iprofile\Repositories\ApiRoleRepository;
use Modules\Iprofile\Transformers\RoleTransformer;
use Modules\User\Contracts\Authentication;

use Illuminate\Http\Request;

class ApiRolesController extends BaseApiController
{

  /**
   * @var Application
   */
  private $app;
  private $userApi;
  private $roleApi;
  protected $auth;

  public function __construct(
    Application $app,
    ApiRoleRepository $roleApi
  )
  {

    $this->app = $app;
    $this->roleApi = $roleApi;
    $this->auth = app(Authentication::class);
  }

  /*return all user*/
  public function index()
  {
    try {
      
      
      //Get Parameters from URL.
      $p = $this->parametersUrl(false, false, ["status" => [1]], []);
      
      //Request to Repository
      $roles = $this->roleApi->index($p->page, $p->take, $p->filter, $p->include);
  

      //Response
      $response = ["data" => RoleTransformer::collection($roles)];
      //If request pagination add meta-page
      $p->page ? $response["meta"] = ["page" => $this->pageTransformer($roles)] : false;

    } catch (\Exception $e) {
      //Message Error
      $status = 500;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response, $status ?? 200);
  }
  


}
