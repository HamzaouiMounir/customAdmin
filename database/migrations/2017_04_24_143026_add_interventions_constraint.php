<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInterventionsConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interventions', function (Blueprint $table) {
            //
          

            $table->integer('id_type_interv')->unsigned();
            $table->integer('id_type_status_interv')->unsigned();
            $table->integer('id_address')->unsigned();
            $table->foreign('id_type_interv')->references('id')->on('type_intervention');
            $table->foreign('id_type_status_interv')->references('id')->on('type_status_intervention');
            $table->foreign('id_address')->references('id')->on('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interventions', function (Blueprint $table) {
            //
        });
    }
}
