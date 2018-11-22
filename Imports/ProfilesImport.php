<?php

namespace Modules\Iprofile\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\Iprofile\Imports\UsersImport;
use Modules\Iprofile\Imports\RolesImport;
use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\RoleRepository;
use Modules\Iprofile\Repositories\ProfileRepository;


class ProfilesImport implements WithMultipleSheets {
    
    private $user;
    private $role;
    private $profile;

    public function __construct(  
        UserRepository $user, 
        RoleRepository $role,
        ProfileRepository $profile
        
    ){
        $this->user = $user;
        $this->role = $role;
        $this->profile = $profile;
    }

    public function sheets(): array
    {
        return [
            'Roles' => new RolesImport($this->role),
            'Users' => new UsersImport($this->user,$this->role,$this->profile),
        ];
    }
}