<div class="tab-pane fade" id="imp">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
						<div class="row">
							<div class="panel-body">
								<div class="table-responsive">
									<table width="100%" id="dt-cos" class="table table-hover table-striped">
										<thead class="the-box dark full">
										<tr>
											<th>ID IMPORTADOR</th>
											<th>NOMBRE COMERCIAL</th>
											<th>DIRECCION</th>
											<th>TELEFONO</th>
											<th>CORREO</th>
											<th>VIGENCIA</th>
										</tr>
										</thead>
										<tbody>
										@if($imp->isEmpty())
											@if(Session::has('message'))
											<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											    {{Session::get('message')}}
											</div>
											@endif
										@else
											@foreach($imp as $i)
											<tr>
												<td>{!!$i->idEstablecimiento!!}</td>
												<td>{!!$i->nombreComercial!!}</td>
												<td>{!!$i->direccion!!}</td>
												<td>{{json_decode($i->telefonosContacto)[0]}}</td>
												<td>{!!$i->emailContacto!!}</td>
												<td>{!!$i->vigenteHasta!!}</td>
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
