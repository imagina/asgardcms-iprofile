<?php

namespace Modules\Iprofile\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\User\Repositories\RoleApiRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheApiRoleDecorator extends BaseCacheDecorator implements RoleApiRepository
{
  public function index($page, $take, $filter, $include)
  {
    // TODO: Implement index() method.
  }
}
