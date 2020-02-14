<?php //dd($fuente);?>
<!DOCTYPE html>
<html>
@for($i=0;$i<count($data);$i++)
  @if($data[$i]['solicitud']->tipoSolicitud==2 || $data[$i]['solicitud']->tipoSolicitud==4)
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title> </title>
    <style type="text/css">

      body{
        font-size: {{$tamanioFuente}};
        margin-left: 2.5em;
        margin-right: 2.25em;
        position: relative;
        font-family: Times New Roman;

      }
      #wrap {
      float: center;
      position: relative;
      left: 35%;
    }

    #content {
        float: center;
        position: relative;
        left: -10%;
    }
      div#header{
        width: 74%;
        display: inline-block;
        margin: 0 auto;
        border:1px solid black;
      }

      #footer {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        padding: 0;
        text-align: center;
        font-family: Times New Roman;
        font-size:9;
        margin-bottom:-30px;
      }
      div#subTitle{
        width: 300px;
        height: 50px;
        margin: 0 auto;
        bottom: 200px;
        border: 2px solid black;
      }

      #firma{
        height: auto;
        width: auto;
        max-width: 400px;
        max-height: 800px;

      }
      .info{
        background-color:#BEBBBA;
      }
    </style>
  </head>
  <body>


  <header style="margin-top:15%;">
    <table  style="width:100%;">
      <tr>

        <td style="width:70%;">
          <center>
            <h2 style="margin:0;padding:0;">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CERTIFICADO DE VENTA LIBRE&nbsp;&nbsp;

            </h2>
          </center>
        </td>
       </tr>
    </table>
  </header>
    <main>
      <p align="justify" >
      La Unidad de Importaciones, Exportaciones y Donaciones de Medicamentos, con fundamento en lo establecido
en La Ley de Medicamentos, Reglamento General de la Ley de Medicamentos, Anexo 2 de la Resolución No.
231-2008 (COMIECO-L) y Anexo 1 de la Resolución No. 230-2008 (COMIECO-L), extiende el presente
certificado, de conformidad al registro sanitario del producto que a continuación se detalla:
       <table style="table-layout: fixed" width="100%">
        </br>
        <tr>
          <td width="5%" align="left">No. de Registro:</td>
          <td width="80%"><b>{!!$data[$i]['solicitud']->idProducto!!} </b></td>
        </tr>
        <tr>
          <td style="vertical-align: top;" width="35%">Nombre del Producto:</td>
          <td style="text-align: justify;"><b>{!!$data[$i]['producto']->nombreComercial!!} </b></td>
        </tr>
        <tr>
          <td align="left">Titular:</td>
          @if(isset($data[$i]['propietario']))
            <td><b> {!!$data[$i]['propietario']->nombre!!}</b></td>
          @endif
        </tr>
        <tr>
          <td  style="vertical-align: top;">Fabricante:</td>
          <td>@foreach($data[$i]['fabricantes'] as $fab)
            <b>{!!$fab->nombreComercial.' ('.$fab->nombre_pais.')'!!}<br/></b>
              @endforeach
          </td>
        </tr>
        <tr>
          <td style="vertical-align: top;">Presentaciones:</td>
            <td style="text-align: justify;"><b>
            @foreach($data[$i]['presentaciones'] as $p)
                {!!$p->textoPresentacion!!},
            @endforeach
            @if(isset($data[$i]['coempaques']))
              @for($j=0; $j<count($data[$i]['coempaques']); $j++)
                  {!!$data[$i]['coempaques'][$j]->nombreCoempaque!!}:
                  @for($k=0; $k<count($data[$i]['detalles'][0]); $k++)
                     @if($data[$i]['detalles'][$j][$k]->idCoempaque==$data[$i]['coempaques'][$j]->idCoempaque)
                        {!!$data[$i]['detalles'][$j][$k]->nombreComercial!!}
                        {!!$data[$i]['detalles'][$j][$k]->textoPresentacion!!}
                      @endif
                     @if ($k==count($data[$i]['detalles'][0])-1)
                      .
                     @else
                      ,
                    @endif

                  @endfor
              @endfor
            @endif
            </b>
            </td>
        </tr>
        <tr>
          <td style="vertical-align: top;">Distribuidor:</td>
          @if($data[$i]['solicitud']->distribuidorTitular==0)
          <td>@foreach($data[$i]['distribuidores'] as $dis)
            <b>{!!$dis->NOMBRE_COMERCIAL!!}<br/></b>
              @endforeach
          </td>
          @else
          <td>
          @if(isset($data[$i]['propietario']))
            <b>{!!$data[$i]['propietario']->nombre!!}</b>
          @endif
          </td>
           @endif
        </tr>
        <tr>
          <td style="vertical-align: top;">Profesional Responsable:</td>
          @if($data[$i]['profesional']!=null)
            <td><b>{!!$data[$i]['profesional'][0]->NOMBREPROF!!} </b></td>
          @else
            <td></td>
          @endif
        </tr>
        <tr>
          <td align="left">Fecha de Vencimiento:</td>
          <td><b>{!!$data[$i]['fechaVencimiento']!!} </b></td>
        </tr>

  </table>
      <br>
      <p align="justify">
      Esta certificación autoriza su Venta Libre en todo el territorio de la República de El Salvador, extendiéndose la presente por la Dirección Nacional de Medicamentos, en la ciudad de Santa Tecla, a los {!!$data[$i]['fechaActual']!!}.
      </p>
      <br/><br/>
      <p align="center" style="margin: 30px; margin-top: 10px;  ">
        <b>DIOS   UNION   LIBERTAD</b>
      </p> <br/><br/>
      <div align="center" style="page-break-before: avoid; ">
          <p><strong>-</strong><br/>
          <strong>SECRETARIO DE LA JUNTA DE DELEGADOS</strong></p>
      </div>
       <table width="100%" style="font-size:10px;">
        <tr>
          <td>Usuario:{!!$data[$i]['user']!!}</td>
          <td></td>
          <td style="text-align: right;">No.Ref. :{{$data[$i]['solicitud']->idSolicitud}}/{{$data[$i]['solicitud']->numeroSolicitud}}</td>
        </tr>
      </table>
    </main>
     <footer id="footer">
    </footer>

  </body>
