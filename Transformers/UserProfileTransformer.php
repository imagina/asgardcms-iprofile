<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class UserProfileTransformer extends Resource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'first_name'=> $this->when($this->first_name,$this->first_name),
            'last_name'=> $this->when($this->last_name,$this->last_name),
            'email'=> $this->when($this->email,$this->email),
            'created_at'=> $this->when($this->created_at,$this->created_at),
        ];

        foreach ($this->fields as $field) {
            if ($field->is_translatable) {
                $data[$field->name] = $field->value;
            } else {
                if (validateJson($field->plain_value)) {
                    $data[$field->name] = json_decode($field->plain_value);
                } else {
                    $data[$field->name] = $field->plain_value;
                }
            }

        }
        $data['addresses']= AddressTransformer::collection($this->whenLoaded('addresses'));

        return $data;

    }
}