<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPassagesStuff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('passages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_passage');
            $table->string('description_passage');
            $table->date('estimated_end_date');
            $table->enum('is_archived',['1','0'])->default('0');
            $table->timestamps();

        });
        Schema::create('type_status_passage', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('color_code');
            $table->enum('is_archived',['1','0'])->default('0');
            $table->timestamps();
        });
        Schema::create('type_passage', function (Blueprint $table) {
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
        Schema::dropIfExists('passages');
        Schema::dropIfExists('type_status_passage');
        Schema::dropIfExists('type_passage');
    }
}
