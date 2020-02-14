@extends('master')

@section('css')

@endsection

@section('contenido')

    @if(Session::has('message'))
        <div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get('message')}}
        </div>
    @endif

    <div class="panel-body" style="margin-top: 20px;">
        <div class="table-responsive">
            <table width="100%" style="font-size: 12px;" id="dt-solFav" class="table table-hover table-striped">
                <thead class="the-box dark full">
                <tr>
                    <th>Número de Solicitud</th>
                    <th>N° Registro</th>
                    <th>Nombre Comercial</th>
                    <th>Trámite</th>
                    <th>Estado</th>
                     <th>Certificar<input type="checkbox" name="all" onclick="seleccionar();" /></th>
                </tr>

                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-4">
                   <form name="certificarSolicitudesPost" id="certificarSolicitudesPost" method="POST" role="form" action="{{route('sesion.certificar.postSol')}}">
                    <div id="sol"></div>
                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                    <input type="hidden" id="idSesion" name="idSesion" value="{{$sesion->idSesion}}"/>
                    <button type="submit"  class="btn btn-primary">CERTIFICAR SOLICITUDES</button>
                   </form>
            </div>
            {{--<div class="col-md-4">
                <a href="{{route("imprimir.solicitudes",['sesion'=>$sesion])}}" id="imprimir" target="_blank" class="btn btn-success impr">IMPRIMIR TODAS</a>
                <label>Tamaño de fuente:</label>
                  <select name="fuente" id="fuente">
                    <option value="14">14</option>
                    @for($i=10;$i<=20;$i++)
                      <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>--}}
        </div>

    </div>


@endsection

@section('js')
    {!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}

    <script type="text/javascript">
        var table;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#token').val()
            }
        });

        $(document).ready(function () {
            var idsesion = '{{$sesion->idSesion}}';

            var token = $('#token').val();
            table = $('#dt-solFav').DataTable({
                filter:true,
                processing: true,
                serverSide: false,
                scrollY: '450',
                paging: false,
                lengthChange: false,
                order: [[0, "desc"]],
                ajax: {

                    url: "{{route('dt.rows.sols.sesionespost')}}",
                    data: {"idsesion": idsesion},
                    type: 'GET',
                },
                columns: [
                    {data: 'numSolicitud', name: 'numSolicitud', orderable: false},
                    {data: 'noRegistro', name: 'noRegistro', orderable: false},
                    {data: 'nombreComercial', name: 'nombreComercial', orderable: false},
                    {data: 'nombreTramite', name: 'nombreTramite', orderable: false},
                    {data: 'estado', name: 'estado', orderable: false},
                    {data: 'agregar', name: 'agregar', orderable: false}

                ],
                language: {
                    //"sProcessing": '<div class=\"dlgwait\"></div>',
                    "url": "{{ asset('plugins/datatable/lang/es.json') }}"

                },
                columnDefs: [
                    {

                        "visible": false
                    }
                ]

            });

            /* $('#dt-cos').on('submit',function(e) {

                 table.draw();
                 e.preventDefault();

             });

             table.rows().remove();*/


        });

        function desaprobar(idSol){
            console.log('holña');
            idSesion='{{$sesion->idSesion}}';

            $.ajax({
                url:  '{{route('desaprobarsol.sesionpost')}}',
                data: {idSolicitud: idSol,idSesion:idSesion},
                type: 'POST',
                beforeSend: function() {
                    $('body').modalmanager('loading');
                },
                success:  function (r){
                    $('body').modalmanager('loading');
                    table.ajax.reload();
                },
                error: function(data){
                    // Error...
                    console.error(data);
                    $('body').modalmanager('loading');
                    alertify.alert("Mensaje del Sistema","No se ha podido realizar la carga de los datos del producto!, por favor contacte al administrador del sistema!");
                }
            });
        }

        function seleccionar() {
            if ($('input[type=checkbox]').prop('checked')) {
                //   alert("hola");
                $('.checkAll').prop('checked', 'true');
            } else {
                $('.checkAll').removeProp('checked');
            }

        }

        $('#certificarSolicitudesPost').submit(function(e){
             e.preventDefault();
                var sol = [];
                $('input[name="solChek[]"]:checked').each(function () {
                    var input = "";
                    input += '<input type="hidden" name="sol[]" value="' + $(this).val() + '">';
                    $('#sol').append(input);

                });

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
                                alertify.alert("Mensaje de Sistema",data["message"],function(){
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

        });

    function printCert(id){
          var sesion=$('#idSesion').val();
          var fuente=$('#fuente').val();
          window.open('{{ route('certificacion.requisito.post')}}?idSolicitud='+id);

    }

    function actualizarDocumento(idSolicitud,tipoDocumento,numeroSolicitud){
    alertify.confirm("Mensaje de sistema", "¿Esta seguro que desea volver a generar y guardar el documento  de la solicitud?", function (asc) {
        if (asc) {
              $.ajax({
                          data: {idSolicitud:idSolicitud, tipoDocumento:tipoDocumento},
                          url: '{{route("post.cambiarestado.documentocertificacion")}}',
                          type: 'post',
                          success:  function (r){
                            if(r.status == 200){
                                   alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>"+r.message+"</p></strong>",function(){
                                          if(tipoDocumento===3){
                                              //FAVORABLE
                                              printCert(r.idSolicitud);
                                          }else{
                                              //DESFAVORABLE
                                              $ruta = "{{url('solicitudesPost/resolucion/desfavorable')}}/"+r.idSolicitud;
                                              window.open($ruta);
                                          }
                                          location.reload();
                                  });
                             } else if(r.status == 404){
                                  alertify.alert("Mensaje de error", r.message);
                             }
                         }
              });
        }
    }, "Default Value").set('labels', {ok: 'SI', cancel: 'NO'});
   }




    </script>

@endsection