<?php

namespace App\Http\Controllers;
use App\Models\Area;
use App\Models\ClasificacionCos;
use App\Models\ClasificacionHig;
use App\Models\FormasCosmeticas;
use App\Models\GruposFormas;
use Auth;
use Session;
use Illuminate\Http\Request;
use Redirect;
use Yajra\Datatables\Datatables;
use DB;

class ClasificacionController extends Controller
{
    public function crearc(){
    	$data=['title'=>'Catálogo de Clasificación de Cosméticos',
    			'subtitle'=>''];
        //Buscar todas las areas para combobox
    	$areas=Area::all();
        $formas=FormasCosmeticas::all();
    	$data['areas']=$areas;
        $data['formas']=$formas;

    	return view('clasificacion.crear',$data);
    }

    public function guardar(Request $request){
  // dd($request->formas);
    	$data=['title'=>'Catálogo de Clasificación de Cosméticos',
    			'subtitle'=>''];
               // dd($request);
        //Se crea una una clasificacion
      DB::connection('sqlsrv')->beginTransaction();
        try{
            	$clasificacion= new ClasificacionCos;
            	$clasificacion->nombreClasificacion=strtoupper($request->nombre);
            	$clasificacion->idArea=$request->area; 
                $clasificacion->poseeTono=(int)$request->tono;
                $clasificacion->poseeFragancia=(int)$request->fragancia;
            	$clasificacion->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
            	$clasificacion->save();

                $clas=ClasificacionCos::all()->last(); 
                for($i=0;$i<count($request->formas);$i++){ 
                $grupoForma= new GruposFormas();
                $grupoForma->idClasificacion=$clas->idClasificacion;
                $grupoForma->idForma=$request->formas[$i];
                $grupoForma->save();
                }
                //Buscar todas las areas para combobox
            	$areas=Area::all();
                $formas=FormasCosmeticas::all();
            	$data['areas']=$areas;
                $data['formas']=$formas;
         
            	Session::flash('message','Se ha creado Clasificación');
          }  catch(Exception $e){
            DB::connection('sqlsrv')->rollback();
            throw $e;
            Session::flash($e->getMessage());
            return back();
        }  
        DB::connection('sqlsrv')->commit();

    	return view('clasificacion.crear',$data);
    	}

    
    public function index(){
        $data=['title'=>'Catálogo de Clasificación de Cosméticos',
                'subtitle'=>''];
        // Buscar todas las areas para combobox 
        $areas=Area::all();
        $data['areas']=$areas;
        return view('clasificacion.index',$data);

    }

    public function editar($id){
        $data=['title'=>'Catálogo de Clasificación de Cosméticos',
                'subtitle'=>''];
        // Busco la clasificacion a editar
        $clasificacion=ClasificacionCos::find($id);
        //Paso todas las areas para combobox
        $areas=Area::all();
        $data['clas']=$clasificacion;
        $data['areas']=$areas;

        return view ('clasificacion.editar',$data);

    }

  public function actualizar(Request $request){
    //   dd($request);
        $data=['title'=>'Catálogo de Clasificación de Cosméticos',
                'subtitle'=>''];
        //Busco la clasificacion a actualizar    
        $clasificacion=ClasificacionCos::find($request->id);
        $clasificacion->nombreClasificacion=strtoupper($request->nombre);
        $clasificacion->idArea=$request->area;
        $clasificacion->poseeFragancia=(int)$request->fragancia;
        $clasificacion->poseeTono=(int)$request->tono;
    
        $clasificacion->estado=$request->estado;
        $clasificacion->idUsuarioModificacion=Auth::User()->idUsuario.'@'.$request->ip();
        $clasificacion->save();

        $areas=Area::all();
        $data['areas']=$areas;
        Session::flash('message','Clasifiación actualizada con éxito');
        return view('clasificacion.index',$data);      
    }

    public function consultarClass(Request $request){ //consulta si la clasificacion para cosmetico tiene tono/fragancia
        //dd($request->id);
       
        $clas=ClasificacionCos::consultar($request->id);
      
         return $clas;
    }

    public function consultarClassHig(Request $request){ //consulta si la clasificacion para higienicos tiene tono/fragancia
        return $clas=ClasificacionHig::consultar($request->id);


    }
    public function getDataClass(Request $request){
 
     //   data de datatable
        $clasificacion=ClasificacionCos::getClasificaciones();
        return Datatables::of($clasificacion)
                ->addColumn('editar',function($dt){
                                    return '<a href="'.route('editar',['idClasificacion' =>$dt->idClasificacion]).'"class="btn btn-info"><b>Editar</b></a>';
                            })
               ->filter(function ($query) use ($request) { 
                     if ($request->has('idArea')) {
                         $query->where('idArea','=',$request->get('idArea'));
                        }
                    })->rawColumns(['editar'])
               /* ->filter(function ($query) use ($request){
                    if($request->has('nombreClasificacion')) {
                         $query->where('nombreClasificacion','=',$request->get('nombreClasificacion'));
                        }
                   })
                */

                ->make(true);
        //$areas=Area::all();
      //  $data['areas']=$areas;
      //  $data['class']=$clasificacion;
       // return view('clasificacion.index',$data);  
    }

    public function getClassByArea(Request $request){
      
        return $clas=ClasificacionCos::getClassByArea($request->id);
    }
}
