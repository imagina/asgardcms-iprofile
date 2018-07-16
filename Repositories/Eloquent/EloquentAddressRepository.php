<?php

namespace Modules\Iprofile\Repositories\Eloquent;

use Modules\Iprofile\Repositories\AddressRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentAddressRepository extends EloquentBaseRepository implements AddressRepository
{
    public function findByProfileId($id){
        return $this->model->where('profile_id',$id)->get();
    }
    public function deleteAllAddress($profile_id){
        $this->model->where('profile_id',$profile_id)->delete();
        return 1;
    }
    public function updateMassiveById($arrayAddress,$profile_id){
        $addresses= $this->model->where('profile_id',$profile_id)->get();
        foreach($addresses as $key){
            $band=0;
            foreach($arrayAddress[0] as $key2){
                if($key->id==$key2['id']){
                    $key->address_1=$key2['address_1'];
                    $key->firstname=$key2['firstname'];
                    $key->lastname=$key2['lastname'];
                    $key->city=$key2['city'];
                    $key->company=$key2['company'];
                    $key->postcode=$key2['postcode'];
                    $key->address_2=$key2['address_2'];
                    $key->type=$key2['type'];
                    $key->zone=$key2['zone'];
                    $key->country=$key2['country'];
                    $key->update();
                    $band=1;
                    break;
                }else
                    $band=0;
            }//foreachWithAddressToUpdate
            if($band==0)
                $key->delete();
        }//foreach address actually
        return $this->model->where('profile_id',$profile_id)->get();
    }
}
