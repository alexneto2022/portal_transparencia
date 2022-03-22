<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Especialidades extends Model
{
	protected $table = 'especialidades';

    protected $fillable = [
		'id',
        'nome',
		'created_at',
		'updated_at'
	];
}
