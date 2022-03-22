<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProcessoArquivos extends Model
{
    protected $table = 'processo_arquivos';
	
	protected $fillable = [
		'file_path',
	    'title',
		'processo_id',
		'unidade_id',
		'created_at',
		'updated_at'
	];
}
