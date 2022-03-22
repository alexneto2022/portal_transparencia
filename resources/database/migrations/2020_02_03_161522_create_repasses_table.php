<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repasses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mes');
            $table->string('ano');
            $table->decimal('contratado', 10, 2);
            $table->decimal('recebido', 10, 2);
            $table->decimal('desconto', 10, 2);
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
        Schema::dropIfExists('repasses');
    }
}
