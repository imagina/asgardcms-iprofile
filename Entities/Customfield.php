<?php

namespace Modules\Iprofile\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Customfield extends Model
{
    use Translatable;

    protected $table = 'iprofile__customfields';
    public $translatedAttributes = ['value'];
    protected $fillable = ['name','value','plainValue','profile_id','status','isTranslatable'];

    protected $casts = [
        'status'=>'int',
    ];

    public function getPlainValueAttribute($value){

        if(isset($value)&&!empty($value)){
            if(!$this->isTranslatable){
                if(json_validator($value)){
                    return json_decode($value);
                }
                return $value;
            }
        }
        return null;

    }

}
