@extends('master')

@section('css')

@endsection

@section('contenido')

<div class="row">
		<div class="col-sm-12">
			<div class="the-box">
				<form role ="form" method="POST" action="{{route('guardarmarca')}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
				<div class="group-control">
				   <label> Nombre Marca: </label>
				   <input type="text" class="form-control" style="text-transform:uppercase;" name="nombre">
				</div>
				</br>
				<input type="submit" value="Guardar" class="btn btn-success">

				</form>
			</div>
		</div>
</div>
@endsection