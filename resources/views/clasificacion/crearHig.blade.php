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
		 <form role="form" method="POST" action="{{route('guardarClasHig')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<div class="group-control">
						<label>Nombre de Clasificación:</label>
						<input type="text" name="nombre" style="text-transform:uppercase;" class="form-control"></input>
					</div><br/>
				
				   <label>Posee:</label>
				
					
						   <label class="checkbox-inline"><input type="checkbox" name="tono" value="1">TONO</label>
						   <label class="checkbox-inline"><input type="checkbox" name="fragancia"  value="1">FRAGANCIA</label>

				   <br/><br/>	
				 
				<input type="submit" id="guardar" value="Guardar" class="btn btn-success" >	
				</div>
		 </form>
		</div>
	</div>
</div>
			

@endsection

@section('js')

@endsection