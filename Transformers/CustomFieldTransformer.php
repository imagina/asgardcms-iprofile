<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CustomFieldTransformer extends Resource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "plainValue"=>$this->plainValue,
            "value" => $this->value,
            'status' => $this->status,
        ];

    }
}
