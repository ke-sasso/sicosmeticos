<div class="tab-pane" id="anexos">

    <div class="panel-body">
        <div class="table-responsive">
            <table width="100%" class="table table-hover table-striped documentos" id="documentos">
                <thead>
                <tr>

                    <th>DOCUMENTO</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
               @if($anexos!=null)
                   @for($i=0;$i<count($anexos);$i++)
                        @if($anexos[$i]->poseeDoc==1)
                       <tr class="anexos">
                            <td width='1%' hidden>{{$anexos[$i]->idItem}}</td>
                            <td width='49%'>{{$anexos[$i]->nombreItem}}</td>
                            <td>
                            <a class="btn btn-success" href="{{route('ver.documento',['idDoc' => Crypt::encrypt($anexos[$i]->idDoc)])}}"
                                                       target="_blank">VER ANEXO<i
                                            class="fa fa-download" aria-hidden="true"></i></a>
                             <a class="btn btn-danger btnEliminarDoc" title="Eliminar Documento" data-nomdoc="{{$anexos[$i]->nombreItem}}" data-id="{{$anexos[$i]->idItem}}" data-iddoc="{{$anexos[$i]->idDoc}}" class="btn btn-danger btnEliminarDoc"><i class="fa fa-trash" aria-hidden="true">ELIMINAR</i></a></td>
                        @else
                            <tr class="anexos">
                            <td width='1%' hidden>{{$anexos[$i]->idItem}}</td>
                            <td width='49%'>{{$anexos[$i]->nombreItem}}</td>
                            <td><input type='file' id='docs' value={{$anexos[$i]->idItem}} name="files[{{$anexos[$i]->idItem}}]" ></td>
                        @endif


                    @endfor
                @endif




                </tbody>
            </table>
        </div>

    </div>

</div>