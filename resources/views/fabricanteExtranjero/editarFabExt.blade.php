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
		 <form role="form" method="POST" action="{{route('actualizarFabExt')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<input type="hidden" name="idFabricanteExtranjero" value="{{$fabExt->idFabricanteExtranjero}}" class="form-control"/>
				<div class="group-control">
						<label>ID Fabricante:</label>
						<input type="text" name="id" class="form-control" value="{{$fabExt->idFabricanteExtranjero}}" readonly></input>	
						<label>Nombre del fabricante:</label>
						<input type="text" name="nombre" class="form-control" value="{{$fabExt->nombreFabricante}}" required></input>
						<label>Dirección:</label>
						<input type="text" name="direccion" class="form-control" value="{{$fabExt->direccion}}" required></input>
						<label>Teléfono:</label>
						<input type="text" name="telefono" class="form-control" value="{{$fabExt->telefonos}}" ></input>
						<label>Correo Electronico:</label>
						<input type="email" name="correoElectronico" class="form-control" value="{{$fabExt->correoElectronico}}" ></input>
						<div class="group-control">
							<label> País: </label>
						   	<select class="form-control" id="pais" name="pais" required>
									@foreach($paises as $pais)										 
									    <option value="{{$pais->codigoId}}"
									   @if($fabExt->codigoIdPais==$pais->codigoId)
									   selected 
									   @endif>{!!$pais->nombre!!}</option>
									@endforeach
							</select>
						</div>
						<div class="group-control">
						   <label>Estado:</label>						 
						   	<select class="form-control" name="estado">
							     @if($fabExt->estado=='A')
							   		<option value="A" selected="true">Activo</option>
							   		<option value="I" >Inactivo</option>
							  	 @else
							  		<option value="A">Activo</option>
							   		<option value="I" selected="true">Inactivo</option>
							     @endif
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