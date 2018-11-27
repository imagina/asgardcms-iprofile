<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;

class CustomfieldTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['value'];
    protected $table = 'iprofile__customfield_translations';

    public function getValueAttribute($value){

        if(isset($value)&&!empty($value)){
            if($this->isTranslatable){
                if(json_validator($value)){
                    return json_decode($value);
                }
                return $value;
            }
        }
        return null;

    }
}
