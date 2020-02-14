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

					</tbody>
				</table>
		
			</div>
		</div>
</div>