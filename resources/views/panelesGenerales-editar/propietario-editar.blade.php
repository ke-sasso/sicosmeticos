	<div class="tab-pane fade" id="propietario">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<form id="frmPropietario">
						<div class="row">
						@if($pp==null)
										@if(Session::has('message'))
											<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													{{Session::get('message')}}
											</div>
										@endif
						@endif
							@if($pp!=null)
								@if(isset($pp->ACTIVO))
									@if($pp->ACTIVO=='I')
											<div class="alert alert-warning" role="alert">
												Este titular tiene estado INACTIVO.
											</div>
									@endif
								@endif
							@endif

							<div class="col-xs-6 col-sm-4">
							   <label>Identificador Titular:</label>
							   <input type="text" class="form-control" name="idTitular"
								@if($pp!=null)
							   		value="{{$pp->idPropietario}}"
							   	@else
							   		value=""
							   	@endif
							   id="idTitular" readonly="true">
							</div>
							<input type="hidden" id="titularTipo" name="titularTipo" value="">
							<div class="col-xs-6 col-sm-2">
								<br>
								<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalPropietario" id="buscarPropietario"><i class="fa fa-search"></i></a>
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label>Nombre Titular: </label>
							   <input type="text" class="form-control" name="nombreTitular"
								@if($pp!=null)
							   		value="{{$pp->nombre}}"
							   	@else
							   		value=""
							   	@endif
							    id="nombreTitular" readonly="true">
							</div>
						</div>

						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label>NIT: </label>
							   <input type="text" class="form-control" name="nit"
								@if($pp!=null)
									@if($pp->tipoTitular==3)
							   			value="N/A"
							   		@else
							   			value="{{$pp->nit}}"
							   		@endif
							   	@else
							   		value=""
							   	@endif
							    id="nit" readonly="true">
							</div>
							<div class="col-xs-6 col-sm-6">
							   <label>Email: </label>
							   <input type="text" class="form-control" name="email"
								@if($pp!=null)
							   		value="{{$pp->emailsContacto}}"
							   	@else
							   		value=""
							   	@endif
							    id="email" readonly="true">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6">
							   <label>País: </label>
							   <input type="text" class="form-control" name="paisTitular"
								@if($pp!=null)
									@if($pp->tipoTitular==3)
							   			value="{{$pp->PAIS}}"
							   		@else
							   			value="EL SALVADOR"
							   		@endif
							   	@else
							   		value=""
							   	@endif
							   id="paisTitular" readonly="true">
							</div>

							<div class="col-xs-6 col-sm-6">
							   <label>Telefono de Contacto: </label>
							   <input type="text" class="form-control" name="telefono"
								@if($pp!=null)
							   		value="{{json_decode($pp->telefonosContacto)[0]}}"
							   	@else
							   		value=""
							   	@endif
							    id="telefono" readonly="true">
							</div>

						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-12">
							   <label>Dirección: </label>
							   <textarea type="text" class="form-control" name="direccion"  id="direccion" readonly="true">@if($pp!=null){{$pp->direccion}}@endif</textarea>

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
				<input type="radio" name="tipoT" value="1"> Persona Natural
				<input type="radio" name="tipoT" value="2"> Persona Jurídica
				<input type="radio" name="tipoT" value="3"> Extranjero
			</div><br/>

            <div class="form-group" align="center">
	            <table id="dt-busquedaProp" class="table table-hover table-striped" cellspacing="0" width="100%">
	                  <thead>
	                  		<tr>
	                          <th id="th-id-propietario">NIT</th>
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
