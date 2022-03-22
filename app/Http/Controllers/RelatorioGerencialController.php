<?php

namespace App\Http\Controllers;

use App\Model\RelatorioGerencial;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class RelatorioGerencialController extends Controller
{
	public function __construct(Unidade $unidade, RelatorioGerencial $relatorio_gerencial, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->relatorio_gerencial = $relatorio_gerencial;
		$this->logger_users = $logger_users;
	}
	
    public function cadastroRelGerencial($id_unidade, Request $request)
	{ 	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$demonstrativoContaveis = RelatorioGerencial::where('unidade_id', $id_unidade)->orderBy('mes', 'ASC')->get();
        $lastUpdated = $demonstrativoContaveis->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/relatorioGerencial/relatorio_gerencial_cadastro', compact('unidade','unidades','unidadesMenu','demonstrativoContaveis','lastUpdated','permissao_users'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function relatorioGerencialNovo($id_unidade, Request $request)
	{ 	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$competenciasMatriz = RelatorioGerencial::where('unidade_id', $id_unidade)->get();
        $lastUpdated = $competenciasMatriz->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','permissao_users'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function storeRelatorioG($id_unidade, Request $request)
	{ 	
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$demonstrativoContaveis = RelatorioGerencial::where('unidade_id',$id_unidade)->get();
        $lastUpdated = $demonstrativoContaveis->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($input['ano'] < 1800){
			$validator = 'Ano Inválido!';		
			return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else if($input['ano'] > 2500){
			$validator = 'Ano Inválido!';
			return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
		if($request->file('file_path') === NULL) {	
			$validator = 'Informe o arquivo do Relatório Mensal de Execução!';		
			return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else {
			if($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title' => 'required|max:255',
					'ano'   => 'required|max:4'
				]);
				if ($validator->fails()) {
					return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				} else {
					$nome = $_FILES['file_path']['name']; 					
					$request->file('file_path')->move('../public/storage/relatorio_gerencial/', $nome);
					$input['file_path'] = 'relatorio_gerencial/' .$nome; 
					$demonstrativoContaveis = RelatorioGerencial::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$demonstrativoContaveis = RelatorioGerencial::where('unidade_id',$id_unidade)->get();
					$validator = 'Relatório Mensal de Execução cadastrado com sucesso!';
					$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
					return view('transparencia/relatorioGerencial/relatorio_gerencial_cadastro', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','permissao_users'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			} else {	
				$validator = 'Só é suportado arquivos: pdf!';
				return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}
	
	public function relatorioGerencialExcluir($id_unidade, $id_rel, Request $request)
	{ 	
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$demonstrativoContaveis = RelatorioGerencial::where('id', $id_rel)->get();
        $lastUpdated = $demonstrativoContaveis->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/relatorioGerencial/relatorio_gerencial_excluir', compact('unidade','unidades','unidadesMenu','demonstrativoContaveis','lastUpdated','permissao_users'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function destroy($id_unidade, $id_rel, Request $request)
	{ 	
		RelatorioGerencial::find($id_rel)->delete();  
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$demonstrativoContaveis = RelatorioGerencial::all();
		$validator = 'Relatório Mensal de Execução excluído com sucesso!';
		return view('transparencia/relatorioGerencial/relatorio_gerencial_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','demonstrativoContaveis'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));		
	}
}