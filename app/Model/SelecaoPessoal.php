<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SelecaoPessoal extends Model
{
	protected $table = 'selecao_pessoals';
	
	protected $fillable = [
		'cargo_name_id',
		'ano',
		'quantidade',
		'unidade_id',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'ano' 			=> 'required|digits:4|integer',
		'quantidade' 	=> 'required|integer'
	];
	
    public function cargos()
    {
        //$this->belongsTo(relação, chave estrangeira local, primary key da relação);
        return $this->belongsTo('App\Model\Cargo', 'cargo_name_id', 'id');
    }
}
