<div class="tab-pane fade in active" id="generales">
	<div class="panel-body">
		<div class="the-box full no-border">
			<div class="container-fluid">
				<form id="frmGeneralesCos">
					 <input type="hidden" class="form-control" value="{{$clasificacionProd}}" id="clasificacionProducto">
					 <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label> Número de Registro: </label>
							   <input type="text" class="form-control" name="idCosmetico" value="{{$cos->idCosmetico}}" id="idCosmetico" readonly="true">
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label> Tipo: </label>
							   <input type="text" class="form-control" name="tipo" value="{{$cos->tipoProducto}}" id="tipo" readonly="true">
							    <input type="hidden" class="form-control" name="idtipo" value="{{$cos->tipo}}" id="idtipo">
							</div>
						</div><br/>
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label> Nombre Comercial: </label>
							   <input type="text" class="form-control" name="nombreComercial" value="{{$cos->nombreComercial}}" id="nombreComercial">
							</div>
							<div class="col-xs-6 col-sm-6">
								   <label> País de Origen: </label>
								   <select class="form-control chosen-select" id="idPais" name="idPais" required>
										@foreach($allPaises as $paisCA)
										    <option value="{{$paisCA->codigoId}}"
										    @if($paisCA->codigoId==$cos->idPaisOrigen)
										    	selected
										    @endif>{!!$paisCA->nombre!!}</option>
										@endforeach
									</select>
							</div>

							{{--
							@if($cos->tipo==2)
								<div class="col-xs-6 col-sm-6">
								   <label> País de Origen: </label>
								   <select class="form-control" id="idPais" name="idPais" required>
										@foreach($paises as $paisCA)
										    <option value="{{$paisCA->codigoId}}"
										    @if($paisCA->codigoId==$cos->idPaisOrigen)
										    	selected
										    @endif>{!!$paisCA->nombre!!}</option>
										@endforeach
									</select>
								</div>
							@else
								<div class="col-xs-6 col-sm-6">
									<label> País de Origen: </label>
									<input type="hidden" class="form-control" name="idPais" value="{{$cos->idPaisOrigen}}" id="idPais" readonly="true">
								   <input type="text" class="form-control" name="pais" value="{{$pais->nombre}}" id="pais" readonly="true">
								</div>
							@endif
								--}}
						</div><br/>
							@if($cos->tipo==2)
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label> Número de Registro en el pais de Origen: </label>
							   <input type="text" class="form-control" name="numeroReconocimiento" value="{{$cos->numeroReconocimiento}}" id="numeroReconocimiento">
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label> Fecha de Vencimiento del Reconocimiento: </label>
							   <input  class="form-control datepicker" name="fechaVencimiento" value="{{$cos->VencimientoRec}}" id="fechaVen">
							</div>
						</div><br/>
						@endif
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label>Fecha Vigencia: </label>
							   <input type="text" class="form-control datepicker" name="vigenciaHasta" value="{{$cos->vigenciaHasta}}" id="vigenciaHasta">
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label>Fecha Renovación:</label>
							   <input type="text" class="form-control datepicker" name="renovacion" value="{{$cos->renovacion}}" id="renovacion">
							</div>
						</div><br/>
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label>Estado: </label>
									<select class="form-control" name="estado" id="estado">

											<option value="A" @if($cos->estado=='ACTIVO') selected="true" @endif >Activo</option>
											<option value="I" @if($cos->estado=='INACTIVO') selected="true" @endif>Inactivo</option>
									</select>
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label>Actualizar:</label>
									<select class="form-control" name="actualizado" id="actualizado">

											<option value="A" @if($cos->actualizado=='A') @endif >Actualizado</option>
											<option value="I" @if($cos->actualizado=='I' || $cos->actualizado=='N') selected="true" @endif>Incompleto</option>
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
