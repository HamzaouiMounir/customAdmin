<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPassagesConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passages', function (Blueprint $table) {
            //
            $table->integer('id_interv')->unsigned();
            $table->integer('id_type_status_passage')->unsigned();
            $table->integer('id_type_passage')->unsigned();
            $table->foreign('id_interv')->references('id')->on('interventions');
            $table->foreign('id_type_status_passage')->references('id')->on('type_status_passage');
            $table->foreign('id_type_passage')->references('id')->on('type_passage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('passages', function (Blueprint $table) {
            //
        });
    }
}
