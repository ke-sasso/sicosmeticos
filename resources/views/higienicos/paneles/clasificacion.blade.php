<div class="tab-pane fade" id="classh">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<form id="clash">
						<div class="row">
					
							<div class="group-control">
							   <label>Clasificación de Producto: </label>
							    <input type="hidden" class="form-control" name="idClas" value="{{$hig->clasificacion->idClasificacion}}">
							   <input type="text" class="form-control" name="nombreClas" value="{{$hig->clasificacion->nombreClasificacion}}" readonly="true" >
							</div>	
							<div class="group-control">
							   <label>Uso: </label>
							   <input type="text" class="form-control" name="uso" value="{{$hig->uso}}" id="uso" readonly="true">
							</div>	
						</div>
					</form>
				</div>
			</div>

		</div>
</div>