<?php

namespace App\Http\Controllers;

use App\Model\Decreto;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class DecretoController extends Controller
{
	public function __construct(Unidade $unidade, Decreto $decreto, LoggerUsers $logger_users)
    {
        $this->unidade 		= $unidade;
		$this->decreto 	    = $decreto;
		$this->logger_users = $logger_users;
    }
	
    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('transparencia', compact('unidades'));
    }

    public function decretoCadastro($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);

		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);	
		$decretos = Decreto::all();
        $lastUpdated = $decretos->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/decretos/decreto_cadastro', compact('unidade','unidades','unidadesMenu','decretos','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function decretoNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		if($validacao == 'ok') {
			return view('transparencia/decretos/decreto_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function decretoExcluir($id_unidade, $id_item, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$decretos = Decreto::where('id',$id_item)->get();
		$lastUpdated = $decretos->max('updated_at');	
		if($validacao == 'ok') {
			return view('transparencia/decretos/decreto_excluir', compact('unidade','unidades','unidadesMenu','decretos','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
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
		$decretos = Decreto::all();
        $lastUpdated = $decretos->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['path_file']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION); 
		if($request->file('path_file') === NULL) {	
			$validator = 'Informe o arquivo do Decreto';
			return view('transparencia/decretos/decreto_novo', compact('unidades','unidade','unidadesMenu','decretos','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else {  
			if($extensao == 'pdf') {
				$validator = Validator::make($request->all(), [
					'title'   => 'required|max:255',
					'decreto' => 'required',
					'kind'	  => 'required'
				]); 
				if ($validator->fails()) {
					return view('transparencia/decretos/decreto_novo', compact('unidades','unidade','unidadesMenu','decretos','lastUpdate'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				} else {
					$nome = $_FILES['path_file']['name'];  
					$request->file('path_file')->move('../public/storage/decretos/', $nome);
					$input['path_file'] = 'decretos/' .$nome; 
					$input['decreto'] = 'Nº: '.$input['decreto'];
					$decretos = Decreto::create($input);	
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$decretos = Decreto::all();
					$validator = 'Decreto cadastrado com Sucesso!!';
					return view('transparencia/decretos/decreto_cadastro', compact('unidades','unidade','unidadesMenu','decretos','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));										
				} 			
			} else {	
				$validator = 'São suportados somente arquivos do tipo: PDF!';
				$decretos = Decreto::all();
				$lastUpdated = $decretos->max('updated_at');
				return view('transparencia/decretos/decreto_novo', compact('unidades','unidade','unidadesMenu','decretos','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));	
			}
		}
	}

    public function destroy($id_unidade, $id_item, Decreto $decreto, Request $request)
    {
		Decreto::find($id_item)->delete();		
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['path_file'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);		
		$decretos = Decreto::all();
		$validator = 'Decreto excluido com sucesso!';
		return view('transparencia/decretos/decreto_cadastro', compact('unidades','unidade','unidadesMenu','decretos','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }
}