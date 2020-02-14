<div class="row">
    <div class="col-xs-12 form-group">
        <div class="group-control">
            <label> Número de Registro: </label>
            <input type="text" class="form-control" name="idCosmetico" value="{{$cos->idCosmetico}}" id="idCosmetico" readonly="true">
        </div>
        <div class="group-control">
            <label> Nombre Comercial: </label>
            <input type="text" class="form-control" name="nombreComercial" value="{{$cos->nombreComercial}}" id="nombreComercial" readonly="true">
        </div>
        <div class="group-control">
            <label> País de Origen: </label>
            <input type="hidden" class="form-control" name="idPais" value="{{$cos->pais->idPaisOrigen}}" id="idPais" readonly="true">
            <input type="text" class="form-control" name="pais" value="{{$cos->pais->nombre}}" id="pais" readonly="true">
        </div>

        <div class="group-control">
            <label> Tipo: </label>
            <input type="text" class="form-control" name="tipo" value="{{$cos->tipoProducto}}" id="tipo" readonly="true">
        </div>
        @if($cos->tipo==2)
            <div class="group-control">
                <label> Número de Registro en el pais de Origen: </label>
                <input type="text" class="form-control" name="numeroReconocimiento" value="{{$cos->numeroReconocimiento}}" id="numeroReconocimiento" readonly="true">
            </div>
            <div class="group-control">
                <label> Fecha de Vencimiento del Reconocimiento: </label>
                <input type="text" class="form-control" name="numeroReconocimiento" value="{{$cos->VencimientoRec}}" id="numeroReconocimiento" readonly="true">
            </div>
        @endif
        <div class="group-control">
            <label>Fecha Vigencia: </label>
            <input type="text" class="form-control" name="vigenciaHasta" value="{{$cos->vigenciaHasta}}" id="vigenciaHasta" readonly="true">
        </div>
        <div class="group-control">
            <label>Fecha Renovación: </label>
            <input type="text" class="form-control" name="renovacion" value="{{$cos->renovacion}}" id="renovacion" readonly="true">
        </div>
        <div class="group-control">
            <label>Estado: </label>
            <input type="text" class="form-control" name="estado" value="{{$cos->estado}}" id="estado" readonly="true">
        </div>
        @if(!empty($cos->profesional))
            <input type="hidden" name="idpro" id="idpro" value="{{Crypt::encrypt($cos->profesional->idProfesional)}}">
        @else
               <input type="hidden" name="idpro" id="idpro" value="0">
        @endif
    </div>

</div>