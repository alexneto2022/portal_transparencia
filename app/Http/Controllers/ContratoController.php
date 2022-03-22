<?php

namespace App\Http\Controllers;

use App\Model\ContratoGestao;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Validator;

class ContratoController extends Controller
{
    public function __construct(Unidade $unidade, ContratoGestao $contratoGestao, LoggerUsers $logger_users)
    {
        $this->unidade 		  = $unidade;
		$this->contratoGestao = $contratoGestao;
		$this->logger_users   = $logger_users;
    }
	
	public function index(Unidade $unidade)
    {
        $unidades = $this->unidade->all();
		return view('transparencia.contratoGestao', compact('unidades'));
    }
	
	public function contratoNovo($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		if($validacao == 'ok') {
			return view('transparencia/contratosGestao/contratoGestao_novo', compact('unidades','unidade','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
	public function contratoCadastro($id_unidade, ContratoGestao $contrato, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		if($id_unidade === 1){
			$contratos = ContratoGestao::all();
		}else{
			$contratos = ContratoGestao::where('unidade_id',$id_unidade)->get();
		}
		$lastUpdated = $contratos->max('updated_at');
    	if($validacao == 'ok') {
			return view('transparencia/contratosGestao/contratoGestao_cadastro', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
	public function contratoExcluir($id_unidade, $escolha, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = ContratoGestao::where('id',$escolha)->get();
        $lastUpdated = $contratos->max('updated_at');        
		if($validacao == 'ok') {
			return view('transparencia/contratosGestao/contratoGestao_excluir', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
    public function store($id_unidade, Request $request)
    { 
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = ContratoGestao::where('unidade_id',$id_unidade)->get();
        $lastUpdated = $contratos->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['path_file']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('path_file') === NULL) {	
			$validator = 'Informe o arquivo do contrato';
			return view('transparencia/contratosGestao/contratoGestao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title' => 'required|max:255',
					]);
				if ($validator->fails()) {
					return view('transparencia.contratoGestao', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$nome = $_FILES['path_file']['name']; 					
					$request->file('path_file')->move('../public/storage/contrato_gestao/', $nome);
					$input['path_file'] = 'contrato_gestao/' .$nome; 
					$contrato_gestao = ContratoGestao::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$contratos = ContratoGestao::where('unidade_id',$id_unidade)->get();
					$validator = 'Contrato de Gestão/Aditivo cadastrado com sucesso!';
					return view('transparencia/contratosGestao/contratoGestao_cadastro', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));				
				}
			} else {	
				$validator = 'Só suporta arquivos do tipo: PDF';
				return view('transparencia/contratosGestao/contratoGestao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	
    }
	
    public function destroy($id_unidade, $id_escolha, ContratoGestao $contrato, Request $request)
    {
        ContratoGestao::find($id_escolha)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['path_file'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = ContratoGestao::where('unidade_id',$id_unidade)->get();
		$validator = 'Contra de Gestão/Aditivo excluído com sucesso!';
   		return view('transparencia/contratosGestao/contratoGestao_cadastro', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }
}