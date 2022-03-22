<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissaoTable extends Migration
{
    public function up()
    {
        Schema::create('permissao', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('acao');
			$table->string('tela');			
			$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissao');
    }
}
