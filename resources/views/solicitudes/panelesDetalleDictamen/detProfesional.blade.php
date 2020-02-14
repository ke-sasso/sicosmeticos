<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Código de profesional:</b>
                </div>
                <input type="text" class="form-control" name="ID_PROFESIONAL"
                       value="{{$profesional[0]->ID_PROFESIONAL}}" readonly="true">
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Poder de Profesional:</b>
                </div>
                <input type="text" class="form-control" name="ID_PODER" value="{{$profesional[0]->ID_PODER}}" readonly="true">
            </div>
        </div>      
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Nombre Profesional:</b>
                </div>
                <input type="text" class="form-control" name="NOMBRE_PROFESIONAL"
                       value="{{$profesional[0]->NOMBRE_PROFESIONAL}}" readonly="true">
            </div>
        </div>  
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Email:</b>
                </div>
                <input type="text" class="form-control" name="email" value="{{$profesional[0]->EMAIL}}" readonly="true">
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Teléfono:</b>
                </div>
                <input type="text" class="form-control" name="telefono_1" value="{{$profesional[0]->TELEFONO_1}}" readonly="true">
            </div>
        </div>  
    </div>
</div>