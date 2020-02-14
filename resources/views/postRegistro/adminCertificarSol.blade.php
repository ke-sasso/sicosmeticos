@extends('master')

@section('css')

@endsection

@section('contenido')

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
        {{--<div class="btn-toolbar top-table" role="toolbar" id="top-table">
            <div class="btn-group">
                <a href="{{route('certificaciones.post')}}" target="_blank" class="btn btn-info btn-rounded-lg btn-sm">IMPRIMIR TODAS </a>
            </div>
        </div><!-- /.btn-toolbar top-table --> --}}

        <div class="table-responsive">
            <table width="100%"  style="font-size: 11px;" id="dt-sol" class="table table-hover table-striped">
                <thead class="the-box dark full">
                <tr>
                    <th>Correlativo de Solicitud</th>
                    <th>Número de Solicitud</th>
                    <th>No Registro</th>
                    <th >Nombre Comercial</th>
                    <th>Tipo Producto</th>
                    <th>Trámite</th>
                    <th>Origen</th>
                    <th>Estado</th>
                    <th>Días transcurridos</th>
                    <th>Fecha de Ingreso</th>
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

    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#dt-sol').DataTable({
                filter: true,
                searching: true,
                processing: true,
                serverSide: true,
                autoWidth: true,
                scrollX: true,
                order: [[9, "asc"]],
                ajax: {
                    url: "{{route('dtrows.certificar.sol.post')}}",

                },
                columns: [
                    {data: 'idSolicitud', name: 'idSolicitud', orderable: true},
                    {data: 'numeroSolicitud', name: 'numeroSolicitud', orderable: true},
                    {data: 'noRegistro', name: 'noRegistro', orderable: true},
                    {data: 'nombreComercial', name: 'nombreComercial', orderable: true},
                    {data: 'tipoProducto', name: 'tipoProducto', orderable: true},
                    {data: 'nombreTramite', name: 'nombreTramite', orderable: true},
                    {data: 'origen', name: 'origen', orderable: true},
                    {data: 'estado', name: 'estado', orderable: true},
                    {data: 'diasTranscurridos', name: 'diasTranscurridos', orderable: false,searchable:false},
                    {data: 'fechaCreacion', name: 'fechaCreacion', orderable: true},
                    {data: 'plazo', name: 'plazo', orderable: false,searchable:false},
                    {data: 'opciones', name: 'opciones', orderable: false,searchable:false}

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
        });

    </script>

@endsection