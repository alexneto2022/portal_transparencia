<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
	protected $table = 'contratos';
	
	protected $fillable = [
		'prestador_id',
		'objeto',
		'aditivos',
		'valor',
		'inicio',
		'fim',
		'renovacao_automatica',
		'aviso_venc90',
		'aviso_venc60',
		'yellow_alert',
		'red_alert',
		'file_path',
		'unidade_id',
		'ativa',
		'inativa',
		'created_at',
		'updated_at',
		'cadastro'
	];
		
	public $rules = [
		'objeto' 	=> 'required',
		'valor' 	=> 'required',
		'file_path' => 'required',
	    'inicio' 	=> 'required',
		'fim' 		=> 'required'
	];
	
    public function prestador()
    {
        return $this->belongsTo('App\Model\Prestador', 'prestador_id','id');
    }

    public function aditivosContrato(){
        return $this->hasMany('App\Model\Aditivo');
    }
}
