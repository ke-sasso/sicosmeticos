<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Nombre Comercial:</b>
                </div>
                <input type="text" name="nombreComercial" value="{{$solicitud->detalleSolicitud->nombreComercial}}" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Uso:</b>
                </div>
                <input type="text" name="uso" value="{{$detalleHig[0]->uso}}" class="form-control" readonly="true">
            </div>
        </div>      
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Clasificación:</b>
                </div>
                <input type="text" class="form-control" name="class" value="{{$detalleHig[0]->nombreClasificacion}}" readonly="true">
            </div>
        </div>      
    </div>
</div>