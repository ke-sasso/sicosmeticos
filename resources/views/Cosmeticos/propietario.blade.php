
	<div class="tab-pane fade" id="propietario">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<form id="generalesCos">
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
							   <input type="text" class="form-control" name="telefono" value="{{$pp->telefonosContacto}}" id="telefono" readonly="true">
							</div>
							
						</div>
					
					</form>
				</div>
			</div>
		</div>
	</div>
