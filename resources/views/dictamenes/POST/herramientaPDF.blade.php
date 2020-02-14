<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title> </title>
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

      .info{
      	background-color:#BEBBBA;
      }
    </style>
  </head>
  <body>


    <header>
    <table  style="width:100%;">
      <tr>
        <td style="width:15%;">
          <center>
            <img id="escudo" src="{{ url('img/escudo.png') }}" />
          </center>
        </td>
        <td style="width:70%;">
          <center>
            <h2 style="margin:0;padding:0;">
              &nbsp;&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dirección Nacional de Medicamentos &nbsp;&nbsp;
              <p>
              &nbsp;&nbsp;&nbsp;República de El Salvador, América Central&nbsp;&nbsp;
             </p>
              <strong>COSMETICOS</strong>
              ___________________________________________________________
            </h2>
          </center>
        </td>
        <td>
          <center>
            <img id="logo" src="{{ url('img/dnm.png') }}" />
          </center>
        </td>
    </table>
    </header>
    <table border="2px" cellspacing="1px" cellpadding="4px" width="100%">
        <thead>
			<tr class="info">
			<th>NO. SOLICITUD</th>
			<th>FECHA DE RECEPCION</th>
			<th>NOMBRE DEL TRAMITE</th>
      <th>No. REGISTRO</th>
			</tr>

		</thead>
		<tbody>
			<tr>
				<td>{{$solicitud->numeroSolicitud}}</td>
				<td>{{$solicitud->fechaCreacion}}</td>
				<td>{{$solicitud->tramite->nombreTramite}}</td>
        <td>{{$solicitud->noRegistro}}</td>

			</tr>
			<tr class="info">
				<th colspan="4">NOMBRE COMERCIAL</th>
			</tr>
			<tr>
				<td colspan="4">{{$solicitud->nombreComercial}}</td>
			</tr>
		</tbody>
	</table>

    <table border="2px" cellspacing="1px" cellpadding="4px" width="100%">
        <thead>
			<tr class="info">
				<th>REQUISITO</th>
				<th>OPCIONES</th>
				<th>OBSERVACIONES</th>
			</tr>
		</thead>
		<tbody>
		@foreach($dictamen->detalles as $d)
				<tr>
					<td>{{$d->requisito->nombreRequisito}}</td>
          @if($d->opcion==1)
            <td style="text-align: center;">CUMPLE</td>
          @elseif($d->opcion==0)
            <td style="text-align: center;">NO CUMPLE</td>
          @else
            <td style="text-align: center;">NO APLICA</td>
          @endif
					<td><?php echo $d->observacion?></td>
        </tr>
		@endforeach
		</tbody>
	</table>
	<br/>
	 <table border="2px" cellspacing="1px" cellpadding="4px" width="100%">
        <thead>
        	<tr class="info">
					<th>RESOLUCION</th>
					<th>FECHA DE REVISION</th>
			</tr>

		</thead>
		<tbody>
			<tr>
				<td>{{$dictamen->estado->estado}}</td>
				<td>{{$dictamen->fechaCreacion}}</td>
			</tr>
			<tr class="info" rowspan="3">
					<th>ELABORACION DE LA REVISIÓN</th>
					<th>COMENTARIOS</th>
			</tr>
			<tr>
				<td>{{$dictamen->usuarioCreacion}}</td>
				<td align="left"><?php echo $dictamen->observaciones?></td>

			</tr>
		</tbody>
	</table>

	</main>

	   <footer id="footer">

   		</footer>

  </body>

</html>

