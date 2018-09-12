<?php

namespace Modules\Iprofile\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;

/**
 * Interface UserRepository
 * @package Modules\User\Repositories
 */
interface ApiUserRepository extends BaseRepository
{
  /**
   * Return all Users witch standard JSON API
   *
   * @param $page
   * @param $take
   * @param $filter
   * @param $include
   * @return mixed
   */
  public function index($page, $take, $filter, $include);

  public function find($id);

  public function activateUser($user);

  public function disableUser($user);

}
