<?php


namespace Modules\Iprofile\Events;

use Modules\User\Entities\Sentinel\User;
use Modules\Media\Contracts\StoringMedia;

class ProfileWasUpdated
{

    public $data;
    public $user;

    public function __construct(User $user, array $data)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->user;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }

}