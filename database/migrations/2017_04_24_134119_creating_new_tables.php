<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatingNewTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creation of tables: Address, TelNumber, TypeTelNumber, Region, Country ...
        Schema::create('tel_number_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_label');
            $table->string('logo_url')->nullable();
            $table->timestamps();
        });

        Schema::create('tel_number', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->timestamps();
        });

        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero');
            $table->string('street');
            $table->string('postal_code');
            $table->timestamps();
        });
        Schema::create('country', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_name');
            $table->timestamps();
        });
        Schema::create('region', function (Blueprint $table) {
            $table->increments('id');
            $table->string('region_name');
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
        //
        Schema::dropIfExists('tel_number_type');
        Schema::dropIfExists('tel_number');
        Schema::dropIfExists('address');
        Schema::dropIfExists('country');
        Schema::dropIfExists('region');
    }
}
