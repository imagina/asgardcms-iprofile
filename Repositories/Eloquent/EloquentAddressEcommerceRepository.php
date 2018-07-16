<?php

namespace Modules\Iprofile\Repositories\Eloquent;

use Modules\Iprofile\Repositories\AddressEcommerceRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentAddressEcommerceRepository extends EloquentBaseRepository implements AddressEcommerceRepository
{
	public function findByProfileId($profile_id)
    {
        $address = $this->model->where('profile_id',$profile_id)->orderBy('active','DESC')->first();
        if(isset($address) && !empty($address))
            return $address;
        else
            return $this->model->create(["profile_id" => $profile_id,"active" => 1]);

    }
}
