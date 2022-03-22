<?php

namespace App\Http\Controllers;

use App\Model\Superintendente;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use App\Http\Controllers\PermissaoUsersController;
use App\Model\PermissaoUsers;
use Auth;
use Validator;

class SuperintendentesController extends Controller
{
    public function __construct(Unidade $unidade, Request $request, Superintendente $superintendente, LoggerUsers $logger_users)
    {
        $this->unidade 		   = $unidade;
		$this->request 		   = $request;
		$this->superintendente = $superintendente;
		$this->logger_users    = $logger_users;
    }
	
	public function index()
	{
		$unidades = $this->unidade->all();
		return view('home', compact('unidades'));
	}
	
	public function listarSuper($id, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);	
		$superintendentes = $this->superintendente->all();
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_super_cadastro', compact('unidade','unidades','unidadesMenu','superintendentes'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function superNovo($id, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);		
		$superintendentes = $this->superintendente->all();
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_super_novo', compact('unidade','unidades','unidadesMenu','superintendentes'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function superAlterar($id_unidade, $id_super, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id_unidade);		
		$superintendentes = $this->superintendente->find($id_super);
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_super_alterar', compact('unidade','unidades','unidadesMenu','superintendentes'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function superExcluir($id_unidade, $id_super, Request $request)
	{	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id_unidade);		
		$superintendentes = $this->superintendente->find($id_super);
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_super_excluir', compact('unidade','unidades','unidadesMenu','superintendentes'));
		} else {
			$validator = 'Você não tem permissão!';
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
		$superintendentes = $this->superintendente->all();
		$input = $request->all(); 
        $validator = Validator::make($request->all(), [
			'name'  => 'required|max:255',
			'cargo' => 'required'
		]);
		if ($validator->fails()) {
			$failed = $validator->failed();
			$validator = 'Algo de errado aconteceu, verifique os campos e preencha novamente!';
			return view('transparencia/membros/membros_super_novo', compact('unidades','unidadesMenu','unidade','superintendentes'))
			->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$superintendente = Superintendente::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$superintendentes = $this->superintendente->all();
			$validator = 'Superintendente cadastrado com sucesso!';
			return view('transparencia/membros/membros_super_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','superintendentes'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
    }

    public function update($id_unidade, $id_super, Request $request, Superintendente $superintendente)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$superintendentes = $this->superintendente->all();
		$input = $request->all(); 
        $validator = Validator::make($request->all(), [
			'name'  => 'required|max:255',
			'cargo' => 'required'
		]);
		if ($validator->fails()) {
			return view('transparencia/membros/membros_super_alterar', compact('unidades','unidadesMenu','unidade','superintendentes'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$superintendente = Superintendente::find($id_super); 
			$superintendente->update($input);
			LoggerUsers::create($input);
			$superintendentes = $this->superintendente->all();
			$validator = 'Superintendente alterado com sucesso!';
			return view('transparencia/membros/membros_super_cadastro', compact('unidades','unidadesMenu','unidade','superintendentes'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}	
    }

    public function destroy($id_unidade, $id_super, Superintendente $superintendente, Request $request)
    {
        Superintendente::find($id_super)->delete();  
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$superintendentes = $this->superintendente->all();
		$validator = 'Superintendente excluído com sucesso!';
		return view('transparencia/membros/membros_super_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','superintendentes'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
    }
}