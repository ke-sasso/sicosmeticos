<div class="tab-pane fade" id="reconocimiento">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <label>Nombre CVL:</label>
                <input type="text" name="nombreCVL" value="{{$solicitud->detalleSolicitud->nombreComercial}}"
                       class="form-control" readonly>
            </div>
        </div>
        </br>

        </br>
        <div class="row">

            <div class="col-xs-4">
                <label>País de Origen:</label>
                <input type="text" class="form-control" name="paisOrigen" value="{{$pais->nombre}}" readonly="true">

            </div>
            <div class="col-xs-4">
                <label>Número de Registro en el País de Origen:</label>
                <input type="text" name="numRegistro" class="form-control"
                       value="{{$solicitud->detalleSolicitud->numeroRegistroExtr}}" readonly="true">

            </div>

            <div class="col-xs-4">
                <label>Fecha de Vencimiento:</label>

                <input type="date" name="fechaVen" class="form-control"
                       value="{{$solicitud->detalleSolicitud->fechaVencimiento}}" readonly="true">

            </div>

        </div>

    </div>
</div>


