<?php

namespace App\Http\Controllers\SolicitudesPost;


use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Models\Mandamiento;
use App\Models\Profesional;
use App\Models\SolicitudesPost\Solicitud as SolicitudPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\fpdf\PDF_Code128;

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
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use PDF;




class MandamientoController extends Controller
{
    private $pathfiles=null;
    private $url=null;
    private $token=null;

    public function __construct() {
        $this->pathfiles= Config::get('app.mapeo_files_cos');
        $this->url = Config::get('app.api');
        $this->token = Config::get('app.token');
    }

     public function validarMandamientoPost(Request $rq){
      $verificacion="";
      $response = ['status' => 404, 'message' => "Debe ingresar un número de mandamiento"];

        $rules = [
            'mandamiento'     =>  'required',
            'mancos' =>  'required',
            'manhig' =>  'required',
            'tipoPro'  =>  'required',
            'generoMandamiento' => 'required'
        ];

        $v = Validator::make($rq->all(),$rules);
        if ($v->fails()){
            $msg = "<ul>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            $response = ['status' => 404, 'message' => $msg];
            return $response;
        }

      try{

          if($rq->tipoPro=='COS')
            $tipoPago=Crypt::decrypt($rq->mancos);
          else
            $tipoPago=Crypt::decrypt($rq->manhig);


                 $mandamientoUtilizados=SolicitudPost::verificarSolPost();
                 $verificacion = DB::connection('mysql')->table('cssp.cssp_mandamientos as m')
                    ->join('cssp.cssp_mandamientos_detalle as md','md.id_mandamiento','=','m.id_mandamiento')
                    ->join('cssp.cssp_mandamientos_recibos as mr','mr.id_mandamiento', '=','m.id_mandamiento')
                    ->join('cssp.cssp_tipos_pagos_col as col','col.id_tipo_pago','=','md.id_tipo_pago')
                    ->whereNotIn('m.id_mandamiento',$mandamientoUtilizados)
                    ->where('col.id_tipo_pago',$tipoPago)
                    ->where('m.id_mandamiento',$rq->mandamiento)
                    ->select('md.COMENTARIOS','mr.ID_RECIBO','md.correlativo','m.id_mandamiento', 'm.id_cliente', 'm.a_nombre', 'm.total', 'md.valor as valorDet', 'col.nombre_tipo_pago', 'mr.fecha', 'mr.total_cobrado')
                    ->get();

          if(count($verificacion) > 0)
            $response = ['status' => 200, 'data' => $verificacion];
          else
            $response = ['status' => 404, 'message' => "El mandaminento no es válido."];


        return response()->json($response);

      }catch (Exception $e){
        return response()->json(['status' => 404, 'message' => "No fue posible validar el mandamiento, favor contacte a DNM informática"],200);
      }

    }
     public function validarMandamientoRevision(Request $rq){
      $verificacion="";
      $response = ['status' => 404, 'message' => "Debe ingresar un número de mandamiento"];

        $rules = [
            'mandamiento'     =>  'required',
        ];

        $v = Validator::make($rq->all(),$rules);
        if ($v->fails()){
            $msg = "<ul>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            $response = ['status' => 404, 'message' => $msg];
            return $response;
        }

      try{

                 $verificacion = DB::connection('mysql')->table('cssp.cssp_mandamientos as m')
                    ->join('cssp.cssp_mandamientos_detalle as md','md.id_mandamiento','=','m.id_mandamiento')
                    ->leftjoin('cssp.cssp_mandamientos_recibos as mr','mr.id_mandamiento', '=','m.id_mandamiento')
                    ->join('cssp.cssp_tipos_pagos_col as col','col.id_tipo_pago','=','md.id_tipo_pago')
                    ->where('m.id_mandamiento',$rq->mandamiento)
                    ->select('md.COMENTARIOS','mr.ID_RECIBO','md.correlativo','m.id_mandamiento', 'm.id_cliente', 'm.a_nombre', 'm.total', 'md.valor as valorDet', 'col.nombre_tipo_pago', 'mr.fecha', 'mr.total_cobrado')
                    ->get();

          if(count($verificacion) > 0)
            $response = ['status' => 200, 'data' => $verificacion];
          else
            $response = ['status' => 404, 'message' => "Problemas al consultar mandamiento."];


        return response()->json($response);

      }catch (Exception $e){
        return response()->json(['status' => 404, 'message' => "No fue posible validar el mandamiento, favor contacte a DNM informática"],200);
      }

    }

