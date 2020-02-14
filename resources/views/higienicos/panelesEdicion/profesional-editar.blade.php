
	<div class="tab-pane fade" id="profesional">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<form id="frmProfesional">
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label>Poder Profesional: </label>
							   <input type="hidden" class="form-control" name="idPoderprof" value="{{$pro[0]->ID_PODER}}" id="idPoderprof" readonly="true">
							   <select class="form-control input-sm" name="idPoderprof" value="" id="ID_PODER" placeholder="Buscar por número de Poder:" required>
							   </select>
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label>Identificador Profesional:</label>
							   <input type="text" class="form-control" name="idProfesional" value="{{$pro[0]->ID_PROFESIONAL}}" id="idProfesional" readonly="true">
							</div>
						</div>
						<div class="row">	
							<div class="col-xs-6 col-sm-12">
							   <label>Nombre Profesional: </label>
							   <input type="text" class="form-control" name="nombreProfesional" value="{{$pro[0]->NOMBREPROF}}" id="nombreProfesional" readonly="true">
							</div>
						</div><br/>
						<div class="row">
							
							<div class="col-xs-6 col-sm-6">
							   <label>Telefono de Contacto: </label>
							   <input type="text" class="form-control" name="telefonoProf" value="{{$pro[0]->TELEFONO_1}}" id="telefonoProf" readonly="true">
						
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label>Email de Contacto: </label>
							   <input type="text" class="form-control" name="emailprof" value="{{$pro[0]->EMAIL}}" id="emailprof" readonly="true">
						
							</div>
						
						</div> <br>
						<button type="button" class="btn btn-success" id="profesionalSave">Guardar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
