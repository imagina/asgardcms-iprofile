<?php

namespace Modules\Iprofile\Repositories\Cache;

use Modules\Iprofile\Repositories\ProfileRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProfileDecorator extends BaseCacheDecorator implements ProfileRepository
{
    public function __construct(ProfileRepository $profile)
    {
        parent::__construct();
        $this->entityName = 'iprofile.profiles';
        $this->repository = $profile;
    }
  
  public function findByUserId($user_id){
      
  }
}
