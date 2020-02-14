@extends('master')

@section('css')

@endsection

@section('contenido')

    @if(Session::has('message'))
        <div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('message')}}
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

    <div class="panel-body" style="margin-top: 20px;">
        <input type="hidden" value="{{$sesion}}" id="sesion">

        <div class="table-responsive">
            <table width="100%" style="font-size: 12px;" id="dt-solFav" class="table table-hover table-striped">
                <thead class="the-box dark full">
                <tr>
                    <th>Número de Solicitud</th>
                    <th>Tipo de Solicitud</th>
                    <th>Nombre Comercial</th>
                    <th>Estado</th>
                    <th>Agregar <input type="checkbox" name="all" onclick="seleccionar();" /></th>                    
                </tr>

                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <form name="solicitudesSes" method="POST" role="form" enctype="multipart/form-data"
              action="{{route('agregarSolicitudesAsesion')}}">
            <div id="sol"></div>
            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" class="form-control"/>
            <input type="hidden" id="nomsesion" name="nomsesion"/>
            <input type="submit" value="Agregar" id="agregarSol" class="btn btn-success">
        </form>

    </div>


@endsection

@section('js')

    <script>
        $(document).ready(function () {
            var idsesion = $('#sesion').val();
            // alert(idsesion);
            var token = $('#token').val();
            var table = $('#dt-solFav').DataTable({
                filter:true,
                processing: true,
                serverSide: false,           
                scrollY: '450',
                paging: false,        
                lengthChange: false,
                order: [[0, "desc"]],
                ajax: {

                    url: "{{route('dt.row.data.sol.fav')}}",
                    data: {"idsesion": idsesion},
                    type: 'GET',
                },
                columns: [
                    {data: 'idSolicitud', name: 'idSolicitud', orderable: false},
                    {data: 'nombreTramite', name: 'nombreTramite', orderable: false},
                    {data: 'nombreComercial', name: 'nombreComercial', orderable: false},
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


        function seleccionar() {
            if ($('input[type=checkbox]').prop('checked')) {
                //   alert("hola");
                $('.checkAll').prop('checked', 'true');
            } else {
                $('.checkAll').removeProp('checked');
            }

        }

        $('#agregarSol').click(function () {
            var sol = [];
            var nomsesion = $('#sesion').val();
            $('#nomsesion').val(nomsesion);

            $('input[name="solChek[]"]:checked').each(function () {
                var input = "";
                input += '<input type="hidden" name="sol[]" value="' + $(this).val() + '">';
                $('#sol').append(input);

            });
        });

    </script>

@endsection