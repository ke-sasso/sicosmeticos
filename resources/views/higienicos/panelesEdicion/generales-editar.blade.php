<div class="tab-pane fade in active" id="generales">
	<div class="panel-body">
		<div class="the-box full no-border">
			<div class="container-fluid">
				<form id="frmGeneralesHig">
					 <input type="hidden" class="form-control" value="{{$clasificacionProd}}" id="clasificacionProducto">
					 <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label> Número de Registro: </label>
							   <input type="text" class="form-control" name="idHigienico" value="{{$hig->idHigienico}}" id="idHigienico" readonly="true">
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label> Tipo: </label>
							   <input type="text" class="form-control" name="tipo" value="{{$hig->tipoProducto}}" id="tipo" readonly="true">
							    <input type="hidden" class="form-control" name="idtipo" value="{{$hig->tipo}}" id="idtipo">
							</div>
						</div><br/>
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label> Nombre Comercial: </label>
							   <input type="text" class="form-control" name="nombreComercial" value="{{$hig->nombreComercial}}" id="nombreComercial">
							</div>
								<div class="col-xs-6 col-sm-6">
								   <label> País de Origen: </label>
								   <select class="form-control chosen-select" id="idPais" name="idPais" required>
										@foreach($paises as $paisCA)
										    <option value="{{$paisCA->codigoId}}"
										    @if($paisCA->codigoId==$hig->idPaisOrigen)
										    	selected
										    @endif>{!!$paisCA->nombre!!}</option>
										@endforeach
									</select>
								</div>


						</div><br/>
							@if($hig->tipo==2)
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label> Número de Registro en el pais de Origen: </label>
							   <input type="text" class="form-control" name="numeroReconocimiento" value="{{$hig->numeroReconocimiento}}" id="numeroReconocimiento">
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label> Fecha de Vencimiento del Reconocimiento: </label>
							   <input  class="form-control datepicker" name="fechaVencimiento" value="{{$hig->VencimientoRec}}" id="fechaVen">
							</div>
						</div><br/>
						@endif
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label>Fecha Vigencia: </label>
							   <input type="text" class="form-control datepicker" name="vigenciaHasta" value="{{$hig->vigenteHasta}}" id="vigenteHasta">
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label>Fecha Renovación:</label>
							   <input type="text" class="form-control datepicker" name="renovacion" value="{{$hig->renovacion}}" id="renovacion">
							</div>
						</div><br/>
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label>Estado: </label>
									<select class="form-control" name="estado" id="estado">

											<option value="A" @if($hig->estado=='ACTIVO') selected="true" @endif >Activo</option>
											<option value="I" @if($hig->estado=='INACTIVO') selected="true" @endif>Inactivo</option>
									</select>
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label>Actualizar:</label>
									<select class="form-control" name="actualizado" id="actualizado">

											<option value="A" @if($hig->actualizado=='A') selected="true" @endif >Actualizado</option>
											<option value="I" @if($hig->actualizado=='I') selected="true" @endif>Incompleto</option>
											<option value="N" @if($hig->actualizado=='N') selected="true" @endif>No Actualizado</option>
									</select>
							</div>
						</div>
						<br/>
							<button type="button" class="btn btn-success" id="generalesSave">Guardar</button>
							<br/>
				</form>
			</div>
		</div>
	</div>
</div>
