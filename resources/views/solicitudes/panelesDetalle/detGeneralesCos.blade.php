<div class="tab-pane fade in active" id="generalesCos">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-6">
                <label>Nombre Comercial:</label>
                <input type="text" name="nombreComercial" value="{{$solicitud->detalleSolicitud->nombreComercial}}"
                       class="form-control" readonly>
            </div>
            <div class="col-xs-6">
                <label>Marca:</label>
                <input type="hidden" name="idMarca" value="{{$solicitud->detalleSolicitud->idMarca}}"
                       class="form-control" readonly>
                <input type="text" name="marca" value="{{$solicitud->detalleSolicitud->marca->nombreMarca}}"
                       class="form-control" readonly>
            </div>
        </div>
        </br>

        <div class="row">

            <div class="col-xs-4">
                <label>Área de Aplicación:</label>
                <input type="text" class="form-control" value="{{$detalleCos->clasificacion->area->nombreArea}}"
                       readonly/>
            </div>
            <div class="col-xs-4">
                <label>Clasificación:</label>
                <input type="text" class="form-control" value="{{$detalleCos->clasificacion->nombreClasificacion}}"
                       readonly/>
            </div>

            <div class="col-xs-4">
                <label>Forma Cosmética:</label>
                <input type="text" class="form-control" value="{{$detalleCos->forma->nombreForma}}" readonly/>
            </div>

        </div>
        <br/>
             <div class="row">
            <div class="col-xs-12">
                <label>Numero de mandamiento:</label>
                <input type="text" name="mandamiento" value="{{$solicitud->idMandamiento}}" class="form-control" readonly="true">
              </div>
              </div>
             <br/>
        <div class="row">
             @if($solicitud->poseeCoempaque==0)
                <div class="col-xs-4">
                    <label>Posee Coempaque:</label>
                    <input type="text" class="form-control" value="NO" readonly/>
                </div>
            @else
                <div class="col-xs-4">
                    <label>Posee Coempaque:</label>
                    <input type="text" class="form-control" value="SI" readonly/>
                </div>
                <div class="col-xs-8">
                    <label>Coempaques a registrar:</label>
                    <textarea type="text" class="form-control" readonly>{{$solicitud->descripcionCoempaque}}</textarea>
                </div>
            @endif

        </div>

        <br/>
    </div>
</div>





