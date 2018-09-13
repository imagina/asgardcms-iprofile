<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class Department extends Model
{
  protected $table = 'iprofile__departments';
  protected $fillable = [];

  public function users()
  {
    return $this->belongsToMany(User::class, 'iprofile__user_departments')->withTimestamps();
  }
}
