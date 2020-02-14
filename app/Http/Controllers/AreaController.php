<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use Auth;
use Session;

class AreaController extends Controller
{
    public function crearArea(){

    	$data=['title'=>'Areas de Aplicación',
    			'subtitle'=> ''];

        return view('areas.crearArea',$data);  
    }	

    public function guardarArea(Request $request){
		$data=['title'=>'Areas de Aplicación',
    			'subtitle'=> ''];

    	$area= new Area();
    	$area->nombreArea=strtoupper($request->nombre);
    	$area->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
    	$area->save();

    	Session::flash('message','Área de Aplicación creado con éxito');
    	return view ('areas.crearArea',$data);

    }

    public function editarArea($id){
		$data=['title'=>'Areas de Aplicación',
		    			'subtitle'=> ''];

		$area=Area::find($id);
		$data['area']=$area;
		return view ('areas.editarArea',$data);

    }

    public function index(){
    	$data=['title'=>'Areas de Aplicación',
		    			'subtitle'=> ''];
		$areas=Area::all();
		$data['areas']=$areas;
		return view ('areas.indexAreas',$data);

    }

    public function actualizarArea(Request $request){
    	$data=['title'=>'Areas de Aplicación',
		    			'subtitle'=> ''];

		$area=Area::find($request->id);
		$area->nombreArea=strtoupper($request->nombre);
		$area->estado=strtoupper($request->estado);
		$area->idUsuarioModificacion=Auth::User()->idUsuario.'@'.$request->ip();
		$area->save();

		$areas=Area::all();
		$data['areas']=$areas;
		Session::flash('message','Área de aplicación actualizada');
		return view('areas.indexAreas',$data);

    }

    
}
