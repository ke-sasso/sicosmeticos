<div class="tab-pane fade" id="coempaque">
	    <div class="panel-body">
		    <div class="the-box full no-border">
				<div class="container-fluid">
					<div>
						<label>COEMPAQUES</label>
						<table id="dtformula" class="table table-hover table-striped" cellspacing="0" width="100%">
					        <thead>
					        
					                <th>Nombre Coempaque</th>
					                <th>Detalle de Coempaque</th>

					              			     
					        </thead>
					        <tbody>
					        			@foreach($coempaques as $c)
											<tr>
												<td>{!!$c->nombreCoempaque!!}</td>
												<td><button type="button" class="btn btn-xs btn-info coempaque"  data-toggle="modal" data-target="#detCoempaque" id="detalleCoempaque" name="detalleCoempaque" onclick="modalDetCoempaque({{$c->idCoempaque}});">Ver Detalle Coempaque</button></td>
												
											</tr>
										@endforeach
					        </tbody>
					    </table>

					</div>
				</div>
			</div>
		</div>
</div>
<!--modal coempaque-->
<div id="detCoempaque" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="modal-header">
           <input type="hidden" id="idsolicitud" name="idsolicitud"  class="form-control"/>    
          <button type="button" class="close" data-dismiss="modal">&times;</button>
              <b><h3 class="modal-title" align="center">Detalle Coempaque <label id="textoP"></label></h3></b>
          <div class="modal-body">
            <div class="form-group" align="center">
	            <table id="dt-coempaque" class="table table-hover table-striped" cellspacing="0" width="100%">
	                  <thead>
	                  		<tr>
	                          <th>Nombre Comercial</th>
	                          <th>Presentación</th>
	                      	</tr>
	                  </thead>	
	              <tbody>
	              </tbody>
	          </table>
          </div>
            
          </div>
        </div>
      </div>
  </div>
</div>
<!-- fin modal coempaque-->
