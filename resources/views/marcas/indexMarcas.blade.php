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

	<div class="panel-body">		  
		<div class="table-responsive">		
			<table width="100%" style="font-size: 12px;" id="dt-insumos" class="table table-hover table-striped">
				<thead class="the-box dark full">
					<tr>
						<th>Identificador</th>
						<th>Nombre Marca</th>
						<th>Estado</th>
						<th>Opciones</th>
					</tr>
				</thead>
			<tbody>
				@foreach($marcas as $marca)
				    <tr>
				    	<td>{!!$marca->idMarca!!}</td>
				    	<td>{!!$marca->nombreMarca!!}</td>
				    	@if($marca->estado=='A')
				    		<td>Activo</td>
				    	@else
				    	 	<td>Inactivo</td>
				    	@endif
				    	<td>{!!link_to_route('editarmarca', $title = "Editar", $parameters = $marca->idMarca, $attributes = ['class'=>'btn btn-info'])!!}
</td>
				    </tr>
				@endforeach
			</tbody>	
		</table>
		{!!link_to_route('crearmarca', $title = "Crear Marca", $parameters = null, $attributes = ['class'=>'btn btn-success'])!!}

	</div>
</div>
@endsection

@section('js')


@endsection