<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIprofileAddressesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('iprofile__addresses', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('profile_id')->unsigned();
      $table->foreign('profile_id')->references('id')->on('iprofile__profiles')->onDelete('cascade');
      $table->string('firstname');
      $table->string('lastname');
      $table->string('company')->nullable();
      $table->text('address_1');
      $table->text('address_2')->nullable();
      $table->string('city');
      $table->string('postcode');
      $table->string('country');
      $table->string('zone')->nullable();
      $table->string('type');
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
    Schema::dropIfExists('iprofile__addresses');
  }
}
