<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RelatorioGerencial extends Model
{
	protected $table = 'relatorio_gerencial';
	
	protected $fillable = [
		'title',
		'file_path',
		'ano',
		'mes',
		'unidade_id',
		'created_at',
		'updated_at'
	];
}
