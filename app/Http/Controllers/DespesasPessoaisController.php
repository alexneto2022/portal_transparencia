<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\DespesasPessoais;
use App\Model\Unidade;
use DB;
use Validator;

class DespesasPessoaisController extends Controller
{
	public function __construct(Unidade $unidade)
	{
		$this->unidade = $unidade;
	}
	
    public function cadastroDespesas($id)
	{
		$unidades = $this->unidade->all();
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		return view('transparencia/rh/rh_despesasp_cadastro', compact('unidades','unidade','unidadesMenu'));
	}
	
	public function storeDespesas($id_unidade, Request $request)
	{
		$unidades = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$input = $request->all();
		$mes = $input['mes'];
		$ano = $input['ano'];
		$tipo = $input['tipo'];
		if($id_unidade == 2){
			$nome = 'hmr';
		} else if ($id_unidade == 3) {
		   $nome = 'belo_jardim';
	    } else if ($id_unidade == 4) {
		   $nome = 'arcoverde';
	    } else if ($id_unidade == 5) {
		   $nome = 'arruda';
	    } else if ($id_unidade == 6) {
		   $nome = 'upaecaruaru';
	    } else if ($id_unidade == 7) {
		   $nome = 'hss';
	    } else if ($id_unidade == 8) {
		   $nome = 'hpr';
	    } else if ($id_unidade == 9) {
	       $nome = 'igarassu'; 
	    }
		$qtd = 0; 
		if($qtd > 30) {
			$validator = 'Esta Despesa Pessoal já foi cadastrada!!';
			return view('transparencia/rh/rh_despesasp_cadastro', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else {
		   for($i = 1; $i < 11; $i++){
			   $nivel = "";
			   $cargo = "";
			   if($i == 1) {
				 $nivel = $input['nivel1'];
				 $cargo = $input['cargo'.$i];
			   } else if($i > 1 && $i < 5) {
				 $nivel = "";
				 $cargo = $input['cargo'.$i];
			   } else if ($i == 5) {
				 $nivel = $input['nivel2'];
				 $cargo = $input['cargo'.$i];
			   } else if ($i > 5 && $i < 8) {
				 $nivel = "";
				 $cargo = $input['cargo'.$i];
			   } else if ($i == 8) {
				 $nivel = $input['nivel3'];
				 $cargo = $input['cargo'.$i];
			   } else if ($i > 8 && $i < 10) {
				 $nivel = "";
				 $cargo = $input['cargo'.$i];
			   } else if ($i == 10){
				 $nivel = $input['nivel4'];
			   }
			   $qtd   = $input['Quant'.$i];
			   $valor = $input['valor'.$i];	
			   $despesas = DB::statement("INSERT INTO desp_com_pessoal_" .$nome. " (Nivel,Cargo,Quant,Valor
				,Mes,Ano,tipo) VALUES('$nivel','$cargo','$qtd','$valor','$mes','$ano','$tipo')");
		  }	
	   }
	   	$validator = 'Despesas com pessoal cadastrada com sucesso!';
		return view('transparencia/rh/rh_despesas_exibe', compact('unidades','unidade','unidadesMenu','mes','ano','tipo'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
	   }
}