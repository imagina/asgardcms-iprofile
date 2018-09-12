<?php

namespace Modules\Iprofile\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ProfileRepository extends BaseRepository
{
    /**
     * Return the user's profile
     * @param int $id
     * @return Collection
     */
    public function findByUserId($user_id);

}
