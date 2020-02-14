@extends('master')

@section('css')

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
		 <form role="form" method="POST" action="{{route('saveFabExt')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<div class="group-control">
						<label>Nombre del fabricante:</label>
						<input type="text" name="nombre" class="form-control" required></input>
						<label>Dirección:</label>
						<input type="text" name="direccion" class="form-control" required></input>
						<label>Teléfono:</label>
						<input type="text" name="telefono" class="form-control" ></input>
						<label>Correo Electronico:</label>
						<input type="email" name="correoElectronico" class="form-control" ></input>
						<div class="group-control">
							<label> País: </label>
						   	<select class="form-control" id="pais" name="pais" required>
									@foreach($paises as $pais)										 
									    <option value="{{$pais->codigoId}}">{!!$pais->nombre!!}</option>
									@endforeach
							</select>
						</div>
					</div><br/>
				
				  				 
				<input type="submit" id="guardar" value="Guardar" class="btn btn-success" >	
				</div>
		 </form>
		</div>
	</div>
</div>
			

@endsection

@section('js')

@endsection