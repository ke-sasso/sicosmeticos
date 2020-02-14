<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Redirect;
use PDF;
use File;
use Response;
use App\Models\SolicitudesPost\Dictamen;
use App\Models\SolicitudesPost\DictamenBitacora;
use App\Models\SolicitudesPost\Solicitud as SolicitudesPost;


class PostController extends Controller
{

    public function pdfDictamenPost($idSolicitud,$idDictamen){
        $dictamen = Dictamen::find($idDictamen);
        $solicitud = SolicitudesPost::find($dictamen->idSolicitud);
        $bitacora = DictamenBitacora::where('idDictamen',$idDictamen)->where('idTipo',2)->where('estado',1)->first();
        if(!empty($bitacora)){
                 if (File::isFile($bitacora->urlArchivo)){
                             try{
                                    $file = File::get($bitacora->urlArchivo);
                                    $response = Response::make($file, 200);
                                    $response->header('Content-Type', 'application/pdf');
                                    return $response;
                             } catch (Exception $e) {
                                    return Response::download($bitacora->urlArchivo);
                             }
                }else{
                        Session::flash('msnError','¡PROBLEMAS AL CONSULTAR PDF!');
                        Log::warning('Error Exception PROBLEMAS AL CONSULTAR PDF!');

                }

        }else{
            return 'problemas';
        }
    }

}
