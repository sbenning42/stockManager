<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_global_model_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->string('name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('address');
            $table->text('complement')->nullable();
            $table->integer('floor')->unsigned();
            $table->integer('elevator')->unsigned();
            $table->string('city');
            $table->string('postcode');
            $table->integer('longitude')->unsigned()->nullable();
            $table->integer('latitude')->unsigned()->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
