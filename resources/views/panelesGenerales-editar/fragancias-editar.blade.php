<div class="tab-pane fade" id="fragancia">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
						@if($fra->isEmpty())
							@if(Session::has('message'))
								<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									{{Session::get('message')}}
								</div>
							@endif
						@endif
						
						<div class="panel-body">
							<form id="fraganciaFrm">
								<label>FRAGANCIAS</label> 
									<div class="row">
										<a class="btn btn-primary" id="btnFragancia">
											<i class="fa fa-plus"></i> Agregar Fragancia
										</a>
										<a class="btn btn-danger" id="btnEliminarFragancia">
											<i class="fa fa-plus"></i>
										</a>
										<div class="col-xs-6 col-sm-6" id="fraganciasDiv">
											@foreach($fra as $f)
											<input type="text" name="fragancias[]" class="form-control fragancias" value="{{$f->fragancia}}"><br/>	
											@endforeach	
										</div>
									</div>	
								 <button type="button" class="btn btn-success" id="fraganciaSave">Guardar</button>
							</form>
						</div>
				</div>
			</div>
		</div>
</div>