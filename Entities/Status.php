<?php

namespace Modules\Iprofile\Entities;

class Status
{
    const NOTVERIFIED = 0;
    const VERIFIED = 1;
    
    private $statuses = [];

    public function __construct()
    {

        $this->statuses = [
            self::NOTVERIFIED => trans('iprofile::profiles.status.notverified'),
            self::VERIFIED => trans('iprofile::profiles.status.verified'),
        ];

    }

    /**
     * Get the available statuses
     * @return array
     */
    public function lists()
    {
        return $this->statuses;
    }

    /**
     * Get the auction status
     * @param int $statusId
     * @return string
     */
    public function get($statusId)
    {
        
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::NOTVERIFIED];
    }

}

