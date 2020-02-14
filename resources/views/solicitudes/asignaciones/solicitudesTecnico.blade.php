@extends('master')

@section('css')

@endsection

@section('contenido')

    @if(Session::has('message'))
        <div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>{{Session::get('message')}}</strong>
        </div>
    @endif

    <div class="panel-body" style="margin-top: 30px;">
        <div class="table-responsive">
            <table width="100%" style="font-size: 12px;" id="dt-sol" class="table table-hover table-striped">
                <thead class="the-box dark full">
                <tr>
                    <th>Número de Solicitud</th>
                    <th>Número de Presentación</th>
                    <th>Fecha de Ingreso</th>
                    <th>Tipo de Solicitud</th>
                    <th width="25%">Nombre Comercial</th>
                    <th>Origen</th>
                    <th>Días transcurridos</th>
                    <th>Estado</th>
                    <th>Plazo</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('js')

    <script>
        $(document).ready(function () {
            var table = $('#dt-sol').DataTable({
                filter: true,
                searching: true,
                processing: true,
                serverSide: false,
                order: [2, "desc"],
                ajax: {
                    url: "{{route('solicitudes.get.pre.tecnico')}}",

                },
                columns: [
                    {data: 'idSolicitud', name: 'idSolicitud', orderable: true},
                    {data: 'numeroSolicitud', name: 'numeroSolicitud', orderable: true},
                    {data: 'fecha', name: 'fecha', orderable: true},
                    {data: 'nombreTramite', name: 'nombreTramite', orderable: true},
                    {data: 'nombreComercial', name: 'nombreComercial', orderable: true},
                    {data: 'origen', name: 'origen', orderable: true},
                    {data: 'diasTranscurridos', name: 'diasTranscurridos', orderable: false,searchable:false},
                    {data: 'estado', name: 'estado', orderable: true},
                    {data: 'plazo', name: 'plazo', orderable: false,searchable:false},
                    {data: 'opciones', name: 'opciones', searchable: false, orderable: false}

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
        function seleccionar() {
            if ($('input[type=checkbox]').prop('checked')) {
                //   alert("hola");
                $('.checkAll').prop('checked', 'true');
            } else {
                $('.checkAll').removeProp('checked');
            }

        }

        $('#asignarSolUsuario').submit(function(e){
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


    </script>

@endsection