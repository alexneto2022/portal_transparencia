<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssistencialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistencials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao');
            $table->unsignedBigInteger('indicador_id');
            $table->foreign('indicador_id')->references('id')->on('indicadors');
            $table->string('meta');
            $table->string('janeiro');
            $table->string('fevereiro');
            $table->string('marco');
            $table->string('abril');
            $table->string('maio');
            $table->string('junho');
            $table->string('julho');
            $table->string('agosto');
            $table->string('setembro');
            $table->string('outubro');
            $table->string('novembro');
            $table->string('dezembro');
            $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->string('ano_ref');
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
        Schema::dropIfExists('assistencials');
    }
}
