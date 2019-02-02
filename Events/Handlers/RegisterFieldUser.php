<?php

namespace Modules\Iprofile\Events\Handlers;

use Modules\Iprofile\Events\ProfileWasCreated;
use Modules\Iprofile\Repositories\UserFieldRepository;

class RegisterFieldUser
{
    public $setting;
    public $userField;
    public function __construct(UserFieldRepository $userFiel)
    {
        $this->userField=$userFiel;
        $this->setting = app('Modules\Setting\Contracts\Setting');
    }

    public function handle(ProfileWasCreated $event)
    {
        $fields = array_diff_key($event->data, ['password_confirmation'=>true,'_token'=>true,'email'=>true, 'password'=>true, 'permissions'=>true, 'first_name'=>true, 'last_name'=>true]);
        $labels=config()->get('asgad.iprofile.config.fields');
        if (count($fields)) {
            foreach ($fields as $index => $field) {
                $type = array_get($labels,$index.'.type');
                if(is_array($field)){
                    $field=json_encode($field);
                }
                $data = ["user_id" => $event->user->id, 'name' => $index, 'plain_value'=>$field,'type'=>$type??'text'];
                $this->userField->create($data);
            }
        }
    }
}