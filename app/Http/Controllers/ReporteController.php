<?php
namespace App\Http\Controllers;
use Auth;
use Session;
use DB;
use Illuminate\Http\Request;
//use Yajra\Datatables\Datatables;
use App\Models\Solicitud;
use App\Models\Fabricantes;
use App\Models\FabExtUnidadReg;
use App\Models\VwReporteSolicitudPortal;
use App\Models\VwReporteTrazabilidad;
use App\Models\VwFabricanteExtranjero;
use App\Models\Cosmetico;
use App\Models\Higienico;
use App\Models\Dictamen;
use Illuminate\Database\Eloquent\Collection;
use Crypt;
use Validator;
use Response;
use Yajra\Datatables\Datatables;
use Log;
use File;
use Config;
//use Session;
//use DB;
class ReporteController extends Controller
{
	

    public function reportePortal(){
      $data=['title'=>'Reporte Solicitudes Portal en Linea',
          'subtitle'=>''];
      return view ('reportes.reportePortal',$data);
    }

    public function generarReporte(request $request){
      $data=['title'=>'Reporte Solicitudes Portal en Linea',
          'subtitle'=>''];
          //dd(Solicitud::getSolicitudesPortal());
          
      return view ('reportes.reportePortal',$data);
    }

    public function getSolicitudesPortal(Request $request){

        //if($request->has('idTitular'))
           // dd($request);
        //$solicitudes=collect(Solicitud::getSolicitudesPortal());
        $solicitudes=VwReporteSolicitudPortal::getSolicitudesPortal($request);
        
        return Datatables::of($solicitudes)           
            ->make(true);
    }
/*************************************************************************************************************/
//REPORTE DE TRAZABILIDAD DE SOLICITUDES

public function reporteTrazabilidad(){
      $data=['title'=>'Reporte de Trazabilidad de Solicitudes',
          'subtitle'=>''];
      $data['estadoSol']=Solicitud::getEstadosSol();
      return view ('reportes.reporteTrazabilidadSolicitudes',$data);
    }

    public function generarReporteTrazabilidad(request $request){
      $data=['title'=>'Reporte Solicitudes Portal en Linea',
          'subtitle'=>''];
          //dd(Solicitud::getSolicitudesPortal());
          
      return view ('reportes.reportePortal',$data);
    }

    public function getSolicitudesTrazabilidad(Request $request){
        //dd($request);
        //if($request->has('numPresentacion'))
          //  dd($request->numPresentacion);
        //$solicitudes=collect(Solicitud::getSolicitudesPortal());
        $solicitudes=VwReporteTrazabilidad::getTrazabilidadSolicitudes($request);
        //dd($solicitudes);

        return Datatables::of($solicitudes)
            ->addColumn('idFabricante',function($dt){
                 $fabricantes=Fabricantes::where('idSolicitud',$dt->numeroSolicitud)->get();
               //dd($fabricantes[0]);
                $idFab=null;
                for ($i=0; $i < count($fabricantes); $i++) { 
                    if($fabricantes[$i]->tipoFabricante==1){
                        $fab=Solicitud::getNomFabricanteNacional($fabricantes[$i]->idFabricante);
                        //dd($fab);
                        $idFab=$idFab.$fab[0]->ID_ESTABLECIMIENTO.'-';
                         
                    } else {
                        $fab=VwFabricanteExtranjero::find($fabricantes[$i]->idFabricante);
                        if($fab!=null)
                            $idFab=$idFab.$fab->idFabricanteExtranjero.'-';
                       // dd($nomFab);
                        
                    }
                }
              return $idFab;

            })
            ->addColumn('nombreFabricante',function($dt){
                $fabricantes=Fabricantes::where('idSolicitud',$dt->numeroSolicitud)->get();
               //dd($fabricantes[0]);
                $nomFab=null;
                for ($i=0; $i < count($fabricantes); $i++) { 
                    if($fabricantes[$i]->tipoFabricante==1){
                        $fab=Solicitud::getNomFabricanteNacional($fabricantes[$i]->idFabricante);
                        //dd($fab);
                        $nomFab=$nomFab.$fab[0]->nombreFabricante.'-';
                         
                    } else {
                        $fab=VwFabricanteExtranjero::find($fabricantes[$i]->idFabricante);
                        if($fab!=null)
                            $nomFab=$nomFab.$fab->nombreFabricante.'-';
                       // dd($nomFab);
                        
                    }
                }
              return $nomFab;
               
            })            
            ->addColumn('fechaProceso',function($dt){
                $fecha='SIN ASIGNAR';
                $dic=Dictamen::where('idSolicitud',$dt->numeroSolicitud)->orderBy('fechaCreacion','desc')->first();
                if($dic!=null){
                    $fecha=$dic->fechaCreacion;                   
               } 

                return $fecha;
            })
            ->addColumn('tecnico',function($dt){
                $tec='SIN ASIGNAR';
                $dic=Dictamen::where('idSolicitud',$dt->numeroSolicitud)->orderBy('fechaCreacion','desc')->first();
                if($dic!=null){
                    $tec=$dic->idUsuarioCrea;                   
               } 
                return $tec;

            })->rawColumns(['idFabricante','nombreFabricante','fechaProceso','tecnico'])
            ->make(true);
    }

}