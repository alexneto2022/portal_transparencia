<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    protected $table = 'gestor';
	
	protected $fillable = [
		'nome',
		'email',
		'created_at',
		'updated_at'
	];
}
