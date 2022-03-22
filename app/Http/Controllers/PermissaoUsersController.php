<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PermissaoUsers;
use Validator;
use Auth;

class PermissaoUsersController extends Controller
{
    public static function Permissao($id)
	{
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
		for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
        return $validacao;
    }
}
