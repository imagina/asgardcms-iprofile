<?php

namespace Modules\Iprofile\Repositories\Cache;

use Modules\Iprofile\Repositories\UserFieldRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheUserFieldDecorator extends BaseCacheDecorator implements UserFieldRepository
{
    public function __construct(UserFieldRepository $userfield)
    {
        parent::__construct();
        $this->entityName = 'iprofile.userfields';
        $this->repository = $userfield;
    }
}
