<?php

namespace Modules\Iprofile\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class UserDepartment extends Model
{

  protected $table = 'iprofile__user_department';

  protected $fillable = [
    'user_id',
    'department_id'
  ];
}
