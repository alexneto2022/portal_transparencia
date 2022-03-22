<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Decreto extends Model
{
    protected $table = 'decretos';
	
	protected $fillable = [
		'title',
		'decreto',
		'kind',
		'path_file'
	];
}
