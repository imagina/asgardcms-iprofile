<?php

namespace Modules\Iprofile\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;
use Modules\Iprofile\Repositories\ApiRoleRepository;


class EloquentApiRoleRepository extends EloquentBaseRepository implements ApiRoleRepository
{

  public function index($page, $take, $filter, $include)
  {

    //Initialize query
    $query = $this->model->orderBy('id', 'asc'); // Order By;

    /*== RELATIONSHIPS ==*/
    if (count($include)) {
      //Include relationships for default

      $includeDefault = [];

      $query->with(array_merge($includeDefault, $include));
    }

    /*=== PERMISSIONS ===*/
    $rolesSlug = DB::table("roles")->pluck("slug");

    $user = \Auth::user();
    $rolesPermissions = [];

    /*foreach ($rolesSlug as $slug)
      if ($user->hasAccess('fhia.index.roles.' . $slug))
        array_push($rolesPermissions, $slug);

    $query->whereIn('slug', $rolesPermissions);*/


    //Return request with pagination
    if ($page) {
      $take ? true : $take = 12; //If no specific take, query take 12 for default
      return $query->paginate($take);
    }

    //Return request without pagination
    if (!$page) {
      $take ? $query->take($take) : false; //if request to take a limit
      return $query->get();
    }
  }
}
