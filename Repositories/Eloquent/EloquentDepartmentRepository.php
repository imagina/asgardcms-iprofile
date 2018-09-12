<?php

namespace Modules\Iprofile\Repositories\Eloquent;

use Modules\Iprofile\Repositories\DepartmentRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\DB;

class EloquentDepartmentRepository extends EloquentBaseRepository implements DepartmentRepository
{
  public function updateById($id, $fields)
  {
    $this->model->where('id', $id)->update($fields);
  }

  public function index($page, $take, $filter, $include, $fields)
  {
    $includeDefault = ['users'];

    /*Initialize Query*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (count($include)) {
      $query->with(array_merge($includeDefault, $include));
    } else {
      $query->with($includeDefault);
    }

    /*== FILTER ==*/
    if ($filter) {
      /*filter by user*/
      if (isset($filter->user_id)) {
        $query->whereIn('id', function ($query) use ($filter) {
          $query->select('iprofile__user_departments.department_id')
            ->from('iprofile__user_departments')
            ->where('fhia__user_department.user_id', $filter->user_id);
        });
      }
      //add filter by search
      if (!empty($filter->search)) {

        //find search in columns Customer_name and Customer_Last_Name
        $query->where(function ($query) use ($filter) {
          $query->where('id', $filter->search)
            ->orWhere('title', 'like', '%' . $filter->search . '%');

        });
      }
    }

    /*== FIELDS ==*/
    if ($fields) {
      /*filter by user*/
      $query->select($fields);
    }

    /*=== REQUEST ===*/
    $query->orderBy('id', 'asc'); // Order By

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

  public function show($filter, $include, $fields, $id)
  {
    $includeDefault = [];
    //Initialize Query
    $query = $this->model->where('id', $id);


    /*== RELATIONSHIPS ==*/
    if (count($include))
      $query->with(array_merge($includeDefault, $include));
    else
      $query->with($includeDefault);


    /*== FILTER ==*/
    /*
    if ($filter) {


    }*/

    /*== FIELDS ==*/
    if ($fields) {
      /*filter by user*/
      $query->select($fields);
    }

    return $query->first();

  }
}
