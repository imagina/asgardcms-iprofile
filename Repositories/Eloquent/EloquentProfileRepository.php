<?php

namespace Modules\Iprofile\Repositories\Eloquent;

use Modules\Iprofile\Repositories\Collection;
use Modules\Iprofile\Repositories\ProfileRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Profile\Entities\Profile;

class EloquentProfileRepository extends EloquentBaseRepository implements ProfileRepository
{
    public function latest($amount = 5)
    {

    }

    public function getPreviousOf($profile)
    {

    }

    public function getNextOf($profile)
    {

    }

    public function findByUserId($user_id)
    {
       $profile = $this->model->where('user_id',$user_id)->first();

        if(isset($profile) && !empty($profile)) {
            return $profile;
        }else{
            return $this->model->create(["user_id" => $user_id,"active" => 1]);
        }
    }
}
