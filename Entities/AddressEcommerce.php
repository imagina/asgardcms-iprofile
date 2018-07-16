<?php

namespace Modules\Iprofile\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AddressEcommerce extends Model
{

    protected $table = 'iprofile__addressecommerces';
    protected $fillable = [
    	'profile_id',
    	'active',
    	'payment_firstname',
        'payment_lastname',
        'payment_company',
        'payment_address_1',
        'payment_address_2',
        'payment_city',
        'payment_postcode',
        'payment_country',
        'payment_zone',
        'shipping_firstname',
        'shipping_lastname',
        'shipping_company',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_postcode',
        'shipping_country',
        'shipping_zone',
      
    ];
    protected $casts = [
	    'active' => 'boolean'
	];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
