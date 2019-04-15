<?php

namespace Modules\Iprofile\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class Field extends Model
{

  protected $table = 'iprofile__fields';

  protected $fillable = [
    'user_id',
    'value',
    'name',
    'type'
  ];

  protected $fakeColumns = ['value'];

  protected $casts = [
    'value' => 'array'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function getValueAttribute($value)
  {

    return json_decode($value);

  }

  public function setValueAttribute($value)
  {

    $this->attributes['value'] = json_encode($value);

  }
}
