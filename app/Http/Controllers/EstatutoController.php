<?php

namespace App\Http\Controllers;

use App\Model\Estatuto;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class EstatutoController extends Controller
{
	public function __construct(Unidade $unidade, Estatuto $estatuto, LoggerUsers $logger_users)
	{
		$this->unidade  	= $unidade;
		$this->estatuto 	= $estatuto;
		$this->logger_users = $logger_users;
	}

    public function index()
    {
        $unidades = $this->unidade->all();
		return view('transparencia.estatuto', compact('unidades'));
    }

	public function estatutoCadastro($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$estatutos = $this->estatuto->all();
		if($validacao == 'ok') {
			return view('transparencia/estatuto/estatuto_cadastro', compact('unidade','unidades','unidadesMenu','estatutos'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	 		
		}
	}

	public function estatutoNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		if($validacao == 'ok') {
			return view('transparencia/estatuto/estatuto_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

	public function estatutoExcluir($id, $id_estatuto, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$estatutos = $this->estatuto->find($id_estatuto);
		if($validacao == 'ok') {
			return view('transparencia/estatuto/estatuto_excluir', compact('unidade','unidades','unidadesMenu','estatutos'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

    public function store($id, Request $request)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$estatutos = $this->estatuto->all();
		$input = $request->all();
		$nome = $_FILES['path_file']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255'		
		]);
		if ($validator->fails()) {
			return view('transparencia/estatuto/estatuto_novo', compact('unidade','unidades','unidadesMenu','estatutos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else {
			if($request->file('path_file') === NULL) {
				$validator = 'Informe o arquivo do Estatuto / Ata!';
				return view('transparencia/estatuto/estatuto_novo', compact('unidade','unidades','unidadesMenu','estatutos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));	
			} else {
				if($extensao === 'pdf') {
					$nome = $_FILES['path_file']['name']; 
					$request->file('path_file')->move('../public/storage/estatuto_ata/', $nome);
					$input['path_file'] = 'estatuto_ata/'.$nome; 
					$input['kind'] = 'ATA';
					$estatuto = Estatuto::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$estatutos = $this->estatuto->all();
					$validator = 'Estatuto / Ata cadastrado com sucesso!';
					return view('transparencia/estatuto/estatuto_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','estatutos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				} else {
					$validator = 'Só são permitidos arquivos do tipo: PDF!';
					return view('transparencia/estatuto/estatuto_novo', compact('unidade','unidades','unidadesMenu','estatutos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				}
			}
		}
    }

    public function destroy($id, $id_estatuto, Estatuto $estatuto, Request $request)
    {
		Estatuto::find($id_estatuto)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$nome = $input['path_file'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
		$lastUpdated = $log->max('updated_at');
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$estatutos = $this->estatuto->all();
		$validator = 'Estatuto/Ata Excluído com sucesso!';
		return view('transparencia/estatuto/estatuto_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','estatutos'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }
}