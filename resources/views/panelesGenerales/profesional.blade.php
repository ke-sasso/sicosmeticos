<div class="tab-pane fade" id="profesional">
    <div class="panel-body">
        <div class="the-box full no-border">
            <div class="container-fluid">
                <form id="frmProfesional">
                        @if($pro==null)
                            @if(Session::has('message'))
                                <div class="alert alert-warning" role="alert">
                                    Este producto no posee profesional responsable
                                </div>
                            @endif
                        @else
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <label>Poder Profesional: </label>
                                    <input type="hidden" class="form-control" name="idPoderprof" value="{{$pro->ID_PODER}}"  id="idPoderprof" readonly="true">
                                    <input class="form-control" type="text" name="idPoder"
                                           value="{{$pro->ID_PODER}}" readonly>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <label>Identificador Profesional:</label>
                                    <input type="text" class="form-control" name="idProfesional" value="{{$pro->ID_PROFESIONAL}}" id="idProfesional" readonly="true">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-12">
                                    <label>Nombre Profesional: </label>
                                    <input type="text" class="form-control" name="nombreProfesional"
                                           value="{{$pro->NOMBRES .' '. $pro->APELLIDOS}}"
                                           id="nombreProfesional" readonly="true">
                                </div>
                            </div>
                            <br/>
                            <div class="row">

                                <div class="col-xs-6 col-sm-6">
                                    <label>Telefono de Contacto: </label>
                                    <input type="text" class="form-control" name="telefonoProf"
                                           value="{{$pro->TELEFONO_1}}"
                                           id="telefonoProf" readonly="true">

                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <label>Email de Contacto: </label>
                                    <input type="text" class="form-control" name="emailprof"
                                           value="{{$pro->EMAIL}}"
                                           id="emailprof" readonly="true">

                                </div>

                            </div>
                        <div align="center">
                            <button type="button" class="btn btn-success" id="profesionalSave">Guardar</button>
                        </div>
                        @endif
                </form>
            </div>
        </div>
    </div>
</div>
