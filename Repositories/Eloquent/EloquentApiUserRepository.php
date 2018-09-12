<?php

namespace Modules\Iprofile\Repositories\Eloquent;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;
use Modules\Iprofile\Repositories\ApiUserRepository;
use Modules\User\Entities\Sentinel\User;
use Illuminate\Support\Facades\Auth;


class EloquentApiUserRepository extends EloquentBaseRepository implements ApiUserRepository
{
  /**
   * Index for Users
   *
   * @param $page
   * @param $take
   * @param $filter
   * @param $include
   * @return mixed
   */
  public function index($page, $take, $filter, $include)
  {
    !isset($filter->status) ? $filter->status = [1] : false; //filter default

    //Initialize query
    $result = $this->model->query();

    /*=== Filter by status ===*/
    if (count($filter->status) == 1) {
      if ($filter->status[0]) {//If request active users
        $result->whereIn('users.id', function ($query) use ($filter) {
          $query->select('activations.user_id')
            ->from('activations')
            ->where('activations.completed', 1);
        });
      } else {//If request disable users
        $result->whereNotIn('users.id', function ($query) use ($filter) {
          $query->select('activations.user_id')
            ->from('activations')
            ->where('activations.completed', 1);
        });
      }
    }

    /*=== PERMISSIONS ===*/
    /*$user = Auth::user();
    $rolesSlug = DB::table("roles")->pluck('slug');
    $rolesPermissions = [];

    foreach ($rolesSlug as $slug) {
      if ($user->hasAccess('fhia.index.users.roles.' . $slug)) {
        array_push($rolesPermissions, $slug);
      }
    }

    $result->with('roles')->whereHas('roles', function ($query) use ($rolesPermissions) {
      $query->whereIn("slug", $rolesPermissions);
    });*/

    /*== RELATIONSHIPS ==*/
    if (count($include)) {
      //Include relationships for default
      $includeDefault = [];
      $result->with(array_merge($includeDefault, $include));
    }

    /*=== FILTERS ===*/
    //filter by deparment
    if (isset($filter->department)) {
      $result->whereIn('users.id', function ($query) use ($filter) {
        $query->select('user_id')
          ->from('iprofile__user_departments')
          ->where('department_id', $filter->department);
      });
    }

    //filter by Role
    if (isset($filter->roles)) {
      $result->whereIn('users.id', function ($query) use ($filter) {
        $query->select('user_id')
          ->from('role_users')
          ->whereIn('role_id', $filter->roles);
      });
    }

    //add filter by search
    if (!empty($filter->search)) {

      //find search in columns Customer_name and Customer_Last_Name
      $result->where(function ($query) use ($filter) {
        $query->where('users.id', $filter->search)
          ->orWhere('first_name', 'like', '%' . $filter->search . '%')
          ->orWhere('last_name', 'like', '%' . $filter->search . '%')
          ->orWhere('email', 'like', '%' . $filter->search . '%');

      });
    }

    //Request Status (active, disable)
    $result->leftJoin('activations', 'users.id', '=', 'activations.user_id')
      ->select('users.*', 'activations.completed as status');

    /*=== REQUEST ===*/
    $result->orderBy('first_name', 'asc'); // Order By

    //Return request with pagination
    if ($page) {
      $take ? true : $take = 12; //If no specific take, query take 12 for default
      return $result->paginate($take);
    }

    //Return request without pagination
    if (!$page) {
      $take ? $result->take($take) : false; //if request to take a limit
      return $result->get();
    }
  }

  /**
   * Return data user with status
   *
   * @param $id
   * @return mixed
   */
  public function find($id)
  {
    return $this->model
      ->leftJoin('activations', 'users.id', '=', 'activations.user_id')
      ->select('users.*', 'activations.id as status')
      ->find($id);
  }

  /**
   * Activate User
   *
   * @param $user
   */
  public function activateUser($user)
  {
    $activation = Activation::create($user);
    Activation::complete($user, $activation->code);
  }

  /**
   * Disable User
   *
   * @param $user
   */
  public function disableUser($user)
  {
    DB::table('activations')->where('user_id', $user->id)->delete();
  }
}
