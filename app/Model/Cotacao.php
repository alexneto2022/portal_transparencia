<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
    protected $table = 'cotacaos';
	
	protected $fillable = [
		'proccess_name',
		'file_name',
		'file_path',
		'ordering',
		'unidade_id'
	];
	
	public $rules = [
		'file_path'    => 'required',
		'ordering'	   => 'required'
	];
}
