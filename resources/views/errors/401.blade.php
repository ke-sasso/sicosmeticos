<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="Unidad de Informática">
		<link href="{{{ asset('img/favicon.ico') }}}" rel="shortcut icon">
		<title>DNM | 401</title>
 
		<!-- BOOTSTRAP CSS (REQUIRED ALL PAGE)-->
		{!! Html::style('css/bootstrap.min.css') !!} 
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		{!! Html::style('plugins/font-awesome/css/font-awesome.min.css') !!} 
		{!! Html::style('css/style.css') !!} 
		{!! Html::style('css/style-responsive.css') !!} 
 
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			body{
				background-image: url("{{asset('img/bg_login.png')}}" );
			}
			.login-wrapper{
				max-width: 600px;
				margin: 0 auto 0 50px auto 0;
			}
		</style>
	</head>
 
	<body class="tooltips"  >
		
		<!--
		===========================================================
		BEGIN PAGE
		===========================================================
		-->
		<div class="login-header text-center">
			
			{!! Html::image('img/seguridad.png','',['class'=>'logo','alt'=>'Logo ADE']) !!}
		</div>
		<div class="login-wrapper" align="center">
			
			<h3 style="color: #FFF000; font-weight: bold;">4<i class="fa fa-meh-o icon-md" ></i>1</h3>

			<p class="text-center text-warning"><h2 style="color: #fff; background-color: #0d3625"><strong>No posee los privilegios {{$permissions}} para realizar esta acción</strong></h2></p>
			
			<p class="text-center"><h2><strong><a href="{{ url('/inicio/') }}" class="btn btn-info btn-perspective">Regresar al Inicio</a></strong></h2></p>
		</div><!-- /.login-wrapper -->
		<!--
		===========================================================
		END PAGE
		===========================================================
		-->

		<!--
		===========================================================
		Placed at the end of the document so the pages load faster
		===========================================================
		-->
		<!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		{!! Html::script('js/jquery.min.js') !!}
		{!! Html::script('js/bootstrap.min.js') !!}
		
	</body>
</html>