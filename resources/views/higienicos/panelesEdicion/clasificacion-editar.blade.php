<div class="tab-pane fade" id="class">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<form id="frmClasificacionHig">
						<div class="row">							
							<div class="col-xs-6 col-sm-6">
							   <label>Clasificación de Producto:</label>
							   <select class="form-control" id="clasSelect" name="clasSelect" required="true" value="{{$hig->idClasificacion}}">
							 			@foreach($clasificaciones as $clasi)								 
										    <option value="{{$clasi->idClasificacion}}" 
										    @if($clasi->idClasificacion==$hig->clasificacion->idClasificacion) 
										    	selected
										    @endif>{!!$clasi->nombreClasificacion!!}</option>		 
										@endforeach
							   </select>
							    <input type="hidden" class="form-control" name="idClas" id="idClas" value="{{$hig->idClasificacion}}">
							     <input type="hidden" class="form-control" name="nombreClas" id="nombreClas" value="{{$hig->clasificacion->nombreClasificacion}}">
							</div>	
							<div class="col-xs-6 col-sm-6">
							   <label>Uso:</label>							   
							    <input class="form-control" id="uso" value="{{$hig->uso}}">					     
							</div>
						</div>
						
								<br/>
							<button type="button" class="btn btn-success" id="clasificacionSave">Guardar</button>
						
					</form>
				</div>
			</div>
		</div>
</div>