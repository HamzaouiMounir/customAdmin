<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInterventionsStuff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Intervention, Passage, TypeIntervention&Passage , TypeStatutIntervention & Passage

        Schema::create('interventions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_intervention');
            $table->string('description');
            $table->enum('is_archived',['1','0'])->default('0');
            $table->timestamps();
          
        });
        Schema::create('type_status_intervention', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('color_code');
            $table->enum('is_archived',['1','0'])->default('0');
            $table->timestamps();
        });
        Schema::create('type_intervention', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->enum('is_archived',['1','0'])->default('0');
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
        Schema::dropIfExists('interventions');
        Schema::dropIfExists('type_status_intervention');
        Schema::dropIfExists('type_intervention');
    }
}
