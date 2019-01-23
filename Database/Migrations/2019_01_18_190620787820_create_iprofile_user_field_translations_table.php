<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIprofileUserFieldTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iprofile__user_field_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('value')->nullable();
            $table->integer('user_field_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['user_field_id', 'locale']);
            $table->foreign('user_field_id')->references('id')->on('iprofile__user_fields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iprofile__user_field_translations', function (Blueprint $table) {
            $table->dropForeign(['user_field_id']);
        });
        Schema::dropIfExists('iprofile__user_field_translations');
    }
}
