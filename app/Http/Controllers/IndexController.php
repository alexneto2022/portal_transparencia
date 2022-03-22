<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Model\Unidade;
use App\Model\Organizational;
use App\Model\Associado;
use App\Model\ConselhoAdm;
use App\Model\ConselhoFisc;
use App\Model\Superintendente;
use App\Model\Estatuto;
use App\Model\DocumentacaoRegularidade;
use App\Model\Type;
use App\Model\Decreto;
use App\Model\Manual;
use App\Model\Pregao;
use App\Model\Pessoa;
use App\Model\Hierarquia;
use App\Model\Cargo;
use App\Model\ContratoGestao;
use App\Model\Despesa;
use App\Model\Ocupacao;
use App\Model\Indicador;
use App\Model\SelecaoPessoal;
use App\Model\AssistencialCovid;
use App\Model\Repasse;
use App\Model\Prestador;
use App\Model\PermissaoUsers;
use App\Model\ContratacaoServicos;
use App\Model\EspecialidadeContratacao;
use App\Model\Especialidades;
use App\Model\Permissao;
use App\Model\Contrato;
use App\Model\Competencia;
use App\Model\FinancialReport;
use App\Model\SelectiveProcess;
use App\Model\Processos;
use App\Model\ProcessoArquivos;
use App\Model\DemonstracaoContabel;
use App\Exports\AssistencialExport;
use App\Exports\AssociadosExport;
use App\Exports\ConselhoAdmExport;
use App\Exports\ConselhoFiscExport;
use App\Exports\SuperintendenteExport;
use App\Exports\RepasseExport;
use App\Exports\RepasseSomExport;
use App\Model\ServidoresCedidosRH;
use App\Model\Assistencial;
use App\Model\Cotacao;
use App\Model\RegimentoInterno;
use App\Model\Aditivo;
use App\Model\RelatorioFinanceiro;
use App\Model\Covenio;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use PDF;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Model\Ouvidoria;
use Validator;
use App\Http\Controllers\PermissaoUsersController;

class IndexController extends Controller
{
    protected $unidade;

    public function __construct(Unidade $unidade, RegimentoInterno $reg_interno)
    {
        $this->unidade 	   = $unidade;
		$this->reg_interno = $reg_interno;
    }

    public function index()
    {
       $unidades = $this->unidade->all();
       return view('welcome', compact('unidades'));
    }

    public function trasparenciaHome($id)
    {
		$unidadesMenu = $this->unidade->all();
        $unidade = $this->unidade->find($id);
        $lastUpdated  = $unidade->updated_at;
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
	    return view('transparencia.institucional', compact('unidade','unidadesMenu','lastUpdated','permissao_users'));
    }
    
    public function transparenciaOuvidoria($id)
    {
		$unidadesMenu = $this->unidade->all();
        $unidade = $this->unidade->find($id);
        $lastUpdated  = $unidade->updated_at;
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        $ouvidorias = Ouvidoria::where('unidade_id',$id)->get();
	    return view('transparencia.ouvidoria', compact('unidade','unidadesMenu','lastUpdated','permissao_users','ouvidorias'));
    }

    public function trasparenciaOrganizacional($id)
    { 
        $unidadesMenu = $this->unidade->all();
        $unidade = $unidadesMenu->find($id);
        if($id == 9){
			$estruturaOrganizacional = Organizational::where('unidade_id', 1)->get();		
		} else {
			$estruturaOrganizacional = Organizational::where('unidade_id', $id)->get();
		}
        if($unidade->id === 1){
           $lastUpdated = $estruturaOrganizacional->max('updated_at');
        }else{
            $ultimaData = Organizational::where('unidade_id', $id)->where('updated_at','<=', Carbon::now() )->orderBy('updated_at', 'DESC')->first();
            $lastUpdated = $estruturaOrganizacional->max('updated_at');
        }
		$reg = RegimentoInterno::where('unidade_id',$id)->get();
		$qtd = sizeof($reg); 
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.organizacional', compact('unidade','unidadesMenu','estruturaOrganizacional','lastUpdated','qtd','reg','permissao_users'));
    }

