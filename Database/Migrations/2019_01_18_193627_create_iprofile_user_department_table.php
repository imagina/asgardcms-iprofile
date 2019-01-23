<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIprofileUserDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iprofile__user_department', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->text('settings')->nullable();
            $table->text('options')->default('')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
            $table->foreign('department_id')->references('id')->on('iprofile__departments')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iprofile__user_department', function (Blueprint $table) {
            $table->dropForeign(['user_id','department_id']);
        });
        Schema::dropIfExists('iprofile_user_department');
    }
}
