
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Notificaci&oacute;n</title>
    <style type="text/css">

      body{
        font-size: 12px;
        font-style: 'times new roman';
      }

    #wrap {
      float: center;
      position: relative;
      left: 35%;
    }

    .parrafo1{
    	display: inline;
    }

    #content {
        float: center;
        position: relative;
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
        border: 1px solid black;
      }

      #firma{
        height: auto;
        width: auto;
        max-width: 400px;
        max-height: 800px;

      }
    </style>
  </head>
  <body>
    <header>
      <table class="table" width="100%">
        <thead>
          <tr>
            <th style="width:15%;">

            </th>
            <th style="width:100%;">
              <div align="right">

              </div>
              <center>
                  <h2 style="margin:0;padding:0;font: Times New Roman;font-size: 15;">
                    <strong>Dirección Nacional de Medicamentos</strong>
                    <p style="font-size: 11">República de El Salvador, América Central</p>

                    ___________________________________________________________
                  </h2>
              </center><br><br>
            </th>
            <th>

            </th>
          </tr>
        </thead>
      </table>
    </header>

    <section>
      <div class="row">
        <p>Saludos Cordiales.</p>
        <p>Su solicitud No. <b>{{$solicitud->numeroSolicitud}}</b> con nombre comercial <b>{{$solicitud->nombreComercial}}</b>, presenta las siguientes observaciones:</p>
        <p>{{$observacion}}</p>
        <p>Feliz día.</p>
        <p><small>*No conteste. Este es un correo autogenerado.</small></p>
      </div>
    </section>

  	<footer id="footer">
      <center>
    	_________________________________________________________________________________________________________________________<br>
      Blv. Merliot y Av. Jayaque, Edif. DNM, Urb. Jardines del Volcán, Santa Tecla, La Libertad, El Salvador, América Central.
      <br>PBX 2522-5000 / Correo: cosmeticos.higienicos@medicamentos.gob.sv / web: www.medicamentos.gob.sv
      <center>
  	</footer>
   </body>

</html>