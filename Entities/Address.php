<?php

namespace Modules\Iprofile\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Fhia\Entities\BranchOffice;
use Modules\User\Entities\Sentinel\User;

class Address extends Model
{
    protected $table = 'iprofile__addresses';

    protected $fillable = [
      'user_id',
      'first_name',
      'last_name',
      'company',
      'address_1',
      'address_2',
      'city',
      'zip_code',
      'country',
      'state',
      'type'
    ];
  
  
  public function user(){
    $this->belognsTo(User::class);
  }
}
