<div class="tab-pane fade" id="presentaciones">
    <div class="panel-body">
        <div class="the-box full no-border">
            <div class="container-fluid">
                <div class="row">
                    <div class="panel-body">
                        <div class="nav-stacked" id="presentaciones1">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pres"
                                    id="btnPre">Agregar Presentacion
                            </button>
                            @if(isset($solicitud))
                                <button type="button" class="btn btn-primary btn-info coempaque" data-toggle="modal"
                                        data-target="#coemp" id="agregarcoempaque"
                                        onclick="modalCoempaque({{$solicitud->idSolicitud}});">Agregar Coempaque
                                </button>
                            @endif
                            <br/><br/>
                        </div>

                        <div id="pres" class="modal fade modal-lg" role="dialog">

                            <div class="modal-dialog ">
                                <div class="modal-content modal-lg">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <b><h3 class="modal-title" align="center">Agregar Presentación...</h3></b>

                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div class="col-xs-12 col-sm-12">
                                                    <label>¿Posee empaque secundario?</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="check" value="1">&nbsp;&nbsp;Si
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="check" value="0">&nbsp;&nbsp;No<br/>
                                                    <a id="ayuda" type="button" data-toggle="modal"
                                                       data-target="#myModal" disable="true" style="font-size:1.5em;">
                                                        <i class="fa fa-question-circle x7"
                                                           style="border-radius: 2em;"></i></a>
                                                    <label style="color:#babec3; font-size:12px;">El empaque secundario
                                                        se refiere a la descripción del envase más externo</label>

                                                </div>
                                            </div>
                                            <br/>
                                        </div>
                                        <div class="modal-body mostrar" style="display:none; padding-top: 5px;">
                                            <div class="form-group">
                                                <div class="col-xs-12 col-sm-12">
                                                    <h3>Su presentación se lee así:</h3>
                                                    <b><input type="text" class="form-control pres"
                                                              style="border-bottom-color: black; background-color: #d5dad8;"
                                                              id="textoPres" readonly="true"/></b>
                                                </div>
                                            </div>
                                            <br/><br/><br/><br/>
                                            <div class="form-group es" style="width:25%; float:left; display:none;">
                                                <div class="col-xs-12 col-sm-12">
                                                    <label>Empaque Secundario (ES):</label><br/>
                                                    <select class="form-control envase pres" name="secundario"
                                                            id="secundario" required="false"
                                                            onchange="armarPresentacion();">
                                                        <option value="0"></option>
                                                    </select>
                                                </div>
                                                <br/><br/><br/><br/>
                                                <div class="col-xs-12 col-sm-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">DE</span>
                                                        <select class="form-control material pres" id="materialSec"
                                                                name="materialSec" required="false"
                                                                onchange="armarPresentacion();">
                                                            <option value="0">Seleccione Material Secundario</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group es"
                                                 style="width:15%;float:left;padding:0;  display:none;">
                                                <div class="col-xs-12 col-sm-12">
                                                    <label>Contenido ES:</label><br/>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><b>X</b></div>
                                                        <input type="text" class="form-control pres" value=""
                                                               id="contenidoS" name="contenidoS" required="false"
                                                               required onkeyup="armarPresentacion();">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" style="width:25%;float:left;">
                                                <div class="col-xs-12 col-sm-12">
                                                    <label>Empaque primario (EP):</label><br/>
                                                    <select class="form-control envase pres" name="primario"
                                                            id="primario" required onchange="armarPresentacion();">
                                                        <option value="0"></option>
                                                    </select>
                                                </div>
                                                <br/><br/><br/><br/>
                                                <div class="col-xs-12 col-sm-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">DE</span>
                                                        <select class="form-control material pres" name="material"
                                                                id="materialPri" required
                                                                onchange="armarPresentacion();">
                                                            <option value="0">Seleccione Material Primario</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" style="width:15%;float:left;">
                                                <div class="col-xs-12 col-sm-12">
                                                    <label>Contenido EP:</label><br/>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><b>X</b></div>
                                                        <input type="text" class="form-control pres" value=""
                                                               name="contenidoPri" id="contenidoPri" required
                                                               onkeyup="armarPresentacion();">
                                                    </div>

                                                </div>
                                                <br/><br/><br/><br/>
                                                <div class="col-xs-12 col-sm-12">

                                                    <select class="form-control unidad pres" name="unidad" id="unidad"
                                                            required>
                                                        <option value="0"></option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group cep" style="width:20%;float:left; display: none;">
                                                <div class="col-xs-12 col-sm-12">
                                                    <label>Peso Unidad(Opcional):</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><b>DE</b></div>
                                                        <input type="text" class="form-control" value="" name="peso"
                                                               id="peso" onkeyup="armarPresentacion();">
                                                    </div>
                                                </div>
                                                <br/><br/><br/><br/>
                                                <div class="col-xs-12 col-sm-12">
                                                    <select class="form-control unidad pres" name="medida" id="medida"
                                                            onchange="armarPresentacion();">
                                                        <option value="0"></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br/><br/><br/><br/><br/><br/><br/><br/>
                                            <div class="form-group">
                                                <div class="col-xs-12 col-sm-12">
                                                    <label>Ingrese un nombre de presentación (Opcional) :</label>
                                                    <input type="text" class="form-control pres" id="nombrePres"
                                                           onkeyup="armarPresentacion();"/>
                                                </div>
                                            </div>
                                            <br><br>
                                            <input type="hidden" name="totalPres" id="totalPres"
                                                   value="{{count($cos->presentaciones)}}"/>

                                            <br><br>
                                            <button type="button" style="margin-left:45%" class="btn btn-primary"
                                                    data-dismiss="modal" id="savePres">Agregar
                                            </button>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!--modal ayda-->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header" align="center">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">EJEMPLO DE PRESENTACIÓN</h4>
                                    </div>
                                    <div class="modal-body">
                                        <center>
                                            <img class="pre1" src="{{ url('img/ejemploPre1.png') }}"
                                                 style="display:none;"/>
                                            <img class="pre2" src="{{ url('img/ejemploPre2.png') }}"
                                                 style="display:none;"/>
                                        </center>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--modal coempaque-->
                        <div id="coemp" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <input type="hidden" id="idsolicitud" name="idsolicitud" class="form-control"/>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <b><h3 class="modal-title" align="center">Agregar Coempaque <label
                                                        id="textoP"></label></h3></b>
                                        <div class="modal-body">
                                            <div class="form-group" align="center">

                                                <label>Ingrese un nombre para el Coempaque:</label>
                                                <input class="form-control coemp" type="text"
                                                       id='nombreCoempaque'/><br/>
                                                <label>Seleccione las presentaciones que componen el coempaque:</label>
                                                <table id="dt-coProd" class="table table-hover table-striped"
                                                       cellspacing="0" width="100%">
                                                    <thead>
                                                    <th>N° registro</th>
                                                    <th>Nombre Comercial</th>
                                                    <th>N° presentación</th>
                                                    <th>Texto Presentación</th>
                                                    <th>Seleccione</th>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>
                                                </table>
                                            </div>
                                            <button type="button" style="margin-left:45%" class="btn btn-primary"
                                                    data-dismiss="modal" id="saveCoempaque">Registrar Coempaque
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- fin modal coempaque-->

                        <div>
                            <table id="dt-pres" class="table table-hover table-striped" cellspacing="0" width="100%">
                                <thead>

                                <th>N°</th>
                                <th>Coempaque</th>
                                <th>Presentacion</th>
                                <th>Opciones</th>


                                </thead>
                                <tbody>
                                @for($i=0;$i<count($cos->presentaciones);$i++)
                                    <tr>
                                        <td>{{$i+1}}</td>
                                        <td></td>
                                        <td>{{$cos->presentaciones[$i]->textoPresentacion}}</td>
                                        <td>
                                            <button type="button" class='btn btn-xs btn-danger borrarPres'
                                                    data-idpres='{{$cos->presentaciones[$i]->idPresentacion}}'><i
                                                        class='fa fa-times' aria-hidden='true'></i></button>
                                        </td>
                                    </tr>
                                @endfor
                                @if(isset($coempaques))
                                    @for($i=0;$i<count($coempaques);$i++)
                                        <tr>
                                            <td>{{count($cos->presentaciones)+$i+1}}</td>
                                            <td>{{$detalles[$i][0]->nombreCoempaque}}</td>
                                            <td>
                                                @for($j=0; $j<count($detalles[$i]); $j++)
                                                    @if($detalles[$i][$j]->idCoempaque==$coempaques[$i]->idCoempaque)
                                                        {!!$detalles[$i][$j]->textoPresentacion!!}
                                                    @endif
                                                    @if ($j==count($detalles[0])-1)
                                                        ({{$detalles[$i][$j]->idCosmetico}}).
                                                    @else
                                                     ({{$detalles[$i][$j]->idCosmetico}}),
                                                    @endif

                                                @endfor
                                            </td>
                                            <td>
                                                <button type="button" class='btn btn-xs btn-danger borrarCoem'
                                                        data-idcoem='{{$coempaques[$i]->idCoempaque}}'><i
                                                            class='fa fa-times' aria-hidden='true'></i></button>
                                        </tr>
                                    @endfor
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