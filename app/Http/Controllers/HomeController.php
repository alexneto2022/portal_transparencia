<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\ProcessoArquivos;
use App\Model\Processos;
use App\Model\Cotacao;
use App\Model\LoggerUsers;
use App\Http\Controllers\ContratacaoController;
use App\Imports\processoImport;
use Auth;
use Validator;

class HomeController extends Controller
{
	    protected $unidade;
      
      public function __construct(Unidade $unidade)
      {
		    $this->unidade = $unidade;
      }

      public function index()
      {
        $unidades = $this->unidade->all();
        if(Auth::user()->id == 24) {
          return view('home_compras', compact('unidades'));
        } else {
          return view('home', compact('unidades'));
        }
      }
	
	    public function transparenciaHome($id)
      {
        $unidadesMenu = $this->unidade->all();
        $unidades = $unidadesMenu;
        $unidade  = Unidade::where('id', $id)->get(); 
        $lastUpdated  = $unidade->max('updated_at');
        return view('transparencia.institucional', compact('unidade','unidades','unidadesMenu','lastUpdated'));
      }

      public function transparenciaOrdemCompra($id)
      {
        $unidade      = Unidade::where('id',$id)->get();
        $processos    = Processos::where('unidade_id',$id)->paginate(20);
        $processo_arq = ProcessoArquivos::where('unidade_id',$id)->get();
        return view('ordem_compra/ordem_compras_cadastro', compact('unidade','processos','processo_arq'));
      }

      public function transparenciaOrdemCompraNovoArquivo($unidade_id, Request $request)
      {
        $unidade =  Unidade::where('id',$unidade_id)->get();
        return view('ordem_compra/ordem_compras_novo_planilha', compact('unidade'));
      }

      public function storeOrdemCompraNovoArquivo($unidade_id, Request $request)
      { 
        $input = $request->all();
        $unidade = Unidade::where('id',$unidade_id)->get();
        $nome = $_FILES['file_path']['name']; 
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        if($request->file('file_path') === NULL) {	
          $validator = 'Informe o arquivo da Ordem de Compra!';
          return view('ordem_compra/ordem_compras_novo_planilha', compact('unidade'))
            ->withErrors($validator)
            ->withInput(session()->flashInput($request->input()));
        } else {	
            if(($extensao === 'csv') || ($extensao === 'xls') || ($extensao === 'xlsx')) {
              $validator = Validator::make($request->all(), [
                'file_path' => 'required',
              ]);
              if ($validator->fails()) {
                $validator = 'o campo arquivo é obrigatório!';
                return view('ordem_compra/ordem_compras_novo_planilha', compact('unidade'))
                  ->withErrors($validator)
                  ->withInput(session()->flashInput($request->input()));
              }else {
                \Excel::import(new processoImport($unidade_id), $request->file('file_path'));
                $input['user_id'] = Auth::user()->id;
                $log = LoggerUsers::create($input);
                $processos = Processos::where('unidade_id', $unidade_id)->paginate(30);
                $processo_arq = ProcessoArquivos::where('unidade_id',$unidade_id)->get();
                return view('ordem_compra/ordem_compras_cadastro', compact('unidade','processos','processo_arq'));		
            }
          } else {
            $validator = 'Só são suportados arquivos tipo: .csv, .xls, .xlsx';
            return view('ordem_compra/ordem_compras_novo_planilha', compact('unidade'))
            ->withErrors($validator)
            ->withInput(session()->flashInput($request->input()));
          }
        }
      }    

      public function transparenciaOrdemCompraNovo($id)
      {
        $unidade = Unidade::where('id',$id)->get();
        $mes = date('m',strtotime('now')); 
        $ano = date('Y', strtotime('now'));
        $processos = Processos::whereMonth('created_at',$mes)->whereYear('created_at',$ano)
                               ->where('unidade_id',$id)->get();
        return view('ordem_compra/ordem_compras_novo', compact('unidade','processos'));
      }

