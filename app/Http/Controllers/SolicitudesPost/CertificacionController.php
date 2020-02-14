<?php

namespace App\Http\Controllers\SolicitudesPost;

use App\Http\Requests\SolicitudesPost\SolPostRequest;
use App\Models\Distribuidores;
use App\Models\Item;
use App\Models\SolicitudesPost\SolicitudDocumento;

use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;


use App\Models\Cosmetico;
use App\Models\Higienico;
use App\Models\EstadoSolicitud;
use App\Models\SolicitudesPost\Tramite;
use App\Models\SolicitudesPost\Solicitud as SolicitudPost;
use App\Models\SolicitudesPost\Requisito;
use App\Models\SolicitudesPost\Documento;
use App\Models\SolicitudesPost\vwSolicitudes;
use App\Models\SolicitudesPost\Dictamen;
use App\Models\SolicitudesPost\DictamenDetalle;
use App\Models\Cosmeticos\FabricantesCosmeticos;
use App\Models\Cat\ProductoExpediente;
use App\Models\Cat\ArchivoExpediente;

use App\Models\Cosmeticos\FormulaCosmeticos;
use App\Models\Higienicos\FormulaHigienicos;
use App\Models\Higienicos\PresentacionesHigienicos;
use App\Models\Cosmeticos\PresentacionesCosmeticos;
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


class CertificacionController extends Controller
{
    private $pathfiles=null;

    public function __construct() {
        $this->pathfiles= Config::get('app.mapeo_files_cos');
    }

