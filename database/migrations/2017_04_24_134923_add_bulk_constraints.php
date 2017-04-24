<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBulkConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tel_number', function (Blueprint $table) {
             $table->integer('id_customer')->unsigned();
             $table->integer('id_tel_type')->unsigned();
             $table->foreign('id_customer')->references('id')->on('customers');
             $table->foreign('id_tel_type')->references('id')->on('tel_number_type');
        });

        Schema::table('address', function (Blueprint $table) {
             $table->integer('id_region')->unsigned();
             $table->integer('id_customer')->unsigned();
             $table->foreign('id_customer')->references('id')->on('customers');
             $table->foreign('id_region')->references('id')->on('region');
        });

        Schema::table('region', function (Blueprint $table) {
             $table->integer('id_country')->unsigned();
             $table->foreign('id_country')->references('id')->on('country');
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
    }
}