    public function generarMandamiento(Request $request){
        $rules = [
            'idProducto'     =>  'required',
            'mandamientocos' =>  'required',
            'mandamientohig' =>  'required',
            'idProfesional'  =>  'required'
        ];

        $v = Validator::make($request->all(),$rules);

        if ($v->fails()){
            $msg = "<ul>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return response()->json(['status' => 400, 'message' => $msg],400);
        }

        try{
            $tipo=$request->idProducto;
            $mancos=Crypt::decrypt($request->mandamientocos);
            $manhig=Crypt::decrypt($request->mandamientohig);
            $pro=Crypt::decrypt($request->idProfesional);

            if($tipo=='COS')
                $codigo=$mancos;
            else
                $codigo=$manhig;

            //CONSULTAMOS LA INFORMACIÓN DEL PAGO
            $client = new Client();
            $res = $client->request('POST', $this->url.'mandamiento/pagosvarios/consulta',[
                'headers' => [
                    'tk' => '$2y$10$T3fudlwIIDTna/dmUJ7fAuMGoKYNxI9eoA8eMXy0nf6WEDFxXMi0a',
                ],
                    'form_params' =>[
                        'idPago'   =>$codigo
              ]

            ]);
            $r = json_decode($res->getBody());
            $info=$r->data[0];


            //COSTO DEL MANDAMIENTO
            $total = $info->VALOR;
            $total=number_format((float)$total, 2, '.', '');
            $last = Mandamiento::last();
            $npe  = Mandamiento::npe($total);
            $codBarra = Mandamiento::codBarra($total);
            $codBarraTexto = Mandamiento::codBarraTexto($total);
            $fechaVencimiento = Mandamiento::fechaVencimiento();
            $profesional = Profesional::find($pro);

            if(!empty($profesional))
                $nombrePro= $profesional->NOMBRES." ".$profesional->APELLIDOS;
            else
               return response()->json(['status' => 400, 'message' => 'No se encontro profesional, notificar a informática del problema'],400);

            $mandamiento = Mandamiento::create([
                'ID_MANDAMIENTO' => $last[0]->LAST_ID,
                'CODIGO_BARRA'   => $codBarra[0]->COD_BARRA,
                'CODIGO_BARRA_TEXTO' => $codBarraTexto[0]->COD_BARRA_TEXTO,
                'NPE'            => $npe[0]->COD_NPE,
                'FECHA'          => date('Y/m/d'),
                'HORA'           => date('H:i:s'),
                'ID_CLIENTE'     => $pro,
                'A_NOMBRE'       => $nombrePro,
                'FECHA_VENCIMIENTO'=> $fechaVencimiento[0]->VENCIMIENTO,
                'ID_JUNTA'      => 'U17',
                'TOTAL'         =>  $total,
                'NOMBRE_CLIENTE'=>  $nombrePro,
                'ID_USUARIO_CREACION' =>Auth::user()->idUsuario.'@'.$request->ip()
            ]);
            $mandamiento->detalle()->create([
                'ID_CLIENTE'=>$pro
                ,'ID_TIPO_PAGO'=>$info->ID_TIPO_PAGO
                ,'VALOR'=>$total
                ,'NOMBRE_CLIENTE'=>$nombrePro
                ,'COMENTARIOS_ANEXOS'=>''
            ]);
            Session::put('mandamiento',$last[0]->LAST_ID);
            Session::put('idpago',$codigo);
            return response()->json(['status' => 200, 'mandamiento' => $last[0]->LAST_ID],200);

        }
        catch (Exception $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
            return new JsonResponse([
                'message'=>'Error, favor contacte a DNM informática'
            ],500);
        }
    }

