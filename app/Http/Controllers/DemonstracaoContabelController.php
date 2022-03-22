<?php

namespace App\Http\Controllers;

use App\Model\DemonstracaoContabel;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PermissaoUsersController;
use App\Model\PermissaoUsers;
use Auth;
use Validator;

class DemonstracaoContabelController extends Controller
{
	public function __construct(Unidade $unidade, DemonstracaoContabel $demonstracaoContabel, LoggerUsers $logger_users)
    {
        $this->unidade 				= $unidade;
		$this->demonstracaoContabel = $demonstracaoContabel;
		$this->logger_users 		= $logger_users;
    }
	
    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('transparencia', compact('unidades'));
    }

    public function demonstrativoContCadastro($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);	
		$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id', $id)->get();
        $lastUpdated = $demonstrativoContaveis->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-contabel/accountable_cadastro', compact('unidade','unidades','unidadesMenu','demonstrativoContaveis','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function demonstrativoContNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		$contabilReports = DemonstracaoContabel::where('unidade_id', $id)->get();
        $lastUpdated = $contabilReports->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidade','unidades','unidadesMenu','contabilReports','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function demonstrativoContAlterar($id_unidade, $id_item, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$contabilReports = DemonstracaoContabel::where('id', $id_item)->get(); 
        $lastUpdated = $contabilReports->max('updated_at');
		if($validacao == 'ok') {
		    return view('transparencia/demonstrativo-contabel/accountable_alterar', compact('unidade','unidades','unidadesMenu','contabilReports','lastUpdated'));	
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function demonstrativoContExcluir($id_unidade, $id_item, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$demonstrativoContaveis = DemonstracaoContabel::where('id',$id_item)->get();
		$lastUpdated = $demonstrativoContaveis->max('updated_at');	
		if($validacao == 'ok') {
		    return view('transparencia/demonstrativo-contabel/accountable_excluir', compact('unidade','unidades','unidadesMenu','demonstrativoContaveis','lastUpdated'));
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
		$contabilReports = DemonstracaoContabel::where('unidade_id', $id_unidade)->get();
        $lastUpdated = $contabilReports->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('file_path') === NULL) {	
			$validator = 'Informe o arquivo do Demonstrativo';
			return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','contabilReports','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else {
			if($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title' => 'required|max:255',
					'ano'   => 'required'
				]);
				if ($input['ano'] < 1800 || $input['ano'] > 2500) {
					return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','contabilReports','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				}		
				if ($validator->fails()) {
					return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','contabilReports','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				}
				$ano  = $_POST['ano'];
				$qtdUnidades = sizeof($unidades);
				$nome = $_FILES['file_path']['name']; 				
				for ( $i = 1; $i <= $qtdUnidades; $i++ ) {
					if ( $unidade['id'] === $i ) {
						$txt1 = $unidades[$i-1]['path_img'];
						$txt1 = explode(".jpg", $txt1);		
						$request->file('file_path')->move('../public/storage/demonstrativo-contabel/'.$txt1[0].'/'.$ano.'/', $nome);
						$input['file_path'] = 'demonstrativo-contabel/'.$txt1[0].'/'.$ano.'/'.$nome; 	
					}
				}				
				$text = true;
				$demonstrativo = DemonstracaoContabel::create($input);	
				$log = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');
				$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
				$validator = 'Demosntrativo Contábiel cadastrado com sucesso!';
				return view('transparencia/demonstrativo-contabel/accountable_cadastro', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));				
			} else {	
				$validator = 'Só suporta arquivos do tipo: PDF!';
				$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
				$lastUpdated = $demonstrativoContaveis->max('updated_at');
				return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));				
			}
		}
    }
	
    public function update($id_unidade, $id_item, Request $request, DemonstracaoContabel $demonstracaoContabel)
    {
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);		
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
		return view('transparencia/demonstrativo-contabel/accountable_cadastro', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }

    public function destroy($id_unidade, $id_item, DemonstracaoContabel $demonstracaoContabel, Request $request)
    {
		DemonstracaoContabel::find($id_item)->delete();		
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['file_path'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);		
		$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
		$validator = 'Demonstrativo Contábil excluído com sucesso!';
		return view('transparencia/demonstrativo-contabel/accountable_cadastro', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));				
	}
}