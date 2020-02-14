<?php 
	$detalleSol = $solicitud->detallesolicitud;
 ?>
<div class="tab-pane fade" id="dictamen">
<div class="row">
		<div class="col-sm-12">
			<div class="the-box">
				<div class="row">
                    <div class="col-xs-6">
						<label>ID Solicitud</label>
						<input type="text" name="idSolicitud" class="form-control" value="{{$solicitud->idSolicitud}}" readonly="true">
					</div>
					<div class="col-xs-6">
						<label>Nombre del Trámite</label>
						<input type="text" name="tramite" class="form-control" value="{{$nomTram[0]->nombreTramite}}" readonly="true">
					</div>
                </div><br/>
                     <div class="row">
                         <div class="col-xs-6">
							<label>Nombre Comercial</label>
							<input type="text" name="nombreComercial" class="form-control" value="{{$detalleSol->nombreComercial}}" readonly="true">
						</div>
					<div class="col-xs-6">
						<label>Fecha de Recepción</label>
						<input type="text" name="fecha" class="form-control" value="{{$solicitud->created_at}}" readonly="true">
					</div>
                 </div>		
                
				<form role ="form" method="POST" action="{{route('guardarDictamen')}}">
					<input type="hidden" name="idSolicitud" value="{{$solicitud->idSolicitud}}"  class="form-control"/>
					<input type="hidden" name="_token" value="{{ csrf_token() }}"  class="form-control"/>
					<br/>
				
					<div class="panel panel-success">
                    	<div class="panel-heading">DICTAMEN</div>
                        	<div class="panel-body">
                        		<div class="table-responsive">		
									<table width="100%" style="font-size: 12px;" id="dt-insumos" class="table table-hover table-striped">
										<thead class="the-box dark full">
											<tr class="info">
												<th>REQUISITO</th>
												<th></th>
												<th>OPCIONES</th>											
												<th>OBSERVACIONES</th>
											</tr>
										</thead>
									<tbody>
										@foreach($items as $it)
												
												@if($it->apartadoRequisitos==$apartados[$c]->idApartado)
													<tr><td class="success" colspan="4"><strong>{!!$it->nombreApartado!!}</strong></td>	</tr>
												
													@if($c<count($apartados)-1)
														<!-{{$c=$c+1}}-->

													@else
														<!-{{$c=0}}--> 
													@endif
												@endif
										
											<tr>
												<td><strong>{!!$it->nombreItem!!}</strong></td>
												<th></th>
												<td>
													<select id="seleccion-{{ $it->idItemDictamen }}" class="form-control select" name="opcion[]" required="true">
													   		<option></option>
													   		<option value="0">NO CUMPLE</option>
													   		<option value="1">CUMPLE</option>
													   		<option value="2">NO APLICA</option>
													</select>
												</td>
												<td>
                                    			<textarea id="txt-[{{ $it->idItemDictamen }}]" class="form-control tx{{ $it->idItemDictamen }}" name="txtObservacion[]" readonly="true"></textarea>
                                    			<input type="hidden" name="items[]" value="{{ $it->idItemDictamen }}">
												</td>
											</tr>
										@endforeach
									</tbody>	
								</table>
							</div>	
						</div>
					</div>
					<input type="submit" value="Guardar" class="btn btn-success">
				</form>
			</div>
		</div>
</div>
</div> <!-- verifico que el index del arreglo de apartados para que no acceda a una posicion no existente