<div class="panel-body" id="importadores">

	
		<div class="row">
			<label>Nombre Importador: </label>
				<select class="form-control input-sm" name="NOMBRE_IMP"  id="NOMBRE_IMP"  placeholder="Buscar por nombre de importador:"></select>
		</div><br/>

		<div class="row">
			<div class="table-responsive">
				<table width="100%" style="font-size: 12px;" id="dt-imp" class="table table-hover table-striped">
					<thead class="the-box dark full">
					<tr>
						<th>ID IMPORTADOR</th>
						<th>NOMBRE COMERCIAL</th>
						<th>TELEFONO</th>
						<th style="width:25%;">DIRECCION</th>
						<th>EMAIL</th>
						<th>OPCIONES</th>
						
					</tr>
					</thead>
					<tbody>
						@foreach($importadores as $imp)
							<tr class='fila'>
								<td class='id'>{{$imp->idEstablecimiento}}</td>
								<td>{{$imp->nombreComercial}}</td>
								<td>{{$imp->telefonosContacto}}</td>
								<td>{{$imp->direccion}}</td>
								<td>{{$imp->emailContacto}}</td>
								<td><a class='btn btn-xs btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a></td></tr>
						@endforeach
					</tbody>
				</table>
			
			</div>
		</div>
		
</div>