<div class="row">
    <div class="col-xs-12 form-group">
        <div class="group-control">
            <label> Número de Registro: </label>
            <input type="text" class="form-control" name="idHigienicos" value="{{$hig->idHigienico}}" id="idHigienico" readonly="true">
        </div>
        <div class="group-control">
            <label> Nombre Comercial: </label>
            <input type="text" class="form-control" name="nombreComercial" value="{{$hig->nombreComercial}}" id="nombreComercial" readonly="true">
        </div>
        <div class="group-control">
            <label> País de Origen: </label>
            <input type="hidden" class="form-control" name="idPais" value="{{$hig->pais->idPaisOrigen}}" id="idPais" readonly="true">
            <input type="text" class="form-control" name="pais" value="{{$hig->pais->nombre}}" id="pais" readonly="true">
        </div>

        @if($hig->nombreCVL==" ")
            <div class="group-control">
                <label> Nombre según CVL: </label>
                <input type="text" class="form-control" name="nombreCVL" value="{{$hig->nombreCVL}}" id="nombreCVL" readonly="true">
            </div>
        @endif
        <div class="group-control">
            <label> Tipo: </label>
            <input type="text" class="form-control" name="tipo" value="{{$hig->tipoProducto}}" id="tipo" readonly="true">
        </div>
        @if($hig->tipo=!"1")
            <div class="group-control">
                <label> Número de Registro en el pais de Origen: </label>
                <input type="text" class="form-control" name="numeroReconocimiento" value="{{$hig->numeroReconocimiento}}" id="numeroReconocimiento" readonly="true">
            </div>
            <div class="group-control">
                <label> Fecha de Vencimiento del Reconocimiento: </label>
                <input type="text" class="form-control" name="numeroReconocimiento" value="{{$hig->numeroReconocimiento}}" id="numeroReconocimiento" readonly="true">
            </div>
        @endif

        <div class="group-control">
            <label>Fecha Vigencia: </label>
            <input type="text" class="form-control" name="vigenciaHasta" value="{{$hig->vigenteHasta}}" id="vigenciaHasta" readonly="true">
        </div>
        <div class="group-control">
            <label>Fecha Renovación: </label>
            <input type="text" class="form-control" name="renovacion" value="{{$hig->renovacion}}" id="renovacion" readonly="true">
        </div>
        <div class="group-control">
            <label>Estado: </label>
            <input type="text" class="form-control" name="estado" value="{{$hig->estado}}" id="estado" readonly="true">
        </div>
         @if(!empty($hig->profesional))
            <input type="hidden" name="idpro" id="idpro" value="{{Crypt::encrypt($hig->profesional->idProfesional)}}">
        @else
               <input type="hidden" name="idpro" id="idpro" value="0">
        @endif

    </div>

</div>