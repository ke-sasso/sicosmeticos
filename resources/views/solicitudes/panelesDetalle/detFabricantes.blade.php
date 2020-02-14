<div class="tab-pane fade" id="fab">
    <div class="panel-body">
        <div class="the-box full no-border">
            <div class="container-fluid">

                <div class="row">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table width="100%" style="font-size: 12px;" id="dt-cos"
                                   class="table table-hover table-striped">
                                <thead class="the-box dark full">

                                <tr>
                                    <th>ID FABRICANTE</th>
                                    <th>NOMBRE FABRICANTE</th>
                                    <th>TIPO</th>
                                    <th>TELEFONO</th>
                                    <th>DIRECCION</th>
                                    <th>CORREO</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($fabricantesNac))
                                    @foreach($fabricantesNac as $f)
                                        <tr>
                                            <td>{!!$f->idEstablecimiento!!}</td>
                                            <td>{!!$f->nombreFab!!}</td>
                                            <td>{!!$f->direccion!!}</td>
                                            <td>{{json_decode($f->telefonosContacto)[0]}}</td>

                                            <td>{!!$f->direccion!!}</td>
                                            <td>{!!$f->emailContacto!!}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if(isset($fabricantesExt))
                                    @foreach($fabricantesExt as $f)
                                        <tr>
                                            <td>{!!$f->idEstablecimiento!!}</td>
                                            <td>{!!$f->nombreFab!!}</td>
                                            <td>{!!$f->direccion!!}</td>
                                            <td>{{json_decode($f->telefonosContacto)}}</td>
                                            <td>{!!$f->direccion!!}</td>
                                            <td>{!!$f->emailContacto!!}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>