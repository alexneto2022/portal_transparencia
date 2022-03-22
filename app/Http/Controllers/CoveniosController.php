<?php

namespace App\Http\Controllers;

use App\Model\Covenio;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use Validator;

class CoveniosController extends Controller
{
    public function __construct(Unidade $unidade, Covenio $covenio, LoggerUsers $logger_users)
    {
        $this->unidade 		= $unidade;
		$this->covenio 		= $covenio;
		$this->logger_users = $logger_users;
    }
	
	public function index(Unidade $unidade)
    {
        $unidades = $this->unidade->all();
		return view('transparencia.covenio', compact('unidades'));
    }
	
	public function covenioNovo($id_unidade, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		return view('transparencia/covenio/covenio_novo', compact('unidades','unidade','unidadesMenu'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
	}
	
	public function covenioCadastro($id_unidade, Covenio $covenio, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$covenios = Covenio::all();
        $lastUpdated = $covenios->max('updated_at');
    	return view('transparencia/covenio/covenio_cadastro', compact('unidades','unidade','unidadesMenu','covenios','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
	}
	
	public function covenioExcluir($id_unidade, $escolha, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$covenios = Covenio::where('id',$escolha)->get();
        $lastUpdated = $covenios->max('updated_at');        
		return view('transparencia/covenio/covenio_excluir', compact('unidades','unidade','unidadesMenu','covenios','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
	}
	
    public function store($id_unidade, Request $request)
    { 
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$covenios = Covenio::where('unidade_id',$id_unidade)->get();
        $lastUpdated = $covenios->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['path_file']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('path_file') === NULL) {	
			$validator = 'Informe o arquivo do Covênio!';		
			return view('transparencia/covenio/covenio_novo', compact('unidades','unidade','unidadesMenu','covenios','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));				
		} else {
			if($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title'    => 'required|max:255',
				]);
				if ($validator->fails()) {
					return view('transparencia/convenio/convenio_novo', compact('unidades','unidade','unidadesMenu','covenios','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$nome = $_FILES['path_file']['name']; 
					$upload = $request->file('path_file')->move('../public/storage/covenio', $nome);
					$input['path_file'] = 'covenio/'.$nome;
					$input['path_name'] = $nome; 
					$covenio = Covenio::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$covenios = Covenio::where('unidade_id',$id_unidade)->get();
					$validator = 'Convênio cadastrado com sucesso!';
					return view('transparencia/covenio/covenio_cadastro', compact('unidades','unidade','unidadesMenu','covenios','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				}
			} else {	
				$validator = 'Só são suportados arquivos do tipo: PDF';
				return view('transparencia/covenio/covenio_novo', compact('unidades','unidade','unidadesMenu','covenios','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));	
			}
		}
    }
	
    public function destroy($id_unidade, $id_escolha, Covenio $covenio, Request $request)
    {
        Covenio::find($id_escolha)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['path_name'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$covenios = Covenio::where('unidade_id',$id_unidade)->get();
		$validator = 'Convênio excluído com sucesso!';
   		return view('transparencia/covenio/covenio_cadastro', compact('unidades','unidade','unidadesMenu','covenios','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));	
    }
}