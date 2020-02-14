<?php
  //  dd($data);
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title> </title>
    <style type="text/css">

      body{
        font-size: {{$tamanioFuente}};
        margin-left: 2.5em;
        margin-right: 2.25em;
        position: relative;
        font-family: Times New Roman !important;

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
      .opacityFont {
            opacity: 0.5;
            font-weight: bold;
            padding: 0px !important;
            margin: 0px !important;
        }

        .opacityFontTwo {
            opacity: 0.4;
            font-weight: bold;
            padding: 0px !important;
            margin: 0px !important;
        }

    </style>
  </head>
  <body>

<header>
    <p style="margin-left:400px;">C02-RS-01-DRS_CH.HER03</p>
    <table style="width:105%; margin-right: 55px">
        <tr>
            <td style="width:15%;">
                <!--<center>
                    <img id="escudo" src="{{ url('img/escudo.png') }}" style="height: 80px; width: auto;"/>
                </center>-->
            </td>
            <td style="width:105%;">
                <center>
                    <div id="mainTitle"><h1 class="opacityFont">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dirección Nacional de Medicamentos</h1>
                        <h2 class="opacityFontTwo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;República de El Salvador, América Central</h2>
                        <h3 class="opacityFont">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSMÉTICOS E HIGIÉNICOS</h3>
                        <hr style="width:100% !important;">
                    </div>
                </center>
            </td>
            <td style="width:15%;">
               <!-- <center>
                    <img id="logo" src="{{ url('img/dnm.png') }}" style="height: 80px; width: auto;"/>
                </center> -->
            </td>
        </tr>
    </table>
</header>
    <main>
      <center><p><b>CERTIFICADO DE REGISTRO SANITARIO</b></p></center>
      <p align="justify" >
      La Dirección Nacional de Medicamentos, con fundamento en lo establecido en La Ley de Medicamentos, Reglamento General de la Ley de Medicamentos, Anexo 2 de la Resolución No. 231-2008 (COMIECO-L) y Anexo 1 de la Resolución No. 230-2008 (COMIECO-L), extiende el presente certificado, de conformidad al registro sanitario del producto que a continuación se detalla:</p>
       <table width="100%">
        </br>
        <tr>
          <td width="5%" align="left">No. de Registro:</td>
          <td width="80%"><b>{!!$data['solicitud']->idProducto!!} </b></td>
        </tr>
        <tr>
          <td style="vertical-align: top;" width="35%">Nombre del Producto:</td>
          <td style="text-align: justify;"><b>{!!$data['producto']->nombreComercial!!} </b></td>
        </tr>
        <tr>
          <td align="left">Titular:</td>
          @if(isset($data['propietario']))
          <td><b> {!!$data['propietario']->nombre!!}</b></td>
          @endif
        </tr>
        <tr>
          <td  style="vertical-align: top;">Fabricante:</td>
          <td>@foreach($data['fabricantes'] as $fab)
            <b>{!!$fab->nombreComercial.' ('.$fab->nombre_pais.')'!!}<br/></b>
              @endforeach
          </td>
        </tr>
          </table>
        @if(count($data['presentaciones'])<35)
                    <table width="100%">
                      <tr>
                      <td  width="30%">Presentaciones:</td>
                      <td><b>
                      @foreach($data['presentaciones'] as $p)
                          {!!$p->textoPresentacion!!},
                      @endforeach
                      @if(isset($data['coempaques']))
                        @for($i=0; $i<count($data['coempaques']); $i++)
                            {!!$data['coempaques'][$i]->nombreCoempaque!!}:
                            @for($j=0; $j<count($data['detalles'][0]); $j++)
                               @if($data['detalles'][$i][$j]->idCoempaque==$data['coempaques'][$i]->idCoempaque)
                                  {!!$data['detalles'][$i][$j]->nombreComercial!!}
                                  {!!$data['detalles'][$i][$j]->textoPresentacion!!}
                                @endif
                               @if ($j==count($data['detalles'][0])-1)
                                .
                               @else
                                ,
                              @endif

                            @endfor
                        @endfor
                      @endif</b></td>
                     </tr>
                    </table>
         @else
                    Presentaciones:<p style="margin-left: 200px;"><b>
                             @foreach($data['presentaciones'] as $p)
                              {!!$p->textoPresentacion!!},
                          @endforeach
                          @if(isset($data['coempaques']))
                            @for($i=0; $i<count($data['coempaques']); $i++)
                                {!!$data['coempaques'][$i]->nombreCoempaque!!}:
                                @for($j=0; $j<count($data['detalles'][0]); $j++)
                                   @if($data['detalles'][$i][$j]->idCoempaque==$data['coempaques'][$i]->idCoempaque)
                                      {!!$data['detalles'][$i][$j]->nombreComercial!!}
                                      {!!$data['detalles'][$i][$j]->textoPresentacion!!}
                                    @endif
                                   @if ($j==count($data['detalles'][0])-1)
                                    .
                                   @else
                                    ,
                                  @endif

                                @endfor
                            @endfor
                          @endif</b></b>
                        </p>
           @endif
                {{--
            @if(count($data['presentaciones'])<50)
            <table width="100%">
            <tr>
            <td  width="30%">Presentaciones:</td>
            <td><b>
            @foreach($data['presentaciones'] as $p)
                {!!$p->textoPresentacion!!},
            @endforeach
            @if(isset($data['coempaques']))
              @for($i=0; $i<count($data['coempaques']); $i++)
                  {!!$data['coempaques'][$i]->nombreCoempaque!!}:
                  @for($j=0; $j<count($data['detalles'][0]); $j++)
                     @if($data['detalles'][$i][$j]->idCoempaque==$data['coempaques'][$i]->idCoempaque)
                        {!!$data['detalles'][$i][$j]->nombreComercial!!}
                        {!!$data['detalles'][$i][$j]->textoPresentacion!!}
                      @endif
                     @if ($j==count($data['detalles'][0])-1)
                      .
                     @else
                      ,
                    @endif

                  @endfor
              @endfor
            @endif</b></td>
           </tr>
          </table>
          @else
                Presentaciones:<p>
                     @foreach($data['presentaciones'] as $p)
                      {!!$p->textoPresentacion!!},
                  @endforeach
                  @if(isset($data['coempaques']))
                    @for($i=0; $i<count($data['coempaques']); $i++)
                        {!!$data['coempaques'][$i]->nombreCoempaque!!}:
                        @for($j=0; $j<count($data['detalles'][0]); $j++)
                           @if($data['detalles'][$i][$j]->idCoempaque==$data['coempaques'][$i]->idCoempaque)
                              {!!$data['detalles'][$i][$j]->nombreComercial!!}
                              {!!$data['detalles'][$i][$j]->textoPresentacion!!}
                            @endif
                           @if ($j==count($data['detalles'][0])-1)
                            .
                           @else
                            ,
                          @endif

                        @endfor
                    @endfor
                  @endif</b>
                </p>


          @endif
    --}}


        <table width="100%">
        <tr>
          <td style="vertical-align: top;" width="5%">Distribuidor:</td>
          @if($data['solicitud']->distribuidorTitular==0)
          <td width="80%">@foreach($data['distribuidores'] as $dis)
            <b>{!!$dis->NOMBRE_COMERCIAL!!}<br/></b>
              @endforeach
          </td>
          @else
          <td width="80%">
          @if(isset($data['propietario']))
            <b>{!!$data['propietario']->nombre!!}</b>
          @endif
          </td>
          @endif
        </tr>
        <tr>
          <td style="vertical-align: top;" width="35%">Profesional Responsable:</td>
          @if($data['profesional']!=null)
          <td><b>{!!$data['profesional'][0]->NOMBREPROF!!} </b></td>
          @else
          <td></td>
          @endif
        </tr>
        <tr>
          <td align="left">Fecha de Vencimiento:</td>
          <td><b>{!!$data['fechaVencimiento']!!} </b></td>
        </tr>

  </table>
      <br>
      <p align="justify">
      Esta certificación autoriza su Venta Libre en todo el territorio de la República de El Salvador, extendiéndose la presente por la Dirección Nacional de Medicamentos, en la ciudad de Santa Tecla, a los {!!$data['fechaActual']!!}.
      </p>
      <br/><br/>
      <p align="center" style="margin: 30px; margin-top: 10px;  ">
        <b>DIOS   UNION   LIBERTAD</b>
      </p> <br/><br/>
      <div align="center" style="page-break-before: avoid; ">
          @if(date("Y-m-d",strtotime($data['fechaSesion'])) >= "2019-07-11")
                   <p><strong>DRA. MÓNICA GUADALUPE AYALA GUERRERO</strong><br/>
                    <strong>DIRECTORA EJECUTIVA</strong></p>
          @else
                  <p><strong>-</strong><br/>
                  <strong>SECRETARIO DE LA JUNTA DE DELEGADOS</strong></p>
          @endif
      </div>
       <table width="100%" style="font-size:10px;">
        <tr>
          <td>Usuario:{!!$data['user']!!}</td>
          <td></td>
          <td style="text-align: right;">No.Ref. :{{$data['solicitud']->idSolicitud}}/{{$data['solicitud']->numeroSolicitud}}</td>
        </tr>
      </table>
    </main>
     <footer id="footer">
       <hr/>
    Blv. Merliot y Av. Jayaque, Edif. DNM, Urb. Jardines del Volcán, Santa Tecla, La Libertad, El Salvador, América
    Central.
    <br>PBX 2522-5000 / Correo: cosmeticos.higienicos@medicamentos.gob.sv / web: www.medicamentos.gob.sv
    </footer>

  </body>

</html>

