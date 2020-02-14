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
				<form role ="form" method="POST" action="{{route('savesustancias')}}" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<div class="group-control">
				   <label> Nombre Sustancia: </label>
				   <input type="text" class="form-control" style="text-transform:uppercase;" name="nombre" required="true">
				</div>
				<div class="group-control">
				   <label> Número CAS: </label>
				   <input type="text" class="form-control" style="text-transform:uppercase;" name="cas">
				</div>
				<div class="group-control">
				   <label> Sustancia para:</label>
				</div>
					
						   <label class="checkbox-inline"><input type="checkbox" name="tipo" value="0">PRODUCTOS HIGIENICOS</label>
						   <label class="checkbox-inline"><input type="checkbox" name="tipo"  value="1">PRODUCTOS COSMETICOS</label>

				   <br/><br/>	

				<br/>
				<input type="submit" value="Guardar" class="btn btn-success">

				</form>
			</div>
		</div>
</div>
@endsection

@section('js')


@endsection