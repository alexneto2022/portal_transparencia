<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Covenio extends Model
{
	protected $table = 'covenio';
	
	protected $fillable = [
		'path_name',
		'path_file',
		'unidade_id',
		'created_at',
		'updated_at'
	];
}