    public function boletaMandamiento(Request $request){
        try{
            $id=Session::get('mandamiento');
            $idPago=Session::get('idpago');
            $mandamiento = Mandamiento::find($id);

             //CONSULTAMOS LA INFORMACIÓN DEL PAGO
            $client = new Client();
            $res = $client->request('POST', $this->url.'mandamiento/pagosvarios/consulta',[
                'headers' => [
                    'tk' => $this->token,
                ],
                    'form_params' =>[
                        'idPago'   =>$idPago
              ]

            ]);
            $r = json_decode($res->getBody());
            $info=$r->data[0];

          error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
          define('FPDF_FONTPATH',app_path().'/fpdf/font/');
          $pdf=new PDF_Code128('P','mm','legal');
          $pdf->AddPage();
          $pdf->SetXY(5,2);
                    $pdf->SetFont('Arial','',12);
                    $pdf->Cell(0,5,'DIRECCION NACIONAL DE MEDICAMENTOS',0,1,'C');
                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(0,5,'NIT 0614-020312-105-7',0,1,'C');
                    $pdf->SetFont('Times','',8);
                    $pdf->Cell(0,4,'MANDAMIENTO DE INGRESOS',0,1,'C');
                    $pdf->SetFont('Times','',7);
                    $pdf->Cell(0,4,'UNIDAD DE '.$info->UNIDAD.' - PAGOS VARIOS WEB',0,1,'C');
                    $pdf->SetFont('Times','',7);
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->Cell(150,4,'Cliente:  '.$mandamiento->ID_CLIENTE.' - '.utf8_decode($mandamiento->NOMBRE_CLIENTE).'',0,1,'J');
                    $pdf->SetXY($x + 135, $y);
                    $pdf->SetFont('Times','B',10);
                    $pdf->Cell(10,4,'Por: $'.$mandamiento->TOTAL.'                       No.: '.$mandamiento->ID_MANDAMIENTO.'',0,1,'J');
                    $pdf->SetFont('Times','',7);
                    $pdf->Cell(0,4,'Por Cuenta de: '.utf8_decode($mandamiento->POR_CUENTA).'                                                                                                                                                                                                 ',0,1,'J');
                    $pdf->Cell(0,4,'_____________________________________________________________________________________________________________________________________________________________ ',0,1,'J');

                    $pdf->Cell(15,3,$info->CODIGO,0,'J',0);
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->MultiCell(165,3,$info->NOMBRE_TIPO_PAGO,0,'L',false);
                    $pdf->SetXY($x + 165, $y);
                    $pdf->MultiCell(20,3,'$ '.$mandamiento->TOTAL.'',0,'L',false);
                    $pdf->Ln();
                    $pdf->SetX($x);
                    $pdf->MultiCell(165,3,utf8_decode($rq->comentario),0,'L',false);
                    $pdf->SetFont('Times','',7);
                    $pdf->SetXY(10,45);
                    $pdf->Write(5,'_____________________________________________________________________________________________________________________________________________________________',0,1,'J');
                    $pdf->SetFont('Times','B',7);
                    $pdf->SetXY(190,50);
                    $pdf->Write(5,'$ '.$mandamiento->TOTAL.'',0,1,'R',0);

                    //A set
                    $pdf->SetXY(9,2);
                    $pdf->Image(url('img/escudo.jpg'));
                    $pdf->SetXY(190,2);
                    $pdf->Image(url('img/dnm.jpg'));
                    $pdf->SetXY(160,10);
                    $pdf->SetFont('Arial','',10);
                    $pdf->Write(5,'Decreto 417');
                    $pdf->SetFont('Times','',7);
                    $pdf->SetXY(90,50);
                    $pdf->Write(5,'NPE:'.$mandamiento->NPE.'');
                    $pdf->SetXY(10,55);
                    $pdf->Write(5,'Emitido:'.$mandamiento->FECHA.'');
                    $pdf->SetXY(10,60);
                    $pdf->SetFont('Times','B',10);
                    $pdf->Write(5,'Vencimiento:'.$mandamiento->FECHA_VENCIMIENTO.'');
                    $pdf->SetFont('Times','',7);
                    $pdf->Code128(70,55,$mandamiento->CODIGO_BARRA,80,6);
                    $pdf->SetXY(75,60);
                    $pdf->Write(5,$mandamiento->CODIGO_BARRA_TEXTO);
                    $pdf->SetXY(180,55);
                    $pdf->Write(5,'Copia: Banco');
                    $pdf->SetXY(180,60);
                    $pdf->Write(5,'Usuario: '.$mandamiento->ID_CLIENTE.'');
                    $pdf->SetXY(10,65);
                    $pdf->Write(4,utf8_decode('Este mandamiento de ingreso será valido con la CERTIFICACIÓN DE LA MAQUINA Y EL SELLO del colector autorizado o con el comprobante del pago electrónico y podrá ser pagado en la red de las Agencias del Banco Agrícola, S.A.'),0,0,'J');
                    //segunda copia
                    $pdf->SetXY(10,87);
                    $pdf->SetFont('Arial','',12);
                    $pdf->Cell(0,5,'DIRECCION NACIONAL DE MEDICAMENTOS',0,1,'C');
                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(0,5,'NIT 0614-020312-105-7',0,1,'C');
                    $pdf->SetFont('Times','',8);
                    $pdf->Cell(0,4,'MANDAMIENTO DE INGRESOS',0,1,'C');
                    $pdf->SetFont('Times','',7);
                    $pdf->Cell(0,4,'UNIDAD DE '.$info->UNIDAD.' - PAGOS VARIOS WEB',0,1,'C');
                    $pdf->SetFont('Times','',7);
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->Cell(150,4,'Cliente:  '.$mandamiento->ID_CLIENTE.' - '.utf8_decode($mandamiento->NOMBRE_CLIENTE).'',0,1,'J');
                    $pdf->SetXY($x + 135, $y);
                    $pdf->SetFont('Times','',10);
                    $pdf->Cell(10,4,'Por: $'.$mandamiento->TOTAL.'                        No.: '.$mandamiento->ID_MANDAMIENTO.'',0,1,'J');
                    $pdf->SetFont('Times','',7);
                    $pdf->Cell(0,4,'Por Cuenta de: '.utf8_decode($mandamiento->POR_CUENTA).'',0,1,'J');
                    $pdf->Cell(0,4,'_____________________________________________________________________________________________________________________________________________________________ ',0,1,'J');
                    $pdf->Cell(15,3,$info->CODIGO,0,'J',0);
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->MultiCell(165,3,utf8_decode($info->NOMBRE_TIPO_PAGO),0,'L',false);
                    $pdf->SetXY($x + 165, $y);
                    $pdf->MultiCell(20,3,'$ '.$mandamiento->TOTAL.'',0,'L',false);
                    $pdf->Ln();
                    $pdf->SetX($x);
                    $pdf->MultiCell(165,3,utf8_decode(''),0,'L',false);
                    $pdf->SetFont('Times','',7);
                    $pdf->SetXY(10,130);
                    $pdf->Write(5,'_____________________________________________________________________________________________________________________________________________________________',0,1,'J');
                    $pdf->SetFont('Times','B',7);
                    $pdf->SetXY(190,135);
                    $pdf->Write(5,'$ '.$mandamiento->TOTAL.'',0,1,'R',0);

                    //A set
                    $pdf->SetXY(9,85);
                    $pdf->Image(url('img/escudo.jpg'));
                    $pdf->SetXY(190,85);
                    $pdf->Image(url('img/dnm.jpg'));
                    $pdf->SetXY(150,95);
                    $pdf->SetFont('Arial','',10);
                    $pdf->Write(5,'Decreto 417');
                    $pdf->SetFont('Times','',7);
                    $pdf->SetXY(90,135);
                    $pdf->Write(5,'NPE:'.$mandamiento->NPE.'');
                    $pdf->SetXY(10,140);
                    $pdf->Write(5,'Emitido:'.$mandamiento->FECHA.'');
                    $pdf->SetXY(10,145);
                    $pdf->SetFont('Times','B',10);
                    $pdf->Write(5,'Vencimiento:'.$mandamiento->FECHA_VENCIMIENTO.'');
                    $pdf->SetFont('Times','',7);
                    $pdf->Code128(70,140,$mandamiento->CODIGO_BARRA,80,6);
                    $pdf->SetXY(75,145);
                    $pdf->Write(5,$mandamiento->CODIGO_BARRA_TEXTO);
                    $pdf->SetXY(180,140);
                    $pdf->Write(5,'Copia: Cliente');
                    $pdf->SetXY(180,145);
                    $pdf->Write(5,'Usuario: '.$mandamiento->ID_CLIENTE.'');
                    $pdf->SetXY(10,150);
                    $pdf->Write(4,utf8_decode('Este mandamiento de ingreso será valido con la CERTIFICACIÓN DE LA MAQUINA Y EL SELLO del colector autorizado o con el comprobante del pago electrónico y podrá ser pagado en la red de las Agencias del Banco Agrícola, S.A.'),0,0,'J');
                    $pdf->Output('mandamiento_'.$mandamiento->ID_MANDAMIENTO.'.pdf','I');



        }
        catch (Exception $e) {
            Log::error('Error Exception',['time'=>Carbon::now(),'code'=>$e->getCode(),'msg'=>$e->getMessage()]);
            return new JsonResponse([
                'message'=>'Error, favor contacte a DNM informática'
            ],500);
        }
    }


}

