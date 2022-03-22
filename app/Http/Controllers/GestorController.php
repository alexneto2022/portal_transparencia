<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Gestor;
use App\Model\Contrato;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class GestorController extends Controller
{
    public function __construct(Unidade $unidade, Request $request, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->request 		= $request;
		$this->logger_users = $logger_users;
	}
	
	public function index()
    {
        $unidades = $this->associado->all();
		return view('home', compact('unidades')); 		
    }
	
	public function cadastroGestor($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$gestores = $this->gestor->all();
		$lastUpdated = $gestores->max('last_updated');
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_gestor_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','associados'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
}