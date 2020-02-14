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
    @if(Session::has('messageSol'))
        <div class="alert alert-warning" role="alert" style="width: 100%; margin-top: 10px; ">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('messageSol')}}
        </div>
    @endif
    @if(Session::has('messageDet'))
        <div class="alert alert-warning" role="alert" style="width: 100%; margin-top: 10px; ">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('messageDet')}}
        </div>
    @endif
    @if(Session::has('messageCos'))
        <div class="alert alert-warning" role="alert" style="width: 100%; margin-top: 10px; ">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('messageCos')}}
        </div>
    @endif
    @if(Session::has('messageHig'))
        <div class="alert alert-warning" role="alert" style="width: 100%; margin-top: 10px; ">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('messageHig')}}
        </div>
    @endif
    @if(Session::has('messageProf'))
        <div class="alert alert-warning" role="alert" style="width: 100%; margin-top: 10px; ">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('messageProf')}}
        </div>
    @endif

    <div class="panel-body" style="margin-top: 30px;">
        <div class="table-responsive">
            <table width="100%" style="font-size: 12px;" id="dt-noti" class="table table-hover table-striped">
                <thead class="the-box dark full">
                <tr>
                    <th>Número de Solicitud</th>
                    <th>Número de Presentación</th>
                    <th>Número de Registro</th>
                    <th width="25%">Nombre Comercial</th>
                    <th>Tipo de Solicitud</th>
                    <th>Fecha de Ingreso</th>
                    <th>Origen</th>                    
                    <th>Opciones</th>

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
            var table = $('#dt-noti').DataTable({
                filter: true,
                searching: true,
                processing: true,
                serverSide: true,
                order: [[0, "desc"]],
                ajax: {
                    url: "{{route('dt.row.data.noti')}}",

                },
                columns: [
                    {data: 'idSolicitud', name: 'idSolicitud', orderable: true},
                    {data: 'numeroSolicitud', name: 'numeroSolicitud', orderable: true},
                    {data: 'idProducto', name: 'idProducto', orderable: true},
                    {data: 'nombreComercial', name: 'nombreComercial', orderable: true},
                    {data: 'nombreTramite', name: 'nombreTramite', orderable: true},
                    {data: 'fecha', name: 'fecha', orderable: true},                                       
                    {data: 'origen', name: 'origen', orderable: true},
                    {data: 'opciones', name: 'opciones', searchable: false, orderable: true}

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

    </script>

@endsection