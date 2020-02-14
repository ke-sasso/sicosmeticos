<div class="nav-stacked">
    <div class="row">
        <div class="col-xs-6">
            <label>Nombre Comercial:</label>
            <input type="text" name="nombreComercial" class="form-control" required>
        </div>

        <div class="col-xs-6">
            <label>Marca:</label>
            <select class="form-control" name="marca" required>
                @foreach($marcas as $m)
                    <option value="{{$m->idMarca}}">{!!$m->nombreMarca!!}</option>
                @endforeach
            </select>
        </div>

        <input type="hidden" value="" name="poseeT">
        <input type="hidden" value="" name="poseeF">

    </div>
    <br/>
</div>