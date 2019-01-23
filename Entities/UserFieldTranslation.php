<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;

class UserFieldTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['value'];
    protected $table = 'iprofile__user_field_translations';
}
