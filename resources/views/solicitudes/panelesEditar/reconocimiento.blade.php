<div class="nav-stacked" id="reconocimiento">

    <div class="row">

        <div class="col-xs-4">
            <label>País de Origen:</label>
            <select class="form-control" id="paisOrigen" name="paisOrigen">
                <option></option>

            </select>
        </div>
        <div class="col-xs-4">
            <label>Número de Registro en el País de Origen:</label>
            <input type="text" name="numRegistro" class="form-control"
            @if($solicitud->detalleSolicitud->numeroRegistroExtr!=null)
                value="{{$solicitud->detalleSolicitud->numeroRegistroExtr}}"
            @else
                value="" @endif>

        </div>

        <div class="col-xs-4">
            <label>Fecha de Vencimiento:</label>

            <input type="date" name="fechaVen" class="form-control"
             @if($solicitud->detalleSolicitud->fechaVencimiento!=null)
                value="{{$solicitud->detalleSolicitud->fechaVencimiento}}"
            @else
                value="" @endif>

        </div>


    </div>


</div>


