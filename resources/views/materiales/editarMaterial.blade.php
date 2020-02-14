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
				<form role ="form" method="POST" action="{{route('actualizarmaterial')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<input type="hidden" name="id" value="{{$material->idMaterial}}" class="form-control"/>
				<div class="group-control">
				   <label> Nombre Material: </label>
				   <input type="text" class="form-control" style="text-transform:uppercase;" value="{{$material->material}}" name="nombre">
				</div>
				<div class="group-control">
				   <label>Estado:</label>
				   <select class="form-control" name="estado">
				     @if($material->estado=='A')
				   		<option value="A" selected="true">Activo</option>
				   		<option value="I" >Inactivo</option>
				  	 @else
				  		<option value="A">Activo</option>
				   		<option value="I" selected="true">Inactivo</option>
				     @endif
				    </select>
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