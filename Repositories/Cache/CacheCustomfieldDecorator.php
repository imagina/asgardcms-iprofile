<?php

namespace Modules\Iprofile\Repositories\Cache;

use Modules\Iprofile\Repositories\CustomfieldRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCustomfieldDecorator extends BaseCacheDecorator implements CustomfieldRepository
{
    public function __construct(CustomfieldRepository $customfield)
    {
        parent::__construct();
        $this->entityName = 'iprofile.customfields';
        $this->repository = $customfield;
    }
}
