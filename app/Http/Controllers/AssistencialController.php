<?php

namespace App\Http\Controllers;

use App\Model\Assistencial;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class AssistencialController extends Controller
{
	public function __construct(Unidade $unidade, Assistencial $assistencial, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->assistencial = $assistencial;
		$this->logger_users = $logger_users;
	}

    public function index()
    {
        $unidades = $this->unidade->all();
		return view('transparencia.assistencial', compact('unidades')); 		
    }

	public function assistencialCadastro($id, Request $request)
	{ 	
		$validacao = permissaoUsersController::Permissao($id);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();		
		$anosRef = Assistencial::where('unidade_id', $id)->orderBy('ano_ref', 'ASC')->pluck('ano_ref')->unique();
        $lastUpdated = $anosRef->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/assistencial/assistencial_cadastro', compact('unidade','unidades','unidadesMenu','anosRef','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}

	public function assistencialAlterar($id_unidade, $id_item, Request $request)
	{ 	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$input = $request->all(); 	
		$anosRef = Assistencial::where('id', $id_item)->where('unidade_id',$id_unidade)->get();
		$ano = $anosRef[0]->ano_ref;
        $lastUpdated = $anosRef->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/assistencial/assistencial_alterar', compact('unidade','unidades','unidadesMenu','anosRef','lastUpdated','ano'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}

	public function assistencialExcluir($id_unidade, $id_item, Request $request)
	{ 	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();		
		$anosRef = Assistencial::where('ano_ref', $id_item)->where('unidade_id',$id_unidade)->get();
        $lastUpdated = $anosRef->max('updated_at');		
		if($validacao == 'ok') {
			return view('transparencia/assistencial/assistencial_excluir', compact('unidade','unidades','unidadesMenu','anosRef','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	 		
		}
	}

	public function assistencialNovo($id_unidade, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();		
		$ano = "";
		if($validacao == 'ok') {
			if(!empty($_GET['year'])) {
				$ano = $_GET['year'];
				$anosRef = Assistencial::where('ano_ref', $ano)->where('unidade_id',$id_unidade)->get();
				return view('transparencia/assistencial/assistencial_novo', compact('unidade','unidades','unidadesMenu','anosRef','ano'));
			} else {
				return view('transparencia/assistencial/assistencial_novo', compact('unidade','unidades','unidadesMenu','ano'));
			}
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

    public function storeAssistencial($id, Request $request)
    {	
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$anosRef = Assistencial::where('unidade_id', $id)->orderBy('ano_ref', 'ASC')->pluck('ano_ref')->unique();
        $lastUpdated = $anosRef->max('updated_at');
		$input = $request->all(); 	
		$ano = $input['ano_ref'];
		$validator = Validator::make($request->all(), [
			'descricao'	=>'required|max:800',
			'ano_ref' 	=>'required',
			'meta' 		=>'required|max:400',
		]);
		if ($validator->fails()) {
			return view('transparencia/assistencial/assistencial_novo', compact('unidade','unidadesMenu','anosRef','lastUpdated','ano'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if($input['descricao'] == ""){ $input['descricao'] = ""; }
			if($input['meta'] == ""){ $input['meta'] = ""; }
			if($input['janeiro'] == ""){ $input['janeiro'] = ""; }
			if($input['fevereiro'] == ""){ $input['fevereiro'] = ""; }
			if($input['marco'] == ""){ $input['marco'] = ""; }
			if($input['abril'] == ""){ $input['abril'] = ""; }
			if($input['maio'] == ""){ $input['maio'] = ""; }
			if($input['junho'] == ""){ $input['junho'] = ""; }
			if($input['julho'] == ""){ $input['julho'] = ""; }
			if($input['agosto'] == ""){ $input['agosto'] = ""; }
			if($input['setembro'] == ""){ $input['setembro'] = ""; }
			if($input['outubro'] == ""){ $input['outubro'] = ""; }
			if($input['novembro'] == ""){ $input['novembro'] = ""; }
			if($input['dezembro'] == ""){ $input['dezembro'] = ""; }
			$assistencial = Assistencial::create($input); 
			$ano = $input['ano_ref'];
			$anosRef = Assistencial::where('unidade_id', $id)->where('ano_ref', $ano)->get();
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$validator = 'Relatório Assistencial cadastrado com Sucesso!!';
			return view('transparencia/assistencial/assistencial_novo', compact('unidade','unidadesMenu','anosRef','lastUpdated','ano'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

    public function update($id_unidade, $id_item, Request $request)
    { 
		$unidadesMenu = $this->unidade->all();
		$unidades 	  = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$anosRef = Assistencial::where('unidade_id', $id_unidade)->get();
		$lastUpdated = $anosRef->max('updated_at'); 
		$input = $request->all(); 	
		$validator = Validator::make($request->all(), [
			'descricao'	=>'required|max:800',
			'ano_ref' 	=>'required',
			'meta' 		=>'required|max:400',
		]);	
		if ($validator->fails()) {
			return view('transparencia/assistencial/assistencial_alterar', compact('unidade','unidadesMenu','anosRef','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if($input['descricao'] == ""){ $input['descricao'] = ""; }
			if($input['meta'] == ""){ $input['meta'] = ""; }
			if($input['janeiro'] == ""){ $input['janeiro'] = ""; }
			if($input['fevereiro'] == ""){ $input['fevereiro'] = ""; }
			if($input['marco'] == ""){ $input['marco'] = ""; }
			if($input['abril'] == ""){ $input['abril'] = ""; }
			if($input['maio'] == ""){ $input['maio'] = ""; }
			if($input['junho'] == ""){ $input['junho'] = ""; }
			if($input['julho'] == ""){ $input['julho'] = ""; }
			if($input['agosto'] == ""){ $input['agosto'] = ""; }
			if($input['setembro'] == ""){ $input['setembro'] = ""; }
			if($input['outubro'] == ""){ $input['outubro'] = ""; }
			if($input['novembro'] == ""){ $input['novembro'] = ""; }
			if($input['dezembro'] == ""){ $input['dezembro'] = ""; }
			$assis = Assistencial::find($id_item);
			$assis->update($input);					
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$ano = $input['ano_ref'];
			$anosRef = Assistencial::where('unidade_id', $id_unidade)->where('ano_ref', $ano)->get();
			$validator = 'Relatório Assistencial alterado com sucesso!';
			return view('transparencia/assistencial/assistencial_novo', compact('unidade','unidades','unidadesMenu','anosRef','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }

    public function destroy($id_unidade, $id_item, Assistencial $assistencial, Request $request)
    { 
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $unidadesMenu;
    	$unidade = $this->unidade->find($id_unidade);
		$assistencial = Assistencial::where('unidade_id',$id_unidade)->where('ano_ref',$id_item)->get();
		$qtd = sizeof($assistencial);  
		for( $i = 0; $i < $qtd; $i++) {
			Assistencial::find($assistencial[$i]->id)->delete();  		
		}
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$anosRef = Assistencial::where('unidade_id', $id_unidade)->orderBy('ano_ref', 'ASC')->pluck('ano_ref')->unique();     
		$validator = 'Relatório Assistencial excluído com sucesso!';
		return view('transparencia/assistencial/assistencial_cadastro', compact('unidade','unidades','unidadesMenu','anosRef','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));			
    }
}