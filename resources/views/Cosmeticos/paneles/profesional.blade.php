
	<div class="tab-pane fade" id="profesional">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					
						<div class="row">
							<div class="group-control">
							   <label>Identificador Profesional:</label>
							   <input type="text" class="form-control" name="idProfesional" value="{{$pro[0]->ID_PROFESIONAL}}" id="idTitular" readonly="true">
							</div>
							<div class="group-control">
							   <label>Nombre Profesional: </label>
							   <input type="text" class="form-control" name="nombre" value="{{$pro[0]->NOMBREPROF}}" id="nombreTitular" readonly="true">
							</div>
							<div class="group-control">
							   <label>Poder Profesional: </label>
							   <input type="text" class="form-control" name="idPoder" value="{{$pro[0]->ID_PODER}}" id="nombreTitular" readonly="true">
							</div>
							<div class="group-control">
							   <label>Telefono: </label>
							   <input type="text" class="form-control" name="direccion" value="{{$telPro}}" id="direccion" readonly="true">
							</div>
							<div class="group-control">
							   <label>Email: </label>
							   <input type="text" class="form-control" name="email" value="{{$pp[0]->email}}" id="EMAIL" readonly="true">
							</div>
						
						</div>
					
				</div>
			</div>
		</div>
	</div>
