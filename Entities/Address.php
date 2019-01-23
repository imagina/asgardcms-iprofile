<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'iprofile__addresses';
    protected $fillable = ['first_name', 'last_name','company','address_1','address_2','city','zip_code','country', 'province','type'];

    /**
     * @return mixed
     */
    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
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
