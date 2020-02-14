@extends('master')

@section('css')
</style>
@endsection

@section('contenido')

@if(Session::has('message'))
<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{Session::get('message')}}
</div>
@endif

<div class="row">
		<div class="col-sm-12">
			<div class="the-box">
				<form role ="form" method="POST" action="{{route('guardararea')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<div class="group-control">
				   <label> Nombre Área de Aplicación:</label>
				   <input type="text" style="text-transform:uppercase;" class="form-control" name="nombre">
				</div>
				<br/>
				<input type="submit" value="Guardar" class="btn btn-success">

				</form>
			</div>
		</div>
</div>


@endsection

@section('js')


@endsection