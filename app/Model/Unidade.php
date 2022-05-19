<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
	protected $table = 'unidades';

	protected $fillable = [
	    'id',
		'owner',
		'cnpj',
		'name',
		'address',
		'numero',
		'further_info',
		'district',
		'sigla',
		'city',
		'uf',
		'cep',
		'time',
		'telefone',
		'capacity',
		'specialty',
		'cnes',
		'path_img',
		'icon_img',
		'google_maps',
		'created_at',
		'updated_at',
	];
	
	public $rulesCadastro = [
		
		'owner' => 'required',
		'cnpj'  => 'required',
		'name'  => 'required',
		'telefone' => 'required'
	];
	
}
