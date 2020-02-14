<?php namespace App\Http\Controllers;

use App;
use Auth;  
use Session; 
use App\Models\Envase;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Debugbar;
use Config;
use Illuminate\Http\Request;

class EnvaseController extends Controller {

	public function crearEnvase(){

		$data = ['title' 			=> 'Envases'
				,'subtitle'			=> ''];

		return view('envases.crearEnvase',$data);
	
	}

	public function guardarEnvase(Request $request){
		$data = ['title' 			=> 'Envases'
				,'subtitle'			=> ''];

        $envase = new Envase();
        $envase->nombreEnvase=strtoupper($request->nombre);
        $envase->estado=1;
        $envase->aplicaPara=(int)$request->aplica[0];
        $envase->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
        $envase->save();
    
        Session::flash('message','Envase creado con éxito');
        return view('envases.crearEnvase',$data);

	}


	public function index(){
		$data = ['title' 			=> 'Catálogo de Envases',
				'subtitle'			=> ''];

		$envases=Envase::all();
		$data['envases']=$envases;
		return view('envases.indexEnvases',$data);

	}

	public function editarEnvase($id){
		$data = ['title' 			=> 'Catálogo de Envases'
				,'subtitle'			=> ''];

		$envase=Envase::find($id);
		$data['envase']=$envase;
		return view('envases.editarEnvase',$data);

	}

	public function actualizarenvase(Request $request){
		$data = ['title' 			=> 'Catálogo de Envases'
				,'subtitle'			=> ''];
		//$envase=Envase::getEnvase((int)$request->id);
		
		$envase=Envase::find($request->id);
		$envase->nombreEnvase=strtoupper($request->nombre);
		$envase->aplicaPara=(int)$request->aplica[0];
		$envase->estado=$request->estado;
		$envase->idUsuarioModificacion=Auth::User()->idUsuario.'@'.$request->ip();
		$envase->save();

		$envases=Envase::all();
		$data['envases']=$envases;

		Session::flash('message','Envase actualizado con éxito');
		return view('envases.indexEnvases',$data);

	}
}