<?php

namespace App\Http\Controllers;

use App\Model\Manual;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class RegulamentoController extends Controller
{
	public function __construct(Unidade $unidade, Manual $manual, LoggerUsers $logger_users)
    {
        $this->unidade 		= $unidade;
		$this->manual  		= $manual;
		$this->logger_users = $logger_users;
    }
	
    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('transparencia', compact('unidades'));
    }

    public function regulamentoCadastro($id)
	{
		$validacao = permissaoUsersController::Permissao($id);

		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);	
		$manuais = Manual::all();
        $lastUpdated = $manuais->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/regulamentos/regulamento_cadastro', compact('unidade','unidades','unidadesMenu','manuais','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function regulamentoNovo($id)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		if($validacao == 'ok') {
			return view('transparencia/regulamentos/regulamento_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function regulamentoExcluir($id_unidade, $id_item)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$manuais = Manual::where('id',$id_item)->get();
		$lastUpdated = $manuais->max('updated_at');	
		if($validacao == 'ok') {
			return view('transparencia/regulamentos/regulamento_excluir', compact('unidade','unidades','unidadesMenu','manuais','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!';
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
		$manuais = Manual::all();
        $lastUpdated = $manuais->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['path_file']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		$nomeImg = $_FILES['path_img']['name'];
		$extensaoI = pathinfo($nomeImg, PATHINFO_EXTENSION);
		if($request->file('path_file') === NULL || $request->file('path_img') === NULL) {	
			$validator = 'Informe o arquivo e a imagem do Regulamento!';
			return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		} else {
			if($extensao == 'pdf') {
				if($extensaoI == 'png' || $extensaoI == 'jpg') {
					$validator  = Validator::make($request->all(), [
						'title' => 'required|max:255'
					]);
					if ($validator->fails()) {
						return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated'))
							->withErrors($validator)
							->withInput(session()->flashInput($request->input()));	
					} else {  
						$nomeA = $_FILES['path_file']['name'];   
						$request->file('path_file')->move('../public/storage/manual', $nomeA);
						$nomeF = $_FILES['path_img']['name'];
						$request->file('path_img')->move('../public/img', $nome);
						$input['path_file'] = 'manual/' .$nomeA;
						$input['path_img'] = $nomeF;					
						$manuais = Manual::create($input);	
						$log = LoggerUsers::create($input);
						$lastUpdated = $log->max('updated_at');
						$manuais = Manual::all();
						$validator = 'Regulamento cadastrado com sucesso!';
						return view('transparencia/regulamentos/regulamento_cadastro', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated'))
							->withErrors($validator)
							->withInput(session()->flashInput($request->input()));										
					} 
				} else {
					$validator = 'Só suporta Imagens do tipo: PNG e JPG!';
					$manuais = Manual::where('unidade_id',$id_unidade)->get();
					$lastUpdated = $manuais->max('updated_at');
					return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));		
				}
			} else {	
				$validator = 'Só suporta arquivos do tipo: PDF!';
				$manuais = Manual::where('unidade_id',$id_unidade)->get();
				$lastUpdated = $manuais->max('updated_at');
				return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));	
			}
		}
	}

    public function destroy($id_unidade, $id_item, Manual $manuais, Request $request)
    {
		Manual::find($id_item)->delete();		
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['path_file'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
		$nome = $input['path_img'];
		$pasta = 'public/img/'.$nome; 
		Storage::delete($pasta);
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);		
		$manuais = Manual::all();
		$validator = 'Regulamento Excluído com sucesso!';
		return view('transparencia/regulamentos/regulamento_cadastro', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }
}