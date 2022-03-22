<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Estatuto extends Model
{
    protected $table = 'estatutos';

	protected $fillable = [
		'name',
		'kind',
		'path_file',
		'unidade_id',
		'created_at',
		'updated_at'
	];

	public $rules = [
		'name' => 'required',
		'kind' => 'required'
	];
}
