<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContratoGestao extends Model
{
    protected $table = 'contrato_gestaos';
	
	protected $fillable = [
		'title',
		'path_file',
		'unidade_id',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'title' 	=> 'required',
		'path_file' => 'required'
	];
	
}
