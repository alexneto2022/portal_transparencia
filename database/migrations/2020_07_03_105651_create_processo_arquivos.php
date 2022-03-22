<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessoArquivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processo_arquivos', function (Blueprint $table) {
            $table->bigIncrements('id');
	    $table->string('file_path');
	    $table->string('title');
	    $table->unsignedBigInteger('processo_id');
            $table->foreign('processo_id')->references('id')->on('processos');
	    $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');
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
        Schema::dropIfExists('processo_arquivos');
    }
}
