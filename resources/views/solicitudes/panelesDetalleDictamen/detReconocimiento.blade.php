<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Nombre CVL:</b>
                </div>
                <input type="text" name="nombreCVL" value="{{$solicitud->detalleSolicitud->nombreComercial}}" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>País de origen:</b>
                </div>
                <input type="text" class="form-control" name="paisOrigen" value="{{$pais->nombre}}" readonly="true">
            </div>
        </div>      
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Número de Registro en el País de Origen:</b>
                </div>
                <input type="text" name="numRegistro" class="form-control"
                       value="{{$solicitud->detalleSolicitud->numeroRegistroExtr}}" readonly="true">
            </div>
        </div>  
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Fecha de Vencimiento:</b>
                </div>
                <input type="date" name="fechaVen" class="form-control"
                       value="{{$solicitud->detalleSolicitud->fechaVencimiento}}" readonly="true">
            </div>
        </div>  
    </div>
</div>