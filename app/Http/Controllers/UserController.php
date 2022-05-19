<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Model\User;
use Auth;
use App\Model\AlterarSenha;
use App\Model\Unidade;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Validator;
use Str;

class UserController extends Controller
{
	public function __construct(Unidade $unidade)
	{
		$this->unidade = $unidade;
	}
	
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
	
	public function telaLogin()
	{
		return view('auth.login');
	}

	public function telaRegistro()
	{
		return view('auth.register');
	}
	
	public function telaEmail()
	{
		return view('auth.passwords.email');
	}
	
	public function telaReset()
	{
		$token = '';
		return view('auth.passwords.reset', compact('token'));
	}
	
	public function cadastroUsuarios(Request $request)
	{
		if(Auth::user()->funcao == 0) {
			$usuarios = User::all();
			$unidades = $this->unidade->all();
			return view('transparencia/usuarios/usuarios_cadastro', compact('usuarios','unidades'));
		} else {
			$validator = 'Você não tem Permissão!';
			$unidades = $this->unidade->all();
			$unidadesMenu = $unidades;
			$unidade = 2;
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function cadastroNovoUsuario(Request $request)
	{
		if(Auth::user()->funcao == 0) {
			return view('transparencia/usuarios/usuarios_novo');
		} else {
			$validator = 'Você não tem Permissão!';
			$unidades = $this->unidade->all();
			$unidadesMenu = $unidades;
			$unidade = 2;
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}

	public function cadastroAlterarUsuario($id, Request $request)
	{
		if(Auth::user()->funcao == 0) {
			$usuarios = User::where('id',$id)->get();
			return view('transparencia/usuarios/usuarios_alterar', compact('usuarios'));
		} else {
			$validator = 'Você não tem Permissão!';
			$unidades = $this->unidade->all();
			$unidadesMenu = $unidades;
			$unidade = 2;
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}

	public function cadastroExcluirUsuario($id, Request $request)
	{
		if(Auth::user()->funcao == 0) {
			$usuarios = User::where('id',$id)->get();
			return view('transparencia/usuarios/usuarios_excluir', compact('usuarios'));
		} else {
			$validator = 'Você não tem Permissão!';
			$unidades = $this->unidade->all();
			$unidadesMenu = $unidades;
			$unidade = 2;
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function Login(Request $request)
	{
		$input = $request->all(); 		
		$validator = Validator::make($request->all(), [
			'email'    => 'required|email',
            'password' => 'required'
		]);		
		if ($validator->fails()) {
			return view('auth.login')
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 
		} else {
			$email = $input['email'];
			$senha = $input['password'];		
			$user = User::where('email', $email)->get();
			$qtd = sizeof($user); 			
			if ( empty($qtd) ) {
				$validator = 'Login Inválido!';
				return view('auth.login')
					->withErrors($validator)
					->withInput(session()->flashInput($request->input())); 	
			} else {
				$unidades = $this->unidade->all();
				Auth::login($user);
				return view('home', compact('unidades','user'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input())); 						
			}
		}
	}
	
	public function resetarSenha(Request $request)
	{
		$input = $request->all();		
		$token = "";
		$validator = Validator::make($request->all(), [
			'email'    => 'required|email',
            'password' => 'required|same:password_confirmation',
			'token_'	   => 'required',
			'password_confirmation' => 'required'
    	]);		
		if ($validator->fails()) {
			return view('auth.passwords/reset', compact('token'))
					  ->withErrors($validator)
                      ->withInput(session()->flashInput($request->input()));						
		} else {
			if(!empty($input['password'])){ 
				$input['password'] = Hash::make($input['password']);
			}else{
				$input = array_except($input,array('password'));    
			}
			$email = $input['email'];
			$token_ = $input['token_'];
			$user = User::where('email',$email)->get();
			$qtd = sizeof($user);
			if($qtd > 0){
				$alt_senha = AlterarSenha::where('token',$token_)->where('user_id',$user[0]->id)->get();
				$qtdAlt = sizeof($alt_senha);
				if($qtdAlt > 0){
					$user = User::find($user[0]->id);
					$user->update($input);
					$validator = 'Senha alterada com sucesso!';
					$unidades  = $this->unidade->all();
					return view('auth.login', compact('unidades','user'))						
						  ->withErrors($validator)
						  ->withInput(session()->flashInput($request->input()));								
				} else {
					$validator = 'Token Inválido!';
					return view('auth.passwords.reset',compact('token'))						
						  ->withErrors($validator)
						  ->withInput(session()->flashInput($request->input()));								
				}
			} else {
				$validator = 'Usuário não existe!';
				$unidades  = Unidade::all();
				$token = '';
				return view('auth.passwords.reset', compact('unidades','user','token'))
					  ->withErrors($validator)
                      ->withInput(session()->flashInput($request->input()));								
			}
		}
	}
	
    public function storeUsuario(Request $request)
    {
		$input = $request->all(); 
		$validator = Validator::make($request->all(), [
			'name'     		   => 'required',
            'email'    		   => 'required|email|unique:users,email',
            'password' 		   => 'required|same:password_confirmation',
			'password_confirmation' => 'required',
			'funcao' 		   => 'required'
    	]);			 
		if ($validator->fails()) {
			return view('transparencia/usuarios/usuarios_novo') 
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$input['password'] = Hash::make($input['password']);
			$user = User::create($input);
			$validator = "Usuário cadastrado com sucesso!!";	
			$usuarios = User::all();
			$unidades = Unidade::all();			
			return view('transparencia/usuarios/usuarios_cadastro', compact('unidades','usuarios'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole'));
    }

    public function updateUsuario(Request $request, $id)
    {
        $this->validate($request, [
            'name' 	 => 'required',
            'email'  => 'required|email',
			'funcao' => 'required'
        ]);
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }
        $user = User::find($id);
        $user->update($input);
        $validator = "Usuário alterado com sucesso!!";	
		$usuarios = User::all();
		$unidades = Unidade::all();		
        return view('transparencia/usuarios/usuarios_cadastro', compact('unidades','usuarios'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
    }

	public function destroyUsuario($id, Request $request)
    {
        User::find($id)->delete();
        $validator = "Usuário excluído com sucesso!!";	
		$usuarios = User::all();
		$unidades = Unidade::all();		
        return view('transparencia/usuarios/usuarios_cadastro', compact('unidades','usuarios'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
    }
    
    public function pesquisarUsuario(Request $request)
	{
		$input = $request->all(); 
		if(empty($input['pesq'])) { $input['pesq'] = ""; }
		if(empty($input['pesq2'])) { $input['pesq2'] = ""; }
		$pesq  = $input['pesq'];
		$pesq2 = $input['pesq2'];
		$unidades = Unidade::all();	
		if($pesq == 0){
			if($pesq2 != ""){
				$usuarios = User::where('name','like','%'.$pesq2.'%')->get();
			} else {
				$usuarios = User::all();
			}
		} else if($pesq == 1){
			if($pesq2 != ""){
				$usuarios = User::where('email','like','%'.$pesq2.'%')->get();
			} else {
				$usuarios = User::all();
			}
		} 
		return view('transparencia/usuarios/usuarios_cadastro', compact('usuarios','unidades','pesq','pesq2'));
	}
    
	public function emailReset(Request $request)
	{
		$input = $request->all(); 
		$email = $input['email'];
		$usuarios = User::where('email',$email)->get();
		$qtd = sizeof($usuarios);
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
		]);	
		if($validator->fails()){
			return view('auth.passwords.email', compact('email','usuarios'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
		} else {
			if($qtd > 0){
				$input['token']   = Str::random('40');
				$input['user_id'] = $usuarios[0]->id;
				$alt_senha = AlterarSenha::where('token',$input['token'])->get();
				$qtdAlt = sizeof($alt_senha);
				if($qtdAlt > 0){
					$validator = 'ESTE TOKEN JÁ FOI CADASTRADO';
					return view('auth.passwords.email', compact('email','usuarios'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$alt = AlterarSenha::where('user_id', $input['user_id'])->get();
					$qtdUser = sizeof($alt);
					if($qtdUser > 0){
						DB::statement('DELETE FROM alterar_senha WHERE user_id = '.$input['user_id']);
					}
					$alt_senha = AlterarSenha::create($input);
					$token  = DB::table('alterar_senha')->where('user_id',$input['user_id'])->max('token');
					$email2 = 'portal@hcpgestao.org.br';
					Mail::send('email.emailReset', ['token' => $token], function($m) use ($email,$email2,$token) {
						$m->from('ilton.albuquerque@hcpgestao.org.br', 'PORTAL DA TRANSPARÊNCIA');
						$m->subject('Solicitação de Alteração de Senha');
						$m->to($email);
						$m->cc($email2);
					});		
					$validator = 'ABRA SUA CAIXA DE E-MAIL PARA VALIDAR SUA SENHA NOVA';
					return view('auth.passwords.email', compact('email','usuarios'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			}else{ 
				$validator = 'Este E-mail não foi cadastrado no Portal da Transparência.';
				return view('auth.passwords.email', compact('email','usuarios'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}
}