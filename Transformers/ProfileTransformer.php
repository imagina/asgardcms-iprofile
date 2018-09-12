<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProfileTransformer extends Resource
{
  public function toArray($request)
  {
    return [
      "id" => $this->id,
      "user_id" => $this->user_id,
      'identification' => $this->identification,
      'business' => $this->business,
      'bio' => $this->bio,
      'tel' => $this->tel,
      'address' => $this->address,
      'social' => $this->social,
      'birthday' => $this->birthday,
      'ext_number' => $this->ext_number,
      'city' => $this->city,
      'state' => $this->state,
      'country' => $this->country,
      'mainimage' => $this->mainimage.'?'.$this->updated_at,
      'mediumimage' => $this->mediumimage.'?'.$this->updated_at,
      'smallimage' => $this->smallimage.'?'.$this->updated_at,
    ];
    
  }
}
