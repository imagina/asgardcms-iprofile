<?php

namespace Modules\Iprofile\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;

/**
 * Interface UserRepository
 * @package Modules\User\Repositories
 */
interface ApiRoleRepository extends BaseRepository
{
  public function index($page, $take, $filter, $include);
  
}
