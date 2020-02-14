<div class="tab-pane fade" id="class">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<form id="generalesCos">
						<div class="row">
					
							<div class="group-control">
							   <label>Area de Aplicación: </label>
							    <input type="hidden" class="form-control" name="idArea" value="{{$cos->clasificacion->area->idArea}}">
							   <input type="text" class="form-control" name="nombreArea" value="{{$cos->clasificacion->area->nombreArea}}" readonly="true">
							</div>

							<div class="group-control">
							   <label>Clasificación de Producto: </label>
							    <input type="hidden" class="form-control" name="idClas" value="{{$cos->clasificacion->idClasificacion}}">
							   <input type="text" class="form-control" name="nombreClas" value="{{$cos->clasificacion->nombreClasificacion}}" readonly="true" >
							</div>	

							<div class="group-control">
							   <label>Forma Farmaceutica: </label>
							    <input type="hidden" class="form-control" name="idForma" value="{{$cos->forma->idForma}}">
							   <input type="text" class="form-control" name="nombreClas" value="{{$cos->forma->nombreForma}}" readonly="true" >
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
</div>