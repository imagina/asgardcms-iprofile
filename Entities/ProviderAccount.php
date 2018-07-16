<?php

namespace Modules\Iprofile\Entities;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Modules\Bcrud\Support\Traits\CrudTrait;

class ProviderAccount extends Model
{

    use CrudTrait;

    protected $table = 'iprofile__provider__accounts';
    protected $fillable = ['user_id', 'provider_user_id', 'provider' ,'options'];
    protected $casts = [
        'options'=>'array'
    ];

    protected $fakeColumns = ['options'];

    public function user()
    {
        $driver = config('asgard.user.config.driver');


        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

}