    public static function certificarSolDocumentos($solicitud,$user,$idTramite){
        $result=false;
        $filesystem= new Filesystem();
        $idItem=null;
        //idTramite
        //6.CAMBIO DE EMPAQUE
        DB::connection('sqlsrv')->beginTransaction();
        try {
            //destino de expediente con el numero de registro
            $pathdest = Storage::disk('coshigexpedientes')->getDriver()->getAdapter()->getPathPrefix() . $solicitud->noRegistro;
            // documento de empaque nuevo de la solicitud post
            $documento = SolicitudDocumento::getDocumento($solicitud->idSolicitud, 2);
            if (empty($documento)) return $result;

            if ($solicitud->tipoProducto === 'COS'){
                if($idTramite==6){
                     $idItem = 5;
                }
            }else if ($solicitud->tipoProducto === 'HIG'){
                if($idTramite==6){
                     $idItem = 9;
                }
            }


            $item = Item::findOrFail($idItem);

            if ($filesystem->exists($pathdest) && $filesystem->isDirectory($pathdest)) {
                    $archivo = ProductoExpediente::where('productoId', $solicitud->noRegistro)->where('itemId', $item->idItem)->first();
                    if (!empty($archivo->archivoExpediente)) {
                        $arcfile=$archivo->archivoExpediente;
                        $filesystem->delete($arcfile->urlArchivo);
                        $source = $pathdest .'\\'. $item->nombreItem . '.pdf';
                        File::copy($documento->urlDoc, $source);
                        $arcfile->update(['urlArchivo' => $source, 'actualizado' => 1, 'usuarioModificacion' => $user]);
                        $result = true;
                    }else{
                            //guardamos el source del doc
                            $source = $pathdest .'\\'. $item->nombreItem . '.pdf';
                            //copiamos el nuevo documento de empaque a la carpeta del producto
                            File::copy($documento->urlDoc, $source);
                            // creamos el archivo expediente donde se guarda la url del documento
                            $archivo = ArchivoExpediente::create(['urlArchivo' => $source, 'tipoArchivo' => $documento->tipoDoc, 'usuarioCreacion' => $user]);
                            // enlazamos este archivo al producto para que pertenezca al expediente del mismo
                            ProductoExpediente::create(['productoId' => $solicitud->noRegistro, 'archivoExpId' => $archivo->idArchivoExp, 'itemId' => $item->idItem, 'usuarioCreacion' => $user]);
                            $result = true;
                    }
            }else {
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

    public static function certificarAmpliacionFrag($solicitud,$producto,$user){
        $result=false;
        DB::connection('sqlsrv')->beginTransaction();
        try {
            if(!empty($solicitud->fragancia)){
                foreach($solicitud->fragancia as $fra){
                   $producto->fragancias()->create(['fragancia'=>$fra->fragancia,'estado'=>'A','idUsuarioCrea'=>$user]);
                }
                DB::connection('sqlsrv')->commit();
                $result=true;
            }
            else{
                $result=false;
            }
        }
        catch (QueryException $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }

        return $result;
    }
    public static function certificarAmpliacionTono($solicitud,$producto,$user){
        $result=false;
        DB::connection('sqlsrv')->beginTransaction();
        try {
            if(!empty($solicitud->tono)){
                foreach($solicitud->tono as $tono){
                     $producto->tonos()->create(['tono'=>$tono->tono,'estado'=>'A','idUsuarioCrea'=>$user]);
                }
                DB::connection('sqlsrv')->commit();
                $result=true;
            }
            else{
                $result=false;
            }
        }
        catch (QueryException $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }

        return $result;
    }
      public static function certificarCambioFormulacion($solicitud,$producto,$user){
        $result=false;
        DB::connection('sqlsrv')->beginTransaction();
        try {
            if(!empty($solicitud->formula)){
                if($solicitud->tipoProducto=='COS'){
                        //COS
                        if(!empty($solicitud->formulaDelete)){
                            foreach($solicitud->formulaDelete as $form){
                                FormulaCosmeticos::where('idCorrelativo',$form->idPrimary)->where('idDenominacion',$form->idDenominacion)->delete();
                            }
                        }
                        foreach($solicitud->formula as $form){
                             $forcos = new FormulaCosmeticos();
                             $forcos->idCosmetico = $solicitud->noRegistro;
                             $forcos->idDenominacion=$form->idDenominacion;
                             $porc=round($form->porcentaje,2);
                             $forcos->porcentaje=$porc;
                             $forcos->idUsuarioCreacion=$user;
                             $forcos->save();
                        }

                 }else{
                        //HIG
                        if(!empty($solicitud->formulaDelete)){
                           foreach($solicitud->formulaDelete as $form){
                                FormulaHigienicos::where('idCorrelativo',$form->idPrimary)->where('idDenominacion',$form->idDenominacion)->delete();
                            }
                        }
                         foreach($solicitud->formula as $form){
                             $forcos = new FormulaHigienicos();
                             $forcos->idHigienico = $solicitud->noRegistro;
                             $forcos->idDenominacion=$form->idDenominacion;
                             $porc=round($form->porcentaje,2);
                             $forcos->porcentaje=$porc;
                             $forcos->idUsuarioCreacion=$user;
                             $forcos->save();

                        }
                 }
                DB::connection('sqlsrv')->commit();
                $result=true;
           }else{
                $result=false;
           }
        }
        catch (QueryException $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }

        return $result;
    }
    public static function certificarCambioNombre($solicitud,$producto,$user){
        $result=false;
        DB::connection('sqlsrv')->beginTransaction();
        try {
            if(!empty($solicitud->cambioNombre)){
                $producto->nombreComercial=$solicitud->cambioNombre->nombreNuevo;
                $producto->idUsuarioModificacion=$user;
                $producto->save();
                DB::connection('sqlsrv')->commit();
                $result=true;
            }
            else{
                $result=false;
            }
        }
        catch (QueryException $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }

        return $result;
    }
      public static function certificarAmpleacionPresentacion($solicitud,$producto,$user){
        $result=false;
        DB::connection('sqlsrv')->beginTransaction();
        try {
            if(!empty($solicitud->presentaciones)){

                foreach($solicitud->presentaciones as $pre){
                        if($solicitud->tipoProducto=='COS'){
                            $prese = new PresentacionesCosmeticos();
                            $prese->idCosmetico = $solicitud->noRegistro;
                        }else{
                            $prese = new PresentacionesHigienicos();
                            $prese->idHigienico = $solicitud->noRegistro;
                        }
                        $prese->idEnvasePrimario   = $pre->idEnvasePrimario;
                        $prese->idMaterialPrimario = $pre->idMaterialPrimario;
                        $prese->contenidoPrimario  = $pre->contenidoPrimario;
                        $prese->idUnidad           = $pre->idUnidad;
                        $prese->idEnvaseSecundario = $pre->idEnvaseSecundario;
                        $prese->idMaterialSecundario=$pre->idMaterialSecundario;
                        $prese->contenidoSecundario=$pre->contenidoSecundario;
                        $prese->peso               = $pre->peso;
                        $prese->idMedida           = $pre->idMedida;
                        $prese->nombrePresentacion = $pre->nombrePresentacion;
                        $prese->textoPresentacion  = $pre->textoPresentacion;
                        $prese->estado             = 'A';
                        $prese->idUsuarioCrea      = $user;
                        $prese->save();
                }
                if(!empty($solicitud->presentacionesDelete)){
                    foreach($solicitud->presentacionesDelete as $dele){
                        if($solicitud->tipoProducto=='COS'){
                            $predelete = PresentacionesCosmeticos::where('idPresentacion',$dele->idPresentacion)->delete();
                        }else{
                            $predelete = PresentacionesHigienicos::where('idPresentacion',$dele->idPresentacion)->delete();
                        }
                    }
                }
                DB::connection('sqlsrv')->commit();
                $result=true;
            }
            else{
                $result=false;
            }
        }
        catch (QueryException $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage().' File: '.$e->getFile().' Line: '.$e->getLine()]);
            throw  $e;
        }

        return $result;
    }



}
