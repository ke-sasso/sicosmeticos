<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title> </title>
    <style type="text/css">

        body{
            text-align: justify ;
            font-family: 'times new roman' !important;
            font-size: 14px;

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
    </style>
</head>
<body>
<header>
    <p class="padding2" style="opacity: 0.4;"></p>
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
                    </div>
                </center>
            </td>
            <td style="width:15%;">
                <center>
                    <img id="logo" src="{{ url('img/dnm.png') }}" style="height: 80px; width:  auto;"/>
                </center>
            </td>
    </table>

</header>

<br>
@if(isset($solicitud))
<p align="right" style="margin: 40px;"> La Libertad, Santa Tecla, {{$solicitud->fechaModificacionText}}.</p>

<p align="justify"  style="margin: 40px; text-indent: 0.5cm; line-height: 1.5;">{!! $solicitud->certificacion->textoEncabezado!!}</p>

<p align="justify" style="margin: 40px; line-height: 1.5;">{!! $solicitud->certificacion->textoMedular!!}</p>

<p align="justify" style="margin: 40px; line-height: 1.5;">{!! $solicitud->certificacion->textoFinal!!}</p>
@endif

<br>
<br>
<div align="center">
    <hr style="width: 40%">
    @if(date("Y-m-d",strtotime($solicitud->certificacion->fechaCreacion)) >= "2019-07-11")
            DRA. MÓNICA GUADALUPE AYALA GUERRERO<br>DIRECTORA EJECUTIVA
    @else
            LIC. JOSÉ ROLANDO PEÑA MEDINA<br>DIRECTOR EJECUTIVO
    @endif
</div>






<footer id="footer">
    <hr>
    <div align="center">
        Blv. Merliot y Av. Jayaque, Edif. DNM, Urb. Jardines del Volcán, Santa Tecla, La Libertad, El Salvador, América Central.
        <br>PBX 2522-5000 / Correo: cosmeticos.higienicos@medicamentos.gob.sv / web: www.medicamentos.gob.sv
    </div>
</footer>

</body>

</html>