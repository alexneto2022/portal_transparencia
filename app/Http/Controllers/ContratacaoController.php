<?php

namespace App\Http\Controllers;

use App\Model\Contrato;
use App\Model\Aditivo;
use App\Model\Cotacao;
use App\Model\Unidade;
use App\Model\Prestador;
use App\Model\Processos;
use App\Model\ProcessoArquivos;
use App\Model\Gestor;
use App\Model\GestorContrato;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Imports\processoImport;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class ContratacaoController extends Controller
{
	public function __construct(Unidade $unidade, Contrato $contrato, Prestador $prestador, Cotacao $cotacao, LoggerUsers $loggerUsers, Aditivo $aditivo, Processos $processos, ProcessoArquivos $processo_arquivos)
	{
		$this->unidade     = $unidade;
		$this->contrato    = $contrato;
		$this->prestador   = $prestador;
		$this->cotacao     = $cotacao;
		$this->loggerUsers = $loggerUsers;
		$this->aditivo 	   = $aditivo;
		$this->processos   = $processos;
		$this->processo_arquivos = $processo_arquivos;
	}

	public function index(Unidade $unidade)
	{
		$unidades = $this->unidade->all();
		return view('transparencia.contrato', compact('unidades'));
	}

	public function contratacaoCadastro($id, Request $request)
	{
		$idspresta = array();
		$idscontratos = array();
		$validacao = permissaoUsersController::Permissao($id);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$contratos = DB::table('contratos')
			->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
			->select(
				'contratos.id as ID',
				'contratos.*',
				'prestadors.prestador as nome',
				'prestadors.*',
				'contratos.inativa as inativa',
			)
			->where('contratos.unidade_id', $id)
			->orderBy('nome', 'ASC')
			->get();
		$aditivos = Aditivo::where('unidade_id', $id)->orderBy('vinculado', 'ASC')->get();
		$lastUpdated = $contratos->max('updated_at');
		$processos = Processos::where('unidade_id', $id)->get();
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'aditivos', 'lastUpdated', 'processos', 'processo_arquivos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function addCotacao($id, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();

		return view('transparencia/contratacao/cotacao_excel', compact('unidades', 'unidade', 'unidadesMenu'));
	}

	public function arquivosCotacoes($id, $id_processo, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidades = $this->unidade->all();
		$unidade  = $this->unidade->find($id);
		$unidadesMenu = $unidades;
		$processo = Processos::where('unidade_id', $id)->where('id', $id_processo)->get();
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/cotacao_arquivos_novo', compact('unidades', 'unidade', 'unidadesMenu', 'processo', 'processo_arquivos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function validarCotacoes($id, $id_processo, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidades = $this->unidade->all();
		$unidade  = $this->unidade->find($id);
		$unidadesMenu = $unidades;
		$cotacoes = Cotacao::find($id_processo);
		DB::statement('UPDATE cotacaos SET validar = 0 WHERE id = ' . $id_processo . ';');
		$cotacoes = Cotacao::where('unidade_id', $id)->get();
		if ($validacao == 'ok') {
			$validator = 'Cotação Válidado com sucesso!';
			return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'permissao_users'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeArquivoCotacao($id, $id_processo, Request $request)
	{
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id)->get();
		$cotacoes = Cotacao::find($id_processo);
		$unidades = $this->unidade->all();
		$unidade  = $this->unidade->find($id);
		$unidadesMenu = $unidades;
		$processos = Processos::where('unidade_id', $id)->where('id', $id_processo)->paginate(15);
		$input = $request->all();
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
		]);
		if ($validator->fails()) {
			return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'processos', 'cotacoes', 'processo_arquivos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$solicitacao = $input['numeroSolicitacao'];
			$nome = $_FILES['file_path']['name'];
			$request->file('file_path')->move('../public/storage/cotacoes/arquivos/' . $solicitacao . '/', $nome);
			$input['file_path'] = 'cotacoes/arquivos/' . $solicitacao . '/' . $nome;
			$input['processo_id'] = $id_processo;
			ProcessoArquivos::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$processo_arquivos = ProcessoArquivos::where('unidade_id', $id)->get();
			$validator = 'Arquivo da cotação cadastrado com sucesso!';
			return view('transparencia/contratacao/cotacao_arquivos_novo', compact('unidade', 'unidades', 'unidadesMenu', 'processos', 'cotacoes', 'processo_arquivos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeExcelCotacao($id, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade  = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$processos = Processos::where('unidade_id', $id)->get();
		$nome = $_FILES['file_path']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if ($request->file('file_path') === NULL) {
			$validator = 'Informe o arquivo do Contrato!';
			return view('transparencia/contratacao/cotacao_excel', compact('unidades', 'unidade', 'unidadesMenu', 'processos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if (($extensao === 'csv') || ($extensao === 'xls') || ($extensao === 'xlsx')) {
				$validator = Validator::make($request->all(), [
					'file_path' => 'required',
				]);
				if ($validator->fails()) {
					return view('transparencia/contratacao/contacao_excel', compact('unidades', 'unidade', 'unidadesMenu', 'processos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$processosA = Processos::where('unidade_id', $id)->get();
					$qtdA = sizeof($processosA);
					\Excel::import(new processoImport($id), $request->file('file_path'));
					$processosD = Processos::where('unidade_id', $id)->get();
					$qtdD = sizeof($processosD);
					if ($qtdA == $qtdD) {
						$validator = 'Erro ao salvar processo! O número do protocolo já existe!';
						return view('transparencia/contratacao/cotacao_excel', compact('unidades', 'unidade', 'unidadesMenu', 'processos'))
							->withErrors($validator)
							->withInput(session()->flashInput($request->input()));
					}
					$cotacoes = Cotacao::where('unidade_id', $id)->get();
					$contratos = Contrato::where('unidade_id', $id)->get();
					$processos = Processos::where('unidade_id', $id)->get();
					$lastUpdated = $contratos->max('updated_at');
					$aditivos = Aditivo::where('unidade_id', $id)->get();
					$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
					$processo_arquivos = ProcessoArquivos::where('unidade_id', $id)->get();
					$a = 0;
					return view('transparencia.contratacao', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'aditivos', 'lastUpdated', 'cotacoes', 'processos', 'permissao_users', 'a', 'processo_arquivos'));
				}
			} else {
				$validator = 'Só são suportados arquivos tipo: .csv, .xls, .xlsx';
				return view('transparencia/contratacao/cotacao_excel', compact('unidades', 'unidade', 'unidadesMenu', 'processos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}

	public function prestadorCadastro($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_prestador_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'contratos'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function cadastroContratos($id_unidade, Contrato $contrato)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->get();
		$vinculos = Aditivo::where('vinculado')->get();
		$CP = array();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'vinculos', 'CP'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarContratos($id_unidade, $id_prestador, $id_contrato)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->where('prestador_id', $id_prestador)->where('inativa', 0)->get();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->where('opcao')->get();
		$prestadores = Prestador::where('id', $id_prestador)->get();
		$ccontratos = DB::table('contratos')
			->join('aditivos', 'aditivos.contrato_id', '=', 'contratos.id')
			->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
			->select('contratos.id', 'contratos.prestador_id', 'contratos.unidade_id', 'aditivos.id', 'aditivos.opcao', 'prestadors.prestador', 'prestadors.cnpj_cpf')
			->where('contratos.unidade_id', '=', $id_unidade)
			->where('contratos.prestador_id', '=', $id_prestador)
			->where('aditivos.opcao', '=', '0')
			->get();
		$vinculos = DB::table('contratos')
			->join('aditivos', 'aditivos.contrato_id', '=', 'contratos.id')
			->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
			->select('contratos.id', 'aditivos.contrato_id as cont_id', 'contratos.prestador_id as prestador_ID', 'contratos.unidade_id', 'aditivos.file_path', 'aditivos.id as aditivo_ID', 'aditivos.opcao', 'prestadors.prestador', 'prestadors.cnpj_cpf', 'aditivos.vinculado', 'aditivos.ativa as ativa', 'aditivos.inativa as inativa')
			->where('contratos.unidade_id', '=', $id_unidade)
			->where('contratos.prestador_id', '=', $id_prestador)
			->where('aditivos.inativa', '=', '0')
			->orderBy('vinculado', 'ASC')
			->get();
		/*
		for ($i=0; $i < sizeof($vinculos); $i++) { 
			echo $vinculos[$i]->aditivo_ID; 
			echo "<br>";
		}
		exit();
		*/


		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'vinculos', 'ccontratos', 'aditivos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function cadastroCotacoes($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
		$processos = Processos::where('unidade_id', $id_unidade)->paginate(50);
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->paginate(50);
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'processos', 'processo_arquivos'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function cotacoesNovo($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cotacoes_novo', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function pesquisarPrestador($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$prestadores = Prestador::all();
		$lastUpdated = $prestadores->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_pesquisar_prestador', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'prestadores'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function responsavelCadastro($id_unidade, $id_contrato, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$gestores = Gestor::all();
		$contrato = Contrato::where('id', $id_contrato)->get();
		$gestorContratos = DB::table('gestor_contrato')
			->join('gestor', 'gestor_contrato.gestor_id', '=', 'gestor.id')
			->join('unidades', 'unidades.id', '=', 'gestor_contrato.unidade_id')
			->select('gestor.nome as Nome', 'gestor_contrato.*')
			->where('gestor_contrato.contrato_id', $id_contrato)
			->where('unidade_id', $id_unidade)
			->get()->toArray();
		$lastUpdated = $gestores->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_responsavel_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'gestores', 'contrato', 'gestorContratos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function responsavelNovo($id_unidade, $id_contrato, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$prestadores = Prestador::all();
		$lastUpdated = $prestadores->max('updated_at');
		$contrato = Contrato::where('id', $id_contrato)->get();
		$id = $contrato[0]->id;
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_gestor_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'prestadores', 'id'));
		} else {
			$validator = 'Você não tem Permissão!!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function pesqPresdator($id_unidade, $id_prestador, Contrato $contrato, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		if ($id_prestador == "procurarPrestador") {
			$prestadores = null;
			return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'prestadores'));
		} else {
			$prestadores = Prestador::where('id', $id_prestador)->get();
			$lastUpdated = $prestadores->max('updated_at');
			//$CP = Contratos do prestador selecionado
			$CP = array();
			$contraPrest = Contrato::where('prestador_id', $id_prestador)->where('unidade_id', $id_unidade)->get();
			if (sizeof($contraPrest) > 0) {
				$contraAditoPrest = Aditivo::where('contrato_id', $contraPrest[0]->id)->where('opcao', 0)->where('ativa', 0)->get();
				$qtdContratos = sizeof($contraPrest) + sizeof($contraAditoPrest);
				for ($i = 0; $i < $qtdContratos; $i++) {
					$CP[$i] = $i + 1 . "º Contrato";
				}
			}
			if ($validacao == 'ok') {
				return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'prestadores', 'CP'));
			} else {
				$validator = 'Você não tem permissão!';
				return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}

	public function procurarPrestador($id_unidade, Request $request, Contrato $contrato)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$input = $request->all();
		$funcao = $input['funcao'];
		$pesq = $input['pesq'];
		if ($funcao == 0) {
			if (!$pesq == "") {
				$prestadores = DB::table('prestadors')->where('prestadors.prestador', 'like', '%' . $pesq . '%')->get();
				$lastUpdated = $prestadores->max('updated_at');
			} else {
				$prestadores = Prestador::all();
				$lastUpdated = $prestadores->max('updated_at');
			}
		} else if ($funcao == 1) {
			$prestadores = DB::table('prestadors')->where('prestadors.cnpj_cpf', 'like', '%' . $pesq . '%')->get();
			$lastUpdated = $prestadores->max('updated_at');
		} else if ($funcao == 2) {
			$prestadores = DB::table('prestadors')->where('prestadors.tipo_contrato', 'like', '%' . $pesq . '%')->get();
			$lastUpdated = $prestadores->max('updated_at');
		} else if ($funcao == 3) {
			$prestadores = DB::table('prestadors')->where('prestadors.tipo_pessoa', 'like', '%' . $pesq . '%')->get();
			$lastUpdated = $prestadores->max('updated_at');
		} else {
			$prestadores = Prestador::all();
			$lastUpdated = $prestadores->max('updated_at');
		}
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_pesquisar_prestador', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'prestadores'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirAditivos($id_unidade, $id_aditivo, Request $request)
	{

		$validacao = permissaoUsersController::Permissao($id_unidade);
		Aditivo::find($id_aditivo)->delete();
		$input = $request->all();
		$input['tela'] = 'contratacao';
		$input['acao'] = 'excluirContratacao';
		$input['user_id'] = Auth::user()->id;
		$input['unidade_id'] = $id_unidade;
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = DB::table('contratos')
			->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
			->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
			->where('contratos.unidade_id', $id_unidade)
			->orderBy('nome', 'ASC')
			->get()->toArray();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->get();
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated', 'permissao_users', 'aditivos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirContratos($id_unidade, $id_contrato)
	{

		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = Contrato::where('id', $id_contrato)->get();
		$id_prestador = $contratos[0]->prestador_id;
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->where('contrato_id', $id_contrato)->get();
		$lastUpdated = $contratos->max('updated_at');
		$prestador = Prestador::where('id', $id_prestador)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_excluir', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated', 'prestador', 'aditivos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirCotacoes($id_unidade, $id_cotacao, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$cotacoes = Cotacao::where('id', $id_cotacao)->get();
		$lastUpdated = $cotacoes->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cotacoes_excluir', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'cotacoes'));
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storePrestador($id_unidade, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$input = $request->all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->get();
		$validator = Validator::make($request->all(), [
			'prestador'     => 'required|max:255',
			'cnpj_cpf'         => 'required|min:14|max:18',
		]);
		if ($validator->fails()) {
			return view('transparencia/contratacao/contratacao_prestador_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'contratos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$prestador = Prestador::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$contratos = Contrato::where('unidade_id', $id_unidade)->get();
			$validator = 'Prestador cadastrado com sucesso!';
			return view('transparencia/contratacao/contratacao_prestador_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'contratos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeGestor($id_unidade, $id_contrato, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$input = $request->all();
		$validator = Validator::make($request->all(), [
			'nome'  => 'required|max:255',
			'email' => 'required|email'
		]);
		if ($validator->fails()) {
			return view('transparencia/contratacao/contratacao_responsavel_novo', compact('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'gestores', 'contrato'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$gestor = Gestor::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$gestores = Gestor::all();
			$contrato = Contrato::where('id', $id_contrato)->get();
			$validator = 'Gestor cadastrado com sucesso!';
			return  redirect()->route('responsavelCadastro', [$id_unidade, $id_contrato])
				->withErrors($validator)
				->with('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'gestores', 'contrato');
		}
	}

	public function validarGestorContrato($id_unidade, $id_gestor, $id_contrato, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$hoje = date('Y-m-d', (strtotime('now')));
		$input = $request->all();
		$input['contrato_id'] = $id_contrato;
		$input['gestor_id'] = $id_gestor;
		$gestorContrato = GestorContrato::where('contrato_id', $id_contrato)->where('gestor_id', $id_gestor)->get();
		$qtd = sizeof($gestorContrato);
		if ($qtd > 0) {
			$gestores = Gestor::all();
			$contrato = Contrato::where('id', $id_contrato)->get();
			$gestorContratos = DB::table('gestor_contrato')
				->join('gestor', 'gestor_contrato.gestor_id', '=', 'gestor.id')
				->join('unidades', 'unidades.id', '=', 'gestor_contrato.unidade_id')
				->select('gestor.nome as Nome', 'gestor_contrato.*')
				->where('gestor_contrato.contrato_id', $id_contrato)
				->where('unidade_id', $id_unidade)
				->get()->toArray();
			$lastUpdated = $gestores->max('updated_at');
			$validator = 'Gestor já vinculado para este contrato!';
			return  redirect()->route('responsavelCadastro', [$id_unidade, $id_contrato])
				->withErrors($validator)
				->with('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'gestores', 'contrato', 'gestorContratos');
		} else {
			$input['unidade_id'] = $id_unidade;
			$gestorContrato = GestorContrato::create($input);
			$lastUpdated = $gestorContrato->max('updated_at');
			$gestores = Gestor::all();
			$contrato = Contrato::where('id', $id_contrato)->get();
			$gestorContratos = DB::table('gestor_contrato')
				->join('gestor', 'gestor_contrato.gestor_id', '=', 'gestor.id')
				->select('gestor.nome as Nome', 'gestor_contrato.*')
				->where('gestor_contrato.contrato_id', $id_contrato)
				->get()->toArray();
			$validator = 'Gestor vinculado ao Contrato com sucesso!!';
			return  redirect()->route('responsavelCadastro', [$id_unidade, $id_contrato])
				->withErrors($validator)
				->with('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'gestores', 'contrato', 'gestorContratos');
		}
	}

	public function updateContratos($id_unidade, $id_prestador, $id_contrato, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->where('prestador_id', $id_prestador)->get();
		$prestadores = Prestador::where('id', $id_prestador)->get();
		$input = $request->all();
		if ($input['file_path_'] !== "") {
			$extensao = 'pdf';
		}
		$data1 = $input['inicio'];
		$data2 = $input['fim'];
		if (strtotime($data1) > strtotime($data2)) {
			$validator = 'O campo data fim, não pode ser maior que o campo data início';
			return view('transparencia/contratacao/contratacao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
		$i = $input['i'];
		for ($a = 1; $a <= $i; $a++) {
			$vinculado     = $input['cont_' . $a];
			$id			   = $input['id_' . $a];
			DB::update(DB::RAW("update aditivos set vinculado = '$vinculado' where id = " . $id));
		}
		$input['yellow_alert'] = 90;
		$input['red_alert']    = 60;
		if ($input['valor'] < 0) {
			$validator = 'O campo valor é inválido!';
			return view('transparencia/contratacao/contratacao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
		$validator = Validator::make($request->all(), [
			'objeto' 	=> 'required|max:255',
			'valor' 	=> 'required'
		]);
		if ($validator->fails()) {
			return view('transparencia/contratacao/contratacao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores'))
				->withErrors()
				->withInput(session()->flashInput($request->input()));
		} else {
			if ($request->file('file_path') === NULL && $input['file_path_'] == "") {
				$validator = 'Informe o arquivo da contratação!';
				return view('transparencia/contratacao/contratacao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				if ($extensao == 'pdf') {
					$input['ativa'] = 1;
					$qtdUnidades = sizeof($unidades);
					for ($i = 1; $i <= $qtdUnidades; $i++) {
						if ($unidade['id'] === $i) {
							$txt1 = $unidades[$i - 1]['path_img'];
							$txt1 = explode(".jpg", $txt1);
							$nome = $_FILES['file_path']['name'];
							if ($request->file('file_path') !== NULL) {
								$request->file('file_path')->move('../public/storage/contratos/' . $txt1[0] . '/', $nome);
								$input['file_path'] = 'contratos/' . $txt1[0] . '/' . $nome;
							}
							$input['prestador_id'] = $id_prestador;
							$input['aviso_venc90'] = 0;
							$input['aviso_venc60'] = 0;
							$contrato = Contrato::find($id_contrato);
							$contrato->update($input);
							$log = LoggerUsers::create($input);
							$lastUpdated = $log->max('updated_at');
						}
					}
					$unidades = $unidadesMenu = $this->unidade->all();
					$unidade = $this->unidade->find($id_unidade);
					$unidadesMenu = $this->unidade->all();
					$contratos = Contrato::where('unidade_id', $id_unidade)->where('prestador_id', $id_prestador)->where('inativa', 0)->get();
					$aditivos = Aditivo::where('unidade_id', $id_unidade)->where('opcao')->get();
					$prestadores = Prestador::where('id', $id_prestador)->get();
					$ccontratos = DB::table('contratos')
						->join('aditivos', 'aditivos.contrato_id', '=', 'contratos.id')
						->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
						->select('contratos.id', 'contratos.prestador_id', 'contratos.unidade_id', 'aditivos.id', 'aditivos.opcao', 'prestadors.prestador', 'prestadors.cnpj_cpf')
						->where('contratos.unidade_id', '=', $id_unidade)
						->where('contratos.prestador_id', '=', $id_prestador)
						->where('aditivos.opcao', '=', '0')
						->get();
					$vinculos = DB::table('contratos')
						->join('aditivos', 'aditivos.contrato_id', '=', 'contratos.id')
						->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
						->select(
							'contratos.id',
							'aditivos.contrato_id as cont_id',
							'contratos.prestador_id as prestador_ID',
							'contratos.unidade_id',
							'aditivos.file_path',
							'aditivos.id as aditivo_ID',
							'aditivos.opcao',
							'prestadors.prestador',
							'prestadors.cnpj_cpf',
							'aditivos.vinculado',
							'aditivos.ativa as ativa',
							'aditivos.inativa as inativa'
						)
						->where('contratos.unidade_id', '=', $id_unidade)
						->where('contratos.prestador_id', '=', $id_prestador)
						->where('aditivos.inativa', '=', '0')
						->get();
					$validator = 'Dados alterados com sucesso!';
					return  redirect()->route('alterarContratos', [$id_unidade, $id_prestador, $id_contrato])
						->withErrors($validator)
						->with('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'vinculos', 'ccontratos', 'aditivos');
				} else {
					$validator = 'Só são suportador arquivos do tipo PDF!';
					return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdate'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			}
		}
	}

	public function alterarAditivo($id_unidade, $id_aditivo, $id_contrato)
	{

		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->where('id', $id_contrato)->get();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->where('id', $id_aditivo)->get();
		$prestadores = Prestador::where('id', $contratos[0]->prestador_id)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function updateAditivo($id_unidade, $id_aditivo, $id_contrato, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->where('id', $id_contrato)->get();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->where('id', $id_aditivo)->get();
		$prestadores = Prestador::where('id', $contratos[0]->prestador_id)->get();
		$input = $request->all();
		if ($input['file_path_'] !== "") {
			$extensao = 'pdf';
		}
		$data1 = $input['inicio'];
		$data2 = $input['fim'];
		if (strtotime($data1) > strtotime($data2)) {
			$validator = 'O campo data fim, não pode ser maior que o campo data início';
			return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
		$input['yellow_alert'] = 90;
		$input['red_alert']    = 60;
		if ($input['valor'] < 0) {
			$validator = 'O campo valor é inválido!';
			return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
		$validator = Validator::make($request->all(), [
			'objeto' 	=> 'required|max:255',
			'valor' 	=> 'required'
		]);
		if ($validator->fails()) {
			$failed = $validator->failed();
			return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'))
				->withErrors()
				->withInput(session()->flashInput($request->input()));
		} else {
			if ($request->file('file_path') === NULL && $input['file_path_'] == "") {
				$validator = 'Informe o arquivo da contratação!';
				return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				if ($extensao == 'pdf') {
					$qtdUnidades = sizeof($unidades);
					for ($i = 1; $i <= $qtdUnidades; $i++) {
						if ($unidade['id'] === $i) {
							$txt1 = $unidades[$i - 1]['path_img'];
							$txt1 = explode(".jpg", $txt1);
							$nome = $_FILES['file_path']['name'];
							if ($request->file('file_path') !== NULL) {
								$request->file('file_path')->move('../public/storage/contratos/' . $txt1[0] . '/aditivos/', $nome);
								$input['file_path'] = 'contratos/' . $txt1[0] . '/aditivos/1-' . $nome;
							}
							$aditivos = Aditivo::find($id_aditivo);
							$aditivos->update($input);
							$log = LoggerUsers::create($input);
							$lastUpdated = $log->max('updated_at');
						}
					}
					$validacao = permissaoUsersController::Permissao($id_unidade);
					$unidades = $unidadesMenu = $this->unidade->all();
					$unidade = $this->unidade->find($id_unidade);
					$unidadesMenu = $this->unidade->all();
					$contratos = Contrato::where('unidade_id', $id_unidade)->where('id', $id_contrato)->get();
					$aditivos = Aditivo::where('unidade_id', $id_unidade)->where('id', $id_aditivo)->get();
					$prestadores = Prestador::where('id', $contratos[0]->prestador_id)->get();
					if ($validacao == 'ok') {
						if ($aditivos[0]->opcao == 0) {
							$validator = 'Contrato alterado com sucesso !';
						} elseif ($aditivos[0]->opcao == 1) {
							$validator = 'Aditivo alterado com sucesso !';
						} else {
							$validator = 'Distrato alterado com sucesso !';
						}
						return  redirect()->route('alterarAditivo', [$id_unidade, $id_aditivo, $id_contrato])
							->withErrors($validator)
							->with('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos');
					} else {
						$validator = 'Você não tem permissão!!';
						return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
							->withErrors($validator)
							->withInput(session()->flashInput($request->input()));
					}
				} else {
					$validator = 'Só são suportador arquivos do tipo PDF!';
					return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			}
		}
	}

	public function excluirAditivo($id_unidade, $id_aditivo, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$aditivos = Aditivo::where('id', $id_aditivo)->get();
		$contratos = Contrato::where('unidade_id', $id_unidade)->where('id', $aditivos[0]->contrato_id)->get();
		$prestadores = Prestador::where('id', $contratos[0]->prestador_id)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_excluir_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeContratos($id_unidade, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->get();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->get();
		$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
		$input = $request->all();
		$nome = $_FILES['file_path']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		$CP = array();
		if (empty($input['prestador'])) {
			$validator = 'Informe o prestador!';
			return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated', 'CP'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
		$data1 = $input['inicio'];
		$data2 = $input['fim'];
		if (strtotime($data1) > strtotime($data2)) {
			$validator = 'O campo data fim, não pode ser maior que o campo data de início!';
			return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'CP'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
		$input['yellow_alert'] = 90;
		$input['red_alert']    = 60;
		$input['prestador_id'] = $input['id'];
		if ($input['valor'] < 0) {
			$validator = 'O campo valor é inválido!';
			return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated', 'CP'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
		$validator = Validator::make($request->all(), [
			'objeto' 	=> 'required|max:255',
			'valor' 	=> 'required'
		]);
		if ($validator->fails()) {
			return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'CP'))
				->withErrors()
				->withInput(session()->flashInput($request->input()));
		} else {

			if ($input['aditivos'] !== "0" && $input['vinculado'] == "0") {
				$validator = 'Escolha um contrato para vincular o Adtivo ou Distrato!';
				return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'CP'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				if ($extensao == 'pdf' || $extensao == 'PDF') {
					$input['ativa'] = 1;
					$qtdUnidades = sizeof($unidades);
					$nome = $_FILES['file_path']['name'];
					$input['cadastro'] = 1;
					for ($i = 1; $i <= $qtdUnidades; $i++) {
						if ($unidade['id'] === $i) {
							$txt1 = $unidades[$i - 1]['path_img'];
							$txt1 = explode(".jpg", $txt1);
							$prestador = $input['prestador_id'];
							$contratosN = Contrato::where('unidade_id', $id_unidade)->where('prestador_id', $prestador)->get();
							$qtd = sizeof($contratosN);
							if ($input['aditivos'] === '0') {
								if ($qtd > 0) {
									$request->file('file_path')->move('../public/storage/contratos/' . $txt1[0] . '/aditivos/', '0-' . $nome);
									$input['file_path'] = 'contratos/' . $txt1[0] . '/aditivos/0-' . $nome;
									$input['opcao'] = 0;
									$input['ativa'] = 0;
									$input['contrato_id'] = $contratosN[0]->id;
									$input['aviso_venc90'] = 0;
									$input['aviso_venc60'] = 0;
									$input['inativa'] = 0;
									$aditivo = Aditivo::create($input);
									$log 	 = LoggerUsers::create($input);
									$lastUpdated = $log->max('updated_at');
								} else {
									$request->file('file_path')->move('../public/storage/contratos/' . $txt1[0] . '/', $nome);
									$input['file_path'] = 'contratos/' . $txt1[0] . '/' . $nome;
									$input['aviso_venc90'] = 0;
									$input['aviso_venc60'] = 0;
									$input['inativa'] = 0;
									$contrato = Contrato::create($input);
									$log 	  = LoggerUsers::create($input);
									$lastUpdated = $log->max('updated_at');
								}
							} else if ($input['aditivos'] === '1') {
								$request->file('file_path')->move('../public/storage/contratos/' . $txt1[0] . '/aditivos/', '1-' . $nome);
								$input['file_path'] = 'contratos/' . $txt1[0] . '/aditivos/1-' . $nome;
								$input['opcao'] = 1;
								$input['ativa'] = 0;
								$input['contrato_id'] = $contratosN[0]->id;
								$input['aviso_venc90'] = 0;
								$input['aviso_venc60'] = 0;
								$input['inativa'] = 0;
								$aditivo = Aditivo::create($input);
								$log 	 = LoggerUsers::create($input);
								$lastUpdated = $log->max('updated_at');
							} else if ($input['aditivos'] === '2') {
								$request->file('file_path')->move('../public/storage/contratos/' . $txt1[0] . '/aditivos/', '2-' . $nome);
								$input['file_path'] = 'contratos/' . $txt1[0] . '/aditivos/2-' . $nome;
								$input['opcao'] = 2;
								$input['ativa'] = 0;
								$input['contrato_id'] = $contratosN[0]->id;
								$input['aviso_venc90'] = 0;
								$input['aviso_venc60'] = 0;
								$input['inativa'] = 0;
								$aditivo = Aditivo::create($input);
								$log 	 = LoggerUsers::create($input);
								$lastUpdated = $log->max('updated_at');
							}
						}
					}
					$contratos = DB::table('contratos')
						->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
						->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
						->where('contratos.unidade_id', $id_unidade)
						->orderBy('nome', 'ASC')
						->get();
					$aditivos = Aditivo::where('unidade_id', $id_unidade)->get();
					$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
					$a = 0;
					if ($input['aditivos'] == 0) {
						$validator = 'Contratação anexada com sucesso !';
					} elseif ($input['aditivos'] == 1) {
						$validator = 'Adtivo anexado com sucesso !';
					} else {
						$validator = 'Distrato anexado com sucesso !';
					}
					return  redirect()->route('contratacaoCadastro', [$id_unidade])
						->withErrors($validator)
						->with('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated', 'cotacoes', 'aditivos', 'permissao_users', 'a');
					/*
				return view('transparencia/contratacao', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','cotacoes','aditivos','permissao_users','a'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));*/
				} else {
					$validator = 'Só são suportados arquivos do tipo: PDF!';
					return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'CP'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			}
		}
	}

	public function storeCotacoes($id_unidade, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$input = $request->all();
		$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
		$nome = $_FILES['file_path']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if ($request->file('file_path') === NULL) {
			$validator = 'Informe o arquivo da cotação!';
			return view('transparencia/contratacao/contratacao_cotacoes_novo', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if ($extensao == 'xlsx' || $extensao == 'xls') {
				if (!empty($input['proccess_name2'])) {
					$ord = Cotacao::where('unidade_id', $id_unidade)->max('ordering');
					$ord = $ord + 1;
					$qtdUnidades = sizeof($unidades);
					$input['ordering'] = $ord;
					$input['proccess_name'] = $input['proccess_name2'];
					$input['file_name'] = $input['proccess_name'];
					$nomeCotacao = $input['proccess_name'];
					$input['validar'] = 0;
					for ($i = 1; $i <= $qtdUnidades; $i++) {
						if ($unidade['id'] === $i) {
							$request->file('file_path')->move('../public/storage/cotacoes/hpr/', $nomeCotacao . '.xlsx');
							$input['file_path'] = 'cotacoes/hpr/' . $nomeCotacao . '.xlsx';
						}
					}
					$cotacao = Cotacao::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
					$processos = Processos::where('unidade_id', $id_unidade)->paginate(30);
					$processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->paginate(30);
					$validator = 'Cotação cadastrada com sucesso!';
					return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'lastUpdated', 'processos', 'processo_arquivos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$qtds = sizeof($cotacoes);
					$input['ordering'] = $qtds + 1;
					$qtdUnidades = sizeof($unidades);
					$nome = $_FILES['file_path']['name'];
					$nomeCotacao = $input['proccess_name'];
					$input['file_name'] = $nome;
					for ($i = 1; $i <= $qtdUnidades; $i++) {
						if ($unidade['id'] === $i) {
							$txt1 = $unidades[$i - 1]['path_img'];
							$txt1 = explode(".jpg", $txt1);
							$request->file('file_path')->storeAs('public/cotacoes/' . $txt1[0] . '/' . $nomeCotacao . '/', $nome);
							$input['file_path'] = 'cotacoes/' . $txt1[0] . '/' . $nome;
						}
					}
					$cotacao = Cotacao::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
					$processos = Processos::where('unidade_id', $id_unidade)->paginate(30);
					$processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->paginate(30);
					$validator = 'Cotação cadastrada  com sucesso!';
					return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'lastUpdated', 'processos', 'processo_arquivos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			} else {
				$validator = 'Só suporta arquivos do tipo: PDF!';
				return view('transparencia/contratacao/contratacao_cotacoes_novo', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}

	public function destroy($id_unidade, $id_contrato, Contrato $contrato, Request $request)
	{
		$aditivos = Aditivo::where('unidade_id', $id_unidade)
			->where('contrato_id', $id_contrato)
			->where('vinculado', '1º Contrato')
			->get();
		$qtd = sizeof($aditivos);
		for ($i = 0; $i < $qtd; $i++) {
			DB::statement('UPDATE aditivos SET inativa = 1 WHERE id = ' . $aditivos[$i]->id . ';');
		}
		DB::statement('UPDATE contratos SET inativa = 1 WHERE id = ' . $id_contrato . ';');
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['file_path'];
		$pasta = 'public/' . $nome;
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = DB::table('contratos')
			->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
			->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
			->where('contratos.unidade_id', $id_unidade)
			->orderBy('nome', 'ASC')
			->get()->toArray();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->get();
		$validator = 'Contrato excluído com sucesso!';
		return  redirect()->route('contratacaoCadastro', [$id_unidade])
			->withErrors($validator)
			->with('unidades', 'unidade', 'unidadesMenu', 'contratos', 'aditivos', 'lastUpdated');
	}

	public function destroyCotacao($id_unidade, $id_cotacao, Cotacao $cotacao, Request $request)
	{
		Cotacao::find($id_cotacao)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['file_path'];
		$pasta = 'public/' . $nome;
		Storage::delete($pasta);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
		$lastUpdated = $cotacoes->max('updated_at');
		$validator = 'Cotação excluído com sucesso!';
		return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'cotacoes'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	}

	public function destroyAditivo($id_unidade, $id_aditivo)
	{

		//Obtendo dados do ativo, contrato e prestador
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->where('id', $id_aditivo)->get();
		$contrato = Contrato::where('id', $aditivos[0]->contrato_id)->get();
		$id_contrato = $contrato[0]->id;
		$id_prestador = $contrato[0]->prestador_id;
		$qtd = sizeof($aditivos);

		//Inativação de aditivo
		DB::statement('UPDATE aditivos SET inativa = 1 WHERE id = ' . $id_aditivo . ';');

		//Resgistro de atividade na tabela loggers
		$input['tela'] = 'contratacao';
		$input['acao'] = 'excluirContratacao';
		$input['user_id'] = Auth::user()->id;
		$input['unidade_id'] = $id_unidade;
		$log = LoggerUsers::create($input);

		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->where('prestador_id', $id_prestador)->get();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->where('opcao')->get();
		$prestadores = Prestador::where('id', $id_prestador)->get();

		//Contrato vinculado ao aditivo
		$ccontratos = DB::table('contratos')
			->join('aditivos', 'aditivos.contrato_id', '=', 'contratos.id')
			->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
			->select('contratos.id', 'contratos.prestador_id', 'contratos.unidade_id', 'aditivos.id', 'aditivos.opcao', 'prestadors.prestador', 'prestadors.cnpj_cpf')
			->where('contratos.unidade_id', '=', $id_unidade)
			->where('contratos.prestador_id', '=', $id_prestador)
			->where('aditivos.opcao', '=', '0')
			->get();

		//Aditivos e distratos vinculados vinculados ao contrato
		$vinculos = DB::table('contratos')
			->join('aditivos', 'aditivos.contrato_id', '=', 'contratos.id')
			->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
			->select('contratos.id', 'aditivos.contrato_id as cont_id', 'contratos.prestador_id as prestador_ID', 'contratos.unidade_id', 'aditivos.file_path', 'aditivos.id as aditivo_ID', 'aditivos.opcao', 'prestadors.prestador', 'prestadors.cnpj_cpf', 'aditivos.vinculado')
			->where('contratos.unidade_id', '=', $id_unidade)
			->where('contratos.prestador_id', '=', $id_prestador)
			->where('aditivos.opcao', '!=', '0')
			->where('aditivos.inativa', '=', '0')
			->get();

		$validator = "Aditivo excluido com sucesso";
		return  redirect()->route('alterarContratos', [$id_unidade, $id_prestador, $id_contrato])
			->withErrors($validator)
			->with('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'vinculos', 'ccontratos', 'aditivos');
	}
}
