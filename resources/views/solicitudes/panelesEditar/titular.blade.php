<div class="nav-stacked" id="titular">

    <div>
        <label>Tipo de Titular:</label>
    </div>
     <div class="row">
        <div class="col-xs-4" id="tipoTitular">
            <input type="radio" name="tipoT" value="1"> Persona Natural
            <input type="radio" name="tipoT" value="2"> Persona Jurídica
            <input type="radio" name="tipoT" value="3"> Extranjero

        </div>
         <div class="col-xs-8">
            <label>Buscar Titular: </label>
            <select class="form-control input-sm" name="nombre_propietario" id="nombre_propietario"
                    placeholder="Buscar por nombre de Titular:">
                    
                    </select>
        </div>
    </div>
    <br/>
    <input type="hidden" name="titularTipo" id="titularTipo" 
    @if($solicitud->detalleSolicitud->tipoTitular!=null)
        value="{{$solicitud->detalleSolicitud->tipoTitular}}"
    @else
        value="" 
    @endif>

    <input type="hidden" name="idTitular" id="idTitular" 
    @if($solicitud->detalleSolicitud->idTitular!=null)
        value="{{$solicitud->detalleSolicitud->idTitular}}"
    @else
        value="" 
    @endif>
    <div class="row">
        <div class="col-xs-4">
            <label>Identificador Titular:</label>
            <input type="text" class="form-control" name="id_propietario" id="id_propietario" readonly="true" required>
        </div>
        <div class="col-xs-8">
            <label>Nombre Titular:</label>
            <input type="text" class="form-control" name="nompro" id="nompro" readonly="true" required>
        </div>
        <div id="Titular">
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-4">
            <label>País: </label>
            <input type="text" class="form-control" name="PAIS_TITULAR" id="PAIS_TITULAR" readonly="true">
        </div>
        <div class="col-xs-4">
            <label>Dirección: </label>
            <input type="text" class="form-control" name="DIRECCION_TITULAR" id="DIRECCION_TITULAR" readonly="true">
        </div>
        <div class="col-xs-4">
            <label>Email: </label>
            <input type="text" class="form-control" name="EMAIL_TITULAR" id="EMAIL_TITULAR" value="" readonly="true">
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-4">
            <label>Telefono de Contacto: </label>
            <input type="text" class="form-control" name="TELEFONO_TITULAR" id="TELEFONO_TITULAR" readonly="true">
        </div>

    </div>

</div>