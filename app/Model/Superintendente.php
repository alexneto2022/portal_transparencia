<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Superintendente extends Model
{
    protected $table = 'superintendentes';
	
	protected $fillable = [
		'name',
		'cargo',
		'tipo_membro',
		'unidade_id',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'name' 		  => 'required',
		'cargo' 	  => 'required',
		'tipo_membro' => 'required'
	];
}
