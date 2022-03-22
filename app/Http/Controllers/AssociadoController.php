<?php

namespace App\Http\Controllers;

use App\Model\Associado;
use App\Model\ConselhoAdm;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class AssociadoController extends Controller
{
	public function __construct(Unidade $unidade, Associado $associado, Request $request, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->associado 	= $associado;
		$this->request 		= $request;
		$this->logger_users = $logger_users;
	}
	
    public function index()
    {
        $unidades = $this->associado->all();
		return view('home', compact('unidades')); 		
    }
	
	public function listarAssociado($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$associados = new Associado();
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$associados = $this->associado->all();
		$lastUpdated = $associados->max('last_updated');
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','associados'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
	public function associadoAlterar($id_unidade, $id_associado, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$associados = new Associado();
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$associado = $this->associado->find($id_associado);
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_alterar', compact('unidades','unidadesMenu','unidade','associado'));	
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function associadoNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$associados = new Associado();
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$associados = $this->associado->all();
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_novo', compact('unidades','unidadesMenu','unidade','associados'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function associadoExcluir($id_unidade, $id_associado , Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$associados = new Associado();
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$associados = $this->associado->find($id_associado);
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_excluir', compact('unidades','unidadesMenu','unidade','associados'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

    public function store($id, Request $request)
    {
		$unidadesMenu = $this->unidade->all();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->find($id);
		$associados = $this->associado->all();
		$input = $request->all(); 	
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'cpf'  => 'required|max:14|min:14',
		]);
		if ($validator->fails()) {
			return view('trasparencia/membros/membros_novo', compact('unidades','unidadesMenu','unidade','associados'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$associado = Associado::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$associados = $this->associado->all();
			$validator = 'Membro Associado, cadastrado com sucesso';
			return view('transparencia/membros/membros_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','associados'));
		}
    }

    public function update($id_unidade, $id_associado, Request $request)
    {	
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$associado = $this->associado->find($id_associado);
		$input = $request->all();
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'cpf'  => 'required|max:14|min:14',
		]);
		if ($validator->fails()) {
			return view('transparencia/membros/membros_alterar', compact('unidades','unidadesMenu','unidade','associados'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$associado = Associado::find($id_associado); 
			$associado->update($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$associados = $this->associado->all();
			$validator = 'Membro associado alterado com sucesso!';
			return view('transparencia/membros/membros_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','associados'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }

    public function destroy($id_unidade, $id_associado, Associado $associado, Request $request)
    { 
        Associado::find($id_associado)->delete();  
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$associados = $this->associado->all();
		$validator = 'Membro Associado excluído com sucesso!';
		return view('transparencia/membros/membros_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','associados'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }
}