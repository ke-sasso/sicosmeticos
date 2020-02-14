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
		 <form role="form" method="POST" action="{{route('guardar')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<div class="group-control">
						<label>Nombre de Clasificación:</label>
						<input type="text" name="nombre" style="text-transform:uppercase;" class="form-control"></input>
					</div></br>
				<div class="group-control">
					<label>Área de Aplicación a la que pertenece:</label>
					<select class="form-control" name="area">
						@foreach($areas as $area)
						<option value="{{$area->idAreaAplicacion}}">{!!$area->nombreArea!!}</option>
						@endforeach
					</select>
				</div>
				<div class="group-control">
				   <label>Posee:</label>
				</div>
					
						   <label class="checkbox-inline"><input type="checkbox" name="tono" value="1">TONO</label>
						   <label class="checkbox-inline"><input type="checkbox" name="fragancia"  value="1">FRAGANCIA</label>

				   <br/><br/>	
				 <div class="group-control">
				   <label>Formas Cosmeticas aplicables:</label>
				</div>
						@foreach($formas as $f)
						   <label class="checkbox-inline"><input type="checkbox" name="formas[]" value="{{$f->idForma}}">{!!$f->nombreForma!!}</label>
						@endforeach

				   <br/>  <br/>
				<input type="submit" id="guardar" value="Guardar" class="btn btn-success" >	
		 </form>
		</div>
	</div>
</div>
			

@endsection

@section('js')

@endsection