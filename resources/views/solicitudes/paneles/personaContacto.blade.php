<div class="nav-stacked" id="contacto">
    <div class="row">
        <div class="col-xs-4">
            <label>NIT:</label>
            <input type="text" class="form-control" id="idPersona" name="nitPersona" readonly="readonly">
        </div>
        <div class="col-xs-5 form-group">
            <label>Nombre:</label>
            <select class="form-control input-sm" value="" id="nombrePersona" name="idPersona"
                    placeholder="Buscar por nombre de persona:"></select>
            <div class="help-block with-errors"></div>
        </div>
        <div class="col-xs-3"><br/>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#persona" id="nuevapersona">
                <i class='fa fa-plus-circle' aria-hidden='true'></i></button>

        </div>
    </div>
    <div class="row">
        <div class="col-xs-4">
            <label>Email: </label>
            <input type="text" class="form-control" name="emailPersona" id="emailPersona" value="" readonly="readonly">
        </div>
        <div class="col-xs-4">
            <label>Teléfono de Contacto: </label>
            <input type="text" class="form-control" name="telefonoPersona" id="telefonoPersona" readonly="readonly">
        </div>
    </div>

</div>



