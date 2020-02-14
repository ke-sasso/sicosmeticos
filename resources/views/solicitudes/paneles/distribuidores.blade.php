<div class="panel-body" id="distribuidores">

		<div class="row" id="disTitular">
			<label>¿El distribuidor es el mismo titular?</label>
				Si <input type="radio" id="disTitu" name="disTitu" value="1" > 
				No <input type="radio" id="disTitu" name="disTitu" value="0" > 
		</div>
		<div class="row">
			<label>Nombre Distribuidor: </label>
				<select class="form-control input-sm" name="NOMBRE_DIS"  id="NOMBRE_DIS"  placeholder="Buscar por nombre o poder de distribuidor:"></select>
		</div><br/>

		<div class="row">
			<div class="table-responsive">
				<table width="100%" style="font-size: 12px;" id="dt-dis" class="table table-hover table-striped">
					<thead class="the-box dark full">
					<tr>
						<th>ID ESTABLECIMIENTO</th>
						<th>PODER DISTRIBUCION</th>
						<th>NOMBRE COMERCIAL</th>
						<th>TELEFONO</th>
						<th style="width:25%;">DIRECCION</th>
						<th>EMAIL</th>
						<th>OPCIONES</th>
						
					</tr>
					</thead>
					<tbody id="dt-dis-body">
					

					</tbody>
				</table>
		
			</div>
		</div>
</div>