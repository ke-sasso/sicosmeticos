<div class="tab-pane fade in active" id="generalesHig">
    <br/>
    <div class="row">
        <div class="col-xs-10">
            <label>Nombre Comercial:</label>
            <input type="text" name="nombreComercial" value="{{$solicitud->detalleSolicitud->nombreComercial}}"
                   class="form-control" readonly/>
        </div>
    </div>
    <br/>
    <div class="row">

        <div class="col-xs-5">
            <label>Uso:</label>
            <input type="text" name="uso" value="{{$detalleHig[0]->uso}}" class="form-control" readonly="true">
        </div>

        <div class="col-xs-5">
            <label>Clasificación:</label>
            <input type="text" class="form-control" name="class" value="{{$detalleHig[0]->nombreClasificacion}}"
                   readonly="true">
            <input type="hidden" name="idClass" value="{{$detalleHig[0]->idClasificacion}}" class="form-control"
                   readonly="true">

        </div>
    </div>
    <div class="row">

        <div class="col-xs-5">
            <label>Numero de mandamiento:</label>
            <input type="text" name="mandamiento" value="{{$solicitud->idMandamiento}}" class="form-control" readonly="true">
        </div>

    </div>
    <br/>
    <div class="row">


    </div>
    <br/>
</div>


