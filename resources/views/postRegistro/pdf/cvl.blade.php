<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title> </title>
    <style type="text/css">

        body{
            text-align: justify ;
            font-family: 'times new roman' !important;
            font-size: 12px;

        }
        p{
            margin-top: -5px; margin-bottom: -5px; !important
            padding-top: -5px; padding-bottom: -5px; !important
        }
        #footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 180px; opacity: 0.6;font-size: 12px; }
        #firma { position: fixed; left: 0px; bottom: 80px; right: 0px; height: 180px;}

        .opacityFont{
            opacity: 0.5;
            font-weight: bold;
            padding: 0px !important;
            margin: 0px !important;
        }

        .opacityFontTwo{
            opacity: 0.4;
            font-weight: bold;
            padding: 0px !important;
            margin: 0px !important;
        }

        p.padding2 {
            padding-left: 15cm;
            margin: 0px;
        }


        #parrafo2 tr td {
            width:25%;
            vertical-align: top;
        }
    </style>
</head>
<body>
<header>
    <p class="padding2" style="opacity: 0.4;"></p>
    <p style="text-align: right; margin: 40px;">C02-RS-02-DRS_CH.HER03</p>
    <table  style="width:105%; margin-right: 55px">
        <tr>
            <td style="width:15%;">
                <center>
                    <img id="escudo" src="{{ url('img/escudo.png') }}" style="height: 80px; width: auto;"/>
                </center>
            </td>
            <td style="width:105%;">
                <center>
                    <div id="mainTitle"><h1 class="opacityFont">Dirección Nacional de Medicamentos</h1>
                        <h2 class="opacityFontTwo">República de El Salvador, América Central</h2>
                        <h2 class="opacityFont">COSMÉTICOS E HIGIÉNICOS</h2>
                    </div>
                </center>
            </td>
            <td style="width:15%;">
                <center>
                    <img id="logo" src="{{ url('img/dnm.png') }}" style="height: 80px; width:  auto;"/>
                </center>
            </td>
        <hr>
    </table>

</header>
<h4 align="center"><b></b></h4>

@if(isset($solicitud))
    <p align="justify" style="margin: 40px;">
        <?php echo $solicitud->certificacion->textoEncabezado; ?>
    </p>


    <table style="margin: 30px;">
        {!! $solicitud->certificacion->textoMedular!!}
    </table>

    <p align="justify" style="margin: 40px;"> {!! $solicitud->certificacion->textoFinal!!}   </p>


@endif
<br><br><br><br>
<div align="center">
    <hr style="width: 40%">
     @if(date("Y-m-d",strtotime($solicitud->certificacion->fechaCreacion)) >= "2019-07-11")
             DRA. MÓNICA GUADALUPE AYALA GUERRERO<br>DIRECTORA EJECUTIVA
    @else
            -<br>
             SECRETARIO DE SESIONES DE LA JUNTA DE DELEGADOS
    @endif
</div>
<br>
       <table width="90%" style="font-size:10px; margin-left: 30px;">
        <tr>
          <td>Usuario:{{Auth::User()->idUsuario}}</td>
          <td></td>
          <td style="text-align: right;">No.Ref. :{{$solicitud->numeroSolicitud}}</td>
        </tr>
      </table>
    <footer id="footer" style="page-break-before: avoid;">
            <hr>
            <div align="center">
                Blv. Merliot y Av. Jayaque, Edif. DNM, Urb. Jardines del Volcán, Santa Tecla, La Libertad, El Salvador, América Central.
                <br>PBX 2522-5000 / Correo: cosmeticos.higienicos@medicamentos.gob.sv / web: www.medicamentos.gob.sv
            </div>
        </footer>

</body>

</html>