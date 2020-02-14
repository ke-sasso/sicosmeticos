<div class="tab-pane fade" id="tonos">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					@if($tonos->isEmpty())
						@if(Session::has('message'))
							<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									{{Session::get('message')}}
							</div>
						@endif
					@endif
							<div class="panel-body">
								<form id="tonosFrm">
									<label>TONOS</label> 
									<div class="row">
									<a class="btn btn-primary" id="btnTono">
											<i class="fa fa-plus"></i> Agregar Tono
										</a>
										<a class="btn btn-danger" id="btnEliminarTono">
											<i class="fa fa-plus"></i>
										</a>
										<div class="col-xs-6 col-sm-6" id="tonosDiv">
											@foreach($tonos as $t)
											<input type="text" name="tonos[]" class="form-control tonos" value="{{$t->tono}}"><br/>	
											@endforeach	
										</div>
									</div>	
								 <button type="button" class="btn btn-success" id="tonoSave">Guardar</button>
								</form>
								
							</div>
						
				</div>
			</div>
		</div>
</div>
