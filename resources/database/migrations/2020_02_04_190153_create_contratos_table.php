<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prestador_id');
            $table->foreign('prestador_id')->references('id')->on('prestadors');
            $table->string('objeto');
            $table->boolean('aditivos');
            $table->decimal('valor')->nullable();
            $table->date('inicio');
            $table->date('fim')->nullable();
            $table->boolean('renovacao_automatica');
            $table->integer('yellow_alert')->nullable();
            $table->integer('red_alert')->nullable();
            $table->string('file_path')->nullable();
            $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->boolean('ativa');
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
        Schema::dropIfExists('contratos');
    }
}
