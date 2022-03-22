<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoggerUsersTable extends Migration
{
    public function up()
	{
		Schema::create('logger_users', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('tela');
			$table->string('acao');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('unidade_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('unidade_id')->references('id')->on('unidades');
			$table->timestamps();
	   });
	}

	public function down()
	{
		Schemma::dropIfExists('logger_users');
	}
}
