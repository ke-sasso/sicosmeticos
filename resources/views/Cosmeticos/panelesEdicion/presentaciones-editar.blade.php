<div class="tab-pane fade" id="presentaciones">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
			
						<div class="row">
							<div class="panel-body">
								<div class="table-responsive">
									<table width="100%"  id="dt-cos" class="table table-hover table-striped">
										<thead class="the-box dark full">
										<tr>
											<th>Presentación</th>
										
										</tr>
										</thead>
										<tbody>
										@if($pres->isEmpty())
											@if(Session::has('message'))
											<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											    {{Session::get('message')}}
											</div>
											@endif
										@else
											@foreach($pres as $pre)
											<tr>
								
												@if($pre->eterciario!="")
												<td>
													{!!$pre->eterciario!!} DE {!!$pre->mterciario!!} X {!!$pre->contenidoTerciario!!} {!!$pre->esecundario!!}
														DE {!!$pre->msecundario!!} X {!!$pre->contenidoSecundario!!} {!!$pre->eprimario!!}
														{!!$pre->eprimario!!} DE {!!$pre->mprimario!!} X {!!$pre->contenidoPrimario!!} {!!$pre->abreviatura!!}		
												</td>
												@elseif($pre->esecundario!="")
												<td>		
													{!!$pre->esecundario!!} DE {!!$pre->msecundario!!} X {!!$pre->contenidoSecundario!!} {!!$pre->eprimario!!}
													DE {!!$pre->mprimario!!} X {!!$pre->contenidoPrimario!!} {!!$pre->abreviatura!!}		
												</td>
												@else
												<td>
													{!!$pre->eprimario!!} DE {!!$pre->mprimario!!} X {!!$pre->contenidoPrimario!!} {!!$pre->abreviatura!!}</td>
												@endif
												</td>
											</tr>
											@endforeach
										@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
</div>