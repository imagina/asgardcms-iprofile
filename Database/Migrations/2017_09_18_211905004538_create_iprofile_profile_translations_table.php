<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIprofileProfileTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iprofile__profile_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('bio')->nullable();
            $table->integer('profile_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['profile_id', 'locale']);
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
        Schema::table('iprofile__profile_translations', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);
        });
        Schema::dropIfExists('iprofile__profile_translations');
    }
}
