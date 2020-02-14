
	<div class="tab-pane fade" id="propietario">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<form id="generalesCos">
						@if($pp==null)
							<div class="row">
								<div class="alert alert-warning" role="alert">
									Este producto no posee titular
								</div>
							</div>
						@else
							@if(isset($pp->ACTIVO))
								@if($pp->ACTIVO=='I')
									<div class="row">
										<div class="alert alert-danger" role="alert">
											El titular de este producto se encuentra inactivo!!
										</div>
									</div>
								@endif
							@endif

							<div class="row">
								<div class="group-control">
								   <label>Identificador Titular:</label>
								   <input type="text" class="form-control" name="idTitular" value="{{$pp->idPropietario}}" id="idTitular" readonly="true">
								</div>
								<div class="group-control">
								   <label>Nombre Titular: </label>
								   <input type="text" class="form-control" name="nombreTitular" value="{{$pp->nombre}}" id="nombreTitular" readonly="true">
								</div>
								<div class="group-control">
								   <label>Dirección: </label>
								   <input type="text" class="form-control" name="direccion" value="{{$pp->direccion}}" id="direccion" readonly="true">
								</div>
								<div class="group-control">
								   <label>Email: </label>
								   <input type="text" class="form-control" name="email" value="{{$pp->emailsContacto}}" id="email" readonly="true">
								</div>
								<div class="group-control">
								   <label>Telefono de Contacto: </label>
								   <input type="text" class="form-control" name="telefono" value="{{json_decode($pp->telefonosContacto)[0]}}" id="telefono" readonly="true">
								</div>



							</div>
						@endif
					</form>
				</div>
			</div>
		</div>
	</div>
