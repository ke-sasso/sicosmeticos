<?php

namespace App\Http\Controllers\SolicitudesPost;

use App\Http\Requests\SolicitudesPost\SolPostRequest;
use App\Models\SolicitudesPost\SolicitudDocumento;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

use App\Models\Item;
use App\Models\Cosmetico;
use App\Models\Higienico;
use App\Models\Solicitud as SolicitudesSol;
use App\Models\EstadoSolicitud;
use App\Models\DetalleDocumentos;
use App\Models\SolicitudesDocumentos;
use App\Models\SolicitudesPost\Tramite;
use App\Models\SolicitudesPost\Solicitud;
use App\Models\SolicitudesPost\Requisito;
use App\Models\SolicitudesPost\Documento;
use App\Models\SolicitudesPost\vwSolicitudes;
use App\Models\SolicitudesPost\Dictamen;
use App\Models\Cosmeticos\FabricantesCosmeticos;
use App\Models\Cat\ProductoExpediente;
use App\Models\Cat\ArchivoExpediente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;


use Crypt;
use Validator;
use Session;
use Response;
use File;
use Config;
use Log;
use Auth;
use DB;
use Carbon\Carbon;

use PDF;

use App\Http\Controllers\CosmeticoController;
use App\Http\Controllers\HigienicoController;


class ExportarArchivosPostController extends Controller
{
    private $pathfiles=null;

    public function __construct() {
        $this->pathfiles= Config::get('app.mapeo_files_cos');
    }

    public function mapeoArchivosPost(){
           $filesystem= new Filesystem();
          //CONSULTAMOS TODAS LAS SOLICITUDES QUE ESTAN CERTIFICADA
            DB::connection('sqlsrv')->beginTransaction();
            //$sol=SolicitudesSol::find(29);
            $solicitudes = SolicitudesSol::where('estado',9)->get();
            //dd($sol);

    foreach ($solicitudes as $sol){
                //verificamos que el idProducto se encuentre en la tabla COS.Cosmeticos
            $coshig = Cosmetico::find($sol->idProducto);
            $hig = Higienico::find($sol->idProducto);
            $ban=0;

            if(!empty($coshig)){
                $ban=1;
            }elseif(!empty($hig)){
                $ban=1;
            }else{
                $ban=0;
            }
            if($ban==1){
                //consultamos los documentos que tiene la solicitud
                $doc=SolicitudesDocumentos::where('idSolicitud',$sol->idSolicitud)->pluck('idDetalleDoc')->toArray();
                if(count($doc)>0){
                    //CONSULTAMOS LAS URL DE LOS DOCUMENTOS CON SU ITEM
                    $docUrl=SolicitudesDocumentos::join('dnm_cosmeticos_si.SOL.detalleDocumentos','dnm_cosmeticos_si.SOL.documentosSol.idDetalleDoc','dnm_cosmeticos_si.SOL.detalleDocumentos.idDoc')->select('urlArchivo','tipoArchivo','idItemDoc')->where('idSolicitud',$sol->idSolicitud)->get();
                    //destino de expediente con el numero de registro
                    $pathdest = Storage::disk('coshigexpedientes')->getDriver()->getAdapter()->getPathPrefix().$sol->idProducto;
                    //dd($pathdest);
                    foreach($docUrl as $url){
                            $item=Item::find($url->idItemDoc);
                            if(!empty($item)){
                                $nombreI = $item->nombreItem;
                                $idItemm = $item->idItem;
                            }else{
                                $nombreI = 'SOLICITUD';
                                $idItemm = 0;
                            }
                            File::makeDirectory($pathdest, 0777, true, true);
                            //guardamos el source del doc
                            $source = $pathdest .'\\'. $nombreI . '.pdf';
                            //copiamos el nuevo documento de empaque a la carpeta del producto
                            if($filesystem->exists($url->urlArchivo)){
                              File::copy($url->urlArchivo, $source);
                            }
                            // creamos el archivo expediente donde se guarda la url del documento
                            $archivo = ArchivoExpediente::create(['urlArchivo' => $source, 'tipoArchivo' => $url->tipoArchivo, 'usuarioCreacion' => 'SYSTEM']);
                            // enlazamos este archivo al producto para que pertenezca al expediente del mismo
                            ProductoExpediente::create(['productoId' => $sol->idProducto, 'archivoExpId' => $archivo->idArchivoExp, 'itemId' => $idItemm, 'usuarioCreacion' => 'SYSTEM']);
                    }
                }

            }

    }


            DB::connection('sqlsrv')->commit();
            dd("simon limon");
    }

    public function certificarSolCambioEmpaque($solicitud,$user){
        $result=false;
        $filesystem= new Filesystem();
        $idItem=null;

        DB::connection('sqlsrv')->beginTransaction();
        try {
            //destino de expediente con el numero de registro
            $pathdest = Storage::disk('coshigexpedientes')->getDriver()->getAdapter()->getPathPrefix() . $solicitud->noRegistro;
            // documento de empaque nuevo de la solicitud post
            $documento = SolicitudDocumento::getDocumento($solicitud->idSolicitud, 2);
            if (empty($documento)) return $result;

            if ($solicitud->tipoProducto === 'COS') $idItem = 5;
            else if ($solicitud->tipoProducto === 'HIG') $idItem = 9;

            $item = Item::findOrFail($idItem);

            if ($filesystem->exists($pathdest) && $filesystem->isDirectory($pathdest)) {
                    $archivo = ProductoExpediente::where('productoId', $solicitud->noRegistro)->where( 'itemId', $item->idItem)->first()->archivoExpediente;
                    if (!empty($archivo)) {
                        $filesystem->delete($archivo->urlArchivo);
                        $source = $pathdest .'\\'. $item->nombreItem . '.pdf';
                        File::copy($documento->urlDoc, $source);
                        $archivo->update(['urlArchivo' => $source, 'actualizado' => 1, 'usuarioModificacion' => $user]);
                        $result = true;
                    }
            }
            else {
                    //dd($pathdest);
                    //SI NO EXISTE LA CARPETA DEL PRODUCTO SE CREA
                    File::makeDirectory($pathdest, 0777, true, true);
                    //guardamos el source del doc
                    $source = $pathdest .'\\'. $item->nombreItem . '.pdf';
                    //copiamos el nuevo documento de empaque a la carpeta del producto
                    File::copy($documento->urlDoc, $source);
                    // creamos el archivo expediente donde se guarda la url del documento
                    $archivo = ArchivoExpediente::create(['urlArchivo' => $source, 'tipoArchivo' => $documento->tipoDoc, 'usuarioCreacion' => $user]);
                    // enlazamos este archivo al producto para que pertenezca al expediente del mismo
                    ProductoExpediente::create(['productoId' => $solicitud->noRegistro, 'archivoExpId' => $archivo->idArchivoExp, 'itemId' => $item->idItem, 'usuarioCreacion' => $user]);
                    $result = true;
                    //dd($result);
            }


            DB::connection('sqlsrv')->commit();
        }
        catch(\Exception $e){
            DB::connection('sqlsrv')->rollback();
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }

        return $result;
    }


}

