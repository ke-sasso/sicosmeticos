<div id="persona" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar Persona de Contacto...</h4>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-4">
                            <label>NIT:</label>
                            <input type="text" class="form-control persona" name="nitPersona" id="nitPersona"/>
                        </div>
                        <div class="col-xs-4">
                            <label>Tipo de Documento:</label>
                            <select class="form-control persona" id="tipoDoc"
                                    placeholder="Seleccione Tipo de Documento:">
                                <option value="1">DUI</option>
                                <option value="2">CARNET DE RESIDENTE</option>
                                <option value="3">PASAPORTE</option>
                            </select>

                        </div>
                        <div class="col-xs-4">
                            <label>Número de Documento:</label>
                            <input class="form-control persona" value="" id="docPersona"/>

                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-4">
                            <label>Fecha de Nacimiento: </label>
                            <input type="date" class="form-control persona" id="fechaNac">
                        </div>
                        <div class="col-xs-4">
                            <label>Sexo: </label>
                            <select class="form-control persona" id="sexo">
                                <option value="F">FEMENINO</option>
                                <option value="M">MASCULINO</option>

                            </select>
                        </div>
                        <div class="col-xs-4">
                            <label>Tratamiento: </label>
                            <select class="form-control persona" id="trat"
                                    placeholder="Seleccione Tratamiento para persona:">

                            </select>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-6">
                            <label>Nombre:</label>
                            <input class="form-control persona" id="nombreNuevaPersona"/>

                        </div>
                        <div class="col-xs-6">
                            <label>Apellidos:</label>
                            <input class="form-control persona" id="apellidoNuevaPersona"/>
                        </div>

                    </div>
                    <br/>
                    <div class="row">

                        <div class="col-xs-6">
                            <label>Departamento:</label>
                            <select class="form-control persona" id="depart" placeholder="Seleccione Departamento:">

                            </select>
                        </div>
                        <div class="col-xs-6">
                            <label>Municipio:</label>
                            <select class="form-control persona" id="municipio" placeholder="Seleccione Municipio:">

                            </select>
                        </div>

                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-12">
                            <label>Dirección:</label>
                            <textarea class="form-control persona" id="direccionPersona" rows="2"> </textarea>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <label>Email:</label>
                            <input type="text" class="form-control persona" name="emailPer" id="emailNuevaPersona"/>
                        </div>
                        <div class="col-xs-6">
                            <label>Telefono de Contacto: </label>
                            <input type="text" class="form-control persona" name="telPersona" id="telNuevaPersona"/>
                        </div>
                    </div>
                    <br/>

                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarPersona">Guardar
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>