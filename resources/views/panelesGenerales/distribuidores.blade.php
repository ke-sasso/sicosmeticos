<div class="tab-pane fade" id="dist">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
						<div class="row">
							<div class="panel-body">
								<div class="table-responsive">
									<table width="100%" id="dt-dist" class="table table-hover table-striped">
										<thead class="the-box dark full">
										<tr>
											<th>ID DISTRIBUIDOR</th>
											<th>PODER DE DISTRIBUIDOR</th>
											<th>NOMBRE COMERCIAL</th>
											<th>DIRECCION</th>
											<th>TELEFONO</th>
											<th>CORREO</th>
											<th>ESTADO PODER</th>
										</tr>
										</thead>
										<tbody>
										@if($dis->isEmpty())
											@if(Session::has('message'))
											<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											    {{Session::get('message')}}
											</div>
											@endif
										@else
											@foreach($dis as $d)
											<tr>
												<td>{!!$d->ID_DISTRIBUIDOR_MAQUILA!!}</td>
												<td>{!!$d->ID_PODER!!}</td>
												<td>{!!$d->NOMBRE_COMERCIAL!!}</td>
												<td>{!!$d->DIRECCION!!}</td>
												<td>{{$d->TELEFONO_1}}</td>
												<td>{!!$d->EMAIL!!}</td>
												<td>
												@if($d->ESTADO=="A")
													ACTIVO
												@else
												 	INACTIVO
												@endif
												</td>
											</tr>
											@endforeach
										@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
</div>
