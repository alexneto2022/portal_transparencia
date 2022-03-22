<?php

namespace App\Http\Controllers;

use App\Model\Ouvidoria;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use App\Model\Unidade;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;

class OuvidoriaController extends Controller
{
    public function __construct(Unidade $unidade, Ouvidoria $ouvidoria)
    {
        $this->unidade 	 = $unidade;
		$this->ouvidoria = $ouvidoria;
    }
    
    public function sicCadastro($id, Request $request)
    {
        $validacao = permissaoUsersController::Permissao($id);
		$unidade   = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->all();
		$unidades 	  = $unidadesMenu;
		if($id == 1){
            $ouvidorias = Ouvidoria::all();
        } else {
            $ouvidorias = Ouvidoria::where('unidade_id', $id)->get();
        }
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_cadastro', compact('unidades','unidadesMenu','unidade','ouvidorias'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
    }

    public function ouvidoriaNovo($id, Request $request)
    {
        $validacao = permissaoUsersController::Permissao($id);
		$unidade   = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->all();
		$unidades 	  = $unidadesMenu;
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_novo', compact('unidades','unidadesMenu','unidade'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
    }

    public function ouvidoriaAlterar($id, $id_ouvidoria, Request $request)
    {
        $validacao = permissaoUsersController::Permissao($id);
		$unidade   = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->all();
		$unidades 	  = $unidadesMenu;
        $ouvidoria 	  = $this->ouvidoria->find($id_ouvidoria);
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_alterar', compact('unidades','unidadesMenu','unidade','ouvidoria'));
		} else {
			$validator = "Você não tem Permissão!!";		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
    }

    public function ouvidoriaExcluir($id, $id_ouvidoria, Request $request)
    {
        $validacao = permissaoUsersController::Permissao($id);
		$unidade   = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->all();
		$unidades 	  = $unidadesMenu;
        $ouvidoria    = $this->ouvidoria->find($id_ouvidoria);
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_excluir', compact('unidades','unidadesMenu','unidade','ouvidoria'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }

    public function storeOuvidoria($id, Request $request)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$ouvidorias   = $this->ouvidoria->where('unidade_id',$id);
		$input        = $request->all();
		$validator = Validator::make($request->all(), [
			'responsavel' => 'required|max:255',
            'email'       => 'required|max:255|email',
            'telefone'    => 'required|max:40'		
		]);
		if ($validator->fails()) {
			return view('transparencia/ouvidoria/ouvidoria_novo', compact('unidade','unidades','unidadesMenu','ouvidorias'))
			  ->withErrors($validator)
			  ->withInput(session()->flashInput($request->input()));
		} else {
			$ouvidoria   = Ouvidoria::create($input);
			$log         = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$ouvidorias  = Ouvidoria::where('unidade_id',$id)->get();
			$validator   = 'Ouvidoria cadastrada com sucesso!';		
			return view('transparencia/ouvidoria/ouvidoria_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','ouvidorias'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }

    public function updateOuvidoria($id, $id_ouvidoria, Request $request)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$ouvidorias   = $this->ouvidoria->where('unidade_id',$id_ouvidoria);
		$input        = $request->all();
		$validator = Validator::make($request->all(), [
			'responsavel' => 'required|max:255',
            'email'       => 'required|max:255|email',
            'telefone'    => 'required|max:40'		
		]);
		if ($validator->fails()) {
			return view('transparencia/ouvidoria/ouvidoria_alterar', compact('unidade','unidades','unidadesMenu','ouvidorias','text'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$ouvidoria = $this->ouvidoria->find($id_ouvidoria);
            $ouvidoria->update($input);	
			$log         = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$ouvidorias  = Ouvidoria::where('id',$id_ouvidoria)->get();
			$validator = 'Ouvidoria alterada com sucesso!';		
			return view('transparencia/ouvidoria/ouvidoria_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','ouvidorias'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }

    public function destroyOuvidoria($id, $id_ouvidoria, Request $request)
    {
		Ouvidoria::find($id_ouvidoria)->delete();
		$input        = $request->all();
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$ouvidorias  = Ouvidoria::where('id',$id_ouvidoria)->get();
		$validator = 'Ouvidoria excluída com sucesso!';
		return view('transparencia/ouvidoria/ouvidoria_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','ouvidorias'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
    }
}