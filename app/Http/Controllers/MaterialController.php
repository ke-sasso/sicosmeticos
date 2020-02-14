<?php namespace App\Http\Controllers;

use App;
use Auth;  
use Session; 
use App\Models\Material;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Debugbar;
use Config;
use Illuminate\Http\Request;

class MaterialController extends Controller {

	public function crearMaterial(){

		$data = ['title' 			=> 'Crear Material'
				,'subtitle'			=> ''];

		return view('materiales.crearMaterial',$data);
	
	}

	public function guardarMaterial(Request $request){
		$data = ['title' 			=> 'Catálogo de Material'
				,'subtitle'			=> ''];

		$material=new Material();
		
		$material->material=strtoupper($request->nombre);
		$material->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
		$material->save();

		Session::flash('message','Material creado con éxito');
		return view('materiales.crearMaterial',$data);
	}
	

	public function index(){
		$data = ['title' 			=> 'Ver Materiales'
				,'subtitle'			=> ''];

		$materiales=Material::all();
		$data['materiales']=$materiales;

		return view('materiales.indexMateriales',$data);
	}


	public function editarMaterial($id){
		$data = ['title' 			=> 'Material'
				,'subtitle'			=> ''];

		$material=Material::find($id);
		$data['material']=$material;
		return view ('materiales.editarMaterial',$data);
	}

	public function actualizarMaterial(Request $request){

		$data = ['title' 			=> 'Ver Materiales'
				,'subtitle'			=> ''];

		$material=Material::find($request->id);
		$material->material=strtoupper($request->nombre);
		$material->estado=$request->estado;
		$material->idUsuarioModificacion=Auth::User()->idUsuario.'@'.$request->ip();
		$material->save();

		$materiales=Material::all();
		$data['materiales']=$materiales;
		Session::flash('message','Material actualizado con éxito');
		return view('materiales.indexMateriales',$data);

	}


}