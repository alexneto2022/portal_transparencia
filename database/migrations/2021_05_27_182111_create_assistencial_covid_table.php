<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssistencialCovidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistencial_covid', function (Blueprint $table) {
            $table->bigIncrements('id');
	    $table->string('titulo');
	    $table->string('file_name');
	    $table->string('file_path');
	    $table->string('ano');
 	    $table->string('mes');
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
        Schema::dropIfExists('assistencial_covid');
    }
}