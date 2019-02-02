<?php

namespace Modules\Iprofile\Events;



class ProfileWasCreated
{

    public $user;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param user
     * @param array $data
     */
    public function __construct($user, array $data)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * @return mixed
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