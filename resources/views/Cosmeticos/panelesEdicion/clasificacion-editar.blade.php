<div class="tab-pane fade" id="class">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<form id="frmClasificacionCos">
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label>Area de Aplicación:</label>
							    <input type="hidden" class="form-control" id="idArea" value="{{$cos->clasificacion->idArea}}">
							   <select class="form-control" id="area" name="area" required>
									@foreach($areas as $area)
										<option  value="{{$area->idAreaAplicacion}}" @if($cos->clasificacion->idArea==$area->idAreaAplicacion) selected="true" @endif >{!!$area->nombreArea!!}</option>
									@endforeach
								</select>

							</div>

							<div class="col-xs-6 col-sm-6">
							   <label>Clasificación de Producto:</label>
							   <select class="form-control cos" id="clas" name="class" required="true" value="{{$cos->idClasificacion}}">
							 	<option value="{{$cos->idClasificacion}}">{!!$cos->clasificacion->nombreClasificacion!!}</option>
							   </select>
							    <input type="hidden" class="form-control" id="idClas" value="{{$cos->idClasificacion}}">
							     <input type="hidden" class="form-control" id="nombreClas" value="{{$cos->clasificacion->nombreClasificacion}}">
							</div>	
						</div>
						<div class="row">	
							<div class="col-xs-6 col-sm-6">
							   <label>Forma Farmaceutica: </label>
							   <select class="form-control cos" id="forma" name="forma" required>
									<option value="{{$cos->idForma}}">{!!$cos->forma->nombreForma!!}</option>
							   </select>
							   </select>
							   <input type="hidden" class="form-control" id="idForma" value="{{$cos->idForma}}">
							   <input type="hidden" class="form-control" id="nombreClas" value="{{$cos->forma->nombreForma}}">
							</div>
						
							</div>
								<br/>
							<button type="button" class="btn btn-success" id="clasificacionSave">Guardar</button>
						
					</form>
				</div>
			</div>
		</div>
</div>