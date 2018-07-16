<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIprofileAddressEcommercesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iprofile__addressecommerces', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');


            $table->integer('profile_id')->unsigned();
            $table->foreign('profile_id')->references('id')->on('iprofile__profiles')->onDelete('cascade');
            
            $table->boolean('active')->default(0);

            $table->string('payment_firstname');

            $table->string('payment_lastname');

            $table->string('payment_company')->nullable();

            $table->text('payment_address_1');

            $table->text('payment_address_2')->nullable();

            $table->string('payment_city');

            $table->string('payment_postcode');

            $table->string('payment_country');

            $table->string('payment_zone');



            $table->string('shipping_firstname');

            $table->string('shipping_lastname');

            $table->string('shipping_company')->nullable();

            $table->text('shipping_address_1');

            $table->text('shipping_address_2')->nullable();

            $table->string('shipping_city');

            $table->string('shipping_postcode');

            $table->string('shipping_country');

            $table->string('shipping_zone');


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
        Schema::dropIfExists('iprofile__addressecommerces');
    }
}
