<?php

namespace Modules\Iprofile\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Iprofile\Repositories\ApiUserRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheApiUserDecorator extends BaseCacheDecorator implements ApiUserRepository
{
  public function index($page, $take, $filter, $include)
  {
    // TODO: Implement index() method.
  }
}
