<div class="tab-pane fade" id="profesional">
    @if(Session::has('messageProf'))
        <div class="alert alert-warning" role="alert" style="width: 100%; margin-top: 10px; ">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('messageProf')}}
        </div>
    @endif
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-4">
                <label>Código de profesional:</label>
                <input type="text" class="form-control" name="ID_PROFESIONAL"
                       value="{{$profesional[0]->ID_PROFESIONAL}}" readonly="true">
            </div>
            <div class="col-xs-8">
                <label>Poder de Profesional: </label>
                <input type="text" class="form-control" name="ID_PODER" value="{{$profesional[0]->ID_PODER}}"
                       readonly="true">
            </div>

        </div>
        <div class="row">
            <div class="col-xs-12">
                <label>Nombre Profesional: </label>

                <input type="text" class="form-control" name="NOMBRE_PROFESIONAL"
                       value="{{$profesional[0]->NOMBRE_PROFESIONAL}}" readonly="true">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-4">
                <label>Correo: </label>
                <input type="text" class="form-control" name="email" value="{{$profesional[0]->EMAIL}}" readonly="true">
            </div>
            <div class="col-xs-4">
                <label>Teléfono: </label>
                <input type="text" class="form-control" name="telefono_1" value="{{$profesional[0]->TELEFONO_1}}"
                       readonly="true">
            </div>
        </div>
    </div>
</div>