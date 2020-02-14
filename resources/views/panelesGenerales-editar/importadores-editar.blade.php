<div class="tab-pane fade" id="imp">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<div class="panel-body">
					@if($imp->isEmpty())
						@if(Session::has('message'))
							<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									{{Session::get('message')}}
							</div>
						@endif
					@endif
					<form id="impFrm">
						<div class="row">
							<label>Nombre Importador: </label>
								<select class="form-control input-sm" name="NOMBRE_IMP"  id="NOMBRE_IMP"  placeholder="Buscar por nombre de importador:"></select>
						</div>
						<br/>
						<div class="row">
								<div class="table-responsive">
									<table width="100%" id="dt-imp" class="table table-hover table-striped">
										<thead class="the-box dark full">
										<tr>
											<th>ID IMPORTADOR</th>
											<th>NOMBRE COMERCIAL</th>
											<th>DIRECCION</th>
											<th>TELEFONO</th>
											<th>CORREO</th>
											<th>VIGENCIA</th>
											<th>OPCIONES</th>
										</tr>
										</thead>
										<tbody>					
											@foreach($imp as $i)
											<tr><input type="hidden" name="importadores[]" value="{{$i->idEstablecimiento}}">
												<td>{!!$i->idEstablecimiento!!}</td>
												<td>{!!$i->nombreComercial!!}</td>
												<td>{!!$i->direccion!!}</td>
												<td>{{json_decode($i->telefonosContacto)[0]}}</td>
												<td>{!!$i->emailContacto!!}</td>
												<td>{!!$i->vigenteHasta!!}</td>
												<td><a class='btn btn-xs btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a></td>
											</tr>
											@endforeach								
										</tbody>
									</table>
								</div>
							</div>
								 <button type="button" class="btn btn-success" id="ImpSave">Guardar</button>
							</form>
						</div>
				</div>
			</div>
		</div>
</div>
