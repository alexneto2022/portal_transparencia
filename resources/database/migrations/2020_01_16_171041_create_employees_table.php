<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('matricula');
            $table->string('name');
            $table->string('cpf');
            $table->string('birth');
            $table->decimal('salario_bruto', 8, 2);
            $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');

            $table->unsignedBigInteger('area_ocupacao_id');
            $table->foreign('area_ocupacao_id')->references('id')->on('area_ocupacaos');

            $table->unsignedBigInteger('ocupacao_id');
            $table->foreign('ocupacao_id')->references('id')->on('ocupacaos');

            $table->unsignedBigInteger('regime_id');
            $table->foreign('regime_id')->references('id')->on('regime_trabalhos');
            
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
        Schema::dropIfExists('employees');
    }
}
