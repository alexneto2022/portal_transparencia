<?php

namespace App\Http\Controllers;

use App\Model\ConselhoAdm;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class ConselhoAdmController extends Controller
{
	public function __construct(Unidade $unidade, Request $request, ConselhoAdm $conselhoAdm, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->request 		= $request;
		$this->conselhoAdm  = $conselhoAdm;
		$this->logger_users = $logger_users;
	}
   
    public function index()
    {
        $unidades = $this->unidade->all();
		return view('home', compact('unidades'));
    }

	public function listarConselhoAdm($id, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$conselhoAdms = $this->conselhoAdm->all();
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoAdm_cadastro', compact('unidade','unidades','unidadesMenu','conselhoAdms'));
		} else {
			$validator = 'Você não tem permissao!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
	public function conselhoAdmNovo($id, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$conselhoAdms = $this->conselhoAdm->all();
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoAdm_novo', compact('unidade','unidades','unidadesMenu','conselhoAdms'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
	public function conselhoAdmAlterar($id_unidade, $id_conselhoAdm, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id_unidade);
		$conselhoAdm = $this->conselhoAdm->find($id_conselhoAdm);
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoAdm_alterar', compact('unidade','unidades','unidadesMenu','conselhoAdm'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	 		
		}
	}
	
	public function conselhoAdmExcluir($id_unidade, $id_conselhoAdm, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id_unidade);
		$conselhoAdm = $this->conselhoAdm->find($id_conselhoAdm);
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoAdm_excluir', compact('unidade','unidades','unidadesMenu','conselhoAdm'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
    public function store($id, Request $request)
    {
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$conselhoAdms = $this->conselhoAdm->all();
		$input = $request->all(); 
		$validator = Validator::make($request->all(), [
			'name'  => 'required|max:255|unique:conselho_adms',
			'cargo' => 'required'
		]);
		if ($validator->fails()) {
			$validator = 'Algo de errado aconteceu, verifique os campos!';
			return view('transparencia/membros/membros_conselhoAdm_novo', compact('unidades','unidadesMenu','unidade','conselhoAdms'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$conselhoAdm = ConselhoAdm::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$conselhoAdms = $this->conselhoAdm->all();
			$validator = 'Conselho de Administração cadastrado com sucesso!';
			return view('transparencia/membros/membros_conselhoAdm_cadastro', compact('unidades','unidadesMenu','unidade','conselhoAdms'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}    
	}
    public function update($id_unidade, $id_conselhoAdm, Request $request)
    {
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$conselhoAdms = $this->conselhoAdm->all();
		$input = $request->all(); 
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'cargo'  => 'required'
		]);
		if ($validator->fails()) {
			return view('transparencia/membros/membros_conselhoAdm_alterar', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoAdms'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$conselhoAdm = ConselhoAdm::find($id_conselhoAdm); 
			$conselhoAdm->update($input);	
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$conselhoAdms = $this->conselhoAdm->all();
			$validator = 'Conselho de Adminstração alterado com sucesso!';
			return view('transparencia/membros/membros_conselhoAdm_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoAdms'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

    public function destroy($id_unidade, $id_conselhoAdm, ConselhoAdm $conselhoAdm, Request $request)
    {
        ConselhoAdm::find($id_conselhoAdm)->delete();  
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$conselhoAdms = $this->conselhoAdm->all();
		$validator = 'Conselho de Administração Excluído com sucesso!';
		return view('transparencia/membros/membros_conselhoAdm_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoAdms'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }
}