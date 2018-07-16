<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;

class ProfileTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['bio'];
    protected $table = 'iprofile__profile_translations';
}
