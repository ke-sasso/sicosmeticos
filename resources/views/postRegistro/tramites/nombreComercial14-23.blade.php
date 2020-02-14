<div class="col-sm-12">
    <div class="panel panel-success">
            <div class="panel-heading">CAMBIO DE NOMBRE</div>
            <div class="panel-body">
            <div class="container-fluid the-box">
                <div class="row">
                    @if(isset($solicitud))
                            @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
                                <div class="col-sm-12 col-md-12 form-group">
                                       <label>Nuevo nombre comercial:</label>
                                      <input type="text" name="nombreNuevo" id="nombreNuevo"  class="form-control" value="{{$solicitud->cambioNombre->nombreNuevo}}">
                                </div>
                            @else
                                <div class="col-sm-12 col-md-12 form-group">
                                       <label>Nuevo nombre comercial:</label>
                                      <input type="text" name="nombreNuevo" id="nombreNuevo"  class="form-control" value="{{$solicitud->cambioNombre->nombreNuevo}}" disabled>
                                </div>
                                <div class="col-sm-12 col-md-12 form-group">
                                       <label>Antiguo nombre comercial:</label>
                                      <input type="text" name="nombreNuevo" id="nombreNuevo"  class="form-control" value="{{$solicitud->cambioNombre->nombreAntiguo}}" disabled>
                                </div>
                            @endif
                    @else
                          <div class="col-sm-12 col-md-12 form-group">
                                 <label>Nuevo nombre comercial:</label>
                                <input type="text" name="nombreNuevo" id="nombreNuevo"  placeholder="Ingrese el nuevo nombre comercial del producto" class="form-control"  required>
                          </div>
                    @endif
                 </div>
            </div>
        </div>
    </div>
</div>