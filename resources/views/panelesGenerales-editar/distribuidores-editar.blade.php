<div class="tab-pane fade" id="dist">
	<div class="panel-body">
		<div class="the-box full no-border">
			<div class="container-fluid">
				@if($dis->isEmpty())
					@if(Session::has('message'))
						<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							{{Session::get('message')}}
						</div>
					@endif
				@endif
			<form id="disFrm">
				@if(!empty($cos))
					<div class="row" id="disTitular"><label>¿El distribuidor es el mismo titular?</label>
						Si <input type="radio" id="disTitu" name="disTitu" value="1" @if($cos->distribuidorTitular!=null)  @if($cos->distribuidorTitular==1)  checked @endif @endif>
		     			No <input type="radio" id="disTitu" name="disTitu" value="0" @if($cos->distribuidorTitular!=null)  @if($cos->distribuidorTitular==0)  checked @endif @endif>
		    		</div>
				@else
					<div class="row" id="disTitular"><label>¿El distribuidor es el mismo titular?</label>
						Si <input type="radio" id="disTitu" name="disTitu" value="1" @if($hig->distribuidorTitular!=null)  @if($hig->distribuidorTitular==1)  checked @endif @endif>
		     			No <input type="radio" id="disTitu" name="disTitu" value="0" @if($hig->distribuidorTitular!=null)  @if($hig->distribuidorTitular==0)  checked @endif @endif>
		    		</div>
				@endif

				<div class="row">
							<label>Nombre Distribuidor: </label>
								<select class="form-control input-sm" name="NOMBRE_DIS"  id="NOMBRE_DIS"  placeholder="Buscar por nombre o poder de distribuidor:"></select>
				</div><br/>
				<div class="row">
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

											<th>OPCIONES</th>
										</tr>
										</thead>
										<tbody>

											@foreach($dis as $d)
											<tr><input type='hidden' name='poderDistribuidores[]' value="{{$d->ID_PODER}}">
												<td>{!!$d->ID_DISTRIBUIDOR_MAQUILA!!}</td>
												<td>{!!$d->ID_PODER!!}</td>
												<td>{!!$d->NOMBRE_COMERCIAL!!}</td>
												<td>{!!$d->DIRECCION!!}</td>
												<td>{{$d->TELEFONO_1}}</td>
												<td>{!!$d->EMAIL!!}</td>

												<td><a class='btn btn-xs btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a></td>
											</tr>
											@endforeach

										</tbody>
						</table>
					</div>
				</div><br>

					 <button type="button" class="btn btn-success" id="disSave">Guardar</button>
			</form>
				</div>
			</div>
	</div>
</div>
