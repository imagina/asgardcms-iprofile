<?php

namespace Modules\Iprofile\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

  protected $table = 'iprofile__addresses';
  protected $fillable = [
    'profile_id',
    'firstname',
    'lastname',
    'company',
    'address_1',
    'address_2',
    'city',
    'postcode',
    'country',
    'zone',
    'type'
  ];
  
  /**
   * @return array
   */
  public function profile()
  {
    $driver = config('asgard.user.config.driver');
    
    return $this->belongsTo(Profile::class);
  }
 
}
