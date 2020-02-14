
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
                            <th>-</th>
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
                                    @if($dic->idEstado==4)
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

        @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
        <form action="{{route('store.revision.post')}}" method="post" id="revisionForm" enctype="multipart/form-data">
               {{ csrf_field() }}
        @endif

                @if(isset($solicitud))
                    <input type="hidden" value="{{Crypt::encrypt($solicitud->idSolicitud)}}" name="idSolicitud">
                @endif
                <div class="row">
                    <div class="col-sm-6 form-group">
                                         <label>Tipo de producto:</label>
                                         @if(isset($solicitud))
                                                 @if($solicitud->tipoProducto=='COS')
                                                     <input type="radio" name="tipoProducto" id="inlineRadio1" value="COS" checked  style="display: none;">
                                                     <input type="text" class="form-control" value="COSMÉTICO" disabled>
                                                 @else
                                                    <input type="radio" name="tipoProducto" id="inlineRadio1" value="HIG" checked   style="display: none;">
                                                    <input type="text" class="form-control" value="HIGIÉNICO" disabled>
                                                 @endif
                                        @endif
                    </div><!-- /.col-sm-6 -->
                    <div class="col-sm-6 form-group">
                        <label>Tipo de trámite:</label>
                        @if(isset($solicitud))
                             <input type="hidden" value="{{$solicitud->tramite->idTramite}}" name="idTramite">
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
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="alert alert-warning alert-block fade in alert-dismissable">
                                                <strong>Si el producto no esta actualizado, puede dar clic en el botón Editar!</strong>
                                            </div>
                                        </div>
                                            <div class="col-md-2">
                                                @if($solicitud->tipoProducto=='COS')
                                                    <a href="{{route('vercosmetico',['idCosmetico'=>Crypt::encrypt($solicitud->noRegistro),'opcion'=>Crypt::encrypt(1)])}}" target="_blank" class="btn btn-warning btn-rounded-lg">Editar <i class="fa fa-pencil"></i></a>
                                                @else
                                                    <a href="{{route('verhigienico',['indexhigienico'=>Crypt::encrypt($solicitud->noRegistro),'opcion'=>Crypt::encrypt(1)])}}" target="_blank" class="btn btn-warning btn-rounded-lg">Editar <i class="fa fa-pencil"></i></a>
                                                @endif
                                            </div>
                                            <div class="col-md-2">
                                                <a onclick="getTabsProducto('{{$solicitud->noRegistro}}')" class="btn btn-info btn-rounded-lg">Actualizar <i class="fa fa-undo"></i></a>
                                            </div>
                                    </div>
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
                    @elseif($solicitud->tramite->idTramite==11 || $solicitud->tramite->idTramite==17)
                        @include('postRegistro.tramites.formula11-17')
                    @elseif($solicitud->tramite->idTramite==14 || $solicitud->tramite->idTramite==23)
                        @include('postRegistro.tramites.nombreComercial14-23')
                    @elseif($solicitud->tramite->idTramite==16 || $solicitud->tramite->idTramite==18)
                        @include('postRegistro.tramites.presentaciones16-18')
                    @endif
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">MANDAMIENTO DE PAGO</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 form-group form-inline">
                                        <label>No. Mandamiento:</label>
                                        <input type="text" id="mandamiento" name="mandamiento" class="form-control" />
                                        <button  type="button" name="validar" id="validarMandamiento" class="btn btn-primary btn-perspective">Validar</button>
                                    </div>
                                </div>
                            </div>
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
       @if($solicitud->idEstado==1 || $solicitud->idEstado==2 || $solicitud->idEstado==4 || $solicitud->idEstado==11)
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <div class="panel panel-success">
                            <div class="panel-heading">DICTAMINAR SOLICITUD</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label>Observaciones:</label>
                                        <textarea rows="3" class="form-control" id="observaciones" value="" name="observaciones"></textarea>
                                    </div>
                                    <div class="col-xs-6 form-group">
                                        <label>Estado del trámite:</label>
                                        <select class="form-control" value="" id=estado name="estado" placeholder="Seleccione el estado:" required="true">
                                            <option value="" disabled selected hidden>Seleccione...</option>
                                            @if(isset($estados))
                                                @foreach($estados as $est)
                                                    <option value="{{$est['idEstado']}}">{{$est['estado']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row text-center" id="enviarDatos">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

        </form>
        @endif
    </div>
    @include('postRegistro.panel.modalPresentacion')

@endsection

@section('js')
    {!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
    {!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
    {!! Html::script('plugins/bootstrap-fileinput/js/fileinput.js') !!}
    {!! Html::script('plugins/bootstrap-fileinput/js/locales/es.js') !!}
    {!! Html::script('plugins/bootstrap-fileinput/themes/explorer-fa/theme.js') !!}
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

                    validarMandamientoRevision(mandamiento);

                    tipoProducto='{{$solicitud->tipoProducto}}';

                    getTabsProducto('{{$solicitud->noRegistro}}');

                };
            @endif

        });
         $.each($('input[type=file]'), function () {
                            $('#' + $(this).attr('id')).fileinput({
                                theme: 'fa',
                                language: 'es',
                                allowedFileExtensions: ['pdf'],
                                showUpload : false
                            });

         });

        function enviarRevision(formData,formURL){
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
                                estado=$('#estado option').filter(':selected').val();
                                alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Datos enviados registrados de forma exitosa!</p></strong>",function(){
                                        $ruta1 = "{{url('solicitudesPost/dictamen/herramienta')}}/"+data["idDictamen"];
                                        window.open($ruta1);
                                    if(estado==='4'){
                                        //OBSERVADA
                                        $ruta2 = "{{url('solicitudesPost/dictamen/resolucion')}}/"+data["idDictamen"];
                                        window.open($ruta2);
                                    }
                                    location.reload();
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

        };

        $('#revisionForm').submit(function(event) {
            event.preventDefault(); //this will prevent the default submit
            estado=$('#estado option').filter(':selected').val();
            var formObj = $(this);
            var formURL = formObj.attr("action");
            var formData = new FormData(this);

            var submit = $(this).find(':submit');
            if(estado!=3){
                if($('textarea[name="observaciones"]').val()==""){
                    alertify.alert("Mensaje del Sistema","Debe digitar una observacion si el estado de la resolución es diferente de FAVORABLE!")
                    return false;
                }else{
                     enviarRevision(formData,formURL);
                }
            }else{
                enviarRevision(formData,formURL);
            }

        });

        function validarMandamientoRevision(mandamiento){
                $.ajax({
                    data:{ mandamiento: mandamiento},
                    url:  route('validar.mandamiento.revision'),
                    type:  'POST',
                    success:  function (r){
                        if(r.status == 200){

                            $('#mandamiento').prop('readonly', true);
                            var total=0;
                            $('#idMand').val(r.data[0].id_mandamiento);
                            $('#idCliente').val(r.data[0].id_cliente);
                            $('#nombreMand').val(r.data[0].a_nombre);
                            $('#pago').val(r.data[0].fecha);
                            var idrecibo = r.data[0].ID_RECIBO;

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
                            console.log(idrecibo);
                            if(!idrecibo){
                                alertify.alert("Mensaje de sistema - Advertencia", 'El mandamiento de esta solicitud no ha sido pagado.');
                                $('#enviarDatos').hide();
                            }

                        }
                        else if(r.status == 404)
                        {

                                alertify.alert("Mensaje de sistema - Advertencia", r.message);
                        }
                    },

                });
        }
        $('.select').change(function(){

                var index=this.id.split('-');

                var val=$(this).val();

                if(val==0){
                //  alert(val);
                    $('.tx'+index[1]).removeAttr('readonly');
                    $('.tx'+index[1]).attr('required','true');

                } else {
                    $('.tx'+index[1]).attr('readonly','true');
                    $('.tx'+index[1]).removeAttr('required');
                }
                //alert("hola");
        });

function cambiar(row){
    var nomdoc= $(row).data('nombre');
    var id= $(row).data('idrequisito');
    var td=$(row).closest('td');

    alertify.confirm("Mensaje de sistema", "Esta seguro que desea eliminar el documento "+nomdoc+"?", function (asc) {
        if (asc) {
            td.empty();
            td.append(' <div class="file-loading"><input id="file'+id+'" name="file-es['+id+']" type="file" required="true"></div>');
            $('#file' + id).fileinput({
                theme: 'fa',
                language: 'es',
                allowedFileExtensions: ['pdf'],
                showUpload : false
            });
        } else {
        }
    }, "Default Value").set('labels', {ok: 'SI', cancel: 'NO'});
  }






    </script>

@endsection
