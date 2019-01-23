<?php

namespace Modules\Iprofile\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\NamespacedEntity;


class UserField extends Model
{
    use Translatable, PresentableTrait, NamespacedEntity;

    protected $table = 'iprofile__user_fields';

    public $translatedAttributes = ['value'];

    protected $fillable = ['user_id','name','plain_value','value','is_translatable','type'];

    protected static $entityNamespace = 'asgardcms/user_field';
    /**
     * @var array
     */
    protected $cast = [
        'status' => 'int'
    ];

    /**
     * @return mixed
     */
    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }


    /**
     * @return mixed
     */
    public function getMain_imageAttribute()
    {
       if($this->name=='mainimage'){
           $image= url($this->plain_value.'?'.strtotime($this->updated_at));
       }else{
           $image=url('modules/iprofile/img/default.jpg');
       }
       return $image;
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.iprofile.config.user_field.relations', $method]);
        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);
            return $function($this);
        }
        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }

}
