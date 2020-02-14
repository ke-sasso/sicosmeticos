<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<p>Se le notifica que:</p>
	<p>Su solicitud: # <b>{{$solicitud->numeroSolicitud}} - {{$solicitud->tipotramite->nombreTramite}}</b></p>
	<p>Presenta las siguientes observaciones: </p>
	<br>
	@foreach($observaciones as $obs)
		<p style='margin-left: 2em'>- <b>{{$obs->nombreItem}}:</b> {{$obs->observaciones}}</p>		
	@endforeach
<br>	
<p>Favor ingresar al <a href="http://portalenlinea.medicamentos.gob.sv/">Portal en linea</a> y corregir las observaciones de su solicitud.</p>
</body>
</html>