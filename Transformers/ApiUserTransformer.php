<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Iprofile\Transformers\DepartmentTransformer;
use Modules\Iprofile\Transformers\RoleTransformer;
use Cartalyst\Sentinel\Activations\EloquentActivation as Activation;

class ApiUserTransformer extends Resource
{
  public function toArray($request)
  {
    $deparments = $this->departments()->get();

    return [
      'id' => $this->id,
      'first_name' => $this->first_name,
      'last_name' => $this->last_name,
      'full_name' => $this->present()->fullname,
      'email' => $this->email,
      'roles' => RoleTransformer::collection($this->roles),

      'status' => is_null($this->status) ? false : true,
      'departments' => $deparments ? DepartmentTransformer::collection($deparments) : [],
      'created_at' => strftime('%Y/%B/%d', strtotime($this->created_at)),
      'updated_at' => strftime('%Y/%B/%d', strtotime($this->updated_at)),
    ];
  }
}