      public function storeOrdemCompra($id, Request $request)
      {
        $input   = $request->all();
        $unidade = Unidade::where('id',$id)->get();
        $validator = Validator::make($request->all(), [
          'numeroSolicitacao'  => 'required|max:255',
          'dataSolicitacao'    => 'required|date',
          'numeroOC'           => 'required|max:255',
          'dataAutorizacao'    => 'required|date',
          'fornecedor'         => 'required|max:255',
          'cnpj'               => 'required|max:14',
          'produto'            => 'required|max:500',
          'qtdOrdemCompra'     => 'required|max:255',
          'totalValorOC'       => 'required|max:255',
          'classificacaoItem'  => 'required|max:255',
          'numeroNotaFiscal'   => 'required|max:255',
          'quantidadeRecebida' => 'required|max:255',
          'valorTotalRecebido' => 'required|max:255',
          'chaveAcesso'        => 'required|max:255',
          'codigoIBGE'         => 'required|max:255' 
        ]);
        if ($validator->fails()) {
          $mes = date('m',strtotime('now')); 
          $ano = date('Y', strtotime('now'));
          $processos = Processos::whereMonth('created_at',$mes)->whereYear('created_at',$ano)
                                 ->where('unidade_id',$id)->get();
          $processo_arq = ProcessoArquivos::where('unidade_id',$id)->get();
           return view('ordem_compra/ordem_compras_novo', compact('unidade','processos','processo_arq'))
              ->withErrors($validator)
						  ->withInput(session()->flashInput($request->input()));
          
        } else {
          $processos = Processos::create($input);
          $processos = Processos::all();
          $input['user_id'] = Auth::user()->id;
          $log = LoggerUsers::create($input);
          $mes = date('m',strtotime($processos[0]->created_at));
          $now = date('m',strtotime('now')); 
          $processos = Processos::whereMonth('created_at',$mes)->where('unidade_id',$id)->get();
          $validator = 'A Ordem de Compra(OC) foi cadastrada com sucesso!';
          $processo_arq = ProcessoArquivos::where('unidade_id',$id)->get();
          return view('ordem_compra/ordem_compras_novo', compact('unidade','processos','processo_arq'))
						 ->withErrors($validator)
						 ->withInput(session()->flashInput($request->input()));
        }
      }

      public function ordemCompraAlterar($unidade_id,$id, Request $request)
      {
        $unidade =  Unidade::where('id',$unidade_id)->get();
        $processos = Processos::where('id', $id)->get();
        return view('ordem_compra/ordem_compras_alterar', compact('unidade','processos'));
      }

