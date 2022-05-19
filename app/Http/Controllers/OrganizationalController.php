<?php

namespace App\Http\Controllers;

use App\Model\Organizational;
use App\Model\Organograma;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Unidade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Facades\Schema;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Auth;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Validator;

class OrganizationalController extends Controller
{
	protected $unidade;
	
    public function __construct(Unidade $unidade, Organizational $organizacional, LoggerUsers $logger_users)
    {
		$this->unidade 		  = $unidade;
		$this->organizacional = $organizacional;
		$this->logger_users   = $logger_users;
    }
	
    public function index()
    {
        $unidades = $this->unidade->all();
        return view('transparencia.organizacional', compact('unidades'));
    }
	
	public function organizacionalNovo($id, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);		
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
    public function store($id, Request $request, LoggerUsers $logger_users, Auth $auth)
    {
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$estruturaOrganizacional = Organizational::where('unidade_id', $id)->get();
        if($unidade->id === 1){
            $lastUpdated = '2020-01-01 00:00:00';
        }else{
            $ultimaData = Organizational::where('unidade_id', $id)->where('updated_at','<=', Carbon::now() )->orderBy('updated_at', 'DESC')->first();
            $lastUpdated = '2020-01-01 00:00:00';
        }
		$validator = Validator::make($request->all(), [
				'name'  	 => 'required|min:10',
				'cargo' 	 => 'required|min:3',
				'email' 	 => 'required|email',
				'telefone' 	 => 'required|min:8'
		]);
		if ($validator->fails()) {
			return view('transparencia/organizacional/organizacional_novo', compact('unidade','unidadesMenu','estruturaOrganizacional'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}else {
			$input = $request->all(); 
			$organizacional = Organizational::create($input); 			
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$estruturaOrganizacional = Organizational::where('unidade_id', $id)->get();
			if($unidade->id === 1){
				$lastUpdated = '2020-01-01 00:00:00';
			}else{
				$ultimaData = Organizational::where('unidade_id', $id)->where('updated_at','<=', Carbon::now() )->orderBy('updated_at', 'DESC')->first();
				$lastUpdated = '2020-01-01 00:00:00';;
			}
			$validator = 'Estrutura organizacional cadastrada com sucesso!';
			return  redirect()->route('organizacionalCadastro', [$id])
				->withErrors($validator)
				->with('unidade', 'unidadesMenu', 'lastUpdated', 'estruturaOrganizacional');
		}
    }

	public function organizacionalCadastro($id, Organizational $organizational, Request $request)
	{ 
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		$estruturaOrganizacional = Organizational::where('unidade_id', $id)->get();
		$arqOrgano = Organograma::where('unidade_id', $id)->get();
            if($unidade->id === 1){
                $lastUpdated = '2020-01-01 00:00:00';
            }else{
                $ultimaData = Organizational::where('unidade_id', $id)->where('updated_at','<=', Carbon::now() )->orderBy('updated_at', 'DESC')->first();
                $lastUpdated = '2020-01-01 00:00:00';
            }
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_cadastro', compact('unidade','unidades','unidadesMenu','estruturaOrganizacional','arqOrgano'));
		} else {
			$validator ='Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function organizacionalAlterar($id_item, $id_unidade, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);				
		$organizacionals = Organizational::where('id', $id_item)->get();
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_alterar', compact('unidade','unidades','unidadesMenu','organizacionals'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function update($id_item, $id_unidade, Request $request)
    {	
		$unidadesMenu = $this->unidade->all();
		$unidades     = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$validator = Validator::make($request->all(), [
				'name'  	 => 'required|min:10',
				'cargo' 	 => 'required|min:3',
				'email' 	 => 'required|email',
				'telefone' 	 => 'required|min:8'
		]);		
		if ($validator->fails()) {
			$organizacionals = Organizational::where('id', $id_item)->get();
			return view('transparencia/organizacional/organizacional_novo', compact('unidade','unidadesMenu','organizacionals'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$input = $request->all();
			$organizacional = Organizational::find($id_item);
			$organizacional->update($input);			
			$log = LoggerUsers::create($input);
		    $lastUpdated = $log->max('updated_at');
			$estruturaOrganizacional = Organizational::where('unidade_id', $id_unidade)->get();
			$validator = 'Estrutura Organizacional Alterada com Sucesso!';
            return  redirect()->route('organizacionalCadastro', [$id_unidade])
				->withErrors($validator)
				->with('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'estruturaOrganizacional');
		}
    }
	
	public function organograma($id, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		$arqOrgano = Organograma::where('unidade_id', $id)->get();
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organograma_cadastro', compact('unidade','unidades','unidadesMenu','arqOrgano'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function organogramaNovo($id, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);		
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organograma_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function storeOrganograma($id, Request $request)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$undAtual = Unidade::where('id', $id)->get();
		$input = $request->all();
		$nome = $_FILES['file_path']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if ($request->file('file_path') === NULL) {
			$validator = 'Informe o arquivo do Organograma!';
			return view('transparencia/organizacional/organograma_novo', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if ($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title'    => 'required|max:255',
				]);
				if ($validator->fails()) {
					return view('transparencia/organizacional/organograma_novo', compact('unidades', 'unidade', 'unidadesMenu'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$_FILES['file_path']['name'] = $input['title'] . ".pdf";
					$request->file('file_path')->move('../public/storage/organograma/' . $undAtual[0]->sigla . "/", $_FILES['file_path']['name']);
					$input['file'] = $_FILES['file_path']['name'];
					$input['file_path'] = "organograma/" . $undAtual[0]->sigla . "/" . $_FILES['file_path']['name'];
					$input['unidade_id'] =  $undAtual[0]->id;
					Organograma::where('unidade_id',$id)->delete();
					$organograma = Organograma::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$arqOrgano = Organograma::where('unidade_id', $id)->get();
					$valdiator = 'Organograma cadastrado com sucesso!';
					return  redirect()->route('organograma', [$id])
						->withErrors($validator)
						->with('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'arqOrgano');
				}
			} else {
				$validator = 'Só são permitidos arquivos do tipo: PDF!';
				return view('transparencia/organizacional/organograma_novo', compact('unidades', 'unidade', 'unidadesMenu'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}
	
	public function organogramaExcluir($id, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);		
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organograma_excluir', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function destroyOrganograma($id, Request $request)
	{
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$input = $request->all();
		Organograma::where('unidade_id',$id)->delete();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$arqOrgano = Organograma::where('unidade_id', $id)->get();
		$validator = 'Organograma Excluído com sucesso!';
		return view('transparencia/organizacional/organograma_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated','arqOrgano'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	}

	public function organizacionalExcluir($id_item, $id_unidade, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);		
		$organizacionals = new Organizational();
		$organizacionals = Organizational::where('id', $id_item)->get();		
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_excluir', compact('unidade','unidades','unidadesMenu','organizacionals'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
    public function destroy($id_item, $id_unidade, Organizational $organizational, Request $request)
    {
        Organizational::find($id_item)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$estruturaOrganizacional = Organizational::where('unidade_id', $id_unidade)->get();
		$validator  = 'Estrutura Organizacional Excluído com Sucesso!';
				return  redirect()->route('organizacionalCadastro', [$id_unidade])
			->withErrors($validator)
			->with('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'estruturaOrganizacional');
    }
}