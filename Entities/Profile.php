<?php

namespace Modules\Iprofile\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Profile extends Model
{
    use Translatable;

    protected $table = 'iprofile__profiles';
    public $translatedAttributes = ['bio'];
    protected $fillable = [
        'user_id',
        'identification',
        'business',
        'bio',
        'tel',
        'address',
        'social',
        'birthday',
        'gender',
        'city',
        'state',
        'country',
        'options'];
    protected $casts = [
        'social' => 'array',
        'options'=>'array'
    ];

    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function setSocialAttribute($value){
        return $this->attributes['social']=json_encode($value);
    }
    public function setOptionsAttribute($value){

       return $this->attributes['options'] = json_encode($value);
    }
    public function getSocialAttribute($value){
        return json_decode(json_decode($value));
    }
    public function getOptionsAttribute($value){
        return json_decode($value);
    }

    protected function setBirthdayAttribute($value){

        $format = 'd-m-Y';
        $date=DateTime::createFromFormat($format,$value);

      return  $this->attributes['birthday']= $date;
    }

    public function getBirthdayAttribute($value){

        if($value!=null && $value!=""){
            $format = 'd-m-Y';
            return date($format, strtotime($value));  
        }else{
            return $value;
        }
           

    }

    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.iblog.config.relations', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);

            return $function($this);
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }
}
