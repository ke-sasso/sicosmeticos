<?php namespace App\Http\Controllers;

use App;
use Auth;  
use Session; 
use App\Models\Marca;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Debugbar;
use Config;
use Illuminate\Http\Request;

class MarcaController extends Controller {

	public function crearMarca(){
		$data = ['title' 			=> 'Crear Marca'
				,'subtitle'			=> ''];

		return view('marcas.crearMarca',$data);
	
	}

	public function guardarMarca(Request $request){

		$data = ['title' 			=> 'Crear Marca'
				,'subtitle'			=> ''];

		$marca= new Marca();
		$marca->nombreMarca=strtoupper($request->nombre);
		$marca->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
		$marca->save();
 		
 		Session::flash('message', 'Marca creada exitosamente');
		return view('marcas.crearMarca',$data);
	}


	public function index(){
		$data = ['title' 			=> 'Catálogo de Marcas'
				,'subtitle'			=> ''];

		$marcas=Marca::all();
		$data['marcas']=$marcas;
		return view('marcas.indexMarcas',$data);
	}

	public function editarMarca($id){

		$data = ['title' 			=> 'Catálogo de Marcas'
				,'subtitle'			=> ''];

		$marca=Marca::find($id);
		$data['marca']=$marca;
		return view('marcas.editarMarca',$data);
	}

	public function actualizarMarca(Request $request){
		$data = ['title' 			=> 'Catálogo de Marcas'
				,'subtitle'			=> ''];

		$marca=Marca::find($request->id);
		$marca->nombreMarca=strtoupper($request->nombre);
		$marca->estado=$request->estado;
		$marca->idUsuarioModificacion=Auth::User()->idUsuario.'@'.$request->ip();
		$marca->save();

		$marcas=Marca::All();
		$data['marcas']=$marcas;
		Session::flash('message', 'Marca actualizada exitosamente');
		return view('marcas.indexMarcas',$data);

	}
}
