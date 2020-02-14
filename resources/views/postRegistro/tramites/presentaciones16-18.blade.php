<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">PRESENTACIONES</div>
        <div class="panel-body">
                 <div class="container-fluid the-box">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                  <table id="table-presetacionesexistentes" class="table table-hover">
                     @if(isset($solicitud))
                        <caption><b>PRESENTACIONES ELIMINADAS</b></caption>
                     @else
                         <caption><b>PRESENTACIONES EXISTENTES</b></caption>
                     @endif
                        <thead>
                            <tr>
                                <th>PRESENTACIÓN</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                             @if(isset($solicitud))

                                @if(!empty($solicitud->presentacionesDelete))
                                    @foreach($solicitud->presentacionesDelete as $delete)
                                    <tr>
                                      <td>{{$delete->nombrePresentacion}}</td>
                                      <td><span class="label label-danger">PRESENTACIÓN ELIMINADA</span></td>
                                    </tr>
                                    @endforeach
                                @endif

                             @else
                                     @foreach($presentaciones as $prex)
                                    <tr>
                                        <td>{!!$prex->textoPresentacion!!}</td>
                                        <td><button class="btn btn-sm btn-danger btnEliminarPresentacion" data-texto="{!!$prex->textoPresentacion!!}" data-idpresentacion="{{$prex->idPresentacion}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                                    </tr>
                                    @endforeach

                             @endif
                        </tbody>
                    </table>
                    <div id="deletePresentaciones">

                    </div>
                     <table id="presentacion" class="table table-hover">
                        <caption><b>PRESENTACIONES NUEVAS</b></caption>
                        <thead>
                            <tr>
                                <th>PRESENTACIÓN</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                             @if(isset($solicitud))
                                @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
                                    @foreach($solicitud->presentaciones as $pren)
                                    <tr>
                                        <td><input type="hidden" name="presentaciones[]" class="form-control" id="presentaciones" value="{{$pren->toJson()}}">{!!$pren->textoPresentacion!!}</td>
                                        <td><button class="btn btn-sm btn-danger btnEliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                                    </tr>
                                    @endforeach
                                @else
                                    @foreach($solicitud->presentaciones as $pren)
                                    <tr>
                                        <td>{!!$pren->textoPresentacion!!}</td>
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
                                           <span class="btn btn-primary" onclick="btnAddPresentacion()"><i class="fa fa-plus"></i></span>
                                    @endif
                                @else
                                         <span class="btn btn-primary"  onclick="btnAddPresentacion()"><i class="fa fa-plus"></i></span>
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

