<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Resolución {{$solicitud->numeroSolicitud}}</title>
    <style type="text/css">

        body {

            font-family: 'times new roman' !important;
            font-size: 12px;

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
            margin: 35px;
            padding: 0;
        }

    </style>
</head>
<body>


<header>
    <p style="text-align: right; ">C02-RS-02-DRS_CH.HER04</p>
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
                        <h2 class="opacityFontTwo">República de El Salvador, América Central</h2>
                        <h2 class="opacityFont">COSMÉTICOS E HIGIÉNICOS</h2>
                        <hr style="width:100% !important;">
                    </div>
                </center>
            </td>
            <td style="width:15%;">
                <center>
                    <img id="logo" src="{{ url('img/dnm.png') }}" style="height: 80px; width: auto;"/>
                </center>
            </td>
        </tr>
    </table>
</header>
<div>
    <p align="right" style="margin: 50px;">Santa Tecla, <b>{{$dias}}.</b></p>
    <p class="alignp">
      <b>
      {{$profesional}}<br>
      Profesional responsable de productos <br>
      Propiedad de {{$titular}} <br>
      Presente.
      </b>
    </p>
    <p class="alignp">
        En referencia a solicitud No. <b>{{$solicitud->numeroSolicitud}}</b>, presentada para el
        trámite de <b>{{$solicitud->tramite->nombreTramite}}</b>, del producto
        <b>{{$solicitud->nombreComercial}}</b>,inscrito bajo el número de registro {{$solicitud->noRegistro}},
        por este medio se le informa que
        previo a resolver deberá solventar:
    </p>
    <p class="alignp">
        <?php echo $dictamen->observaciones?>
    </p>
    <p class="alignp">
        Infórmese al regulado que de acuerdo al artículo 72 de la Ley de Procedimientos Administrativos, deberán subsanar presentar los requisitos observados en un plazo máximo de diez días hábiles, posterior a la notificación de la presente, de lo contrario se archivaran diligencias sin más trámite y deberá ingresar nuevamente la solicitud, si fuere procedente conforme a la ley.<br>
        Notifíquese
    </p>
    <p class="alignp">Atentamente,</p>
    <div align="center">
        <p><b>Dr. Haryes Alfredo Funes Magaña</b></p>
        <p><b>Jefe de Registro de Dispositivos Médicos, Cosméticos e Higiénicos</b></p>
    </div>
    <p class="alignp"><p align="right" style="margin: 50px;"><b>{{Auth::User()->idUsuario}}</b></p></p>
</div>
<footer id="footer">
    <hr/>
    Blv. Merliot y Av. Jayaque, Edif. DNM, Urb. Jardines del Volcán, Santa Tecla, La Libertad, El Salvador, América
    Central.
    <br>PBX 2522-5000 / Correo: cosmeticos.higienicos@medicamentos.gob.sv / web: www.medicamentos.gob.sv
</footer>

</body>

</html>

