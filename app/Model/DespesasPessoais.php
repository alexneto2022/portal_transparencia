<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DespesasPessoais extends Model
{
    protected $fillable = [
		'Nivel',
		'Cargo',
		'Quant',
		'Valor',
		'Mes',
		'Ano'
	];
}
