<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prestador extends Model
{
	protected $table = 'prestadors';
	
	protected $fillable = [
		'prestador',
		'cnpj_cpf',
		'tipo_contrato',
		'tipo_pessoa',
		'created_at',	
		'updated_at'
	];
	
	public $rules = [
		'prestador' 	=> 'required',
		'cnpj_cpf' 		=> 'required',
		'tipo_contrato' => 'required',
		'tipo_pessoa'   => 'required'
	];
	
    public function contratos()
    {
        return $this->hasMany('App\Model\Contrato');
    }
}
