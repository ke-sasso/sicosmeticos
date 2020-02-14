<div class="tab-pane fade" id="formula">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<form id="formulaFrm">
					<div>
						<label>SUSTANCIAS DE FORMULA INCI</label>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-1">
							<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalSustancia" id="buscarSustancia"><i class="fa fa-search"></i>Agregar Sustancia</a>
							</div>
						</div>
						<table id="dtformulaEdicion" class="table table-hover table-striped" cellspacing="0" width="100%">
					        <thead>

					                <th>N° CAS</th>
					                <th>NOMBRE SUSTANCIA</th>
					                <th>PORCENTAJE</th>



					        </thead>
					        <tbody>
					        	@for ($i = 0; $i < count($formula); $i++)
								<tr><input type="hidden" name="idDenominacion[]" value="{{$sust[$i]->idDenominacion}}"/>
									<td><input type="hidden" name="numeroCAS[]" value="{{$sust[$i]->numeroCAS}}"/>
										{!!$sust[$i]->numeroCAS!!}
									</td>
									<td><input type="hidden" name="denominacionINCI[]" value="{{$sust[$i]->denominacionINCI}}"/>
										 {!!$sust[$i]->denominacionINCI!!}
									</td>
									<td><input type="hidden" name="porcentaje[]" value="{{$formula[$i]->porcentaje}}"/>
										{{number_format($formula[$i]->porcentaje, 3, ".", "")}}%
									</td>
									<td><a class="btn btn-xs btn-danger borrar"><i class="fa fa-times" aria-hidden="true"></i></a></td>
								</tr>
								@endfor
					        </tbody>
					    </table>
					    <button type="button" class="btn btn-success" id="formulaSave">Guardar</button>
					</div>
					</form>
				</div>

			</div>
		</div>
</div>

<div id="modalSustancia" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
			<div class="modal-content">
        		<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
	       			<h4 class="modal-title">Agregar ...</h4>

					<div class="modal-body">
						<div class="form-group">
							<h4> Agregar Sustancia</h4>
							<div class="col-xs-6 col-sm-6 col-md-4 col-lg-12">
								<span class="input-group-addon">Sustancia INCI</span>


									<select class="form-control" style="text-transform:uppercase;" id="formulaSelect" name="formulaSelect" required>

									</select>

							</div>
						</div> <br/><br/>
						<div class="form-group">
							<div class="col-xs-6 col-sm-6 col-md-4 col-lg-12">
								<div class="input-group">
									<span class="input-group-addon">Porcentaje</span>
									<input class="form-control" name="porcentaje" id="porcentaje" type="number"/>

								</div>
							</div>

						</div><br/><br/>

							<button type="button"  class="btn btn-primary" data-dismiss="modal" id="agregarFormula">Agregar</button>

					</div>
				</div>
			</div>

		</div>
</div>