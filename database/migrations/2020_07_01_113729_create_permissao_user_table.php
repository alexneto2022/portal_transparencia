<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissaoUserTable extends Migration
{
    public function up()
    {
        Schema::create('permissao_user', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('permissao_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('permissao_id')->references('id')->on('permissao');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissao_user');
    }
}
