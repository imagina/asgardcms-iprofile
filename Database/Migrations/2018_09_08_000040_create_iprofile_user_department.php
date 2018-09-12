<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIprofileUserDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iprofile__user_departments', function (Blueprint $table) {
          $table->engine = 'InnoDB';
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('restrict');
          $table->integer('department_id')->unsigned();
          $table->foreign('department_id')
            ->references('id')
            ->on('iprofile__departments')
            ->onDelete('restrict');
          $table->text('settings')->nullable();
          $table->text('options')->default('')->nullable();
          // Your fields
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('iprofile__user_departments', function (Blueprint $table) {
        $table->dropForeign([
          'user_id',
          'department_id'
        ]);
      });
      Schema::dropIfExists('iprofile__user_departments');
    }
}
