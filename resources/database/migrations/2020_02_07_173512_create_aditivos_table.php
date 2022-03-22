<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAditivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aditivos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contrato_id');
            $table->foreign('contrato_id')->references('id')->on('contratos');
            $table->decimal('valor')->nullable();
            $table->date('inicio')->nullable();
            $table->date('fim')->nullable();
            $table->integer('yellow_alert')->nullable();
            $table->integer('red_alert')->nullable();
            $table->string('file_path')->nullable();
            $table->boolean('ativa')->nullable();
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
        Schema::dropIfExists('aditivos');
    }
}
