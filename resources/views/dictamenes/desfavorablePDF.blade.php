<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Resolución {{$data['numeroSolicitud']}}</title>
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
    <p style="text-align: right;">C02-RS-01-DRS_CH.HER05</p>
    <table  style="width:100%;">
      <tr>
        <td style="width:15%;">
          <center>
            <img id="escudo" src="{{ url('img/escudo.png') }}" />
          </center>
        </td>
        <td style="width:70%;">
          <center>
            <h3 style="margin:0;padding:0;">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dirección Nacional de Medicamentos &nbsp;&nbsp;
              <h4>&nbsp;&nbsp;&nbsp;República de El Salvador, América Central</h4>
             &nbsp;&nbsp;&nbsp;COSMÉTICOS E HIGIÉNICOS
            ______________________________________________
            </h3>
          </center>
        </td>
        <td>
          <center>
            <img id="logo" src="{{ url('img/dnm.png') }}" />
          </center>
        </td>
    </table>
  </header>
    <p align="right" style="margin-right: 30px;">Santa Tecla, <b>{{$data['dias']}}.</b></p>
      <p align="justify" style="margin: 30px; font-family: Times New Roman;">
      <strong>DIRECCIÓN NACIONAL DE MEDICAMENTOS:</strong> La Libertad, Santa Tecla, a las {{$data['fecha']}}.
    En atención a solicitud No. <b>{{$data['numeroSolicitud']}}</b>, presentada por {{$data['profesional'][0]->NOMBRE_PROFESIONAL}}, profesional responsable del producto {{$data['solicitud'][0]->nombreComercial}}, de titular {{$data['titular'][0]->nombre_propietario}}, para el trámite {{$data['tram'][0]->nombreTramite}}. Se INFORMA:
      </p>

        <ol type="I" align="justify" style="margin: 15px; font-family: Times New Roman;">
          <li>Que de conformidad al numeral 4.3 del <b>RTCA 71.01.35:06 PRODUCTOS COSMÉTICOS. REGISTRO E INSCRIPCIÓN SANITARIA DE PRODUCTOS COSMÉTICOS,</b> se define como producto cosmético “Toda sustancia o preparado destinado a ser puesto en contacto con las diversas partes superficiales del cuerpo humano (epidermis, sistemas piloso y capilar, uñas, labios y órganos genitales externos) o con los dientes y las mucosas bucales, con el fin exclusivo o principal de limpiarlos, perfumarlos, modificar su aspecto y/o corregir los olores corporales y/o protegerlos o mantenerlos en buen estado”.

        <li>Que de conformidad al numeral 3.10. del <b>RTCA 71.03.37:07 PRODUCTOS HIGIÉNICOS. REGISTRO E INSCRIPCION SANITARIA DE PRODUCTOS HIGIENICOS</b> se define como higiénico los “productos destinados a ser aplicados en objetos, utensilios, superficies y mobiliario que estén en contacto con las personas en viviendas, edificios e instalaciones públicas y privadas, industrias y otros lugares, usados con el fin de limpiar, desinfectar, desodorizar y aromatizar”.
      </ol>
   <p align="justify" style="margin: 30px; margin-top: 10px; ">
      Por lo tanto, con base en las razones antes expuestas y al dictamen técnico de carácter <b>DESFAVORABLE</b>, se RESUELVE: El producto {{$data['solicitud'][0]->nombreComercial}} NO CLASIFICA PARA EL REGISTRO SANITARIO COMO COSMÉTICO O HIGIENICO, por el siguiente motivo: {{$data['resolucion'][0]->observacion}}</p>
      <p align="justify" style="margin: 30px; margin-top: 10px;">Atentamente,</p>

      <div align="center">
            @if(date("Y-m-d",strtotime($data['resolucion'][0]->fechaCreacion)) >= "2019-07-11")
                 <p><strong>DRA. MÓNICA GUADALUPE AYALA GUERRERO<br/>DIRECTORA EJECUTIVA</strong>
            @else
                <p><strong>-</strong><br/>
               <strong>SECRETARIO DE SESIONES DE LA JUNTA DE DELEGADOS </strong></p>
            @endif
      </div>
      <br>
      <p align="right" style="margin: 30px;">{{Auth::User()->idUsuario}}</p>
    </main>
     <footer id="footer" style="margin: 50px; font-family: Times New Roman;">
       ______________________________________________________________________________________________________
        Blv. Merliot y Av. Jayaque, Edif. DNM, Urb. Jardines del Volcán, Santa Tecla, La Libertad, El Salvador, América Central.
        &nbsp;&nbsp;
         PBX 2522-5000 / Correo: cosmeticos.higienicos@medicamentos.gob.sv / web: www.medicamentos.gob.sv
    </footer>

  </body>

</html>

