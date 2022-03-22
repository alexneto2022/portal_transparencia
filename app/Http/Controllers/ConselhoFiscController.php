<?php

namespace App\Http\Controllers;

use App\Model\ConselhoFisc;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class ConselhoFiscController extends Controller
{
    public function __construct(Unidade $unidade, Request $request, ConselhoFisc $conselhoFisc, LoggerUsers $logger_users)
    {
        $this->unidade 		= $unidade;
		$this->request 		= $request;
		$this->conselhoFisc = $conselhoFisc;
		$this->logger_users = $logger_users;
    }
	
	public function index()
    {
        $unidades = $this->unidade->all();
		return view ('home', compact('unidades'));
    }

	public function listarConselhoFisc($id, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$conselhoFiscs = $this->conselhoFisc->all();
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoFisc_cadastro', compact('unidade','unidades','unidadesMenu','conselhoFiscs'));
		} else {
			$validator = 'Você não tem Permissão';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function conselhoFiscNovo($id, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$conselhoFiscs = $this->conselhoFisc->all();
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoFisc_novo', compact('unidade','unidades','unidadesMenu','conselhoFiscs'));
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
	public function conselhoFiscAlterar($id_unidade, $id_conselhoFisc, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id_unidade);
		$conselhoFisc = $this->conselhoFisc->find($id_conselhoFisc);
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoFisc_alterar', compact('unidade','unidades','unidadesMenu','conselhoFisc'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
	public function conselhoFiscExcluir($id_unidade, $id_conselhoFisc, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id_unidade);
		$conselhoFisc = $this->conselhoFisc->find($id_conselhoFisc); 
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoFisc_excluir', compact('unidade','unidades','unidadesMenu','conselhoFisc'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	 		
		}
	}

    public function store($id, Request $request)
    {  
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$conselhoFiscs = $this->conselhoFisc->all();
		$input = $request->all(); 
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
		]);
		if ($validator->fails()) {
			return view('transparencia/membros/membros_conselhoFisc_novo', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoFiscs'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$conselhoFisc = conselhoFisc::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$conselhoFiscs = $this->conselhoFisc->all();
			$validator = 'Conselho Fiscal cadastrado com sucesso!';
			return view('transparencia/membros/membros_conselhoFisc_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoFiscs'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }
	
	public function update($id_unidade, $id_conselhoFisc, Request $request)
    {
        $unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$conselhoFisc = $this->conselhoFisc->find($id_conselhoFisc);
		$input = $request->all(); 
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
		]);
		if ($validator->fails()) {
			return view('transparencia/membros/membros_conselhoFisc_alterar', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoFiscs'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$conselhoFisc = conselhoFisc::find($id_conselhoFisc); 
			$conselhoFisc->update($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$conselhoFiscs = $this->conselhoFisc->all();
			$validator = 'Conselho Fiscal alterado com sucesso';
			return view('transparencia/membros/membros_conselhoFisc_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoFiscs'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

    public function destroy($id_unidade, $id_conselhoFisc, ConselhoFisc $conselhoFisc, Request $request)
    {
        ConselhoFisc::find($id_conselhoFisc)->delete();  
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$conselhoFiscs = $this->conselhoFisc->all();
		$validator = 'Conselho Fiscal excluído com sucesso!!';
		return view('transparencia/membros/membros_conselhoFisc_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoFiscs'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }
}