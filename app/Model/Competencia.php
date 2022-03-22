<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    protected $table = 'competencias';
	
	protected $fillable = [
		'setor' ,
	    'cargo' ,
		'descricao' ,
		'unidade_id' ,
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'setor' => 'required',
		'cargo' => 'required',
		'descricao' => 'required'
	];
}
