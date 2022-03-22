<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RelatorioFinanceiro extends Model
{
    protected $table = 'relatorio_financeiro';
	
	protected $fillable = [
		'title',
		'ano',
		'file_path',
		'unidade_id',
		'created_at',
		'updated_at'
	];
}
