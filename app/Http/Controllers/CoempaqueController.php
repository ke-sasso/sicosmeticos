<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Session;
use Redirect;
use Yajra\Datatables\Datatables;
use DB;
use Crypt;
use Validator;
use App\Models\SolicitudesPresentaciones;
use App\Models\Solicitud;
use App\Models\Coempaques;
use App\Models\DetalleCoempaques;
use App\Models\Cosmeticos\PresentacionesCosmeticos;
use App\Models\Higienicos\PresentacionesHigienicos;
use Illuminate\Database\Eloquent\Collection;


class CoempaqueController extends Controller
{
    public function getCoempaquesSol(Request $request){
    	//dd($request);
    	$tipo=$request->tipo;
    	$presentaciones=SolicitudesPresentaciones::getPresentacionesSol($request->idSol);
    	if($tipo==1){
    	return Datatables::of($presentaciones)
            ->addColumn('opciones',function($dt){
              if($dt->idCoempaque==null||$dt->idCoempaque==''){
              		return '<a class="btn btn-xs btn-danger borrarPres"><i class="fa fa-times" aria-hidden="true"></i></a> <button type="button" class="btn btn-xs btn-info coempaque"  data-toggle="modal" data-target="#coemp" name="agregarcoempaque" value="'.$dt->idPresentacion.'">Agregar Coempaque</button>';
           		} else {
           			return '<a class="btn btn-xs btn-danger borrarPres"><i class="fa fa-times" aria-hidden="true"></i></a>';
           		}
           })->rawColumns(['opciones'])
            ->make(true);
        } else {
        	return Datatables::of($presentaciones)
            ->addColumn('opciones',function($dt){
         
              return '<input type="checkbox" class="checkAll" name="solChek[]" value="'.$dt->idPresentacion.'">';

           
           })->rawColumns(['opciones'])
            ->make(true);
        }
    }

    public function getCoempaquesProducto(Request $request){
    	$solicitud=Solicitud::find($request->idSol);
    	if($solicitud->tipoSolicitud==2||$solicitud->tipoSolicitud==3){
    		$presentaciones=PresentacionesCosmeticos::getPresentacionesCosmeticos();
    	} else {
    		$presentaciones=PresentacionesHigienicos::getPresentacionesHigienicos();
    	}
    	
    	return Datatables::of($presentaciones)
            ->addColumn('opciones',function($dt){
               return '<input type="checkbox" class="checkAll" name="solChek[]" value="'.$dt->idPresentacion.'">';
            })->rawColumns(['opciones'])
            ->make(true);
    }

    public function crearCoempaqueCos(Request $request){
    	 $messages = [
        
          'ids.required' => 'Debe seleccionar al menos una presentación para adicionar al Coempaque.',
          ];   

          $v = Validator::make($request->all(),[
          'ids'   =>  'required'
          ], $messages);

          $v->setAttributeNames([
        
          'ids'   =>  'Presentaciones'
          
          ]);

           if ($v->fails())
            {
              $msg = "<ul class='text-warning'>";
              foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
              }
              $msg .= "</ul>";
                return response()->json(['status' => 404,'message' => 'Debe completar:', 'data' => ['message'=>$msg]]);
            } 
    	
    	DB::connection('sqlsrv')->beginTransaction();
        try{
        	  $coempaque = new Coempaques();
            $coempaque->nombreCoempaque=$request->nombreCoempaque;
        	  $coempaque->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
        	  $coempaque->save();
            /* 
             Se obtiene el ultimo ID insertado debido a un problema de Laravel
             obteniendo el ID insertado
            */
            $coempaque->idCoempaque = Coempaques::getLastID();

        	  for($i=0; $i<count($request->ids);$i++)
            {
	        	  $detalleCoempaque= new DetalleCoempaques();
	        	  $detalleCoempaque->idCoempaque=$coempaque->idCoempaque;
	        	  $detalleCoempaque->idPresentacion=$request->ids[$i];
	        	  $detalleCoempaque->idUsuarioCrea=Auth::User()->idUsuario.'@'.$request->ip();
	        	  $detalleCoempaque->save();
	          }
	          
            $solicitud= Solicitud::find($request->idSolicitud);
            $solicitud->estado=9;
            $solicitud->idUsuarioModificacion=Auth::User()->idUsuario.'@'.$request->ip();
            $solicitud->save();

            

            $detalle=DetalleCoempaques::getDetCoempaque($coempaque->idCoempaque);
            //$detalle=DetalleCoempaques::getDetCoempaque(40);

            $pres=null;
            for ($i=0; $i < count($detalle); $i++) { 
              $pres=$pres.$detalle[$i]->textoPresentacion.'('.$detalle[$i]->idCosmetico.')';
              if($i==count($detalle)-1)
                $pres=$pres.'.';
              else
                $pres=$pres.',';
            }
            $presCoem=DetalleCoempaques::getIdPres($solicitud->idProducto);
            
           
            $idpres = array();
            for ($i=0; $i < count($presCoem); $i++) { 
              $idpres[$i]=$presCoem[$i]->idPresentacion;
              
            }
            $det=DetalleCoempaques::getdetalle($idpres);
            
            $total=count($idpres)+count($det);
            
            
            DB::connection('sqlsrv')->commit();
	          return response()->json(['status' => 200,'message' => 'Se ingreso Coempaque correctamente!' ,'data' => ['detalle'=>$detalle,'nomPres'=>$pres,'total'=>$total]]);
          
        } catch(Exception $e){
           DB::connection('sqlsrv')->rollback();
            throw $e;
          //  return $e->getMessage();
            return response()->json(['status' => 400,'message' => 'Error: no pudimos guardar su coempaque!', 'data' => []]);
          /*  throw $e;*/
        }
    }

    public function deleteCoempaque(Request $request){

        DB::connection('sqlsrv')->beginTransaction();
        try{
          $det=DetalleCoempaques::where('idCoempaque',$request->idcoem)->delete();
          $coem=Coempaques::where('idCoempaque',$request->idcoem)->delete();
          //dd($det,$coem);
          if($det!=null && $coem!=null){
            DB::connection('sqlsrv')->commit();
            return response()->json(['status' => 200,'message' => 'Se elimino presentación correctamente!', 'data' => []]);
          } else {
            return response()->json(['status' => 400,'message' => 'Error: no pudimos eliminar su presentación!', 'data' => []]);
          }
        } catch(Exception $e){
           DB::connection('sqlsrv')->rollback();
            throw $e;
          //  return $e->getMessage();
            return response()->json(['status' => 404,'message' => 'Error: consulte con informatica!', 'data' => []]);
          /*  throw $e;*/
        }
      }

}
