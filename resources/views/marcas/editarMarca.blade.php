@extends('master')

@section('css')
</style>
@endsection

@section('contenido')

<div class="row">
		<div class="col-sm-12">
			<div class="the-box">
				<form role ="form" method="POST" action="{{route('actualizarmarca')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<input type="hidden" name="id" value="{{$marca->idMarca}}" class="form-control"/>
				<div class="group-control">
				   <label> Nombre Marca:</label>
				   <input type="text" class="form-control"  style="text-transform:uppercase;" name="nombre" value="{{$marca->nombreMarca}}">
				</div>
				<div class="group-control">
				   <label>Estado:</label>
				   <select class="form-control" name="estado">
				     @if($marca->estado=='A')
				   		<option value="A" selected="true">Activo</option>
				   		<option value="I" >Inactivo</option>
				  	 @else
				  		<option value="A">Activo</option>
				   		<option value="I" selected="true">Inactivo</option>
				     @endif
				    </select>
				</div>
				</br>
				<input type="submit" value="Guardar" class="btn btn-success">

				</form>
			</div>
		</div>
</div>
@endsection