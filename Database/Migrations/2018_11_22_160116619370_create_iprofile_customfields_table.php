<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIprofileCustomfieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iprofile__customfields', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('profile_id')->unsigned();
            $table->string('name');
            $table->string('plainValue')->nullable();
            $table->boolean('isTranslatable')->default(false);
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->foreign('profile_id')->references('id')->on('iprofile__profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iprofile__customfields', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
        });
        Schema::dropIfExists('iprofile__customfields');
    }
}
