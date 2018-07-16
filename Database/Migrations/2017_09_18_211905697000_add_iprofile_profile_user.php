<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIprofileProfileUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        $users = DB::select('select * from users');
        foreach ($users as $key => $user) {
             DB::insert('insert into iprofile__profiles (user_id) values (?)', [$user->id]);
        }

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
