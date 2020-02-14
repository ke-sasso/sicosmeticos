<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Resolución {{$data['numeroSolicitud']}}</title>
    <style type="text/css">

        body {

            font-family: 'times new roman' !important;
            font-size: 14px;

        }

        #footer {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 0;
            text-align: center;
        }

        #firma {
            height: auto;
            width: auto;
            max-width: 400px;
            max-height: 800px;

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

        .alignp{
            text-align: justify;
            margin: 50px;
            padding: 0;
        }

    </style>
</head>
<body>


<header>
    <p style="text-align: right; ">C02-RS-01-DRS_CH.HER04</p>
    <table style="width:105%; margin-right: 55px">
        <tr>
            <td style="width:15%;">
                <center>
                    <img id="escudo" src="{{ url('img/escudo.png') }}" style="height: 80px; width: auto;"/>
                </center>
            </td>
            <td style="width:105%;">
                <center>
                    <div id="mainTitle"><h1 class="opacityFont">Dirección Nacional de Medicamentos</h1>
                        <h2 class="opacityFontTwo">República de El Salvador, América Central<br>COSMÉTICOS E HIGIÉNICOS</h2>
                        <hr style="width:100% !important;">
                    </div>
                </center>
            </td>
            <td style="width:15%;">
                <center>
                    <img id="logo" src="{{ url('img/dnm.png') }}" style="height: 80px; width: auto;"/>
                </center>
            </td>
    </table>
</header>
<div>
    <p align="right" style="margin-right: 50px;">Santa Tecla, <b>{{$data['dias']}}.</b></p>
    <p class="alignp">
      <b>
      {{$data['profesional'][0]->NOMBRE_PROFESIONAL}}<br>
      Profesional responsable de productos <br>
      Propiedad de {{$data['titular'][0]->nombre_propietario}} <br>
      Presente.
      </b>
    </p>
    <p class="alignp">
        En referencia a solicitud No. <b>{{$data['numeroSolicitud']}}</b>, presentada para el
        trámite de <b>{{$data['tram'][0]->nombreTramite}}</b>, del producto
        <b>{{$data['solicitud'][0]->nombreComercial}}</b>,
        de titular <b>{{$data['titular'][0]->nombre_propietario}} </b>, por este medio se le informa que
        previo a resolver deberá solventar en lo siguiente:
    </p>
    <p class="alignp">
        @if(count($data['observaciones'])>0)
            <?php $i=1; ?>
            @foreach($data['observaciones'] as $d)
                    @if($d->opcion=='NO CUMPLE')
                       {{$i}}. <b>{{$d->nombreItem}}</b>, {{$d->observaciones}}<br>
                       <?php $i++; ?>
                    @endif
            @endforeach
        @endif
        {{$data['resolucion'][0]->observacion}}
    </p>
    <p class="alignp">Infórmese al regulado que de acuerdo al artículo 72 de la Ley de Procedimientos Administrativos, deberán subsanar presentar los requisitos observados en un plazo máximo de diez días hábiles, posterior a la notificación de la presente, de lo contrario se archivaran diligencias sin más trámite y deberá ingresar nuevamente la solicitud, si fuere procedente conforme a la ley.<br>
     Notifíquese.<br><br>Atentamente,</p>

    <div align="center">
        <p><b>Dr. Haryes Alfredo Funes Magaña</b></p>
        <p><b>Jefe de Registro de Dispositivos Médicos, Cosméticos e Higiénicos</b></p>
    </div>
</div>

<p align="right" style="margin-right: 50px;" >{{Auth::User()->idUsuario}}</p>
<footer id="footer">
    <!--<p class="alignp">
        Nota: En el caso de las prevenciones u observaciones realizadas al registro de productos cosméticos e
        higiénicos, el solicitante deberá subsanarlas en un plazo máximo de un año calendario; de lo contrario, se
        tendrá por abandonado el trámite
        y se archivarán las diligencias, de conformidad al Art. 106 del Reglamento General de la Ley de Medicamentos.
    </p>-->
    <hr/>
    Blv. Merliot y Av. Jayaque, Edif. DNM, Urb. Jardines del Volcán, Santa Tecla, La Libertad, El Salvador, América
    Central.
    <br>PBX 2522-5000 / Correo: cosmeticos.higienicos@medicamentos.gob.sv / web: www.medicamentos.gob.sv
</footer>

</body>

</html>

