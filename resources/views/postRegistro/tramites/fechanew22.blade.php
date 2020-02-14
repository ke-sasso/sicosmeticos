<div class="col-sm-12">
    <div class="panel panel-success">
            <div class="panel-heading">FECHA DE VIGENCIA DEL PAÍS DE ORIGEN</div>
            <div class="panel-body">
            <div class="container-fluid the-box">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    @if(isset($solicitud))
                            @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
                                @if(!empty($solicitud->fechareconocimiento))
                                      <input type="date" name="fechaReconocimiento" id="fechaReconocimiento"  class="form-control" value="{{$solicitud->fechareconocimiento->fecha}}" required>
                                @else
                                     <input type="date" name="fechaReconocimiento" id="fechaReconocimiento"  class="form-control"  required>
                                @endif
                            @else
                                @if(!empty($solicitud->fechareconocimiento))
                                      <h4><b>{{date("d-m-Y", strtotime($solicitud->fechareconocimiento->fecha))}}</b></h4>
                                @else
                                     <h4>SIN FECHA</h4>
                                @endif
                            @endif
                    @else
                             <input type="date" name="fechaReconocimiento" id="fechaReconocimiento"  class="form-control" required>
                    @endif
                 </div>
            </div>
        </div>
    </div>
</div>