<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    protected $table = 'permissao';
	
	protected $fillable = [
		'acao',
		'tela',
		'created_at',
		'updated_at'
	];
}
