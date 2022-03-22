<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ContratacaoServicos;
use App\Model\Unidade;
use App\Model\Especialidades;
use App\Model\EspecialidadeContratacao;
use Illuminate\Support\Facades\Storage;
use DB;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\If_;
use Symfony\Component\VarDumper\VarDumper;
use Validator;

class ContratacaoServicosController extends Controller
{
    public function paginaContratacaoServicos()
    {
        $unidades = Unidade::all();
        $contratacao_servicos = ContratacaoServicos::all();
        $sucesso = "";
        return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'unidades', 'sucesso'));
    }

    public function novaContratacaoServicos(Request $request)
    {
        $sucesso = "";
        $Unidades = Unidade::all();
        $contratacao_servicos = ContratacaoServicos::all();
        $especialidades = Especialidades::all();
        return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso'));
    }

    public function salvarContratacaoServicos(Request $request)
    {
        $sucesso                   = "";
        $Unidades                  = Unidade::all();
        $contratacao_servicos      = ContratacaoServicos::all();
        $especialidades            = Especialidades::all();
        $especialidade_contratacao = EspecialidadeContratacao::all();
        $input      = $request->all();
        //Definindo valor em branco para erratass
        $input['nome_arq_errat'] = "";
        $input['nome_arq_errat_2'] = "";
        $input['nome_arq_errat_3'] = "";
        $input['arquivo_errat'] = "";
        $input['arquivo_errat_2'] = "";
        $input['arquivo_errat_3'] = "";
        //Veriicando tipo de prazo.
        if ((isset($input['tipoPrazo']) == false)) {
            $input['tipoPrazo']  = 0;
            $input['prazoFinal'] = date('Y-m-d', strtotime('2025-03-02'));
        }
        //Vericação de inputs
        $validator = Validator::make($request->all(), [
            'texto'        => 'required|max:255',
            'nome_arq'     => 'required|max:2000',
            'unidade_id'   => 'required|max:255',
            'prazoInicial' => 'required'
        ]);
        $unidade_id = $input['unidade_id'];
        $nome       = $_FILES['nome_arq']['name'];
        $dtPrazoIni = $input['prazoInicial'];
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        if ((isset($dtPrazoFim))) {
            if ($dtPrazoIni >= $dtPrazoFim) {
                $sucesso = "no";
                $validator = 'A data inicial do prazo não pode ser maior ou igual que a data final ! ';
                return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            }
        }
        //Verificação de escolha de especialidade
        if (isset($input['especialidade'])) {
            $count       = sizeof($input['especialidade']);
            $qtdEspSelec = array();
            $qtdEspSelec = $input['especialidade'];
        } else {
            $validator = "Selecione alguma Especialidade!";
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
        if ($validator->fails()) {
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ((sizeof($qtdEspSelec)) == 0) {
            $sucesso = "no";
            $validator = 'Escolha pelo menos um especialidade !';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ($request->file('nome_arq') === NULL) {
            $sucesso = "no";
            $validator = 'Você esqueceu de anexar o arquivo!';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ($extensao === 'pdf') {
            $nome = $_FILES['nome_arq']['name'];
            $request->file('nome_arq')->move('../public/storage/contratacao_servicos/', $nome);
            $input['arquivo'] = 'contratacao_servicos/' . $nome;
            $input['nome_arq'] = $nome;
            $input['titulo'] = 'Proposta de contratação' . '-' . $input['unidade_id'] . '-' . now();
            $contratacao_servicos = ContratacaoServicos::create($input);
            $id_contratacao_servico = DB::table('contratacao_servicos')->max('id');
            foreach ($qtdEspSelec as $qtdEsp) {
                $input['contratacao_servicos_id'] =  $id_contratacao_servico;
                $input['especialidades_id'] = $qtdEsp;
                $especialidade_contratacao = EspecialidadeContratacao::all();
                $especialidade_contratacao = EspecialidadeContratacao::create($input);
            }
            $contratacao_servicos = ContratacaoServicos::all();
            $sucesso = "ok";
            $validator = 'Contratação de serviço cadastrada sucesso!';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'validator'))
                ->withInput(session()->flashInput($request->input()));
        } else {
            $sucesso = "no";
            $validator = 'Só são permitidos os arquivos do tipo: PDF';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }

    //Pesquisar contratação
    public function pesquisarContratacao(Request $request)
    {
        $input = $request->all();
        $unidades = Unidade::all();
        $pesq = $input['unidade_id'];
        if (!$pesq == "") {
            $contratacao_servicos = DB::table('contratacao_servicos')->where('unidade_id', $pesq)->get();
        } else {
            $contratacao_servicos = ContratacaoServicos::all();
        }
        return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'unidades'));
    }
    //Pagina exclusão contratação
    public function pagExcluirContratacao($id)
    {
        $sucesso = "";
        $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $Unidades = Unidade::where('id', $unidade_id)->get();
        $especialidades = Especialidades::all();
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get('especialidades_id');
        return view('contratacao_servicos/contratacaoServicos_excluir', compact('contratacao_servicos', 'Unidades', 'sucesso', 'especialidades', 'especialidade_contratacao'));
    }
    //Excluir contratação
    public function excluirContratacao($id)
    {
        EspecialidadeContratacao::where('contratacao_servicos_id', $id)->delete();
        ContratacaoServicos::find($id)->delete();
        $unidades = Unidade::all();
        $contratacao_servicos = ContratacaoServicos::all();
        $especialidades = Especialidades::all();
        $unidades = Unidade::all();
        $validator = "Contratação de serviço exluida com sucesso";
        return redirect()->route('paginaContratacaoServicos', compact('contratacao_servicos', 'especialidades', 'unidades'));
    }
    //Excluir especialidade do contrato
    public function exclEspeContr($idContr, $idEsp)
    {
        EspecialidadeContratacao::where('contratacao_servicos_id', $idContr)->where('especialidades_id', $idEsp)->delete();
        $sucesso = "";
        $contratacao_servicos  = ContratacaoServicos::where('id', $idContr)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $Unidades = Unidade::where('id', $unidade_id)->get();
        $especialidades = Especialidades::all();
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $idContr)->get('especialidades_id');
        return  redirect()->route('pagAlteraContratacao', [$idContr]);
    }

    //Excluir arquivo contratação

    public function exclArqContr($id, Request $request)
    {

        $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
        $pasta = $contratacao_servicos[0]->arquivo;
        Storage::delete($pasta);
        //return $pasta;
        $input['arquivo'] = '';
        $input['nome_arq'] = '';
        $contratacao_servicos  = ContratacaoServicos::find($id);
        $contratacao_servicos->update($input);
        $sucesso = "ok";
        $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $Unidades = Unidade::all();
        $especialidades = Especialidades::all();
        $validator = "Arquivo excluido com sucesso !";
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get('especialidades_id');
        return  redirect()->route('pagAlteraContratacao', [$id])
            ->withErrors($validator);
    }

    //Excluir arquivo errata contratação

    public function exclArqErratContr($id, Request $request)
    {
        $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
        $pasta = $contratacao_servicos[0]->arquivo_errat;
        Storage::delete($pasta);
        $input['arquivo_errat'] = '';
        $input['nome_arq_errat'] = '';
        $contratacao_servicos  = ContratacaoServicos::find($id);
        $contratacao_servicos->update($input);
        $sucesso = "ok";
        $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $Unidades = Unidade::all();
        $especialidades = Especialidades::all();
        $validator = "Arquivo excluido com sucesso !";
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get('especialidades_id');
        return  redirect()->route('pagProrrContr', [$id])
            ->withErrors($validator);
    }


    //Pagina Alterar Contratacao

    public function pagAlteraContratacao($id)
    {
        $sucesso = "";
        $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $Unidades = Unidade::all();
        $especialidades = Especialidades::all();
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get('especialidades_id');

        return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'sucesso', 'especialidades', 'especialidade_contratacao', 'unidade_id'));
    }
    //Alterar dados contratacao
    public function alteraContratacao($id, Request $request)
    {
        $input = $request->all();
        //Definindo valor em branco para erratass
        $input['nome_arq_errat'] = "";
        $input['nome_arq_errat_2'] = "";
        $input['nome_arq_errat_3'] = "";
        $input['arquivo_errat'] = "";
        $input['arquivo_errat_2'] = "";
        $input['arquivo_errat_3'] = "";
        //Veriicando tipo de prazo.
        var_dump(isset($input['tipoPrazo']));
        if ((isset($input['tipoPrazo']) == false)) {
            $input['tipoPrazo']  = 0;
            $input['prazoFinal'] = date('Y-m-d', strtotime('2025-03-02'));
        }
        $sucesso = "";
        $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $nome_arq = $contratacao_servicos[0]->arquivo;
        $Unidades = Unidade::all();
        $especialidades = Especialidades::all();
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get('especialidades_id');
        $dtPrazoIni = $input['prazoInicial'];
        $dtPrazoFim = $input['prazoFinal'];
        $isTouch = isset($input['nome_arq']);
        if ($isTouch == true) {
            $nome = $_FILES['nome_arq']['name'];
            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        }
        $validator = Validator::make($request->all(), [
            'texto' => 'required|max:255',
            'unidade_id' => 'required|max:255',
            'prazoInicial' => 'required',
        ]);
        if ($validator->fails()) {
            $sucesso = "no";
            return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'sucesso', 'especialidades', 'especialidade_contratacao', 'unidade_id'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ($dtPrazoIni >= $dtPrazoFim) {
            $sucesso = "no";
            $validator = 'A data inicial do prazo não pode ser maior ou igual que a data final !';
            return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'especialidade_contratacao', 'unidade_id'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ($nome_arq != "") {
            $contratacao_servicos = ContratacaoServicos::find($id);
            $contratacao_servicos->update($input);
            $count = sizeof($especialidades);
            $id_contratacao_servico = DB::table('contratacao_servicos')->max('id');

            $isTouch = isset($input['especialidade']);
            if ($isTouch) {
                $qtdEspSelec = $input['especialidade'];

                foreach ($qtdEspSelec as $qtdEsp) {
                    $espContr = EspecialidadeContratacao::where('contratacao_servicos_id', $id)
                        ->where('especialidades_id', $qtdEsp)
                        ->get();
                    $espContr = sizeof($espContr);
                    if ($espContr == 0) {
                        $input['contratacao_servicos_id'] =  $id_contratacao_servico;
                        $input['especialidades_id'] = $qtdEsp;
                        $especialidade_contratacao = EspecialidadeContratacao::all();
                        $especialidade_contratacao = EspecialidadeContratacao::create($input);
                    }
                }
            }

            $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
            $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get();
            $sucesso = "ok";
            $validator = 'Contratação de serviço alterada com sucesso!';
            return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'validator', 'unidade_id', 'especialidade_contratacao'))
                ->withInput(session()
                    ->flashInput($request->input()));
        } elseif ($request->file('nome_arq') === NULL) {
            $sucesso = "no";
            $validator = 'Você esqueceu de anexar o arquivo!';
            return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'unidade_id', 'especialidade_contratacao'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ($extensao === 'pdf') {
            $nome = $_FILES['nome_arq']['name'];
            $request->file('nome_arq')->move('../public/storage/contratacao_servicos/', $nome);
            $input['arquivo'] = 'contratacao_servicos/' . $nome;
            $input['nome_arq'] = $nome;
            $input['titulo'] = 'Proposta de contratação' . '-' . $input['unidade_id'] . '-' . now();
            $contratacao_servicos = ContratacaoServicos::find($id);
            $contratacao_servicos->update($input);
            $count = sizeof($especialidades);
            $id_contratacao_servico = DB::table('contratacao_servicos')->max('id');

            $isTouch = isset($input['especialidade']);
            if ($isTouch) {
                $qtdEspSelec = $input['especialidade'];

                foreach ($qtdEspSelec as $qtdEsp) {
                    $espContr = EspecialidadeContratacao::where('contratacao_servicos_id', $id)
                        ->where('especialidades_id', $qtdEsp)
                        ->get();
                    $espContr = sizeof($espContr);
                    if ($espContr == 0) {
                        $input['contratacao_servicos_id'] =  $id_contratacao_servico;
                        $input['especialidades_id'] = $qtdEsp;
                        $especialidade_contratacao = EspecialidadeContratacao::all();
                        $especialidade_contratacao = EspecialidadeContratacao::create($input);
                    }
                }
            }

            $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
            $especialidade_contratacao = EspecialidadeContratacao::all();
            $sucesso = "ok";
            $validator = 'Contratação de serviço alterada com sucesso!';
            return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'validator', 'unidade_id', 'especialidade_contratacao'))
                ->withInput(session()
                    ->flashInput($request->input()));
        } else {
            $sucesso = "no";
            $validator = 'Só são permitidos os arquivos do tipo: PDF';
            return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'unidade_id', 'especialidade_contratacao'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }
    //Pagina prorroga contrato

    public function pagProrrContr($id)
    {
        $sucesso = "";
        $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
        return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso'));
    }

    //Prorrogação de contrato
    public function prorrContr($id, Request $request)
    {
        $input = $request->all();
        $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
        $dtPrazoFim = $contratacao_servicos[0]->prazoFinal;
        $PrazProAtual = $contratacao_servicos[0]->prazoProrroga;
        $dtProrrgac = $input['prazoProrroga'];
        if ($dtProrrgac == "") {
            $sucesso = "no";
            $validator = "Você não digitou a nova data.";
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso'))
                ->withErrors($validator);
        } elseif ($dtProrrgac <= $PrazProAtual) {
            $sucesso = "no";
            $validator = "Data prorroga menor ou igual a data de prorrogação Atual";
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso'))
                ->withErrors($validator);
        } elseif ($dtProrrgac <= $dtPrazoFim) {
            $sucesso = "no";
            $validator = "Data prorroga menor ou igual a data final";
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso'))
                ->withErrors($validator);
        } elseif ($contratacao_servicos[0]->arquivo_errat == "") {
            $nome_arq = $contratacao_servicos[0]->arquivo_errat;
            $nome = "";
            $isTouch = isset($input['nome_arq_errat']);
            if ($isTouch == true) {
                $nome = $_FILES['nome_arq_errat']['name'];
                $extensao = pathinfo($nome, PATHINFO_EXTENSION);
                $extensao = strtolower($extensao);
            }
            if ($nome_arq == "" && $nome == "") {
                $sucesso = "no";
                $validator = "Você precisar anexar o arquivo da errata";
                return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso'))
                    ->withErrors($validator);
            } elseif ($extensao === 'pdf') {
                $input['nome_arq_errat_2'] = "";
                $input['nome_arq_errat_3'] = "";
                $input['arquivo_errat_2'] = "";
                $input['arquivo_errat_3'] = "";
                $input['dtup_errat'] = date('Y-m-d');
                $request->file('nome_arq_errat')->move('../public/storage/contratacao_servicos/', $nome);
                $input['arquivo_errat'] = 'contratacao_servicos/' . $nome;
                $input['nome_arq_errat'] = $nome;
                $sucesso = "ok";
                $contratacao_servicos = ContratacaoServicos::find($id);
                $contratacao_servicos->update($input);
                $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
                $validator = 'Prorrogação efetuada com sucesso';
                return redirect()->route('pagProrrContr', $id)
                    ->withErrors($validator)
                    ->with('contratacao_servicos', 'sucesso', 'validator');
            } else {
                $validator = 'Só é aceito arquivo com a extenssão PDF !';
                return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'validator'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            }
        } elseif ($contratacao_servicos[0]->arquivo_errat_2 == "") {
            $nome_arq = $contratacao_servicos[0]->arquivo_errat_2;
            $nome = "";
            $isTouch = isset($input['nome_arq_errat_2']);
            if ($isTouch == true) {
                $nome = $_FILES['nome_arq_errat_2']['name'];
                $extensao = pathinfo($nome, PATHINFO_EXTENSION);
                $extensao = strtolower($extensao);
            }
            if ($nome_arq == "" && $nome == "") {
                $sucesso = "no";
                $validator = "Você precisar anexar a segunda errata para prorrogar";
                return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'validator'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            } elseif ($extensao === 'pdf') {
                $input['nome_arq_errat_3'] = "";
                $input['arquivo_errat_3'] = "";
                $input['dtup_errat_2'] =  date('Y-m-d');
                $nome = $_FILES['nome_arq_errat_2']['name'];
                $request->file('nome_arq_errat_2')->move('../public/storage/contratacao_servicos/', $nome);
                $input['arquivo_errat_2'] = 'contratacao_servicos/' . $nome;
                $input['nome_arq_errat_2'] = $nome;
                $sucesso = "ok";
                $contratacao_servicos = ContratacaoServicos::find($id);
                $contratacao_servicos->update($input);
                $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
                $validator = 'Prorrogação efetuada com sucesso';
                return redirect()->route('pagProrrContr', $id)
                    ->withErrors($validator)
                    ->with('contratacao_servicos', 'sucesso', 'validator');
            } else {
                $validator = 'Só é aceito arquivo com a extenssão PDF !';
                return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'validator'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            }
        } elseif ($contratacao_servicos[0]->arquivo_errat_3 == "") {
            $nome_arq = $contratacao_servicos[0]->arquivo_errat_3;
            $nome = "";
            $isTouch = isset($input['nome_arq_errat_3']);
            if ($isTouch == true) {
                $nome = $_FILES['nome_arq_errat_3']['name'];
                $extensao = pathinfo($nome, PATHINFO_EXTENSION);
                $extensao = strtolower($extensao);
            }
            if ($nome_arq == "" && $nome == "") {
                $sucesso = "no";
                $validator = "Você precisar anexar o arquivo";
                return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'validator'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            } elseif ($extensao === 'pdf') {
                $input['dtup_errat_3'] = date('Y-m-d');
                $nome = $_FILES['nome_arq_errat_3']['name'];
                $request->file('nome_arq_errat_3')->move('../public/storage/contratacao_servicos/', $nome);
                $input['arquivo_errat_3'] = 'contratacao_servicos/' . $nome;
                $input['nome_arq_errat_3'] = $nome;
                $sucesso = "ok";
                $contratacao_servicos = ContratacaoServicos::find($id);
                $contratacao_servicos->update($input);
                $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
                $validator = 'Prorrogação efetuada com sucesso';
                return redirect()->route('pagProrrContr', $id)
                    ->withErrors($validator)
                    ->with('contratacao_servicos', 'sucesso', 'validator');
            } else {
                $validator = 'Só é aceito arquivo com a extenssão PDF !';
                return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'validator'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            }
        } else {
            $sucesso = "no";
            $validator = "Não é possivel mais inserir prorrogações, solicite ao desenvolvimento o aumento da quantidade upload de erratas.";
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'validator'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }

    //Pagina Especialidade
    public function paginaEspecialidade()
    {
        $Especialidades = Especialidades::all();
        $sucesso = "";
        return view('contratacao_servicos/especialidades_listagem', compact('Especialidades', 'sucesso'));
    }
    //Pagina nova especialidade
    public function novaEspecialidade()
    {
        $Especialidades = Especialidades::all();
        $sucesso = "";
        return view('contratacao_servicos/especialidades_novo', compact('Especialidades', 'sucesso'));
    }
    //Salvar especialidade
    public function salvarEspecialidade(Request $request)
    {
        $input = $request->all();
        $nome = $input['nome'];
        $Especialidades = Especialidades::all();
        $EspecialiCad = Especialidades::where('nome', $nome)->get('nome');
        if ($EspecialiCad == '[]') {
            $novaEspecialidade = Especialidades::create($input);
            $sucesso = "ok";
            $validator = 'Especialidade cadastrada com sucesso';
            return view('contratacao_servicos/especialidades_novo', compact('Especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            $sucesso = "no";
            $validator = 'Especialidade Já está cadastrada !';
            return view('contratacao_servicos/especialidades_novo', compact('Especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }
    //Pesquisar especialidade
    public function pesquisarEspecialidade(Request $request)
    {
        $sucesso = "";
        $input = $request->all();
        $pesq = $input['nomePesq'];
        if (!$pesq == "") {
            $Especialidades = DB::table('especialidades')->where('nome', 'like', '%' . $pesq . '%')->get();
        } else {
            $Especialidades = Especialidades::all();
        }
        return view('contratacao_servicos/especialidades_listagem', compact('Especialidades', 'sucesso'));
    }

    //Pagina excluir especialidade
    public function pagExcluirEspeciali($id)
    {
        $sucesso = "";
        $Especialidades = Especialidades::where('id', $id)->get();
        return view('contratacao_servicos/especialidades_excluir', compact('Especialidades', 'sucesso'));
    }

    //Excluir especialidade
    public function excluirEspecialidade($id)
    {
        EspecialidadeContratacao::where('especialidades_id', $id)->delete();
        Especialidades::find($id)->delete();
        $Especialidades = Especialidades::all();
        return redirect()->route('paginaEspecialidade', compact('Especialidades'));
    }

    //Pagina Altera especialidade
    public function pagAlteraEspeciali($id)
    {
        $sucesso = "";
        $Especialidades = Especialidades::where('id', $id)->get();
        return view('contratacao_servicos/especialidades_alterar', compact('Especialidades', 'sucesso'));
    }

    public function AlteraEspeciali($id, Request $request)
    {
        $input = $request->all();
        $nome = $input['nome'];
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:255'
        ]);
        $EspecialiCad = Especialidades::where('nome', $nome)->get('nome');
        if ($validator->fails()) {
            $sucesso = "no";
            $validator = 'Nome muito longo !';
            return view('contratacao_servicos/especialidades_alterar', compact('Especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ($EspecialiCad == '[]') {
            $sucesso = "ok";
            $validator = 'Nome alterado com sucesso !';
            $Especialidades = Especialidades::find($id);
            $Especialidades->update($input);
            $Especialidades = Especialidades::where('id', $id)->get();
            return view('contratacao_servicos/especialidades_alterar', compact('Especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            $sucesso = "no";
            $validator = 'Não foi indetificado alteração no nome !';
            $Especialidades = Especialidades::where('id', $id)->get();
            return view('contratacao_servicos/especialidades_alterar', compact('Especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }
}
