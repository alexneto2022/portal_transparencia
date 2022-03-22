<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecialidadeContratacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialidade_contratacao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contracao_servicos_id');
            $table->foreign('contracao_servicos_id')->references('id')->on('contratacao_servicos');
            $table->unsignedBigInteger('especialidades_id');
            $table->foreign('especialidades_id')->references('id')->on('especialidades');
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
        Schema::dropIfExists('especialidade_contratacao');
    }
}
