<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processos', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('numeroSolicitacao');
			$table->date('dataSolicitacao');
			$table->string('tipoPedido');
			$table->string('qtdItens');
			$table->string('fornecedor');
			$table->string('cnpj');
			$table->string('numeroOC');
			$table->decimal('totalValorOC', 10, 2);
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
        Schema::dropIfExists('processos');
    }
}
