<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServidoresCedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servidores_cedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('cargo');
			$table->string('nome');
			$table->string('fone');
			$table->string('email');
			$table->string('matricula');
			$table->string('data_inicio');
			$table->string('observacao');
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
        Schema::dropIfExists('servidores_cedidos');
    }
}
