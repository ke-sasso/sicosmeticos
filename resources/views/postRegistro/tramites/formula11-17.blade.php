<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">FORMULA CUALITATIVA</div>
        <div class="panel-body">
            <div class="container-fluid the-box">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                             @if(!isset($solicitud))
                            <table id="table-formulasexistentes" class="table table-hover">
                                    <caption><b>FORMULAS EXISTENTES</b></caption>
                                    <thead>
                                         <tr>
                                            <th>N° CAS</th>
                                            <th>NOMBRE SUSTANCIA</th>
                                            <th>PORCENTAJE</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($formula as $form)
                                    <tr>
                                        <td>{!!$form->sustancia->numeroCAS!!}</td>
                                        <td>{!!$form->sustancia->denominacionINCI!!}</td>
                                        <td>{!!$form->porcentaje!!}</td>
                                        <td><button class="btn btn-sm btn-danger btnEliminarFormula" data-idprimary="{{$form->idCorrelativo}}" data-iddenominacion='{{$form->idDenominacion}}'><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                                    </tr>
                                    @endforeach
                                     </tbody>
                                </table>
                                <div id="deleteFormulas">

                                </div>

                        @endif
                    <table id="tableformula" class="table table-hover">
                        <caption><b>AGREGAR SUSTANCIAS</b></caption>
                        <thead>
                            <tr>
                                <th>N° CAS</th>
                                <th>NOMBRE SUSTANCIA</th>
                                <th>PORCENTAJE</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             @if(isset($solicitud))
                                @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
                                    @foreach($solicitud->formula as $form)
                                    <tr>
                                        <td><input type="hidden" name="ncas[]" class="form-control" id="ncas" value="{!!$form->ncas!!}">{!!$form->ncas!!}</td>
                                        <td><input type="hidden" name="nombreDenominacion[]" class="form-control" id="nombreDenominacion" value="{!!$form->nombreDenominacion!!}">
                                            <input type="hidden" name="idDenominacion[]" class="form-control" id="idDenominacion" value="{!!$form->idDenominacion!!}">
                                            {!!$form->nombreDenominacion!!}</td>
                                         <td><input type="hidden" name="porcentaje[]" class="form-control" id="porcentaje" value="{{floatval($form->porcentaje)}}">{{floatval($form->porcentaje)}}%</td>
                                        <td><button class="btn btn-sm btn-danger btnEliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                                    </tr>
                                    @endforeach
                                    @if(!empty($solicitud->formulaDelete))
                                           @if($solicitud->tipoProducto=='COS')
                                                    @foreach($solicitud->formulaDelete as $formdelete)
                                                        <tr>
                                                           <td>{!!$formdelete->sustanciaCos->numeroCAS!!}</td>
                                                           <td>{!!$formdelete->sustanciaCos->denominacionINCI!!}</td>
                                                            <td><span class="label label-danger">FORMULA ELIMINADA DEL CATALOGO</span></td>
                                                            <td></td>
                                                        </tr>
                                                    @endforeach
                                           @else
                                                     @foreach($solicitud->formulaDelete as $formdelete)
                                                        <tr>
                                                           <td>{!!$formdelete->sustanciaHig->numeroCAS!!}</td>
                                                           <td>{!!$formdelete->sustanciaHig->denominacionINCI!!}</td>
                                                            <td><span class="label label-danger">FORMULA ELIMINADA DEL CATALOGO</span></td>
                                                            <td></td>
                                                        </tr>
                                                    @endforeach
                                            @endif
                                    @endif
                                @else
                                    @foreach($solicitud->formula as $form)
                                    <tr>
                                       <td>{!!$form->ncas!!}</td>
                                       <td>{!!$form->nombreDenominacion!!}</td>
                                        <td>{!!$form->porcentaje!!}%</td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                    @if(!empty($solicitud->formulaDelete))
                                           @if($solicitud->tipoProducto=='COS')
                                                    @foreach($solicitud->formulaDelete as $formdelete)
                                                        <tr>
                                                           <td>{!!$formdelete->sustanciaCos->numeroCAS!!}</td>
                                                           <td>{!!$formdelete->sustanciaCos->denominacionINCI!!}</td>
                                                            <td><span class="label label-danger">FORMULA ELIMINADA DEL CATALOGO</span></td>
                                                            <td></td>
                                                        </tr>
                                                    @endforeach
                                           @else
                                                     @foreach($solicitud->formulaDelete as $formdelete)
                                                        <tr>
                                                           <td>{!!$formdelete->sustanciaHig->numeroCAS!!}</td>
                                                           <td>{!!$formdelete->sustanciaHig->denominacionINCI!!}</td>
                                                            <td><span class="label label-danger">FORMULA ELIMINADA DEL CATALOGO</span></td>
                                                            <td></td>
                                                        </tr>
                                                    @endforeach
                                            @endif
                                    @endif
                                @endif
                             @endif
                        </tbody>
                        <tfoot id="plusPresent">
                            <tr>
                                <th colspan="6" class="text-right">
                                @if(isset($solicitud))
                                    @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
                                        <span class="btn btn-primary" data-toggle="modal" data-target="#modalAddSustancia" onclick="btnAddFormula()" id="btnAddFormula" name="btnAddFormula"><i class="fa fa-plus"></i></span>
                                    @endif
                                @else
                                     <span class="btn btn-primary" data-toggle="modal" data-target="#modalAddSustancia" onclick="btnAddFormula()" id="btnAddFormula" name="btnAddFormula"><i class="fa fa-plus"></i></span>
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
<div id="modalAddSustancia" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">AGREGAR SUSTANCIA</h4>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-12">
                                        <span class="input-group-addon">COMPOSICIÓN</span>
                                            <select class="form-control" style="text-transform:uppercase;" id="formulaSelect" name="formulaSelect"></select>
                                    </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-addon">Porcentaje</span>
                                    <input type="number" id="portcen" name="portcen" class="form-control" value="0" step="0.01">
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer" align="center">
                        <button type="button" id="btnFormulaPost" data-dismiss="modal" onclick="agregarFormulaPost()" name="btnFormulaPost" class="btn btn-primary">Agregar</button>
                      </div><!-- /.modal-footer -->
                </div>
            </div>
        </div>
</div>
