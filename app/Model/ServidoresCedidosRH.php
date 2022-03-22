<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServidoresCedidosRH extends Model
{
    protected $table = 'servidores_cedidos';
	
	protected $fillable = [
		'cargo',
		'nome',
		'fone',
		'email',
		'matricula',
		'data_inicio',
		'observacao',
		'unidade_id',
		'created_at',
		'updated_at'
	];
}
