<?php

namespace App\Http\Controllers;

use App\Model\LoggerUsers;
use App\Model\Unidade;
use App\Model\RegimentoInterno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PermissaoUsersController;
use Validator;

class RegimentoInternoController extends Controller
{
	public function __construct(Unidade $unidade, LoggerUsers $logger_users, RegimentoInterno $regimentoInterno)
	{
		$this->unidade 			= $unidade;
		$this->logger_users     = $logger_users;
		$this->regimentoInterno = $regimentoInterno;
	}
	
    public function index()
    {
        $unidades = $this->unidade->all();
		return view('transparencia.regimento_interno', compact('unidades'));
    }

	public function regimentoCadastro($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$regimentos = RegimentoInterno::where('unidade_id', $id)->get();
		if($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_cadastro', compact('unidades','unidadesMenu','unidade','regimentos'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function regimentoNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		if($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_novo', compact('unidades','unidadesMenu','unidade'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function regimentoAltera($id, $id_escolha, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id);
		$regimentos = RegimentoInterno::where('unidade_id', $id)->where('id', $id_escolha)->get();
		if ($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_alterar', compact('unidades', 'unidadesMenu', 'unidade', 'regimentos'));
		} else {
			$validator = 'Você não tem permissão !!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function regimentoExcluir($id, $id_escolha, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id);
		$regimentos = RegimentoInterno::where('unidade_id', $id)->where('id',$id_escolha)->get();
		if($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_excluir', compact('unidades','unidadesMenu','unidade','regimentos'));
		} else {
			$validator = 'Você não tem Permissão!!';		
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
		$input = $request->all();
		$nome = $_FILES['file_path']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if ($request->file('file_path') === NULL) {
			$validator = 'Informe o arquivo do Regimento Interno!';
			return view('transparencia/organizacional/regimento_novo', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if ($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title'    => 'required|max:255',
				]);
				if ($validator->fails()) {
					return view('transparencia/organizacional/regimento_novo', compact('unidades', 'unidade', 'unidadesMenu'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$nome = $_FILES['file_path']['name'];
					$request->file('file_path')->move('../public/storage/regimento_interno/', $nome);
					$input['file_path'] = 'regimento_interno/' . $nome;
					RegimentoInterno::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$regimentos = RegimentoInterno::where('unidade_id', $id)->get();
					$validator = 'Regismento interno cadastrado com sucesso!';
					return  redirect()->route('regimentoCadastro', [$id])
						->withErrors($validator)
						->with('unidades', 'unidade', 'unidadesMenu', 'regimentos', 'lastUpdated');
				}
			} else {
				$validator = 'Só são permitidos arquivos do tipo: PDF!';
				return view('transparencia/organizacional/regimento_novo', compact('unidades', 'unidade', 'unidadesMenu'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}
	
	public function update($id, $id_escolha, Request $request)
	{
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$input = $request->all();
		$regimentos = RegimentoInterno::where('unidade_id', $id)->where('id', $id_escolha)->get();
		if ($request->file('file_path') !== NULL) {
			$nome = $_FILES['file_path']['name'];
			$extensao = pathinfo($nome, PATHINFO_EXTENSION);
			if ($extensao !== 'pdf') {
				$validator = 'Só são permitidos arquivos do tipo: PDF!';
				return view('transparencia/organizacional/regimento_Alterar', compact('unidades', 'unidade', 'unidadesMenu', 'regimentos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$validator = Validator::make($request->all(), [
					'title'    => 'required|max:255',
				]);
				if ($validator->fails()) {
					return view('transparencia/organizacional/regimento_Alterar', compact('unidades', 'unidadesMenu', 'unidade', 'regimentos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$nome = $_FILES['file_path']['name'];
					$request->file('file_path')->move('../public/storage/regimento_interno/', $nome);
					$input['file_path'] = 'regimento_interno/' . $nome;
					$regimentosInterno = RegimentoInterno::find($id_escolha);
					$regimentosInterno->update($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$regimentos = RegimentoInterno::where('unidade_id', $id)->get();
					$validator = 'Regismento Interno Alterado com sucesso!';
					return  redirect()->route('regimentoAltera', [$id, $id_escolha])
						->withErrors($validator)
						->with('unidades', 'unidadesMenu', 'unidade', 'regimentos');
				}
			}
		} else {
			$validator = Validator::make($request->all(), [
				'title'    => 'required|max:255',
			]);
			if ($validator->fails()) {
				return view('transparencia/organizacional/regimento_Alterar', compact('unidades', 'unidadesMenu', 'unidade', 'regimentos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$regimentosInterno = RegimentoInterno::find($id_escolha);
				$regimentosInterno->update($input);
				$log = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');
				$regimentos = RegimentoInterno::where('unidade_id', $id)->get();
				$validator = 'Regismento Interno Alterado com sucesso!';
				return  redirect()->route('regimentoAltera', [$id, $id_escolha])
					->withErrors($validator)
					->with('unidades', 'unidadesMenu', 'unidade', 'regimentos');
			}
		}
	}

    public function destroy($id, $id_escolha, Request $request)
    {
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$input = $request->all();
		$nome = $input['file_path'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
        RegimentoInterno::find($id_escolha)->delete();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$regimentos = RegimentoInterno::where('unidade_id', $id)->get();
		$validator = 'Regismento Interno Exclupido com sucesso!';
		return  redirect()->route('regimentoCadastro', [$id])
			->withErrors($validator)
			->with('unidades', 'unidade', 'unidadesMenu', 'regimentos', 'lastUpdated');			
    }
}