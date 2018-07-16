<?php

namespace Modules\Iprofile\Repositories\Cache;

use Modules\Iprofile\Repositories\AddressEcommerceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAddressEcommerceDecorator extends BaseCacheDecorator implements AddressEcommerceRepository
{
    public function __construct(AddressEcommerceRepository $addressecommerce)
    {
        parent::__construct();
        $this->entityName = 'iprofile.addressecommerces';
        $this->repository = $addressecommerce;
    }
}
