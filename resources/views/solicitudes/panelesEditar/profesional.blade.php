<div class="nav-stacked" id="profesional">
    <div class="row">
    <input type="hidden" name="poderProfesional" id="poderProfesional" 
    @if($solicitud->detalleSolicitud->idPoderProfesional!=null)
        value="{{$solicitud->detalleSolicitud->idPoderProfesional}}"
    @else
        value=""
    @endif>
        <div class="col-xs-5">
            <label>Código de profesional:</label>
            <input type="text" class="form-control" name="ID_PROFESIONAL" id="ID_PROFESIONAL" readonly="true" required>
        </div>
        <div class="col-xs-7">
            <label>Poder de Profesional: </label>
            <select class="form-control input-sm" name="ID_PODER" value="" id="ID_PODER"
                    placeholder="Buscar por número de Poder:" required></select>

        </div>

    </div>
    <div class="row">
        <div class="col-xs-5">
            <label>Nombre: </label>

            <input type="text" class="form-control" name="NOMBRE_PROFESIONAL" value="" id="NOMBRE_PROFESIONAL"
                   readonly="true">
        </div>
        <div class="col-xs-5">
            <label>Poder: </label>

            <input type="text" class="form-control" name="PODER_PROF" value="" id="PODER_PROF"
                   readonly="true">
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <label>DUI: </label>

            <input type="text" class="form-control" name="DUI" value="" id="DUI"
                   readonly="true">
        </div>
        <div class="col-xs-5">
            <label>NIT: </label>

            <input type="text" class="form-control" name="NIT" value="" id="NIT"
                   readonly="true">
        </div>
    </div>
    <div class="row">
        <div class="col-xs-10">
            <label>Dirección: </label>
            <input type="text" class="form-control" name="direccion" id="DIRECCION_PRO" readonly="true">
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <label>Correo: </label>
            <input type="text" class="form-control" name="email" value="" id="EMAIL_PRO" readonly="true">
        </div>
        <div class="col-xs-5">
            <label>Teléfono: </label>
            <input type="text" class="form-control" name="telefono_1" value="" id="TELEFONO_PRO" readonly="true">
        </div>
    </div>

</div>