<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;

class DepartmentTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
    protected $table = 'iprofile__department_translations';
}
