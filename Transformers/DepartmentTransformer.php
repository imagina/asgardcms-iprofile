<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\User\Transformers\UserTransformer;

class DepartmentTransformer extends Resource
{
  public function toArray($request)
  {
    
    $result = [
      "id" => $this->id,
      "value" => $this->id,
      "title" => $this->title,
      "label" => $this->title,
      "users" => UserTransformer::collection($this->users),
      "created_at" => $this->created_at,
      "updated_at" => $this->updated_at,
    ];

    if($this->settings)
      $result["settings"] = $this->settings;

    return $result;
  }
  
}