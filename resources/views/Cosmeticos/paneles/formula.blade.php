<div class="tab-pane fade" id="formula">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<div>
						<label>SUSTANCIAS DE FORMULA INCI</label>
						<table id="dtformula" class="table table-hover table-striped" cellspacing="0" width="100%">
					        <thead>

					                <th>N° CAS</th>
					                <th>NOMBRE SUSTANCIA</th>
					                <th>PORCENTAJE</th>

					        </thead>
					        <tbody>
					        	@for ($i = 0; $i < count($formula); $i++)
								 <tr>
									 <td>
										{!!$sust[$i]->numeroCAS!!}
									</td>
									<td>
										 {!!$sust[$i]->denominacionINCI!!}
									</td>
									<td>
										{{number_format($formula[$i]->porcentaje, 3, ".", "")}}%

									</td>

								</tr>
								@endfor



					        </tbody>
					    </table>

					</div>
				</div>
			</div>
		</div>
</div>