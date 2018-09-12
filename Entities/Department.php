<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
  protected $table = 'iprofile__departments';
  protected $fillable = [];

  public function users()
  {
    return $this->belongsToMany(User::class, 'iprofile__user_departments')->withTimestamps();
  }
}
