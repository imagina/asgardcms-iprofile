<?php

namespace Modules\Iprofile\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface AddressRepository extends BaseRepository
{
    public function getItemsBy($params = false);

    public function getItem($criteria, $params = false);


}
