	<div class="tab-pane fade" id="propietario">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<form id="frmPropietario">
						<div class="row">
							<div class="col-xs-6 col-sm-4">
							   <label>Identificador Titular:</label>
							   <input type="text" class="form-control" name="idTitular" value="{{$pp->idPropietario}}" id="idTitular" readonly="true">
							</div>
							<input type="hidden" id="titularTipo" name="titularTipo" value="">
							<div class="col-xs-6 col-sm-2">
								<br>
								<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalPropietario" id="buscarPropietario"><i class="fa fa-search"></i></a>
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label>Nombre Titular: </label>
							   <input type="text" class="form-control" name="nombreTitular" value="{{$pp->nombre}}" id="nombreTitular" readonly="true">
							</div>
						</div>
						
						<div class="row">
						@if($pp->tipoTitular!=3)
							<div class="col-xs-6 col-sm-6">
							   <label>NIT: </label>
							   <input type="text" class="form-control" name="nit" value="{{$pp->nit}}" id="nit" readonly="true">
							</div>
						@endif
							<div class="col-xs-6 col-sm-6">
							   <label>Email: </label>
							   <input type="text" class="form-control" name="email" value="{{$pp->emailsContacto}}" id="email" readonly="true">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label>País: </label>
							   <input type="text" class="form-control" name="paisTitular" value="" id="paisTitular" readonly="true">
							</div>
							
							<div class="col-xs-6 col-sm-6">
							   <label>Telefono de Contacto: </label>
							   <input type="text" class="form-control" name="telefono" value="{{json_decode($pp->telefonosContacto)[0]}}" id="telefono" readonly="true">
							</div>
							
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-12">
							   <label>Dirección: </label>
							   <textarea type="text" class="form-control" name="direccion"  id="direccion" readonly="true">{!!$pp->direccion!!}</textarea>
							</div>
						</div>
						<br>
						<button type="button" class="btn btn-success" id="propietarioSave">Guardar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- modal propietario-->
<div id="modalPropietario" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" align="center">
         
          <button type="button" class="close" data-dismiss="modal">&times;</button>
              <b><h3 class="modal-title" align="center">Búsqueda de Propietarios </h3></b>
          <div class="modal-body">
	         <div class="group-control" id="tipoTitular">
				<input type="radio" name="tipoT" value="1"> Nacional Natural
				<input type="radio" name="tipoT" value="2"> Nacional Jurídico
				<input type="radio" name="tipoT" value="3"> Extranjero
			</div><br/>

            <div class="form-group" align="center">
	            <table id="dt-busquedaProp" class="table table-hover table-striped" cellspacing="0" width="100%">
	                  <thead>
	                  		<tr>
	                          <th>Id Propietario</th>
	                          <th>Nombre propietario</th>
	                          <th>Opciones</th>
	                      	</tr>
	                  </thead>
	              <tbody>
	              </tbody>
	          </table>
          	</div>
            
          </div>
        </div>
      </div>
  </div>
</div>
<!-- fin modal propietario-->