@else
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title> </title>
    <style type="text/css">

      body{
        font-size: {{$tamanioFuente}};
        margin-left: 2.5em;
        margin-right: 2.25em;

      }
      #wrap {
      float: center;
      position: relative;
      left: 35%;
    }

    #content {
        float: center;
        position: relative;
        left: -10%;
    }
      div#header{
        width: 74%;
        display: inline-block;
        margin: 0 auto;
        border:1px solid black;
      }
      div#header img#escudo{
        height: 60px;
        width: auto;
        max-width: 20%;
        display: inline-block;
        margin: 0.5em;
      }
      div#header img#logo{
        height: 40px;
        width: auto;
        max-width: 20%;
        display: inline-block;
        margin: 0.5em;
      }
      div#header div#mainTitle{
        width: 65%;
        display: inline-block;
        margin: 0.5em;
        margin-right: 1em;
        text-align: center;
      }
      #footer {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        padding: 0;
        text-align: center;
      }
      div#subTitle{
        width: 300px;
        height: 50px;
        margin: 0 auto;
        bottom: 200px;
        border: 2px solid black;
      }

      #firma{
        height: auto;
        width: auto;
        max-width: 400px;
        max-height: 800px;

      }
      .info{
        background-color:#BEBBBA;
      }
    </style>
  </head>
  <body>



  <header style="margin-top:15%;">
    <table  style="width:100%;">
      <tr>

        <td style="width:70%;">
          <center>
            <h2 style="margin:0;padding:0;">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CERTIFICADO DE VENTA LIBRE&nbsp;&nbsp;

            </h2>
          </center>
        </td>
       </tr>
    </table>
  </header>
    <main>
      <p align="justify" style="font-family: Times New Roman;">
      La Unidad de Importaciones, Exportaciones y Donaciones de Medicamentos, con fundamento en lo establecido
