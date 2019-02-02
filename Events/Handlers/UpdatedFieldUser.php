<?php

namespace Modules\Iprofile\Events\Handlers;


use Modules\Iprofile\Events\ProfileWasUpdated;
use Modules\Iprofile\Repositories\UserFieldRepository;

class UpdatedFieldUser
{
    public $setting;

    public $userField;

    public function __construct(UserFieldRepository $userField)
    {
        $this->userField=$userField;
        $this->setting = app('Modules\Setting\Contracts\Setting');
    }

    public function handle(ProfileWasUpdated $event)
    {
        $fields = array_diff_key($event->data, ['id'=>true,'password_confirmation'=>true,'_token'=>true,'email'=>true, 'password'=>true, 'permissions'=>true, 'first_name'=>true, 'last_name'=>true, 'roles'=>true,"activated"=>true,'_method'=>true]);
        $labels=config('asgad.iprofile.config.fields');
        $userField=$event->user->fields;

        if (count($fields)) {
            foreach ($fields as $index => $field){
                $type = array_get($labels,$index.'.type');
                if(is_array($field)){
                    $field=json_encode($field);
                }
                $data = ["user_id" => $event->user->id, 'name' => $index, "plain_value"=>$field,'type'=>$type??'text'];
                $entity=$userField->where('name', $index)->first();
                if(isset($entity)){
                    $this->userField->update($entity,$data);
                }else{
                    $this->userField->create($data);
                }


            }
        }
    }
}