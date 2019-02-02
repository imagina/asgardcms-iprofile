<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Ilocations\Transformers\CityTransformer;
use Modules\Ilocations\Transformers\ProvinceTransformer;
use Modules\Ilocations\Transformers\CountryTransformer;

class AddressTransformer extends Resource
{

    public function toArray($request)
    {

        $data=[
            'id'=> $this->when($this->id,$this->id),
            'first_name'=> $this->when($this->first_name,$this->first_name),
            'last_name'=> $this->when($this->last_name,$this->last_name),
            'company'=>$this->when( $this->company,$this->company),
            'address_2'=>$this->when( $this->address_2,$this->address_2),
            'address_1'=>$this->when($this->address_1,$this->address_1),
            'zip_code'=>$this->when( $this->zip_code, $this->zip_code),
            'city_id'=>$this->when( $this->city_id, $this->city_id),
            'province_id'=>$this->when( $this->province_id, $this->province_id),
            'country_id'=>$this->when( $this->country_id, $this->country_id),
            'city'=> new CityTransformer($this->whenLoaded('city')),
            'province'=>new ProvinceTransformer($this->whenLoaded('province')),
            'country'=>new CountryTransformer($this->whenLoaded('country')),
        ];


        return $data;
    }
}

