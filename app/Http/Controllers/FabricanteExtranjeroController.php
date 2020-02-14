<?php
namespace App\Http\Controllers;
use Auth;
use Session;
use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\FabricanteExtranjero;
use App\Models\FabExtUnidadReg;

class FabricanteExtranjeroController extends Controller
{
	
	public function indexFabricantesExtranjeros(){
        $data=['title'=>'Catálogo de Fabricantes Extranjeros',
          'subtitle'=>''];  
        return view ('fabricanteExtranjero.indexFabricanteExt',$data);
    }

    public function getFabricantesExt(){
        $data=['title'=>'Catálogo de Fabricantes Extranjeros',
        'subtitle'=>''];

        $fabExt=FabricanteExtranjero::getFabricantesExtra();
        return Datatables::of($fabExt)
            ->addColumn('opciones',function($dt){
              return '<a href="'.route('editarFabExt',['idFabricanteExtranjero'=>$dt->idFabricanteExtranjero]).'" class="btn btn-info"><b>EDITAR</b></a>';
            })->rawColumns(['opciones'])
            ->make(true);
    }

    public function getCrearFabExt(){
        $data=['title'=>'Catálogo de Fabricantes Extranjeros',
          'subtitle'=>''];  
        $paises=FabricanteExtranjero::getPaises();
        $data['paises']=$paises;
        return view ('fabricanteExtranjero.crearFabExt',$data);
    }

    public function saveFabExt(Request $request){
        $data=['title'=>'Catálogo de Fabricantes Extranjeros',
          'subtitle'=>''];  

        $total=FabricanteExtranjero::all()->count()+1;      	
      	$cad=str_pad($total, 4, '0', STR_PAD_LEFT);
      	$id='FE'.$cad;

        $fabricante=new FabricanteExtranjero();
        $fabricante->idFabricanteExtranjero=$id;
        $fabricante->nombreFabricante=$request->nombre;
        $fabricante->direccion=$request->direccion;
        $fabricante->telefonos=$request->telefono;
        $fabricante->correoElectronico=$request->correoElectronico;
        $fabricante->codigoIdPais=$request->pais;
        $fabricante->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
        $fabricante->save();

        $fabUnidad=new FabExtUnidadReg();
        $fabUnidad->idFabricanteExtranjero=$fabricante->idFabricanteExtranjero;
        $fabUnidad->idUnidad=7;
        $fabUnidad->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
        $fabUnidad->save();

        Session::flash('message','Se ha creado el fabricante');
        return view ('fabricanteExtranjero.indexFabricanteExt',$data);
    }

    public function editarFabExt($id){
      $data=['title'=>'Catálogo de Fabricantes Extranjeros',
          'subtitle'=>'']; 
      $fabExt=FabricanteExtranjero::find($id);
      $data['fabExt']=$fabExt;
      $paises=FabricanteExtranjero::getPaises();
      $data['paises']=$paises;

      
      //dd($total);
      return view ('fabricanteExtranjero.editarFabExt',$data);

    }

    public function actualizarFabExt(Request $request){
        $data=['title'=>'Catálogo de Fabricantes Extranjeros',
        'subtitle'=>''];

        $fabricante=FabricanteExtranjero::find($request->idFabricanteExtranjero);
        $fabricante->nombreFabricante=$request->nombre;
        $fabricante->direccion=$request->direccion;
        $fabricante->telefonos=$request->telefono;
        $fabricante->correoElectronico=$request->correoElectronico;
        $fabricante->codigoIdPais=$request->pais;
        $fabricante->estado=$request->estado;
        $fabricante->idUsuarioModifica=Auth::user()->idUsuario.'@'.$request->ip();
        $fabricante->save();

        Session::flash('message','Se ha modificado el fabricante');
        return view ('fabricanteExtranjero.indexFabricanteExt',$data);    
    }

    public function getFabricantesEstado(request $request){
    	$estado=$request->estado;
    	$fabricantes=FabricanteExtranjero::getFabricantesEstado($estado);
    	if($estado=='A'){
    		return Datatables::of($fabricantes)
            ->addColumn('opciones',function($dt){
              return '<a href="'.route('editarFabExt',['idFabricanteExtranjero'=>$dt->idFabricanteExtranjero]).'" class="btn btn-info"><b>EDITAR</b></a>';
            })->rawColumns(['opciones'])
            ->make(true);
    	} else {
    		return Datatables::of($fabricantes)
            ->addColumn('opciones',function($dt){
              return '<a href="'.route('editarFabExt',['idFabricanteExtranjero'=>$dt->idFabricanteExtranjero]).'" class="btn btn-info"><b>EDITAR</b></a>';
            })->rawColumns(['opciones'])
            ->make(true);
    	}
    }

}