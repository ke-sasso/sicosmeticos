
@extends('master')

@section('css')
    {!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!}
    {!! Html::style('plugins/bootstrap-fileinput/css/fileinput.css') !!}
    {!! Html::style('plugins/bootstrap-fileinput/css/fileinput-rtl.css') !!}
    {!! Html::style('plugins/bootstrap-fileinput/themes/explorer-fa/theme.css') !!}
@endsection


@section('contenido')

    {{-- MENSAJE ERROR VALIDACIONES --}}
    @if($errors->any())
        <div class="alert alert-warning square fade in alert-dismissable">
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
            <strong>Oops!</strong>
            Debes corregir los siguientes errores para poder continuar
            <ul class="inline-popups">
                @foreach ($errors->all() as $error)
                    <li  class="alert-link">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- MENSAJE DE EXITO --}}
    @if(Session::has('msnExito'))
        <div class="alert alert-success square fade in alert-dismissable">
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
            <strong>Enhorabuena!</strong>
            {{ Session::get('msnExito') }}
        </div>
    @endif
    {{-- MENSAJE DE ERROR --}}
    @if(Session::has('msnError'))
        <div class="alert alert-danger square fade in alert-dismissable">
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
            <strong>Algo ha salido mal! </strong>{{ Session::get('msnError') }}
        </div>
    @endif

    @if(isset($solicitud))
        @if(count($solicitud->dictamenes)>0)

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">HISTORIAL DE DICTAMENES</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th width="18%">Fecha Resolución</th>
                            <th>Descripción Resolución</th>
                            <th>Observaciones</th>
                            <th>Usuario</th>
                        </tr>
                        </thead>
                        <tbody>
                         @foreach($solicitud->dictamenes as $dic)
                            <tr>
                                <td>{{ date('d-m-Y H:i:s',strtotime($dic->fechaCreacion)) }}</td>
                                <td>{{ $dic->estado->estado }}</td>
                                <td align="justify"><?php echo $dic->observaciones ?></td>
                                <td>{{ $dic->usuarioCreacion }}</td>
                                <td><a data-toggle="tooltip" data-placement="left" title="Herramienta dictamen" target="_blank" href="{{route('pdf.dictamen.herramienta',['idDictamen'=>Crypt::encrypt($dic->idDictamen)])}}" class="btn btn-primary btn-sm"><i class="fa fa-file-text"></i></a><br>
                                    @if($dic->idEstado!=3)
                                        <a   data-toggle="tooltip" data-placement="left"  title="Resolución dictamen" target="_blank" href="{{route('pdf.dictamen.resolucion',['idDictamen'=>Crypt::encrypt($dic->idDictamen)])}}" class="btn btn-primary btn-sm"><i class="fa fa-legal"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @endif
    @endif


    <div class="panel-body">
        <form action="{{route('certificar.post')}}" id="SolFavorable" method="post"  enctype="multipart/form-data">
            {{ csrf_field() }}
            @if(isset($solicitud))
                <input type="hidden" value="{{Crypt::encrypt($solicitud->idSolicitud)}}" name="idSolicitud">
            @endif

            @if(isset($idSesion))
                <input type="hidden" value="{{$idSesion}}" name="idSesion">
            @endif
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tipo de producto:</label></br>
                        @if(isset($solicitud))
                            <input type="text" class="form-control" value="{{($solicitud->tipoProducto=='COS'?'COSMÉTICO':'HIGIÉNICO')}}" disabled="true" >
                        @endif
                    </div>
                </div><!-- /.col-sm-6 -->
                <div class="col-sm-6 form-group">
                    <label>Tipo de trámite:</label>
                    @if(isset($solicitud))
                        <input type="text" class="form-control" value="{{$solicitud->tramite->nombreTramite}}" disabled="true" >
                    @endif
                </div><!-- /.col-sm-6 -->
            </div><!-- /.row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">PRODUCTO</div>
                        <div class="panel-body">
                            <div class="the-box full no-border">
                                <div class="container-fluid" id="dataProducto">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- DINAMICO DEPENDIENDO DEL TRÁMITE -->
            <div class="row" id="tramitesDiv">
                @if($solicitud->tramite->idTramite==7)
                    @include('postRegistro.tramites.fragancianew3')
                @elseif($solicitud->tramite->idTramite==8)
                    @include('postRegistro.tramites.tononew4')
                @elseif($solicitud->tramite->idTramite==22)
                        @include('postRegistro.tramites.fechanew22')
                @endif
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">MANDAMIENTO DE PAGO</div>
                        @include('solicitudes.paneles.mandamiento')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <div class="panel panel-success">
                        <div class="panel-heading">PERSONA DE CONTACTO</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>NIT:</label>
                                    <input type="text" class="form-control" id="idPersona"  value="{!!$solicitud->solicitante->nitNatural!!}" readonly>
                                </div>
                                <div class="col-xs-5 form-group">
                                    <label>Nombre:</label>
                                    <input type="text" class="form-control"  value="{{$solicitud->solicitante->nombres.' '.$solicitud->solicitante->apellidos}}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>Email: </label>
                                    <input type="text" class="form-control"  value="{{$solicitud->solicitante->emailsContacto}}" readonly>
                                </div>
                                <div class="col-xs-4">
                                    <label>Teléfono de Contacto: </label>
                                    <input type="text" class="form-control"  value="{{$solicitud->solicitante->telefonosContacto}}" readonly>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <div class="panel panel-success">
                        <div class="panel-heading">DOCUMENTOS</div>
                        <div class="panel-body">
                            @include('postRegistro.documentos')
                        </div>
                    </div>
                </div>
            </div>

            @if($solicitud->tramite->sesion==0 && $solicitud->idEstado==3 || $solicitud->idEstado==7)
                <div class="row text-center">
                    <button type="submit" class="btn btn-primary">Certificar</button>
                </div>
            @endif

        </form>
    </div>


