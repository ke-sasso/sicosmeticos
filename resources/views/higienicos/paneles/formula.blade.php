<div class="tab-pane fade" id="formula">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<div>
						<label>SUSTANCIAS DE FORMULA:</label>
						<table id="dtformula" class="table table-hover table-striped" cellspacing="0" width="100%">
					        <thead>

					                <th>N° CAS</th>
					                <th>NOMBRE SUSTANCIA</th>
					                <th>PORCENTAJE</th>



					        </thead>
					        <tbody>
					        	@foreach($formula as $f)
					        	<tr>
									<td>
											{!!$f->numeroCAS!!}
									</td>
									<td>
										 {!!$f->denominacionINCI!!}
									</td>
									<td>
											{{number_format($f->porcentaje!, 3, ".", "")}}%
									</td>
								</tr>
								@endforeach

					        </tbody>
					    </table>

					</div>
				</div>
			</div>
		</div>
</div>