<?php

namespace Modules\Iprofile\Repositories\Cache;

use Modules\Iprofile\Repositories\AddressRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAddressDecorator extends BaseCacheDecorator implements AddressRepository
{
    public function __construct(AddressRepository $address)
    {
        parent::__construct();
        $this->entityName = 'iprofile.addresses';
        $this->repository = $address;
    }


    public function getItemsBy($params = false)
    {
        // TODO: Implement getItemsBy() method.
    }

    public function getItem($criteria, $params = false)
    {
        // TODO: Implement getItem() method.
    }
}
