<?php namespace App\Http\Controllers;

use App;
use Auth;  
use Session; 
use App\User;
use App\UserOptions;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Debugbar;
use Config;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CustomAuthController extends Controller {

	public function getLogin(){
		$data = ['title' 			=> 'Inicio'
				,'subtitle'			=> ''];
		//Verificamos si ya esta logueado de lo contrario se redirige al login
		if(Auth::check()){
			return view('inicio.index',$data);
		}else{

			Debugbar::disable();
			
			return view('users.login'); 	
		}
    }  
  	
    public function postLogin(Request $request) {  
        //Obtenemos el usuario que se loguea si es que existe
        $response = ['status' => 409, 'message' => 'Credenciales de Usuario Incorrectas', "redirect" => ''];
    	if(!$request->txtUsuario || $request->txtUsuario == '')
    	{
    		
    		$response = ['status' => 409, 'message' => 'Debe Ingresar su Usuario', "redirect" => ''];
    	}
    	elseif (!$request->txtPwd || $request->txtPwd == '') {
    		
    		$response = ['status' => 409, 'message' => 'Debe Ingresar su Constraseña', "redirect" => ''];
    	}
    	else
    	{
		    $user = User::where('idUsuario', $request->txtUsuario)
    		->where('password', md5($request->txtPwd))
    		->where('activo', 'A')->first();
	        if($user){
                $hasPermission = $user->hasAnyPermission(['sistema.ingreso.coshig']);
                $isAdmin = $user->hasAnyRole(['admin_it']);
                if(!$hasPermission && !$isAdmin)
                    $response = ['status' => 409, 'message' => 'No posee los privilegios para el ingreso al sistema', "redirect" => ''];
                else
                {
                    Auth::login($user);
                    $response = ['status' => 200, 'message' => 'ok', "redirect" => route('doInicio')];
                }
			}
    	}

    	return response()->json($response);

    }
    public function impersonateUser($user = null)
    {
        if ($user)
        {
            $impersonate = User::where('idUsuario',$user)->first();
            $impersonate->idUsuario = 'impersonated';
            Auth::login($impersonate);
            $user = Auth::user();
            $user->idUsuario = 'Personificado';
            return redirect(route('doInicio'));
        }
    }
    public function getLogout()
	{
		//Deslogueamos al usuario
		Auth::logout();
		//Eliminamos de session la variable
		Session::forget('PERMISOS');
        Debugbar::disable();
		//Redireccion a ruta inicial
        return view('users.login');
	}
	
}
