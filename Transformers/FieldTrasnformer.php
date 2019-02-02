<?php


namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class FieldTrasnformer extends Resource
{

    public function toArray($request)
    {

        $data= $this->resource;
        return $data;
    }

}