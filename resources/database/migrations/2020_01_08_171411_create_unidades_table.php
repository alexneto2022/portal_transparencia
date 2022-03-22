<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('owner');
            $table->string('cnpj');
            $table->string('name');
            $table->string('address');
            $table->integer('numero')->nullable();
            $table->string('further_info')->nullable();
            $table->string('district');
            $table->string('city');
            $table->string('uf');
            $table->string('cep');
            $table->string('telefone');
            $table->string('time');
            $table->string('capacity')->nullable();
            $table->string('specialty')->nullable();
            $table->string('cnes')->nullable();
            $table->string('path_img')->nullable();
            $table->string('icon_img')->nullable();
            $table->string('google_maps')->nullable();
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
        Schema::dropIfExists('unidades');
    }
}
