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
				<form role ="form" method="POST" action="{{route('guardarenvase')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<div class="group-control">
				   <label> Nombre Envase: </label>
				   <input type="text" class="form-control" style="text-transform:uppercase;" name="nombre">
				</div>
				
				<div class="group-control">
				   <label>Aplica para:</label>
						<div class="radio">
						   <label><input type="radio" name="aplica[]" value="1">Cosméticos</label>
						</div>
						<div class="radio">
						   <label><input type="radio" name="aplica[]"  value="2">Higiénicos</label>
						</div>
						<div class="radio">
						   <label><input type="radio" name="aplica[]" value="0">Ambos</label>
						</div>
				</div>
				<input type="submit" value="Guardar" class="btn btn-success">

				</form>
			</div>
		</div>
</div>






@endsection

@section('js')


@endsection