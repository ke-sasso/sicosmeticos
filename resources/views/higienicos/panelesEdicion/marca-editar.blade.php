<div class="tab-pane fade" id="marca">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<form id="generalesHig">
						<div class="row">

							<div class="group-control">
							   <label> Nombre Marca: </label>
							   <select class="form-control" id="marcaSelect" name="marcaSelect" required>
										@foreach($marcas as $marc)										 
										    <option value="{{$marc->idMarca}}" 
										    @if($marc->idMarca==$hig->marca->idMarca) 
										    	selected 
										    @endif>{!!$marc->nombreMarca!!}</option>		 
										@endforeach
								</select>
							    <input type="hidden" class="form-control" name="marca" id="idMarca" value="{{$hig->idMarca}}">
							   <input type="hidden" class="form-control" name="nombreMarca" id="nombreMarca" value="{{$hig->marca->nombreMarca}}">
							</div>

								<button type="button" class="btn btn-success" id="marcaSave">Guardar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
</div>