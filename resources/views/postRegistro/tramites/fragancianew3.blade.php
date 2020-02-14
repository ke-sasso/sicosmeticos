<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">FRAGANCIA NUEVA</div>
        <div class="panel-body">
            <div class="container-fluid the-box">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table id="tablefragancias" class="table table-hover">
                        <caption><b>AGREGAR FRAGANCIAS</b></caption>
                        <thead>
                            <tr>
                                <th>FRAGANCIA</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                             @if(isset($solicitud))
                                @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
                                    @foreach($solicitud->fragancia as $fra)
                                    <tr>
                                        <td><input type="text" name="fragancianew[]" class="form-control" id="fragancianew" value="{!!$fra->fragancia!!}"></td>
                                        <td><button class="btn btn-sm btn-danger btnEliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                                    </tr>
                                    @endforeach
                                @else
                                    @foreach($solicitud->fragancia as $fra)
                                    <tr>
                                        <td>{!!$fra->fragancia!!}</td>
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
                                        <span class="btn btn-primary" onclick="btnAddFragancia()" id="btnAddFragancia" name="btnAddFragancia"><i class="fa fa-plus"></i></span>
                                    @endif
                                @else
                                     <span class="btn btn-primary" onclick="btnAddFragancia()" id="btnAddFragancia" name="btnAddFragancia"><i class="fa fa-plus"></i></span>
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