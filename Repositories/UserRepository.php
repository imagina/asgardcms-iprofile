<?php


namespace Modules\Iprofile\Repositories;

use  Modules\User\Repositories\UserRepository as User;

interface UserRepository extends User
{
    /**
     * @param bool $params
     * @return mixed
     */
    public function getItemsBy($params = false);

    /**
     * @param $criteria
     * @param bool $params
     * @return mixed
     */
    public function getItem($criteria, $params = false);

}