<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RegimentoInterno extends Model
{
    protected $table = 'regimento_interno';
	
	protected $fillable = [
		'title',
		'file_path',
		'unidade_id',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'title' 	  => 'required|max:255',
		'file_path'   => 'required'
	];
}