en La Ley de Medicamentos, Reglamento General de la Ley de Medicamentos, Anexo 5 de la Resolución No.
231-2008 (COMIECO-L) y Anexo 3 de la Resolución No. 230-2008 (COMIECO-L), otorga el certificado de
venta libre del <b>RECONOCIMIENTO MUTUO DEL REGISTRO SANITARIO {!!$data[$i]['tipo']!!} DE {{$data[$i]['pais']->nombre}} {!!$data[$i]['producto']->numeroReconocimiento!!} </b> para el producto <b>{!!$data[$i]['producto']->nombreComercial!!}:</b>
      <table style="table-layout: fixed" width="100%">
        <tr>
          <td width="20%" align="left">Titular:</td>
          @if(isset($data[$i]['propietario']))
            <td width="80%"><b>{!!$data[$i]['propietario']->nombre!!}</b>
          @endif
        </tr>
        <tr>
          <td  style="vertical-align: top;">Fabricante:</td>
          <td>@foreach($data[$i]['fabricantes'] as $fab)
            <b>{!!$fab->nombreComercial.' ('.$fab->nombre_pais.')'!!}<br/></b>
              @endforeach
          </td>
        </tr>
        <tr>
          <td style="vertical-align: top;">Presentaciones:</td>
            <td style="text-align: justify;">
            @foreach($data[$i]['presentaciones'] as $p)
                <b>{!!$p->textoPresentacion!!},</b>
            @endforeach
          @if(isset($data[$i]['coempaques']))
            @for($j=0; $j<count($data[$i]['coempaques']); $j++)
                {!!$data[$i]['coempaques'][$j]->nombreCoempaque!!}:
                @if(count($data[$i]['detalles'])>0)
                  @for($k=0; $k<count($data[$i]['detalles'][0]); $k++)
                     @if($data[$i]['detalles'][$j][$k]->idCoempaque==$data[$i]['coempaques'][$j]->idCoempaque)
                        {!!$data[$i]['detalles'][$j][$k]->nombreComercial!!}
                        {!!$data[$i]['detalles'][$j][$k]->textoPresentacion!!}
                      @endif
                  @endfor
                @endif
            @endfor
          @endif
            </td>
        </tr>
        <tr>
          <td style="vertical-align: top;">Distribuidor:</td>
          @if($data[$i]['solicitud']->distribuidorTitular==0)
          <td>@foreach($data[$i]['distribuidores'] as $dis)
            <b>{!!$dis->NOMBRE_COMERCIAL!!}<br/></b>
              @endforeach
          </td>
          @else
          <td>
          @if(isset($data[$i]['propietario']))
            <b>{!!$data[$i]['propietario']->nombre!!}</b>
          @endif
          </td>
           @endif
        </tr>
        <tr>
          <td style="vertical-align: top;">Profesional Responsable:</td>
          @if($data[$i]['profesional']!=null)
            <td><b>{!!$data[$i]['profesional'][0]->NOMBREPROF!!} </b></td>
          @else
            <td></td>
          @endif
        </tr>

    </table>
    <br>
    <p align="justify">
      Este reconocimiento vence el <b>{!!$data[$i]['fechaVencimiento']!!}</b> y se le asigna el No. de Control Interno: <b>
      @if($data[$i]['tipo'] == 'COSMETICO')
        {!!$data[$i]['producto']->idCosmetico!!}
      @else
        {!!$data[$i]['producto']->idHigienico!!}
      @endif
      </b>, este certificado autoriza su venta libre en el territorio de la República de El Salvador y se extiende la presente por la
Dirección Nacional de Medicamentos, en la ciudad de Santa Tecla, a los {!!$data[$i]['fechaActual']!!}.
    </p>
    <br/><br/>
      <p align="center" style="margin: 30px; margin-top: 10px;  ">
        <b>DIOS   UNION   LIBERTAD</b>
      </p> <br/><br/>
      <div align="center" style="page-break-before: avoid; ">
          <p><strong>-</strong><br/>
          <strong>SECRETARIO DE LA JUNTA DE DELEGADOS</strong></p>
      </div>
       <table width="100%" style="font-size:10px;">
        <tr>
          <td>Usuario:{!!$data[$i]['user']!!}</td>
          <td></td>
          <td style="text-align: right;">No.Ref. :{{$data[$i]['solicitud']->idSolicitud}}/{{$data[$i]['solicitud']->numeroSolicitud}}</td>
        </tr>
      </table>
    </main>
     <footer id="footer" style="margin: 50px; font-family: Times New Roman;">

    </footer>

  </body>
  @endif
  @endfor

</html>

