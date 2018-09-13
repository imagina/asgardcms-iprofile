<?php

namespace Modules\Iprofile\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Modules\User\Contracts\Authentication;


abstract class BaseApiController extends Controller
{
  /**
   * @var Authentication
   */
  protected $auth;
  public $locale;
  
  public function __construct()
  {
    $this->locale = App::getLocale();
    $this->auth = app(Authentication::class);
  }
  
  //Request URL Get Standard or set default values
  public function parametersUrl($page = false, $take = false, $filter = [], $include = [], $fields = [])
  {
    $request = request();
    
    return (object)[
      "page" => is_numeric($request->input('page')) ? $request->input('page') : $page,
      "take" => is_numeric($request->input('take')) ? $request->input('take') : $take,
      "filter" => json_decode($request->input('filter')) ?? (object)$filter,
      "include" => $request->input('include') ? explode(",", $request->input('include')) : $include,
      "fields" => $request->input('fields') ? explode(",", $request->input('fields')) : $fields
    ];
  }
  
  //Transform data of Paginate
  public function pageTransformer($data)
  {
    return [
      "total" => $data->total(),
      "lastPage" => $data->lastPage(),
      "perPage" => $data->perPage(),
      "currentPage" => $data->currentPage()
    ];
  }
}
