<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Repasse extends Model
{
    protected $table = 'repasses';
	
	protected $fillable = [
		'mes',
		'ano',
		'contratado',
		'recebido',
		'desconto',
		'unidade_id',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'mes' 		 => 'required',
		'ano' 		 => 'required',
		'contratado' => 'required',
		'recebido'   => 'required',
		'desconto'   => 'required'
	];
}
