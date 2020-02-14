<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Resolución {{$solicitud->numeroSolicitud}}</title>
    <style type="text/css">

      body{
        font-size: 14px;

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


    <header>
    <p align="right">C02-RS-02-DRS_CH.HER05</p>
    <table  style="width:100%;">
      <tr>
        <td style="width:15%;">
          <center>
            <img id="escudo" src="{{ url('img/escudo.png') }}" />
          </center>
        </td>
        <td style="width:70%;">
           <center>
                    <div id="mainTitle"><h1 class="opacityFont">Dirección Nacional de Medicamentos</h1>
                        <h2 class="opacityFontTwo">República de El Salvador, América Central</h2>
                        <h2 class="opacityFont">COSMÉTICOS E HIGIÉNICOS</h2>
                        <hr style="width:100% !important;">
                    </div>
                </center>
        </td>
        <td>
          <center>
            <img id="logo" src="{{ url('img/dnm.png') }}" />
          </center>
        </td>
    </table>
  </header>
    <main>
      <p style="margin: 30px; font-family: Times New Roman; text-align: right;">Santa Tecla, <b>{{$dias}}.</b></p>
      <p align="justify" style="margin: 30px; font-family: Times New Roman;">
      <strong>DIRECCIÓN NACIONAL DE MEDICAMENTOS:</strong> La Libertad, Santa Tecla, a las {{$fecha}}.<br><br>
      A sus antecedentes el escrito por el (la) <b>{{$profesional}}</b>, en su Calidad de Profesional Responsable del producto denominado <b>{{$solicitud->nombreComercial}}</b>, en el cual solicita <b>{{$solicitud->tramite->nombreTramite}}</b>.<br><br>
      En atención a solicitud No.<b>{{$solicitud->numeroSolicitud}}</b>, presentada visto por la Junta de Delegados en la sesión No.<b>{{$sesion->nombreSesion}}</b> realizada en fecha <b>{{$sesion->fechaSesion}}</b>, RESUELVE: No autorizar <b>{{$solicitud->tramite->nombreTramite}}</b> del producto denominado <b>{{$solicitud->nombreComercial}}</b>, por el siguiente motivo:
      </p>
      <p align="justify" style="margin: 30px; font-family: Times New Roman;">
        {{$dictamen->observaciones}}
      </p>
      <p align="justify" style="margin: 30px;">
        <b>INFÓRMESE AL REGULADO</b>, que queda expedito su derecho de incoar el recurso de reconsideración y/o de apelación en la instancia correspondiente, de conformidad a los artículos 132 y 134 de la Ley de Procedimientos Administrativos.
      </p>
      <p align="justify" style="margin: 30px; margin-top: 10px;">Atentamente,</p>
      <div align="center">
       @if(date("Y-m-d",strtotime($dictamen->fechaCreacion)) >= "2019-07-11")
                 DRA. MÓNICA GUADALUPE AYALA GUERRERO<br>DIRECTORA EJECUTIVA
        @else
                -<br>
                 SECRETARIO DE SESIONES DE LA JUNTA DE DELEGADOS
        @endif
      </div>
      <br>
    </main>
	   <footer id="footer" style="margin: 50px; font-family: Times New Roman;">
       ______________________________________________________________________________________________________
        Blv. Merliot y Av. Jayaque, Edif. DNM, Urb. Jardines del Volcán, Santa Tecla, La Libertad, El Salvador, América Central.
        &nbsp;&nbsp;
         PBX 2522-5000 / Correo: cosmeticos.higienicos@medicamentos.gob.sv / web: www.medicamentos.gob.sv
   	</footer>

  </body>

</html>