      public function updateOrdemCompra($unidade_id, $id, Request $request)
      {  
        $input   = $request->all();
        $unidade = Unidade::where('id',$unidade_id)->get();
        $processos = Processos::where('id',$id)->get();
        $validator = Validator::make($request->all(), [
          'numeroSolicitacao'  => 'required|max:255',
          'dataSolicitacao'    => 'required',
          'numeroOC'           => 'required|max:255',
          'dataAutorizacao'    => 'required',
          'fornecedor'         => 'required|max:255',
          'cnpj'               => 'required|max:14',
          'produto'            => 'required|max:500',
          'qtdOrdemCompra'     => 'required|max:255',
          'totalValorOC'       => 'required|max:255',
          'classificacaoItem'  => 'required|max:255',
          'numeroNotaFiscal'   => 'required|max:255',
          'quantidadeRecebida' => 'required|max:255',
          'valorTotalRecebido' => 'required|max:255',
          'chaveAcesso'        => 'required|max:255',
          'codigoIBGE'         => 'required|max:255' 
        ]); 
        if ($validator->fails()) {
          return view('ordem_compra/ordem_compras_alterar', compact('unidade','processos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
        } else { 
          $processos = Processos::find($id);
          $processos->update($input);
          $input['user_id'] = Auth::user()->id;
          $logs = LoggerUsers::create($input);
          $processos = Processos::where('id',$id)->paginate(30);       
          $processo_arq = ProcessoArquivos::where('unidade_id',$unidade_id)->get(); 
          $validator = 'A Ordem de Compra(OC) foi alterada com sucesso!';
          return view('ordem_compra/ordem_compras_cadastro', compact('unidade','processos','processo_arq'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
        }
      }

      public function ordemCompraExcluir($unidade_id, $id , Request $request)
	  {
        $unidade =  Unidade::where('id',$unidade_id)->get();
        $processos = Processos::where('id', $id)->get();
        return view('ordem_compra/ordem_compras_excluir', compact('unidade','processos'));	
      }
      
      public function destroyOrdemCompra($unidade_id, $id, Request $request)
      { 
        $input = $request->all();
        Processos::find($id)->delete(); 
        $input['user_id'] = Auth::user()->id;
        $logs = LoggerUsers::create($input);
        $unidade = Unidade::where('id',$unidade_id)->get();
        $processos = Processos::where('unidade_id', $unidade_id)->paginate(30);
		    $input = $request->all();
        $validator = 'A Ordem de Compra(OC) foi exclu铆da com sucesso!';
        $processo_arq = ProcessoArquivos::where('unidade_id',$unidade_id)->get(); 
        return view('ordem_compra/ordem_compras_cadastro', compact('unidade','processos','processo_arq'))
          ->withErrors($validator)
          ->withInput(session()->flashInput($request->input()));	
      }
    
 
      public function procuraOrdemCompra($unidade_id, Request $request)
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
       	return view('ordem_compra/ordem_compras_cadastro', compact('unidade','processos','processo_arq'));	
	  }

	  public function addOrdemCompra($id)
	  {
		  $unidades = $unidadesMenu = $this->unidade->all();
		  $unidade = $this->unidade->find($id);
      $validator = 'Arquivo adicionado com Sucesso!';
			return view('transparencia/contratacao/cotacao_excel', compact('unidades','unidade'))
      ->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
	  }

  	public function storeArquivoOrdemCompra($id, $id_processo, Request $request)
	  {
      $processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
      $unidade = Unidade::where('id' , $id)->get();
      $processos = Processos::where('unidade_id', $id)->where('id', $id_processo)->get();
      $input = $request->all(); $a = 0;
        for($i=1; $i<=5; $i++){
           if(!empty($input['file_path_'.$i])){
              $solicitacao = $input['numeroSolicitacao'];
              $nome = $_FILES['file_path_'.$i]['name'];                      
              $extensao = pathinfo($nome, PATHINFO_EXTENSION);
                if($extensao === 'pdf') {
                    $request->file('file_path_'.$i)->move('../public/storage/cotacoes/arquivos/'. $solicitacao. '/',$nome);	
                    $input['file_path_'.$i] = 'cotacoes/arquivos/'.$solicitacao.'/'.$nome;
                    $input['processo_id'] = $id_processo;
                    $input['file_path'] = $nome;
                    $input['title'] = $input['title'.$i];
                    ProcessoArquivos::create($input);	
                    $a += 1;
                }else{
                    $validator = 'Só suporta arquivos do tipo PDF!';
                    return view('ordem_compra/ordem_compras_arquivos_novo', compact('unidade','processos','processo_arquivos'))
                        ->withErrors($validator)
                        ->withInput(session()->flashInput($request->input()));
                }          
            }
          }
          if($a > 0){
            $input['user_id'] = Auth::user()->id;
            $logs = LoggerUsers::create($input);
            $lastUpdated = $logs->max('updated_at'); 
            $processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
            $validator = 'Arquivo de Ordem de Compra, cadastrado com sucesso!';
            return view('ordem_compra/ordem_compras_arquivos_novo', compact('unidade','processos','processo_arquivos'))
              ->withErrors($validator)
              ->withInput(session()->flashInput($request->input()));		
          } else {
            $processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
            $validator = 'Informe um Arquivo para o Cadastro!';
            return view('ordem_compra/ordem_compras_arquivos_novo', compact('unidade','processos','processo_arquivos'))
              ->withErrors($validator)
              ->withInput(session()->flashInput($request->input()));		
          }
          
	  } 

    public function cadastroOrdemCompra($id_unidade)
	{ 
      $unidades = $unidadesMenu = $this->unidade->all();
      $unidade = $this->unidade->find($id_unidade);
      $cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
      $processos = Processos::where('unidade_id', $id_unidade)->paginate(50);
      $processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->paginate(50); 
      return view('ordem_compra/ordem_compras_arquivos_novo', compact('unidades','unidade','cotacoes','processos','processo_arquivos'));
	}

    public function arquivosOrdemCompra($id, $id_processo, Request $request)
	{
      $mes = date('m',strtotime('now')); 
      $processos = Processos::where('id', $id_processo)->get();
      $processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
      $unidade = Unidade::where('id',$id)->get();
			return view('ordem_compra/ordem_compras_arquivos_novo', compact('unidade','processos','processo_arquivos'));
    }
}