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
		 <form role="form" method="POST" action="{{route('actualizar')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<input type="hidden" name="id" value="{{ $clas->idClasificacion }}" class="form-control"/>
				<div class="group-control">
				<label>Nombre de Clasificación:</label>
				<input type="text" name="nombre" class="form-control" style="text-transform:uppercase;" value="{{$clas->nombreClasificacion}}"></input>
				</div></br>
				<div class="group-control">
				<label>Área de Aplicación a la que pertenece:</label>
				<select class="form-control" name="area">
					@foreach($areas as $area)
						@if($clas->idArea==$area->idAreaAplicacion)
						<option value="{{$area->idAreaAplicacion}}" selected="true">{!!$area->nombreArea!!}</option>
						@else
						<option value="{{$area->idAreaAplicacion}}">{!!$area->nombreArea!!}</option>
						@endif
					@endforeach
				</select>
				</div>
				<div class="group-control"><br/>
				   <label>Posee:</label>
				</div>
						@if($clas->poseeTono==1&&$clas->poseeFragancia==1)
						<div class="checkbox">
						   <label><input type="checkbox" name="tono" value="1" checked="true">Tono</label>
						</div>
						<div class="checkbox">
						   <label><input type="checkbox" name="fragancia"  value="1" checked="true">Fragancia</label>
						</div>
						@elseif ($clas->poseeTono==1&&$clas->poseeFragancia==0)
						<div class="checkbox">
						   <label><input type="checkbox" name="tono" value="1" checked="true">Tono</label>
						</div>
						<div class="checkbox">
						   <label><input type="checkbox" name="fragancia"  value="1">Fragancia</label>
						</div>
						@elseif($clas->poseeTono==0&&$clas->poseeFragancia==1)
						<div class="checkbox">
						   <label><input type="checkbox" name="tono" value="1">Tono</label>
						</div>
						<div class="checkbox">
						   <label><input type="checkbox" name="fragancia"  value="1" checked="true">Fragancia</label>
						</div>
						@else
						<div class="checkbox">
						   <label><input type="checkbox" name="tono" value="1">Tono</label>
						</div>
						<div class="checkbox">
						   <label><input type="checkbox" name="fragancia"  value="1">Fragancia</label>
						</div>
						@endif
				<br/>
				<div class="group-control">
				   <label>Estado:</label>
				 
				   <select class="form-control" name="estado">
				     @if($clas->estado=='A')
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