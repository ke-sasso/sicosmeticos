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
				<form role ="form" method="POST" action="{{route('actualizarenvase')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<input type="hidden" name="id" value="{{$envase->idEnvase}}" class="form-control"/>
				<div class="group-control">
				   <label> Nombre Envase:</label>
				   <input type="text" class="form-control" name="nombre" style="text-transform:uppercase;" value="{{$envase->nombreEnvase}}">
				</div>
				
				<div class="group-control">
				   <label>Aplica para:</label>
				    @if($envase->aplicaPara==1)
						<div class="radio">
						   <label><input type="radio" name="aplica[]" value="1" checked="true">Cosméticos</label>
						</div>
						<div class="radio">
						   <label><input type="radio" name="aplica[]"  value="2">Higiénicos</label>
						</div>
						<div class="radio">
						   <label><input type="radio" name="aplica[]" value="0">Ambos</label>
						</div>
					@elseif($envase->aplicaPara==2)
						<div class="radio">
						   <label><input type="radio" name="aplica[]" value="1">Cosméticos</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="aplica[]"  value="2" checked="true">Higiénicos</label>
						</div>
						<div class="radio">
						   <label><input type="radio" name="aplica[]" value="0">Ambos</label>
						</div>
					@else
						<div class="radio">
						   <label><input type="radio" name="aplica[]" value="1">Cosméticos</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="aplica[]"  value="2" checked="true">Higiénicos</label>
						</div>
						<div class="radio">
						   <label><input type="radio" name="aplica[]" value="0" checked="true">Ambos</label>
						</div>
					@endif
				</div>
				<div class="group-control">
				   <label>Estado:</label>
				 
				   <select class="form-control" name="estado">
				     @if($envase->estado=='A')
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