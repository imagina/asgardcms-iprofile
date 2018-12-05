<?php

namespace Modules\Iprofile\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Modules\Iprofile\Transformers\CustomFieldTransformer;

class Profile extends Model
{
  use Translatable;

  protected $table = 'iprofile__profiles';
  public $translatedAttributes = ['bio'];
  protected $fillable = [
    'user_id',
    'identification',
    'business',
    'nit',
    'type_person',
    'bio',
    'tel',
    'address',
    'ext_number',
    'social',
    'birthday',
    'gender',
    'city',
    'state',
    'country',
    'options'
  ];

  protected $casts = [
    'social' => 'array',
    'options' => 'array'
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

    public function customFields()
    {
        return $this->hasMany(CustomField::class);
    }

  public function setSocialAttribute($value)
  {
    return $this->attributes['social'] = json_encode($value);
  }

  public function setOptionsAttribute($value)
  {
    return $this->attributes['options'] = json_encode($value);
  }

  public function getSocialAttribute($value)
  {
    return json_decode($value);
  }

  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }

  public function getMainimageAttribute(){
    $options = json_decode($this->attributes['options']);

    if (isset($options->mainimage) && !empty($options->mainimage))
      return url($this->options->mainimage);
    else
      return url('modules/iprofile/img/default.jpg');
  }

  public function getMediumimageAttribute(){
    $options = json_decode($this->attributes['options']);
    if (isset($options->mainimage) && !empty($options->mainimage))
      return url(str_replace('.jpg','_mediumThumb.jpg',$options->mainimage));
    else
      return url('modules/iprofile/img/default.jpg');
  }

  public function getSmallimageAttribute(){
    $options = json_decode($this->attributes['options']);
    if (isset($options->mainimage) && !empty($options->mainimage))
      return url(str_replace('.jpg','_smallThumb.jpg',$options->mainimage));
    else
      return url('modules/iprofile/img/default.jpg');
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