@endsection

@section('js')
    {!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
    {!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
    {!! Html::script('js/postregistro/nuevasolicitud.js') !!}
    @routes()
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            @if(isset($solicitud))
                window.onload = function() {

                var mandamiento='{{$solicitud->idMandamiento}}';
                var mancos = '{{Crypt::encrypt($solicitud->tramite->tipoPagoCos)}}';
                var manhig = '{{Crypt::encrypt($solicitud->tramite->tipoPagoHig)}}';
                var tipo  = '{{$solicitud->tipoProducto}}';
                var genero= '0';
                validarMandamientoSolSinSesion(mandamiento);

                tipoProducto='{{$solicitud->tipoProducto}}';

                getTabsProducto('{{$solicitud->noRegistro}}');

                $("textarea").prop('disabled', true);

            };
            @endif
        });

  function validarMandamientoSolSinSesion(mandamiento){
    $.ajax({
        data:{ mandamiento: mandamiento},
        url:  route('validar.mandamiento.revision'),
        type:  'POST',
        success:  function (r){
            if(r.status == 200){
                if(alert) {
                    console.log('El mandamiento es válido para usar en este trámite');
                }
                $('#mandamiento').prop('readonly', true);
                var total=0;
                $('#idMand').val(r.data[0].id_mandamiento);
                $('#idCliente').val(r.data[0].id_cliente);
                $('#nombreMand').val(r.data[0].a_nombre);
                $('#pago').val(r.data[0].fecha);
                $('#detMand').empty();
                for(var i=0;i<r.data.length;i++){
                    detalle="";
                    if(r.data[i].valorDet>0) {
                        detalle="<div class='col-xs-12'>-"+r.data[i].nombre_tipo_pago+"- $"+r.data[i].valorDet+" <br><b>"+r.data[i].COMENTARIOS+"</b></div><br/>";
                        total=total+parseFloat(r.data[i].valorDet);
                    }
                    $('#detMand').append(detalle);

                }
                $('#totalMand').val(total);

            }
            else if(r.status == 404)
            {   if(alert)
                    alertify.alert("Mensaje de sistema - Advertencia", r.message);
            }
        },

    });
}


        $('#SolFavorable').submit(function(event) {
            event.preventDefault(); //this will prevent the default submit

            var formObj = $(this);
            var formURL = formObj.attr("action");
            var formData = new FormData(this);

             $.ajax({
                    data:formData,
                    url:  formURL,
                    type:  'POST',
                    mimeType:"multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData:false,
                    success:  function (r){
                        var data =  $.parseJSON(r);
                        if(data["status"] ==200){
                                alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Datos enviados registrados de forma exitosa!</p></strong>",function(){
                                        $ruta1 = "{{url('solicitudesPost/certificacionpdf')}}?idSolicitud="+data["idSolicitud"];
                                        window.open($ruta1);
                                        window.location.href=route('admin.certificacion.post');
                                });
                        }else if(data["status"]==404){
                                alertify.alert("Mensaje de sistema - Advertencia", data["message"]);
                        }
                    },
                    error: function(data){
                        // Error...
                        alertify.alert("Mensaje del Sistema","No se ha podido realizar la carga de los datos, por favor contacte al administrador del sistema!");
                        var errors = $.parseJSON(data.message);
                        console.log(errors);

                    }

                });

        });


    </script>

@endsection
