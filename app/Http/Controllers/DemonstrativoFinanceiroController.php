<?php

namespace App\Http\Controllers;

use App\Model\DemonstrativoFinanceiro;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class DemonstrativoFinanceiroController extends Controller
{
	public function __construct(Unidade $unidade, DemonstrativoFinanceiro $demonstrativoFinanceiro, LoggerUsers $logger_users)
    {
        $this->unidade 				   = $unidade;
		$this->demonstrativoFinanceiro = $demonstrativoFinanceiro;
		$this->logger_users 		   = $logger_users;
    }
	
    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('demonstrativoFinanceiro', compact('unidades'));
    }

    public function demonstrativoFinanCadastro($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);	
		$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id)->get();
        $lastUpdated = $financialReports->max('updated_at');	
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-financeiro/demonstrativo_cadastro', compact('unidade','unidades','unidadesMenu', 'financialReports','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function demonstrativoFinanNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);		
		$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id)->get();
        $lastUpdated = $financialReports->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidade','unidades','unidadesMenu', 'financialReports','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function demonstrativoFinanAlterar($id_unidade, $id_item, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$financialReports = DemonstrativoFinanceiro::where('id', $id_item)->get(); 
        $lastUpdated = $financialReports->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-financeiro/demonstrativo_alterar', compact('unidade','unidades','unidadesMenu', 'financialReports','lastUpdated'));
		} else {
			$validator = "Você não tem Permissão!!";
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function demonstrativoFinanExcluir($id_unidade, $id_item, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);		
		$financialReports = DemonstrativoFinanceiro::where('id', $id_item)->get();
        $lastUpdated = $financialReports->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-financeiro/demonstrativo_excluir', compact('unidade','unidades','unidadesMenu', 'financialReports','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
    public function store($id_unidade, Request $request)
    {
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->get();
        $input = $request->all();
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		$mes = $input['mes'];
		$ano = $input['ano'];
		$financialR = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->where('mes', $mes)->where('ano',$ano)->get();
		$qtd = sizeof($financialR);
		if ($qtd > 3) {
			$validator = 'O Relatório correspondente a este mês e ao ano já foi cadastrado';
			return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades','unidade','unidadesMenu','financialReports'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
		if($request->file('file_path') === NULL) {	
			$validator = 'Informe o arquivo do demonstrativo.';
			return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades','unidade','unidadesMenu','financialReports'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else {
			if($extensao === 'pdf') {
				$validator = Validator::make($request->all(),[
					'title' => 'required',
					'mes'	=> 'required',
					'ano'	=> 'required'
				]);
				if ($validator->fails()) {					
					return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				}
				$ano  = $_POST['ano'];
				$mes  = $_POST['mes'];
				$qtdUnidades = sizeof($unidades); 
				for ( $i = 1; $i <= $qtdUnidades; $i++ ) { 				
					if ($unidade['id'] === $i) { 
						$txt1 = $unidades[$i-1]['path_img'];
						$txt1 = explode(".jpg", $txt1); 
						$txt2 = strtoupper($txt1[0]);								
						$nome = $mes .'.relat-mensal-finan-' .$ano. '-'.$txt2.'.pdf';
						$upload = $request->file('file_path')->move('../public/storage/relatorio-mensal-financeiro/'.$txt1[0].'/'.$ano.'/', $nome);
						$input['file_path'] = 'relatorio-mensal-financeiro/'.$txt1[0].'/'.$ano.'/'.$nome; 
					}
				}
				$demonstrativo = DemonstrativoFinanceiro::create($input);	
				$log = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');						
				$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
				$validator = 'Demonstrativo Financeiro cadastrado com sucesso!';
				return view('transparencia/demonstrativo-financeiro/demonstrativo_cadastro', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));	
			} else {	
				$validator = 'Só suporta arquivos do tipo: PDF!';
				return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));	
			}
		}
	}
	
    public function update($id_unidade, $id_item, Request $request, DemonstrativoFinanceiro $demonstrativoFinanceiro)
    {
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);	
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->get();
		$validator = 'Demonstrativo financeiro alterado com sucesso!';
		return view('transparencia/demonstrativo-financeiro/demonstrativo_cadastro', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }

    public function destroy($id_unidade, $id_item, Request $request)
    {
		DemonstrativoFinanceiro::find($id_item)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['file_path'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);	
		$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
		$validator = 'Demonstrativo Financeiro Excluído com sucesso!';
		return view('transparencia/demonstrativo-financeiro/demonstrativo_cadastro', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }
}