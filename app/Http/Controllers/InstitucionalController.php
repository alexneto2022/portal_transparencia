<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\Institucional;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class InstitucionalController extends Controller
{
	protected $unidade;
	
    public function __construct(Unidade $unidade, LoggerUsers $logger_users)
    {
		$this->unidade 		= $unidade;
		$this->logger_users = $logger_users;
    }

    public function index()
    {
		$unidades = $this->unidade->all();
        return view('home', compact('unidades'));
    }
	
	public function institucionalCadastro($id, Request $request)
	{ 
		$validacao = permissaoUsersController::Permissao($id);

		$unidadesMenu = $this->unidade->all();
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		if($validacao == 'ok') {
			return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

	public function institucionalNovo($id, Request $request)
	{ 
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		if($validacao == 'ok') {
			return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu'));
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
		$unidade = $unidadesMenu->find($id);
		$input = $request->all();	
		$nome = $_FILES['path_img']['name']; 		
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);		
		$nomeI = $_FILES['icon_img']['name']; 		
		$extensaoI = pathinfo($nomeI, PATHINFO_EXTENSION);
		if(($request->file('path_img') === NULL) || ($request->file('icon_img') === NULL)) {	
			$validator = 'Insira um arquivo e um ícone!';
			return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu','true'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if(($extensao == 'png' || $extensao == 'jpg') && ($extensaoI == 'png' || $extensaoI == 'jpg')) {
				$validator = Validator::make($request->all(), [
					'owner'       => 'required|max:255',
					'cnpj'        => 'required|max:18',
					'telefone'    => 'required|max:13',
					'cep' 	   	  => 'required|max:11',
					'google_maps' => 'required'
				]);
				if ($validator->fails()) {
					return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$nome = $_FILES['path_img']['name']; 
					$input['path_img'] = $nome; 
					$nomeI = $_FILES['icon_img']['name'];
					$input['icon_img'] = $nomeI;
					$request->file('path_img')->move('../public/img', $nome);	
					$request->file('icon_img')->move('../public/img', $nomeI);	
					$unidade = Unidade::create($input);
					$log = LoggerUsers::create($input);	
					$lastUpdated = $log->max('updated_at');	
					$validator = 'Instituição Cadastrada com Sucesso!';
					return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			} else  {	
				$validator = 'Só são suportados arquivos do tipo: JPG ou PNG!';
				return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}		
	}

	public function institucionalAlterar($id, Request $request)
	{ 	
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		if($validacao == 'ok') {
			return view('transparencia/institucional/institucional_alterar', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Vocênão tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}

	public function update($id, Request $request)
	{
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $unidadesMenu->find($id); 
		$input = $request->all();
		if(($request->file('path_img') === NULL) || ($request->file('icon_img') === NULL)) {
			$validator = Validator::make($request->all(), [
					'owner'    => 'required|max:255',
					'cnpj'     => 'required|max:18',
					'telefone' => 'required|max:13',
					'cep' 	   => 'required|max:10'
			]);
			if ($validator->fails()) {
				return view('transparencia/institucional/institucional_alterar', compact('unidade','unidades','unidadesMenu'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} 
			if(!empty($input['path_img']) && !empty($input['icon_img'])){
				$unidade = Unidade::find($id);
				$unidade->update($input);
				$log = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');
				$validator = 'Instituição Alterada com Sucesso!';	
				return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','lastUpdated','unidadesMenu'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}  
		} else { 
			$unidade = Unidade::find($id);
			$unidade->update($input);
			$lastUpdated = $unidade->max('updated_at');	
			LoggerUsers::create($input);
			$validator = 'Instituição Alterada com Sucesso!';
			return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','lastUpdated','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function institucionalExcluir($id, Request $request)
	{ 
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		if($validacao == 'ok') {
			return view('transparencia/institucional/institucional_excluir', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}

	public function destroy($id, Unidade $unidade, Request $request)
	{ 
		$input = $request->all();
		$logers = LoggerUsers::where('unidade_id', $input['unidade_id'])->get();
		$qtdLog = sizeof($logers);
		if($qtdLog > 0) {
			for ( $i = 0; $i <= $qtdLog; $i++ ) {
				LoggerUsers::find($logers[$i]['id'])->delete();	
			}
		}		
		Unidade::find($id)->delete();		
		$unidadesMenu = $this->unidade->all();
		$unidades = $this->unidade->all();
		$lastUpdated = $unidades->max('updated_at');	
		$unidade = $unidadesMenu->find(1);
		$validator = 'Instituição Excluída com sucesso!';
		return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	}
}