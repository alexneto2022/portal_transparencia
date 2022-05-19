<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\RelatorioFinanceiro;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PermissaoUsersController;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class RelatorioFinanceiroController extends Controller
{
    public function __construct(Unidade $unidade, RelatorioFinanceiro $relatorioFinanceiro, LoggerUsers $logger_users)
    {
        $this->unidade 			   = $unidade;
		$this->relatorioFinanceiro = $relatorioFinanceiro;
		$this->logger_users 	   = $logger_users;
    }
	
	public function index()
    {
		$unidades = $this->unidade->all();
		return view ('transparencia', compact('unidades'));
    }
	
	public function cadastroRelatorio($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);	
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id)->orderBy('ano','ASC')->get();
        $lastUpdated = $relatorioFinanceiro->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/relatorioFinanceiro/relatorio_cadastro', compact('unidade','unidades','unidadesMenu','relatorioFinanceiro','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function relatorioNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);	
		if($validacao == 'ok') {
			return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function relatorioExcluir($id, $id_rel, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);	
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id', $id)->where('id',$id_rel)->get();
		$lastUpdated = $relatorioFinanceiro->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/relatorioFinanceiro/relatorio_excluir', compact('unidade','unidades','unidadesMenu','relatorioFinanceiro','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function storeRelatorio($id_unidade, Request $request)
    { 
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id', $id_unidade)->get();
        $lastUpdated = $relatorioFinanceiro->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('file_path') === NULL) {	
			$validator = 'Informe o arquivo do Relatório financeiro!';
			return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
		    $extensao = strtolower($extensao);
			if($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title' => 'required|max:255',
					'ano'   => 'required'
				]);
				if ($input['ano'] < 1800 || $input['ano'] > 2500) {
					$validator = 'O campo ano é inválido';
					return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}		
				if ($validator->fails()) {
					$failed = $validator->failed();
					$validator = 'Preencha todos os campos corretamente!';
					return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated'))
					->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
				}
				$ano  = $_POST['ano'];
				$qtdUnidades = sizeof($unidades);
				$nome = $_FILES['file_path']['name']; 				
				for ( $i = 1; $i <= $qtdUnidades; $i++ ) {
					if ( $unidade['id'] === $i ) {
						$txt1 = $unidades[$i-1]['path_img'];
						$txt1 = explode(".jpg", $txt1);		
						$request->file('file_path')->move('../public/storage/relatorioFinanceiro/'.$txt1[0].'/'.$ano.'/', $nome);
						$input['file_path'] = 'relatorioFinanceiro/'.$txt1[0].'/'.$ano.'/'.$nome; 	
					}
				}				
				$text = true;
				$relatorioFinanceiro = RelatorioFinanceiro::create($input);	
				$log = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');
				$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id_unidade)->get();
				$validator = 'Relatório Financeiro cadastrado com sucesso!';
				return view('transparencia/relatorioFinanceiro/relatorio_cadastro', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));				
			} else {
				$validator = 'Só suporta arquivos do tipo: PDF!';	
				$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id_unidade)->get();
				$lastUpdated = $relatorioFinanceiro->max('updated_at');
				return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
			}
		}
	}
		
		public function destroyRelatorio($id_unidade, $id_item, RelatorioFinanceiro $relatorioFinanceiro, Request $request)
		{
			RelatorioFinanceiro::find($id_item)->delete();		
			$input = $request->all();
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$nome = $input['file_path'];
			$pasta = 'public/'.$nome; 
			Storage::delete($pasta);
			$unidadesMenu = $this->unidade->all(); 
			$unidades = $this->unidade->all();
			$unidade = $unidadesMenu->find($id_unidade);		
			$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id_unidade)->get();
			$validator = 'Relatório Financeiro excluído com sucesso!';
			return view('transparencia/relatorioFinanceiro/relatorio_cadastro', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated'))
			->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
}