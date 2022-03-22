<?php

namespace App\Http\Controllers;

use App\Model\Competencia;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class CompetenciaController extends Controller
{
	
	public function __construct(Unidade $unidade, Competencia $competencia, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->competencia  = $competencia;
		$this->logger_users = $logger_users;
	}
	
    public function index()
    {
        $unidades = $this->unidade->all();
		return view('transparencia.competencia', compact('unidades')); 		
    }
	
	public function competenciaCadastro($id_unidade, $id_tem, Request $request)
	{ 	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$competenciasMatriz = Competencia::where('id', $id_tem)->get();
        $lastUpdated = $competenciasMatriz->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/competencia/competencia_cadastro', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated'));
		} else {
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function competenciaAlterar($id_unidade, $id_item, Request $request)
	{ 	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$competenciasMatriz = Competencia::where('id', $id_item)->get();
        $lastUpdated = $competenciasMatriz->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/competencia/competencia_alterar', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated'));	
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
	public function competenciaExcluir($id_unidade, $id_item, Request $request)
	{ 	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$competenciasMatriz = Competencia::where('id', $id_item)->get();
        $lastUpdated = $competenciasMatriz->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/competencia/competencia_excluir', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function competenciaNovo($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$competenciasMatriz = Competencia::where('id', $id_unidade)->get();
		$lastUpdated = $competenciasMatriz->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/competencia/competencia_novo', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated'));	
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
		$unidades = $this->unidade->all();
		$unidadesMenu = $this->unidade->all();
		$input = $request->all();			
		$competenciasMatriz = Competencia::where('unidade_id', $id)->get();
		$validator = Validator::make($request->all(), [
			'setor' => 'required|max:255',
			'cargo' => 'required|max:255',
			'descricao' => 'required|max:5000'
		]);
		if ($validator->fails()) {
			return view('transparencia/competencia/competencia_novo', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$competencia = Competencia::create($input); 
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$competenciasMatriz = Competencia::where('unidade_id', $id)->get();
			$validator = 'Matriz de Competência cadastrada com sucesso!';
			$permissao_users = PermissaoUsers::where('unidade_id', $id)->get(); 
			return view('transparencia.competencia', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','permissao_users'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

    public function update($id_unidade, $id_item, Request $request)
    { 
		$unidadesMenu = $this->unidade->all();
		$unidades 	  = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$competenciasMatriz = Competencia::where('id', $id_item)->get();
		$validator = Validator::make($request->all(), [
			'setor' => 'required|max:255',
			'cargo' => 'required|max:255',
			'descricao' => 'required|max:5000'
		]);   
		if ($validator->fails()) {
			return view('transparencia/competencia/competencia_alterar', compact('processos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$input = $request->all(); 
			$competencia = Competencia::find($id_item);
			$competencia->update($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$competenciasMatriz = Competencia::where('id', $id_item)->get();
			$lastUpdated = $competenciasMatriz->max('updated_at'); 
			$validator = 'Matriz de Competência alterada com sucesso!';
			return view('transparencia/competencia/competencia_cadastro', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }
	
    public function destroy($id_unidade, $id_item, Request $request)
    { 
		Competencia::find($id_item)->delete();
		$input = $request->all();	
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$competenciasMatriz = Competencia::where('unidade_id', $id_unidade)->get();
		$validator = 'Matriz de Copetência excluída com sucesso!';
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get(); 
		return view('transparencia.competencia', compact('unidade','unidades','unidadesMenu', 'competenciasMatriz','lastUpdated','permissao_users'))
		->withErrors($validator)
		->withInput(session()->flashInput($request->input()));				
    }
}