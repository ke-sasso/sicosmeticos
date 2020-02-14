<div id="hig" style="display:none;">

    <div class="row">
        <div class="col-xs-6">
            <label>Uso:</label>
            <input type="text" name="uso" class="form-control hig" 

            @if($solicitud->detallesolicitud->detallehigienico!=null) value="{{$solicitud->detallesolicitud->detallehigienico->uso}}" 
            @else value="" @endif required>
        </div>
        <div class="col-xs-6">
            <label>Clasificación:</label>
            <select class="form-control hig" id="classHig" name="classH" required>

            @if($solicitud->tipoSolicitud==4 || $solicitud->tipoSolicitud==5)
                @foreach($clashig as $clas)
                <option id="idClashig" value="{{$clas->idClasificacion}}"
                @if(isset($clas) && $clas->idClasificacion==$solicitud->detallesolicitud->detallehigienico->idClasificacion)
                    selected
                @endif>{!!$clas->nombreClasificacion!!}</option>
                @endforeach
                @else
                 <option value=""></option>
                @endif

            </select>

        </div>
    </div>
</div>
						

