<div id="pres" class="modal fade" role="dialog">
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
                            <a id="ayuda" type="button" data-toggle="modal" data-target="#myModal" disable="true"
                               style="font-size:1.5em;"> <i class="fa fa-question-circle x7"
                                                            style="border-radius: 2em;"></i></a>
                            <label style="color:#babec3; font-size:12px;">El empaque secundario se refiere a la
                                descripción del envase más externo</label>

                        </div>
                    </div>
                    <br/>
                </div>
                <div class="modal-body mostrar" style="display:none; padding-top: 5px;">
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-12">
                            <h3>Su presentación se lee así:</h3>
                            <b><input type="text" class="form-control pres"
                                      style="border-bottom-color: black; background-color: #d5dad8;" id="textoPres"
                                      readonly="true"/></b>
                        </div>
                    </div>
                    <br/><br/><br/><br/>
                    <div class="form-group es" style="width:25%; float:left; display:none;">
                        <div class="col-xs-12 col-sm-12">
                            <label>Empaque Secundario (ES):</label><br/>
                            <select class="form-control envase pres" name="secundario" id="secundario" required="false"
                                    onchange="armarPresentacion();">
                                <option value="0"></option>
                            </select>
                        </div>
                        <br/><br/><br/><br/>
                        <div class="col-xs-12 col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">DE</span>
                                <select class="form-control material pres" id="materialSec" name="materialSec"
                                        required="false" onchange="armarPresentacion();">
                                    <option value="0">Seleccione Material Secundario</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group es" style="width:15%;float:left;padding:0;  display:none;">
                        <div class="col-xs-12 col-sm-12">
                            <label>Contenido ES:</label><br/>
                            <div class="input-group">
                                <div class="input-group-addon"><b>X</b></div>
                                <input type="number" class="form-control pres" value="" id="contenidoS" name="contenidoS"
                                       required="false" required onkeyup="armarPresentacion();">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="width:25%;float:left;">
                        <div class="col-xs-12 col-sm-12">
                            <label>Empaque primario (EP):</label><br/>
                            <select class="form-control envase pres" name="primario" id="primario" required
                                    onchange="armarPresentacion();">
                                <option value="0"></option>
                            </select>
                        </div>
                        <br/><br/><br/><br/>
                        <div class="col-xs-12 col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">DE</span>
                                <select class="form-control material pres" name="material" id="materialPri" required
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
                                <input type="number" class="form-control pres" value="" name="contenidoPri"
                                       id="contenidoPri" required onkeyup="armarPresentacion();">
                            </div>

                        </div>
                        <br/><br/><br/><br/>
                        <div class="col-xs-12 col-sm-12">

                            <select class="form-control unidad pres" name="unidad" id="unidad" required>
                                <option value="0"></option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group cep" style="width:20%;float:left; display: none;">
                        <div class="col-xs-12 col-sm-12">
                            <label>Peso Unidad(Opcional):</label>
                            <div class="input-group">
                                <div class="input-group-addon"><b>DE</b></div>
                                <input type="number" class="form-control" value="" name="peso" id="peso"
                                       onkeyup="armarPresentacion();">
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

                    <br><br>
                    <button type="button" style="margin-left:45%" class="btn btn-primary" data-dismiss="modal"
                            id="savePres">Agregar
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
                    <img class="pre1" src="{{ url('img/ejemploPre1.png') }}" style="display:none;"/>
                    <img class="pre2" src="{{ url('img/ejemploPre2.png') }}" style="display:none;"/>
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>