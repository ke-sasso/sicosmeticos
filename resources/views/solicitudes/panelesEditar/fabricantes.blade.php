<div class="panel-body" id="fabricantes">
		<div class="row">
			<label>Origen Fabricante:</label>
		</div>
		<div class="row" id="tipoFab">
				<input type="radio" id="origen" name="origen" value="1" > Nacional 
				<input type="radio" id="origen" name="origen" value="2" > Extranjero
		</div>
		<br>
		<div class="row">
			<label>Nombre Fabricante: </label>
				<select class="form-control input-sm" name="NOMBRE_FAB"  id="NOMBRE_FAB"  placeholder="Buscar por nombre de fabricante:"></select>
		</div><br/>

		<div class="row">
			<div class="table-responsive">
				<table width="100%" style="font-size: 12px;" id="dt-fab" class="table table-hover table-striped">
					<thead class="the-box dark full">
					<tr>
						<th>ID FABRICANTE</th>
						<th>NOMBRE COMERCIAL</th>
						<th>TELEFONO</th>
						<th style="width:20%;">DIRECCION</th>
						<th>EMAIL</th>
						<th>OPCIONES</th>
						
					</tr>
					</thead>
					<tbody>
						@foreach($fabricantesNac as $fabNac)
							<tr class='fila'>
								<td>{{$fabNac->idEstablecimiento}}</td>
								<td>{{$fabNac->nombreFab}}</td>
								<td>{{$fabNac->telefonosContacto}}</td>
								<td>{{$fabNac->direccion}}</td>
								<td>{{$fabNac->emailContacto}}</td>
								<td><a class='borrar'><i class='btn btn-xs btn-danger fa fa-times' aria-hidden='true'></i></a></td>
							</tr>
						@endforeach
						@foreach($fabricantesExt as $fabNac)
							<tr class='fila'>
								<td>{{$fabNac->idEstablecimiento}}</td>
								<td>{{$fabNac->nombreFab}}</td>
								<td>{{$fabNac->telefonosContacto}}</td>
								<td>{{$fabNac->direccion}}</td>
								<td>{{$fabNac->emailContacto}}</td>
								<td><a class='borrar'><i class='btn btn-xs btn-danger fa fa-times' aria-hidden='true'></i></a></td>
							</tr>
						@endforeach
						
					</tbody>
				</table>
		
			</div>
		</div>
</div>