<?php

namespace Modules\Iprofile\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface AddressRepository extends BaseRepository
{
  public function findByProfileId($id);
}
