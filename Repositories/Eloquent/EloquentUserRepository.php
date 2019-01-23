<?php

namespace Modules\Iprofile\Repositories\Eloquent;

use Modules\Iprofile\Repositories\UserRepository;
use Modules\User\Repositories\Sentinel\SentinelUserRepository;

class EloquentUserRepository extends SentinelUserRepository implements UserRepository
{

}