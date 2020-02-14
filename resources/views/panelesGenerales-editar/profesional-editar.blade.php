<div class="tab-pane fade" id="profesional">
    <div class="panel-body">
        <div class="the-box full no-border">
            <div class="container-fluid">
                <form id="frmProfesional">
                    <div class="row">
                        @if($pro==null)
                                <div class="alert alert-success" role="alert">
                                    Este producto no posee profesional responsable
                                </div>
                        @endif
                        <div class="col-xs-6 col-sm-6">
                            <label>Poder Profesional: </label>
                            <input type="hidden" class="form-control" name="idPoderprof"
                                   @if($pro!=null){
                                   value="{{$pro->ID_PODER}}"
                                   } @else {
                                   value=""
                                   } @endif
                                   id="idPoderprof" readonly="true">
                            <select class="form-control input-sm" name="idPoderprof" value="" id="ID_PODER"
                                    placeholder="Buscar por número de Poder:" required>
                            </select>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <label>Identificador Profesional:</label>
                            <input type="text" class="form-control" name="idProfesional"
                                   @if($pro!=null){
                                   value="{{$pro->ID_PROFESIONAL}}"
                                   } @else {
                                   value=""
                                   } @endif
                                   id="idProfesional" readonly="true">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-12">
                            <label>Nombre Profesional: </label>
                            <input type="text" class="form-control" name="nombreProfesional"
                                   @if($pro!=null){
                                   value="{{$pro->NOMBRES .' '. $pro->APELLIDOS}}"
                                   } @else {
                                   value=""
                                   } @endif
                                   id="nombreProfesional" readonly="true">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-6 col-sm-12">
                            <label>Titular del poder: </label>
                            <input type="text" class="form-control" name="nombreTitular"
                                   @if($pro!=null){
                                   value=""
                                   } @else {
                                   value=""
                                   } @endif
                                   id="nombrePropietario" readonly="true">
                        </div>
                    </div>
                    <br/>
                    <div class="row">

                        <div class="col-xs-6 col-sm-6">
                            <label>Telefono de Contacto: </label>
                            <input type="text" class="form-control" name="telefonoProf"
                                   @if($pro!=null){
                                   value="{{$pro->TELEFONO_1}}"
                                   } @else {
                                   value=""
                                   } @endif
                                   id="telefonoProf" readonly="true">

                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <label>Email de Contacto: </label>
                            <input type="text" class="form-control" name="emailprof"
                                   @if($pro!=null){
                                   value="{{$pro->EMAIL}}"
                                   } @else {
                                   value=""
                                   } @endif
                                   id="emailprof" readonly="true">

                        </div>

                    </div>
                    <br>
                    <button type="button" class="btn btn-success" id="profesionalSave">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
