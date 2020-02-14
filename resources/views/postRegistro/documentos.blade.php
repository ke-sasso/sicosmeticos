<div class="table-responsive" id="documentosDiv">

    <table width="100%" class="table table-striped" id="documentos">
        <thead>
            <th>REQUISITOS:</th>
        </thead>
        <tbody>
        @if(isset($solicitud))
            @foreach($solicitud->tramite->requisitos as $req)
                <tr>
                    <td width="30%">{{$req->nombreRequisito}}</td>
                    <td>

                        @if(!empty($solicitud->documentos))


                            @if(in_array($req->idRequisito, $documentoGuardados))
                                <a class="btn btn-info" href="{{route('doc.requisito.post',['idSolicitud'=>Crypt::encrypt($solicitud->idSolicitud),'idRequisito'=>Crypt::encrypt($req->idRequisito)])}}" target="_blank">Ver documento del requisito<i class="fa fa-download" aria-hidden="true"></i></a>
                                @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4)
                                   <a onclick="cambiar(this);" name="btnEliminarDoc" id="btnEliminarDoc" title="Eliminar Documento"  class="btn btn-danger btnEliminarDoc" data-idrequisito="{{$req->idRequisito}}" data-nombre="{{$req->nombreRequisito}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                 @endif
                            @else
                                @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
                                <div class="file-loading">
                                    <input id="{{'file'.$req->idRequisito}}" name="file-es[{{$req->idRequisito}}]" type="file" required="true" >
                                </div>
                                 @endif
                            @endif


                        @endif
                    </td>
                    @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
                    <td>
                        <select id="opcion-{{$req->idRequisito}}" name="requisito[]" class="form-control select">
                        <option value="1">CUMPLE</option><option value="0">NO CUMPLE</option><option value="2">NO APLICA</option>
                        </select>
                    </td>
                    <td>
                        <textarea id="txt-[{{$req->idRequisito}}]" class="form-control tx{{$req->idRequisito}}" name="txtObservacion[]" readonly="true"></textarea>
                        <input type="hidden" name="items[]" value="{{$req->idRequisito}}">
                    </td>
                    @endif
                </tr>
            @endforeach

        @elseif(isset($requisitos))
            @foreach($requisitos as $req)
                <tr>
                    <td width="50%">{!!$req->nombreRequisito!!}</td>
                    <td>
                        <div class="file-loading">
                            <input id="{{'file'.$req->idRequisito}}" name="file-es[{{$req->idRequisito}}]" type="file" @if($req->pivot->requerido==1) required="true" @endif>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

</div>