<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SelectiveProcess extends Model
{
    protected $table = 'selective_processes';
	
	protected $fillable = [
		'title',
		'file_path',
		'year',
		'ordering',
		'unidade_id',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'title' 	=> 'required',
		'file_path' => 'required',
		'year' 		=> 'required',
	];
}
