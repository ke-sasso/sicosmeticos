<div class="nav-stacked">
    <div class="row">
        <div class="col-xs-6 col-sm-6">
            <label>Nombre Comercial:</label>
            <input type="text" class="form-control"  name="nombreComercial" value="{{$solicitud->detalleSolicitud->nombreComercial}}" id="nombreComercial" required>

        </div>

        <div class="col-xs-6">
            <label>Marca:</label>
            <select class="form-control" name="marca" required>
                @foreach($marcas as $m)
                    <option value="{{$m->idMarca}}"
                    @if($m->idMarca==$solicitud->detallesolicitud->idMarca)                 
                        selected 
                    @endif>{!!$m->nombreMarca!!}</option>
                @endforeach
            </select>
        </div>

        <input type="hidden" value="" name="poseeT">
        <input type="hidden" value="" name="poseeF">

    </div>
    <br/>
</div>