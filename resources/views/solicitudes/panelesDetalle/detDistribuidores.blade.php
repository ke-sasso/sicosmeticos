<div class="tab-pane fade" id="distribuidores">
    <div class="panel-body">
        <div class="the-box full no-border">
            <div class="container-fluid">

                <div class="row">
                    <div class="panel-body">
                    @if($solicitud->distribuidorTitular==1)
                        <div>
                            <h3 align="center">El distribuidor es el mismo titular</h3>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table width="100%" style="font-size: 12px;" id="dt-cos"
                                   class="table table-hover table-striped">
                                <thead class="the-box dark full">

                                <tr>
                                    <th>ID DISTRIBUDIOR</th>
                                    <th>NOMBRE ESTABLECIMIENTO</th>
                                    <th>PODER</th>
                                    <th>TELEFONO</th>
                                    <th>DIRECCION</th>
                                    <th>CORREO</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(isset($distribuidores))
                                    @foreach($distribuidores as $d)
                                        <tr>
                                            <td>{!!$d->idEstablecimiento!!}</td>
                                            <td>{!!$d->nombreDis!!}</td>
                                            <td>{!!$d->ID_PODER!!}</td>
                                            <td>{{json_decode($d->telefonosContacto)}}</td>
                                            <td>{!!$d->direccion!!}</td>
                                            <td>{!!$d->emailContacto!!}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>