    public function transparenciaMembros($id,$escolha)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade = $unidadesMenu->find($id);
		if($id == 9 || $id == 1){
			$associados = Associado::where('unidade_id', 1)->get();
			$conselhoAdms = ConselhoAdm::where('unidade_id', 1)->get();
			$conselhoFiscs = ConselhoFisc::where('unidade_id', 1)->get();
			$superintendentes = Superintendente::where('unidade_id', 1)->get();
		}
        if($id == 1 || $id == 9){
            $datas = array();
            $datas[] = $associados->max('updated_at');
            $datas[] = $conselhoAdms->max('updated_at');
            $datas[] = $conselhoFiscs->max('updated_at');
            $datas[] = $superintendentes->max('updated_at');
            $lastUpdated = max($datas);
        }
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.membros', compact('unidade','unidadesMenu','associados','conselhoAdms','conselhoFiscs','superintendentes','escolha','lastUpdated','permissao_users'));
    }

	public function transparenciaAlterarMembros($idM,$escolha)
	{
		$associados = Associado::where('unidade_id', $idM)->get();
		$unidade = new Unidade();
		$unidades = $this->unidade->find($associados->find($associados));
		return view('transparencia.membros.associados', compact('unidades','associados','escolha'));
	}

	public function salvar($id)
	{
		$unidade = new Unidade();
		$unidade = $this->unidade->find($id);
		return view('welcome', compact('unidade'));
	}
		
    public function exportAssociados() 
    {
        return (new AssociadosExport)->download('associados.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }
	
	public function repassesSomExport($id, $year)
	{
		return Excel::download(new RepasseSomExport($id, $year), 'repasse_som.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
	}

    public function exportConselhoAdm() 
    {
        return (new ConselhoAdmExport)->download('conselhoadm.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }
    
    public function rp()
    {   
        $hoje = date('Y-m-d', strtotime('now'));
        $contratacao_servicos = DB::table('contratacao_servicos')
        ->join('unidades', 'unidades.id', '=', 'contratacao_servicos.unidade_id')
        ->whereRaw('contratacao_servicos.prazoInicial <= CURDATE()')
        ->whereRaw('contratacao_servicos.prazoFinal >= CURDATE()')
        ->orWhereRaw('contratacao_servicos.prazoProrroga >= CURDATE()')
        ->select('unidades.path_img as path_img',
        'contratacao_servicos.tipoPrazo as tipoPrazo',
        'contratacao_servicos.prazoInicial as prazoInicial',
        'contratacao_servicos.prazoFinal as prazoFinal',
        'contratacao_servicos.id as id',
        'contratacao_servicos.prazoProrroga as prazoProrroga',
        'unidades.sigla as nomeUnidade',
        'unidades.path_img as path_img')
        ->orderBy('unidades.sigla','ASC')
        ->get();
        $count = sizeof($contratacao_servicos);
        $unidades = Unidade::all();
        return view('rp', compact('unidades','contratacao_servicos'));
    }

    public function rp2($id)
    {
        $contratacao_servicos = ContratacaoServicos::where('id',$id)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $unidades = Unidade::where('id',$unidade_id)->get();
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id',$id)->get();
        $especialidades = Especialidades::all();

        return view('rp2', compact('contratacao_servicos','unidades','especialidade_contratacao','especialidades'));
    }

    public function exportConselhoFisc() 
    {
       return (new ConselhoFiscExport)->download('conselhofisc.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }

    public function exportSuperintendente() 
    {
        return (new SuperintendenteExport)->download('superintendentes.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }

    public function transparenciaEstatuto($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $estatutos = Estatuto::all();
        $lastUpdated = $estatutos->max('updated_at');
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.estatuto', compact('unidade','unidadesMenu','estatutos','lastUpdated','permissao_users'));
    }

    public function transparenciaDocumento($id,$escolha)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        if($id == 1 || $id == 9) {
            $types = Type::all();
            $documents = DocumentacaoRegularidade::all();
            $lastUpdated = $documents->max('updated_at');          
        } else if (($id == 2) || ($id == 5) || ($id == 8)) {
            $types = Type::where('id', 7)->get(); 
            $documents = DocumentacaoRegularidade::findMany([54,55]); 
            $lastUpdated = $documents->max('updated_at');   
        } else if(($id == 3) || ($id == 4) || ($id == 6) || ($id == 7)){
            $types = Type::where('id', 7)->get();
            $documents = DocumentacaoRegularidade::findMany([51, 52, 53]);
            $lastUpdated = $documents->max('updated_at');              
        }
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.documentos', compact('unidade','unidadesMenu','escolha','documents','types','lastUpdated','permissao_users'));
    }

    public function transparenciaDecreto($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $decretos = Decreto::all();
        $lastUpdated = $decretos->max('updated_at');
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.decreto', compact('unidade','unidadesMenu','decretos','lastUpdated','permissao_users'));
    }

    public function transparenciaPregao($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $pregaos = Pregao::all()->groupBy('ano');
        $lastUpdated = Pregao::all()->max('updated_at');
        return view('transparencia.pregao', compact('unidade','unidadesMenu','pregaos','lastUpdated'));
    }

    public function transparenciaContratoGestao($id,$escolha)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
		if($id == 1 || $id == 9){
            $contratos = ContratoGestao::all();
            $lastUpdated = $contratos->max('updated_at');
        }else{
            $contratos = ContratoGestao::where('unidade_id',$id)->get();
            $lastUpdated = $contratos->max('updated_at');
        }
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.contratoGestao', compact('unidade','unidadesMenu','escolha','contratos','lastUpdated','permissao_users'));
    }

	public function transparenciaCovenio($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $covenios = Covenio::all();
        $lastUpdated = $covenios->max('updated_at');
        return view('transparencia.covenio', compact('unidade','unidadesMenu','covenios','lastUpdated'));
    }

    public function transparenciaContasAtual($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        return view('transparencia.contasAtual', compact('unidade','unidadesMenu'));
    }

    public function transparenciaRelMensalExecucao($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        return view('transparencia.relatorioMensalExecucao', compact('unidade','unidadesMenu'));
    }

    public function transparenciaMensalFinanceiroExercico($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        return view('transparencia.relatorioMensalFinanceiro', compact('unidade','unidadesMenu'));
    }

    public function transparenciaProcessoCotacao($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        return view('transparencia.processoCotacao', compact('unidade','unidadesMenu'));
    }

    public function transparenciaDespesas($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $tableFill = DB::table('employees')
        ->join('unidades', 'employees.unidade_id', '=', 'unidades.id')
        ->join('area_ocupacaos', 'employees.area_ocupacao_id', '=', 'area_ocupacaos.id')
        ->join('ocupacaos', 'employees.ocupacao_id', '=', 'ocupacaos.id')
        ->join('regime_trabalhos', 'employees.regime_id', '=', 'regime_trabalhos.id')
        ->select('unidades.cnpj', 'unidades.name as unidade', 'employees.*','area_ocupacaos.title','regime_trabalhos.title as regime','ocupacaos.cbo')
        ->get()->toArray();
        $tableFillValues = DB::table('vencimento_vantagems')->get();
        return view('transparencia.despesas', compact('unidade','unidadesMenu','tableFill','tableFillValues'));
    }

    public function transparenciaRegulamento($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $manuais = Manual::all();
        $lastUpdated = $manuais->max('updated_at');
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.regulamento', compact('unidade','unidadesMenu','manuais','lastUpdated','permissao_users'));
    }

    public function transparenciaAssistencial($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade = $unidadesMenu->find($id);
        $anosRef = Assistencial::where('unidade_id', $id)->orderBy('ano_ref', 'ASC')->pluck('ano_ref')->unique();
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        $assistencialCovid = AssistencialCovid::all();
        $lastUpdated = $assistencialCovid->max('updated_at');
        return view('transparencia.assistencial', compact('unidade','unidadesMenu','lastUpdated','anosRef','permissao_users','assistencialCovid'));
    }

    public function visualizarAssistencial($id)
	{
	    if(!empty($_GET['year'])){
			$ano = $_GET['year'];
    		$unidadesMenu = $this->unidade->all();
    		$unidade = $unidadesMenu->find($id);
    		$anosRef = Assistencial::where('unidade_id', $id)->where('ano_ref', $ano)->get();
    		$lastUpdated = '2020-06-15 10:00:00';
    		return view('transparencia/assistencial/assistencial_visualizar', compact('unidade','unidadesMenu','lastUpdated','anosRef'));    
	    } else {
	        $unidadesMenu = $this->unidade->all();
    		$unidade = $unidadesMenu->find($id);
    		$anosRef = Assistencial::where('unidade_id', $id)->where('ano_ref', $ano)->get();
    		$lastUpdated = '2020-06-15 10:00:00';
    		return view('transparencia/assistencial/assistencial_visualizar', compact('unidade','unidadesMenu','lastUpdated','anosRef'));    
	    }
	}

    public function exportAssistencialMensal($id, $year)
    {
        return Excel::download(new AssistencialExport($id,$year), 'assistencial.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }

    public function exportAssistencialAnual($id)
    {
        return Excel::download(new AssistencialExport($id, 0), 'assistencial.xlsx');
    }
	
    public function transparenciaInstitucionalPdf($id)
    {
        $unidade = $this->unidade->find($id);
        return PDF::loadView('transparencia.pdf.institucional', compact('unidade'))
        ->download('institucional-'.$unidade->name.'.pdf');
    }

    public function transparenciaCompetencia($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $competenciasMatriz = Competencia::where('unidade_id', $id)->get();
        $lastUpdated = $competenciasMatriz->max('updated_at');
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get(); 
        return view('transparencia.competencia', compact('unidade','unidadesMenu','competenciasMatriz','lastUpdated','permissao_users'));
    }

    public function transparenciaFinanReports($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id)->orderBy('ano','ASC')->get();
		$lastUpdated = $relatorioFinanceiro->max('updated_at');
        return view('transparencia.financeiro', compact('unidade','unidadesMenu','permissao_users','relatorioFinanceiro','lastUpdated'));
    }

    public function transparenciaDemonstrative($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $financialReports = FinancialReport::where('unidade_id', $id)->get();
        $lastUpdated = $financialReports->max('updated_at');
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.demonstrativo', compact('unidade','unidadesMenu','financialReports','lastUpdated','permissao_users'));
    }

    public function transparenciaAccountable($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $demonstrativoContaveis = DemonstracaoContabel::where('unidade_id', $id)->get();
        $lastUpdated = $demonstrativoContaveis->max('updated_at');
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.accountable', compact('unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','permissao_users'));
    }

    public function transparenciaRepasses($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $repasses = Repasse::where('unidade_id', $id)->orderBy('ano', 'ASC')->get();
        $anoRepasses = $repasses->pluck('ano')->unique();
        $mesRepasses = $repasses->pluck('mes')->unique();
        $mesUpdate = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
        function valorMes($month){
            $monthArray = array(
                "1" => "janeiro",
                "2" => "fevereiro",
                "3" => "mar�0�4o",
                "4" => "abril",
                "5" => "maio",
                "6" => "junho",
                "7" => "julho",
                "8" => "agosto",
                "9" => "setembro",
                "10" => "outubro",
                "11" => "novembro",
                "12" => "dezembro",
          );
            return array_search($month, $monthArray);
        };
        $lastUpdated = $repasses->max('updated_at');
        $somContratado = $repasses->sum('contratado');
        $somRecebido = $repasses->sum('recebido');
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.repasses', compact('unidade','unidadesMenu','somContratado','somRecebido','anoRepasses','mesRepasses','lastUpdated','permissao_users','repasses'));
    }

    public function repassesExport($id, $year)
    {
        return Excel::download(new RepasseExport($id,$year), 'repasse.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }

    public function transparenciaContratacao($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $contratos = DB::table('contratos')
        ->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
		->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
		->where('contratos.unidade_id', $id)
		->orderBy('nome', 'ASC')
        ->get();
		$aditivos = Aditivo::where('unidade_id', $id)->get();
		$cotacoes = Cotacao::where('unidade_id', $id)->get();
		$lastUpdated = $contratos->max('created_at'); 
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
	    return view('transparencia.contratacao', compact('unidade','unidadesMenu','contratos','cotacoes','aditivos','lastUpdated','permissao_users'));
    }
	
	public function pesquisarMesCotacao($id, $mes, $ano)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $contratos = DB::table('contratos')
        ->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
		->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
		->where('contratos.unidade_id', $id)
		->orderBy('nome', 'ASC')
        ->get()->toArray();
		$aditivos = Aditivo::where('unidade_id', $id)->get();
		$cotacoes = Cotacao::where('unidade_id', $id)->get();
		$processos = Processos::where('unidade_id', $id)->whereMonth('dataAutorizacao',$mes)->whereYear('dataAutorizacao', $ano)->get();
		$z = 0;
		if($ano == "2020"){ $z = 1; } else if($ano == "2021"){ $z = 2; }
		$processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
		$lastUpdated = $processo_arquivos->max('updated_at');
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$a = 1;
		return view('transparencia.contratacao', compact('unidade','unidadesMenu','contratos','cotacoes','aditivos','lastUpdated','processos','processo_arquivos','permissao_users','a','mes','z'));
    }
    
	public function transparenciaRecursosHumanos($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $docSelectiveProcess = SelectiveProcess::where('unidade_id', $id)->orderBy('year', 'ASC')->get();
        $selecaoPessoal = DB::table('selecao_pessoals')
        ->join('cargos', 'selecao_pessoals.cargo_name_id', '=', 'cargos.id')
		->select('selecao_pessoals.*', 'cargos.*','cargos.cargo_name as nome')
		->where('unidade_id',$id)
		->orderBy('ano', 'ASC')
		->orderBy('cargos.cargo_name', 'ASC')
        ->get();
        $servidores = ServidoresCedidosRH::where('unidade_id',$id)->orderBy('nome','ASC')->get();
        $data = array();
        $data[] = $lastUpdatedRegulamento = '2017-08-31 00:00:00';   
        $data[] = $docSelectiveProcess->max('updated_at');
        $lastUpdated = $selecaoPessoal->max('updated_at');
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.recursos-humanos', compact('unidade','unidadesMenu','selecaoPessoal','docSelectiveProcess','lastUpdatedRegulamento','lastUpdated','permissao_users','servidores'));
    }

    public function transparenciaBensPublicos($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $lastUpdated = '2020-01-01 00:00:00';
        return view('transparencia.bens-publicos', compact('unidade','unidadesMenu','lastUpdated'));
    }

    public function assistencialPdf($id, $year)
    {
        $unidadesMenu = $this->unidade->all();
        $unidade =$unidadesMenu->find($id);
        $assistencials = Assistencial::where('unidade_id', $id)->where('ano_ref', $year)->get();
        $pdf = PDF::loadView('transparencia.pdf.assistencial', compact('assistencials','unidade'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('assistencial.pdf');
    }
    
    public function visualizarOrdemCompra($id)
    { 
      $unidade      = Unidade::where('id',$id)->get();
      $processos    = Processos::where('unidade_id',$id)->paginate(20);
      $processo_arq = ProcessoArquivos::where('unidade_id',$id)->get();
      return view('ordem_compra/ordem_compra_usuarios', compact('unidade','processos','processo_arq'));
    }

    public function procuraVisualizarOrdemCompra($unidade_id, Request $request)
    {    
      $input = $request->all();
      $unidade =  Unidade::where('id',$unidade_id)->get();
      $funcao = $input['funcao'];
      $funcao2 = $input['funcao2'];
      $text = $input['text'];
      $data = $input['data']; 
      if ($funcao2 == "1"){
        if($funcao == "1") {
            $processos = Processos::where('fornecedor','like','%'.$text.'%')->where('dataSolicitacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else if($funcao == "2" ){
            $processos = Processos::where('fornecedor','like','%'.$text.'%')->where('dataAutorizacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else {
            $processos = Processos::where('fornecedor','like','%'.$text.'%')->where('unidade_id',$unidade_id)->paginate(30);
        }
      } else if ($funcao2 == "2"){
        if($funcao == "1") {
            $processos = Processos::where('numeroSolicitacao','like','%'.$text.'%')->where('dataSolicitacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else if($funcao == "2") {
            $processos = Processos::where('numeroSolicitacao','like','%'.$text.'%')->where('dataAutorizacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else {
            $processos = Processos::where('numeroSolicitacao','like','%'.$text.'%')->where('unidade_id',$unidade_id)->paginate(30);
        }
      } else if ($funcao2 == "3"){ 
        if($funcao == "1") {
            $processos = Processos::where('produto','like','%'.$text.'%')->where('dataSolicitacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else if($funcao == "2") {
            $processos = Processos::where('produto','like','%'.$text.'%')->where('dataAutorizacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else {
            $processos = Processos::where('produto','like','%'.$text.'%')->where('unidade_id',$unidade_id)->paginate(30);
        }         
      } else {
        if($funcao == "1") {
            $processos = Processos::where('dataSolicitacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else if($funcao == "2") {
            $processos = Processos::where('dataAutorizacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else if($funcao == "0") {
            $processos = Processos::where('unidade_id',$unidade_id)->paginate(30); 		  
        }
      }
      $processo_arq = ProcessoArquivos::where('unidade_id', $unidade_id)->paginate(30);   
      return view('ordem_compra/ordem_compra_usuarios', compact('unidade','processos','processo_arq'));	
    }
    
    public function despesasUsuarioRH($id)
    {
        $unidadesMenu = $this->unidade->all();
        $unidades = $unidadesMenu; 
        $unidade = $this->unidade->find($id);
        $ano  = 0;
        $mes  = 0;
        $tipo = 0;
        return view('transparencia/rh/rh_despesas_exibe_usuario', compact('unidade','unidades','unidadesMenu','ano','mes', 'tipo')); 
    }

    public function despesasUsuarioRHProcurar($id, Request $request)
    {
        $input = $request->all();
        $unidade = $this->unidade->find($id);		
        $unidadesMenu = $this->unidade->all();
        $mes  = $input['mes'];
        $ano  = $input['ano'];
        $tipo = $input['tipo']; 
        if($tipo == NULL){ $tipo = ""; }
        if ($id == 2){
            $despesas = DB::table('desp_com_pessoal_hmr')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
        }else if ($id == 3){
            $despesas = DB::table('desp_com_pessoal_belo_jardim')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
        }else if($id == 4){
            $despesas = DB::table('desp_com_pessoal_arcoverde')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
       }else if($id == 5){
            $despesas = DB::table('desp_com_pessoal_arruda')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
        }else if($id == 6){
            $despesas = DB::table('desp_com_pessoal_upaecaruaru')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
        }else if($id == 7){
            $despesas = DB::table('desp_com_pessoal_hss')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
        }else if($id == 8){
            $despesas = DB::table('desp_com_pessoal_hpr')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
        }   
        return view('transparencia/rh/rh_despesas_exibe_usuario	', compact('unidade','despesas','unidadesMenu','ano','mes','tipo'));   
    }
}