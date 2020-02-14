<div id="cos" style="display:none;">
    <div class="row">
        <div class="col-xs-6">
            <label>Área de Aplicación:</label>
            <select class="form-control cos" id="area" name="area" required>
                <option></option>
                @foreach($areas as $area)
                    <option id="idArea" value="{{$area->idAreaAplicacion}}">{!!$area->nombreArea!!}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xs-6">
            <label>Clasificación:</label>
            <select class="form-control cos" id="class" name="class" required>

            </select>

        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-6">
            <label>Forma Cosmética:</label>
            <select class="form-control cos" id="forma" name="forma" required>
            </select>
        </div>
    </div>

</div>
			
						



