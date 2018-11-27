<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIprofileCustomfieldTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iprofile__customfield_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->integer('customfield_id')->unsigned();
            $table->string('locale')->index();
            $table->string('value')->nullable();
            $table->unique(['customfield_id', 'locale']);
            $table->foreign('customfield_id')->references('id')->on('iprofile__customfields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iprofile__customfield_translations', function (Blueprint $table) {
            $table->dropForeign(['customfield_id']);
        });
        Schema::dropIfExists('iprofile__customfield_translations');
    }
}
