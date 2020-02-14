<div class="tab-pane fade" id="archivos">

    <div class="panel-body">
        <div class="the-box full no-border">
            <div class="container-fluid">


                @if($documentos!=null)
                    @for($i=0;$i<count($documentos);$i++)

                        <div class="form-group"><a class="btn btn-success"
                                                   href="{{route('ver.documento',['idDoc' => Crypt::encrypt($documentos[$i]->idDoc)])}}"
                                                   target="_blank">{{$documentos[$i]->nombreItem}}<i
                                        class="fa fa-download" aria-hidden="true"></i></a></div>

                    @endfor
                @else
                    <div class="alert alert-warning">
                        <strong>Ups!</strong> No se han cargado Documentos, consulte con Informática.
                    </div>

                @endif

            </div>
        </div>
    </div>
</div>