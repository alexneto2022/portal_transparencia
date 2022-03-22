<?php

namespace App\Http\Controllers;

use App\Model\DocumentacaoRegularidade;
use App\Model\Unidade;
use App\Model\Type;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PermissaoUsersController;
use App\Model\PermissaoUsers;
use Auth;
use Validator;

class DocumentacaoRegularidadeController extends Controller
{
	public function __construct(Unidade $unidade, DocumentacaoRegularidade $docRegularidade, LoggerUsers $logger_users)
	{
		$this->unidade = $unidade;
		$this->documentacaoRegularidade = $docRegularidade; 
		$this->logger_users = $logger_users;
	}

    public function index()
    {
        $unidade = $this->unidade->all();
		return view('transparencia.documentos', compact('unidade'));
    }

	public function documentosCadastro($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidades = $this->unidade->all();
		$unidadesMenu = $unidades;
		$unidade = $this->unidade->find($id);
		$documents = DocumentacaoRegularidade::all();
		$lastUpdated = $documents->max('updated_at');
		$types = Type::all();
		if($validacao == 'ok') {
			return view('transparencia/documento/documentos_cadastro', compact('unidade','unidadesMenu','unidades','lastUpdated','documents','types'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))	
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}

	public function documentosNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidades = $this->unidade->all();
		$unidadesMenu = $unidades;
		$unidade = $this->unidade->find($id);
		$types = Type::all();
		if($validacao == 'ok') {
			return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}

	public function documentosExcluir($id, $id_escolha, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidades = $this->unidade->all();
		$unidadesMenu = $unidades;
		$unidade = $this->unidade->find($id);
		$types = Type::all();
		$documents = DocumentacaoRegularidade::find($id_escolha);
		$lastUpdated = $documents->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/documento/documentos_excluir', compact('unidade','unidadesMenu','unidades','documents','types'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}

    public function store($id, Request $request)
    { 
        $unidades = $this->unidade->all();
		$unidadesMenu = $unidades;
		$unidade = $this->unidade->find($id);
		$types = Type::all();
		$input = $request->all();
		$nome = $_FILES['path_file']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);	
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255'
		]);
		if ($validator->fails()) {			
			return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else {
			if($request->file('path_file') === NULL) {	
				$validator = 'Informe um arquivo para o Documento de Regularidade!';
				return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));	
			} else {
				if($extensao === 'pdf') {
					$nome = $_FILES['path_file']['name'];
					$request->file('path_file')->move('../public/storage/documento_regularidade/', $nome);	
					$input['path_file'] = 'documento_regularidade/'.$nome;
					DocumentacaoRegularidade::create($input);		
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$documents = DocumentacaoRegularidade::all();	
					$validator = 'Documento de Regularidade cadastrado com sucesso!';
					return view('transparencia/documento/documentos_cadastro', compact('unidade','unidadesMenu','unidades','documents','lastUpdated','types'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));				
				} else {
					$validator = 'Só são permitidos os arquivos do tipo: PDF';
					return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));				
				}
			}
		}
    }

    public function destroy($id, $id_escolha, DocumentacaoRegularidade $documentacaoRegularidade, Request $request)
    {
		DocumentacaoRegularidade::find($id_escolha)->delete();
		$input = $request->all();
		$nome = $input['path_file'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
        $unidades = $this->unidade->all();
		$unidadesMenu = $unidades;
		$unidade = $this->unidade->find($id);
		$types = Type::all();
		$documents = DocumentacaoRegularidade::all();
		$validator = 'Documento de Regularidade excluído com sucesso!';
		return view('transparencia/documento/documentos_cadastro', compact('unidade','unidadesMenu','unidades','documents','lastUpdated','types'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));			
    }
}