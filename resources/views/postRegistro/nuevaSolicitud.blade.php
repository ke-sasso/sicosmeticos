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



    <div class="panel-body">
        <!-- BEGIN FORM WIZARD -->


            <div class="the-box full no-border">
                <div class="container-fluid">
                <form action="{{route('store.post')}}" method="post" id="SolicitudPostForm" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="mancos" id="mancos" value="">
                    <input type="hidden" name="manhig" id="manhig" value="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-inline">
                                    <label>Seleccione el tipo de producto:</label></br>
                                    <div class="radio">
                                        <label class="radio-inline">
                                            <input type="radio" name="tipoProducto" id="inlineRadio1" value="COS" required> Cósmetico
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label class="radio-inline">
                                            <input type="radio" name="tipoProducto" id="inlineRadio2"  value="HIG" required> Higiénico
                                        </label>
                                    </div>
                                </div>
                            </div><!-- /.col-sm-6 -->
                            <div class="col-md-9 form-group">
                                 <label for="searchbox-producto">Seleccione el No. Registro:</label>
                                <select id="searchbox-producto" name="qe" placeholder="Buscar por No. Registro o por nombre del producto" class="form-control" required></select>
                                <div class="help-block with-errors"></div>
                            </div><!-- /.col-sm-6 -->
                        </div><!-- /.row -->
                        <div class="row">
                             <div class="col-sm-12 form-group">
                                <label>Seleccione el tipo de trámite:</label>
                                <select data-placeholder="Seleccionar un tipo de trámite..." name="tipoTramite" id="tipoTramite" class="form-control chosen-select" required>
                                   <option value="" disabled selected hidden>Seleccione un trámite...</option>
                                    @foreach($tramites as $tra)
                                        <option value="{{$tra['idTramite']}}" data-mancos="{{Crypt::encrypt($tra['tipoPagoCos'])}}" data-manhig="{{Crypt::encrypt($tra['tipoPagoHig'])}}">{{$tra['nombreTramite']}}</option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                            </div><!-- /.col-sm-6 -->
                        </div>
                        <div class="row" >
                            <div class="col-sm-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">GENERALES DEL PRODUCTO</div>
                                    <div class="panel-body" id="dataProducto">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DINAMICO DEPENDIENDO DEL TRÁMITE -->
                        <div class="row" id="tramitesDiv">

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">VALIDAR MANDAMIENTO</div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-4 form-group">
                                                <label>No. Mandamiento:</label>
                                                <input type="text" id="mandamiento" name="mandamiento" class="form-control" required="true"/>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                            <br/>
                                            <div class="col-xs-4">
                                                <button  type="button" name="validar" id="validarMandamiento" class="btn btn-primary btn-perspective">Validar</button>
                                            </div>
                                            <div class="col-xs-4">
                                            {{--
                                                <button  type="button" name="generarMandamiento" id="generarMandamiento" class="btn btn-primary btn-perspective"><i class="fa fa-file-text-o"></i> Generar Mandamiento</button>
                                            </div>--}}
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
                                        @include('solicitudes.paneles.personaContacto')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <div class="panel panel-success">
                                    <div class="panel-heading">SUBIDA DE DOCUMENTOS</div>
                                    <div class="panel-body" id="docs">
                                        @include('postRegistro.documentos')
                                    </div>
                                </div>
                            </div>
                        </div>
                    <input type="hidden" name="generoMandamiento" id="generoMandamiento" value="0">
                    <div class="text-center">
                        <button type="submit" id="btnSubmit"  class="btn btn-success">Guardar Solicitud</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END FORM WIZARD -->
    </div>

    @include('modals.personaContacto')
    @include('postRegistro.panel.modalPresentacion')


@endsection

@section('js')
    {!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
    {!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
    {!! Html::script('plugins/bootstrap-fileinput/js/fileinput.js') !!}
    {!! Html::script('plugins/bootstrap-fileinput/js/locales/es.js') !!}
    {!! Html::script('plugins/bootstrap-fileinput/themes/explorer-fa/theme.js') !!}
    {!! Html::script('js/postregistro/nuevasolicitud.js') !!}
    @routes()
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.NextStep').click(function(event){

            var stepNumber=$(this).data('step');
            var elmForm = $("#wizard-1-step" + stepNumber);
            if(elmForm)
            {
                elmForm.validator('validate');
                var elmErr = elmForm.children('.has-error');
                console.log(elmErr);
                console.log(elmErr.length);
                if(elmErr && elmErr.length > 0)
                {
                    // Form validation failed
                    event.stopImmediatePropagation();
                    console.log("Error");
                }
            }
            //console.log($(this).data('step'));
        });

        $(function() {
            $.each($('input[type=file]'), function () {
                $('#' + $(this).attr('id')).fileinput({
                    theme: 'fa',
                    language: 'es',
                    allowedFileExtensions: ['pdf'],
                    showUpload : false
                });

            });


        });

        $('#SolicitudPostForm').submit(function(e){
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
                                alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>¡Solicitud registrada de forma exitosa!</p></strong>",function(){
                                    window.location.href=route('administrador.post');
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
                e.preventDefault();
        });


    </script>

@endsection
