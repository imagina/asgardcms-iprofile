<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class RoleTransformer extends Resource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'slug' => $this->slug,
      'created_at' => $this->created_at,
      'label' => $this->name,
      'value' => $this->id,
      'urls' => [
        'delete_url' => route('api.user.role.destroy', $this->id),
      ],
    ];
  }
}
