<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Nombre Comercial:</b>
                </div>
                <input type="text" name="nombreComercial" value="{{$solicitud->detalleSolicitud->nombreComercial}}"
                       class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Marca:</b>
                </div>
                <input type="text" name="marca" value="{{$solicitud->detalleSolicitud->marca->nombreMarca}}" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Área de aplicación:</b>
                </div>
                <input type="text" class="form-control" value="{{$detalleCos->clasificacion->area->nombreArea}}" readonly/>
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Clasificación:</b>
                </div>
                <input type="text" class="form-control" value="{{$detalleCos->clasificacion->nombreClasificacion}}" readonly/>
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Forma Cosmética:</b>
                </div>
                <input type="text" class="form-control" value="{{$detalleCos->forma->nombreForma}}" readonly/>
            </div>
        </div>
        <div class="col-md-12">
        @if($solicitud->poseeCoempaque==0)
            <div class="">
                <div class="input-group">
                    <b>Posee Coempaque:</b>
                </div>
                <input type="text" class="form-control" value="NO" readonly/>
            </div>            
        @else
            <div class="">
                <div class="input-group">
                    <b>Posee Coempaque:</b>
                </div>
                <input type="text" class="form-control" value="SI" readonly/>
            </div>
            <div class="">            
                <div class="input-group">
                    <b>Coempaques a registrar:</b>
                </div>
                <textarea type="text" class="form-control" readonly>{{$solicitud->descripcionCoempaque}}</textarea>
            </div>
        @endif
        </div>
    </div>
</div>