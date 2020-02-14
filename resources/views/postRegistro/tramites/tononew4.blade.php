<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">TONO NUEVO</div>
        <div class="panel-body">
                 <div class="container-fluid the-box">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table id="tabletono" class="table table-hover">
                        <caption><b>AGREGAR TONOS</b></caption>
                        <thead>
                            <tr>
                                <th>TONO</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                             @if(isset($solicitud))
                                @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
                                    @foreach($solicitud->tono as $ton)
                                    <tr>
                                        <td><input type="text" name="tononew[]" class="form-control" id="tononew" value="{!!$ton->tono!!}"></td>
                                        <td><button class="btn btn-sm btn-danger btnEliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                                    </tr>
                                    @endforeach
                                @else
                                    @foreach($solicitud->tono as $ton)
                                    <tr>
                                        <td>{!!$ton->tono!!}</td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                @endif
                             @endif
                        </tbody>
                        <tfoot id="plusPresent">
                            <tr>
                                <th colspan="6" class="text-right">
                                @if(isset($solicitud))
                                    @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
                                        <span class="btn btn-primary" onclick="btnAddTono()" id="btnAddTono" name="btnAddTono"><i class="fa fa-plus"></i></span>
                                    @endif
                                @else
                                     <span class="btn btn-primary" onclick="btnAddTono()" id="btnAddTono" name="btnAddTono"><i class="fa fa-plus"></i></span>
                                @endif
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                </div>
             </div>
        </div>
    </div>
</div>