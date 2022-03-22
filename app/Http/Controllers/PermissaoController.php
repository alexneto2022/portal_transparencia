<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Permissao;
use App\Model\PermissaoUsers;
use App\Model\Unidade;
use App\Model\User;
use App\Http\Controllers\PermissaoUsersController;
use DB;

class PermissaoController extends Controller
{
    public function __construct(Unidade $unidade, Permissao $permissao, PermissaoUsers $permissao_user)
	{
		$this->unidade   = $unidade;
		$this->permissao = $permissao;
		$this->permissao_user = $permissao_user;
	}
	
	public function index(Unidade $unidade)
	{
		$unidade = $this->unidade->all();
		return view ('transparencia.permissao', compact('unidades'));
	}
	
	public function cadastroPermissao($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$permissoes = DB::table('permissao_user')
		->join('permissao', 'permissao_user.permissao_id', '=', 'permissao.id')
		->join('users', 'permissao_user.user_id', '=', 'users.id')
	    ->select('permissao_user.*','users.name as Nome','permissao.tela','permissao.acao')
		->where('unidade_id', $id)
		->get();
		$lastUpdated = $permissoes->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/permissao/permissao_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','permissoes'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function permissaoNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		if($validacao == 'ok') {
			return view('transparencia/permissao/permissao_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function permissaoUsuarioNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$users = User::all();
		$permissoes = Permissao::all();
		if($validacao == 'ok') {
			return view('transparencia/permissao/permissao_usuario_novo', compact('unidade','unidades','unidadesMenu','users','permissoes'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function permissaoAlterar($id, $id_permissao, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$permissoes = Permissao::where('unidade_id', $id)->where('id', $id_permissao)->get();
		$lastUpdated = $permissoes->max('updated_at');
		$users = User::all();
		if($validacao == 'ok') {
			return view('transparencia/permissao/permissao_alterar', compact('unidade','unidades','unidadesMenu','lastUpdated','permissoes','users'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function permissaoExcluir($id_permissao, $id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$permissoes = Permissao::where('id', $id_permissao)->get();
		$lastUpdated = $permissoes->max('updated_at');
		$users = User::all();
		if($validacao == 'ok') {
			return view('transparencia/permissao/permissao_excluir', compact('unidade','unidades','unidadesMenu','lastUpdated','permissoes','users'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function store($id, Request $request)
	{
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$input = $request->all();
		$input['unidade_id'] = $id;
		$permissao = Permissao::create($input);
		$lastUpdated = $permissao->max('updated_at');
		$permissoes = DB::table('permissao_user')
		->join('permissao', 'permissao_user.permissao_id', '=', 'permissao.id')
		->join('users', 'permissao_user.user_id', '=', 'users.id')
	    ->select('permissao_user.*','users.name as Nome','permissao.tela','permissao.acao')
		->where('unidade_id', $id)
		->get();
		return view('transparencia/permissao/permissao_cadastro', compact('unidade','unidadesMenu','unidades','permissoes','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	}
	
	public function storePermissaoUsuario($id, Request $request)
	{
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$input = $request->all();
		$unidade = $input['unidade'];
		if($unidade == 0) {
			for($i = 1; $i <= 8; $i++) {
				$input['unidade_id'] = $i;
				$permissao = PermissaoUsers::create($input);	
			}
		} else {
			$input['unidade_id'] = $unidade;
			$permissao = PermissaoUsers::create($input);
		}
		$lastUpdated = $permissao->max('updated_at');
		$permissoes = DB::table('permissao_user')
		->join('permissao', 'permissao_user.permissao_id', '=', 'permissao.id')
		->join('users', 'permissao_user.user_id', '=', 'users.id')
	    ->select('permissao_user.*','users.name as Nome','permissao.tela','permissao.acao')
		->where('unidade_id', $id)
		->get();
		$unidade = $this->unidade->find($id);	
		$validator = 'Permissão cadastrada com sucesso!';
		return view('transparencia/permissao/permissao_cadastro', compact('unidade','unidadesMenu','unidades','permissoes','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	}
	
	public function destroy()
	{
		
	}	
}
