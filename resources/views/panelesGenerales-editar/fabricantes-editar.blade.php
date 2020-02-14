<div class="tab-pane fade" id="fab">
	<div class="panel-body">
		<div class="the-box full no-border">
			<div class="container-fluid">
				<div class="row">
				@if($fab==null)
						@if(Session::has('message'))
							<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									{{Session::get('message')}}
							</div>
						@endif
				@endif
					<div class="form-group form-inline">
						<label>Seleccione el tipo de fabricante antes de buscarlo:</label><br>
						<div class="radio">
							<label class="radio-inline">
								<input type="radio" name="origenFab" id="inlineRadio1" class="origenFab" value="1" required > Nacional
							</label>
						</div>
						<div class="radio">
							<label class="radio-inline">
								<input type="radio" name="origenFab" id="inlineRadio2" class="origenFab" value="2" required > Extranjero
							</label>
						</div>
					</div>
					<label>Nombre Fabricante: </label>
						<select class="form-control input-sm" name="NOMBRE_FAB"  id="NOMBRE_FAB"  placeholder="Buscar por nombre de fabricante:"></select>
				</div><br/>
			<form id="fabFrm">	
				<div class="row">
					<div class="table-responsive">
					<table width="100%" style="font-size: 12px;" id="dt-fab" class="table table-hover table-striped">
						<thead class="the-box dark full">
						<tr>
							<th>ID FABRICANTE</th>
							<th>NOMBRE COMERCIAL</th>
							<th style="width:20%">DIRECCION</th>
							<th>TELEFONO</th>
							<th>VIGENCIA</th>
							<th>EMAIL</th>
							<th>OPCIONES</th>
							
						</tr>
						</thead>
						<tbody>

							@if($fab!=null)
							@foreach($fab as $f)
											<tr><input type='hidden' name='fabricantes[]' value="{{$f->ID_ESTABLECIMIENTO}}">
												<td>{!!$f->ID_ESTABLECIMIENTO!!}</td>
												<td>{!!$f->NOMBRE_COMERCIAL!!}</td>
												<td>{!!$f->DIRECCION!!}</td>
												<td>{!!$f->TELEFONO_1!!}</td>
                                                <td>{{$f->VIGENCIA_HASTA}}</td>
												<td>{!!$f->EMAIL!!}</td>
												<td><a class='borrar'><i class='btn btn-xs btn-danger fa fa-times' aria-hidden='true'></i></a></td>
											</tr>
							@endforeach
							@endif
						</tbody>
					</table><br>
					<div align="center">
					 <button type="button" class="btn btn-success" id="fabSave">Guardar</button>
					</div>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>