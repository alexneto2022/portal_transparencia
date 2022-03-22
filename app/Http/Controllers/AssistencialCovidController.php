<?php

namespace App\Http\Controllers;

use App\Model\AssistencialCovid;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class AssistencialCovidController extends Controller
{
    public function __construct(Unidade $unidade, AssistencialCovid $assistencialCovid, LoggerUsers $logger_users)
	{
		$this->unidade  	     = $unidade;
		$this->assistencialCovid = $assistencialCovid;
		$this->logger_users      = $logger_users;
	}

    public function index()
    {
        $unidades = $this->unidade->all();
		return view('transparencia.assistencialCovid', compact('unidades'));
    }

    public function assistencialCovidCadastro($id, Request $request)
	{

        $permissao_users   = PermissaoUsers::where('unidade_id', $id)->get();
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$assistencialCovid = $this->assistencialCovid->all();
		if($validacao == 'ok') {
			return view('transparencia/assistencialCovid/covid_cadastro', compact('unidade','unidades','unidadesMenu','assistencialCovid','permissao_users'));
					
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

    public function assistencialCovidNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		if($validacao == 'ok') {
			return view('transparencia/assistencialCovid/covid_novo', compact('unidade','unidades','unidadesMenu'));
				
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

    public function assistencialCovidExcluir($id, $id_covid, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$assistencialCovid = $this->assistencialCovid->find($id_covid);
		if($validacao == 'ok') {
			return view('transparencia/assistencialCovid/covid_excluir', compact('unidade','unidades','unidadesMenu','assistencialCovid'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else {
			$validacao = "Você não tem permissão!";
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}

    public function store($id, Request $request)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$assistencialCovid = $this->assistencialCovid->all();
		$input = $request->all();
		$nome  = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
		]);	
		if ($validator->fails()) {
			return view('transparencia/assistencialCovid/covid_novo', compact('unidade','unidades','unidadesMenu','assistencialCovid'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if($request->file('file_path') === NULL) {
				$validator = 'Informe o arquivo do Assistencial Covid';
				return view('transparencia/assistencialCovid/covid_novo', compact('unidade','unidades','unidadesMenu','assistencialCovid'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				if($extensao === 'pdf') {
					$nome = $_FILES['file_path']['name']; 
                    $mes  = $input['mes'];
					$request->file('file_path')->move('../public/storage/assistencialCovid/'.$mes.'/', $nome);
					$input['file_path'] = 'assistencialCovid/'.$mes.'/'.$nome; 
				    $input['file_name'] = $nome;
                    $input['titulo']    = $input['name'];
					$assistencialCovid  = AssistencialCovid::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$assistencialCovid = $this->assistencialCovid->all();
                    $permissao_users   = PermissaoUsers::where('unidade_id', $id)->get();
					$validator = 'Assistencial Covid cadastrado com sucesso!';
					return view('transparencia/assistencialCovid/covid_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','assistencialCovid','permissao_users'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$validator = 'Só são permitidos arquivos do tipo: PDF';
					return view('transparencia/assistencialCovid/covid_novo', compact('unidade','unidades','unidadesMenu','assistencialCovid'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			}
		}
    }

    public function destroy($id, $id_covid, AssistencialCovid $assistencialCovid, Request $request)
    {
        AssistencialCovid::find($id_covid)->delete();
        $input = $request->all();
        $log   = LoggerUsers::create($input);
        $nome  = $input['path_file'];
        $pasta = 'public/'.$nome; 
        Storage::delete($pasta);
        $lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->all();
        $unidades     = $unidadesMenu; 
        $unidade      = $this->unidade->find($id);
        $assistencialCovid = $this->assistencialCovid->all();
		$validator = 'Assistencial covid excluído com sucesso!';
        return view('transparencia/assistencialCovid/covid_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','assistencialCovid'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }
}