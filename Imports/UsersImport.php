<?php

namespace Modules\Iprofile\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Modules\User\Entities\Sentinel\User;
use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\RoleRepository;

use Modules\Iprofile\Repositories\ProfileRepository;

class UsersImport implements ToCollection,WithHeadingRow,WithChunkReading,ShouldQueue
{

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

    /**
     * Data from Excel
     */
    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row) 
        {
            try {
                $errorMsj = "";
                // Email is priority to create an user
                if(isset($row['email']) && !empty($row['email'])){
                   
                    $user = User::where("email", $row['email'])->first();
                    
                    //If user has a role in the file
                    $roleCustomer = "";
                    if(isset($row['role']) && !empty($row['role']))
                        $roleCustomer = $this->role->findByName($row['role']);
                    else 
                        $roleCustomer = $this->role->findByName("user");

                    //data
                    $param = array(
                        'id' => (int)$row['id'],
                        'email' => $row['email'], 
                        'password' => (string)$row['password'],
                        'first_name' => $row['first_name'] ?? '' ,
                        'last_name' => $row['last_name'] ?? ''
                    );

                    // Check activated
                    $activated = false;
                    if(isset($row['activated']) && !empty($row['activated'])){
                        $userActived = (int)$row['activated'];
                        if($userActived==1)
                            $activated = true;
                    }
                    
                    //data profile
                    $paramIprofile = array(
                        'business' => (string)$row['business'] ?? '',
                        'identification' => (string)$row['identification'] ?? '', 
                        'bio' => (string)$row['bio'] ?? '',
                        'nit' => (string)$row['nit'] ?? '',
                        'type_person' => (string)$row['type_person'] ?? '',
                        'tel' => (string)$row['tel'] ?? '' ,
                        'address' => (string)$row['address'] ?? '',
                        'ext_number' => (string)$row['ext_number'] ?? '',
                        'birthday' => $row['birthday'] ?? '',
                        'city' => (string)$row['city'] ?? '',
                        'state' => (string)$row['state'] ?? '',
                        'country' => (string)$row['country'] ?? ''
                        
                    );

                    // Update
                    if(isset($user->email) && !empty($user->email)){

                        $param["activated"] = $activated;

                        $userUpd = $this->user->updateAndSyncRoles($user->id,  $param, $roleCustomer);
                        \Log::info('Update an User');

                        // update profile
                        $profile = $this->profile->findByUserId($user->id);
                      
                        $paramIprofile["user_id"] = $user->id;
                        $profileUser = $this->profile->update($profile,$paramIprofile);
                        \Log::info('Update a Profile');
                        $errorMsj = "updating";

                    }else{
                        // Create
                        //$userAdded = $this->user->createWithRolesFromCli($param,$roleCustomer,$activated);
                        $userAdded = $this->user->create($param,$activated);

                        // Take id from excel
                        $userAddedId = $userAdded->id;
                        $userAdded->id = $param["id"];
                        $userAdded->save();
                        \Log::info('Create an User');

                        $userAdded->roles()->attach($roleCustomer);

                        // create the profile
                        $paramIprofile["user_id"] = $userAdded->id;
                        $profileUser = $this->profile->create($paramIprofile);
                        \Log::info('Create a Profile');
                        $errorMsj = "Creating";

                    }//if

                }//if email
                
            } catch (\Exception $e) {
                \Log::error($e);
                dd($e->getMessage(),$row['email'],$errorMsj);
            }

        }// foreach

    }

    /*
    The most ideal situation (regarding time and memory consumption) 
    you will find when combining batch inserts and chunk reading.
    */
    public function batchSize(): int
    {
        return 1000;
    }

    /* 
     This will read the spreadsheet in chunks and keep the memory usage under control.
    */
    public function chunkSize(): int
    {
        return 1000;
    }

}