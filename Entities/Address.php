<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Ilocations\Entities\City;
use Modules\Ilocations\Entities\Province;
use Modules\Ilocations\Entities\Country;

class Address extends Model
{
    protected $table = 'iprofile__addresses';
    protected $fillable = ['first_name', 'last_name','company','address_1','address_2','city_id','zip_code','country_id', 'province_id','type', 'user_id', 'default'];

    /**
     * @return mixed
     */
    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');

    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');

    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');

    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.iprofile.config.address.relations', $method]);
        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);
            return $function($this);
        }
        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }


}
