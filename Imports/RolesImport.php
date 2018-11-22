<?php

namespace Modules\Iprofile\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Modules\User\Repositories\RoleRepository;

class RolesImport implements ToCollection,WithHeadingRow,WithChunkReading,ShouldQueue
{

    private $role;

    public function __construct(  
        RoleRepository $role
    
    ){
        $this->role = $role;
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
                
                if(isset($row['slug']) && !empty($row['slug'])){
                   
                    // Search by Slug or Name
                    $role = $this->role->findByName($row['slug']);
                    
                    //data
                    $param = array(
                        'id' => (int)$row['id'],
                        'slug' => (string)$row['slug'], 
                        'name' => (string)$row['name'] ?? '' 
                    );

                    // Update
                    if(isset($role->slug) && !empty($role->slug)){

                        $this->role->update($role->id,  $param);
                        \Log::info('Update a Role');
                        $errorMsj = "updating";

                    }else{
                    // Create
                        $newRole = $this->role->create($param);
                        
                        // Take id from excel
                        $newRole->id = $param["id"];
                        $newRole->save();
                        \Log::info('Create a Rol');
                        $errorMsj = "Creating";
                    }//if

                }//if email
                
            } catch (\Exception $e) {
                \Log::error($e);
                dd($e->getMessage(),$row['slug'],$errorMsj);
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