<?php

namespace Modules\Iprofile\Repositories\Cache;

use Modules\Iprofile\Repositories\DepartmentRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheDepartmentDecorator extends BaseCacheDecorator implements DepartmentRepository
{
    public function __construct(DepartmentRepository $department)
    {
        parent::__construct();
        $this->entityName = 'iprofile.departments';
        $this->repository = $department;
    }
}
