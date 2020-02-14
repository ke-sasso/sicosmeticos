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

    <div class="panel panel-success">
        <div class="panel-heading" >
            <h3 class="panel-title">
                <a class="block-collapse collapsed" id='colp' data-toggle="collapse" href="#collapse-filter">
                    B&uacute;squeda Avanzada de Solicitudes Nuevo-Registro
                    <span class="right-content">
                <span class="right-icon"><i class="fa fa-plus icon-collapse"></i></span>
            </span>
                </a>
            </h3>
        </div>



        <div id="collapse-filter" class="collapse" style="height: 0px;">
            <div class="panel-body">

                {{-- COLLAPSE CONTENT --}}
                <form role="form" id="search-form">
                    <div class="rows">
                        <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <label>Número de presentación:</label>
                            <input type="number" class="form-control" name="numsol" id="numsol" autocomplete="off">
                        </div>
                      
                         <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <label>Fecha Ingreso:</label>
                             <input type="text" name="fecha"  id="fecha" class="form-control  datepicker date_masking2" placeholder="yyyy-mm-dd"  data-date-format="yyyy-mm-dd"  autocomplete="off">
                        </div>
                    </div>
                    <div class="rows">
                        <div class="form-group col-xs-6 col-sm-6 col-md-4 col-lg-4">
                            <label>Estado de Tramite:</label>
                            <select name="idestado" id="idestado" class="form-control">
                                <option value="">Seleccione...</option>
                                 @if(count($estados)>0)
                                     @foreach($estados as $est)
                                            <option value="{{$est->idEstado}}">{{$est->estado}}</option>
                                     @endforeach
                                 @endif
                            </select>
                        </div>
                        <div class="form-group col-xs-6 col-sm-6 col-md-4 col-lg-4">
                            <label>Tipo de solicitud:</label>
                            <select name="idtipo" id="idtipo" class="form-control">
                                <option value="">Seleccione....</option>
                                @if(count($tramites)>0)
                                @foreach($tramites as $tra)
                                       <option value="{{$tra->idTramite}}">{{$tra->nombreTramite}}</option>
                                @endforeach
                            @endif
                            </select>
                        </div>
                           <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                           <label>Origen:</label>
                           <select name="origen" id="origen" class="form-control">
                            <option value="" selected>Seleccione...</option>
                            <option value="0">DNM</option>
                            <option value="1">PORTAL EN LÍNEA</option>  </select>
                           </div>
                    </div>
                    <div class="rows">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label>Nombre Comercial:</label>
                            <input type="text" name="nomComercial" id="nomComercial" autocomplete="off" class="form-control">
                        </div>
                        
                    </div>
                     <div class="rows">
                      <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="modal-footer" >
                            <div align="center">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                                <button type="submit" class="btn btn-success btn-perspective"><i class="fa fa-search"></i> Buscar</button>
                                <a id="limpiar" class="btn btn-warning btn-perspective"><i class="fa  fa-eraser"></i> Limpiar</a>
                            </div>
                        </div>
                        </div>
                    </div>
                </form>
                {{-- /.COLLAPSE CONTENT --}}
            </div><!-- /.panel-body -->
        </div><!-- /.collapse in -->
    </div>

    <div class="panel-body" style="margin-top: 30px;">
        <div class="table-responsive">
            <table width="100%" style="font-size: 12px;" id="dt-sol" class="table table-hover table-striped">
                <thead class="the-box dark full">
                <tr>
                    <th>Número de Presentación</th>
                    <th>Fecha de Ingreso</th>
                    <th>Tipo de Solicitud</th>
                    <th width="25%">Nombre Comercial</th>
                    <th>Origen</th>
                    <th>Días transcurridos</th>
                    <th>Estado</th>
                    <th>Plazo</th>
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
            
            $('.datepicker').datepicker({format: 'yyyy-mm-dd'});
            $('.date_masking2').mask('0000-00-00');

            var table = $('#dt-sol').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                order: [[ 0, "desc" ]],
                ajax: {
                    url: "{{route('dt.row.data.sol')}}",
                    data: function (d) {
                        d.numsol= $('#numsol').val();
                        d.nomComercial= $('#nomComercial').val();
                        d.idestado= $('#idestado').val();
                        d.fecha = $('#fecha').val();
                        d.idtipo = $('#idtipo').val();
                        d.origen = $('#origen').val();
                    }
                },
                columns: [
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
                    "sProcessing": '<div class=\"dlgwait\"></div>',
                    "url": "{{ asset('plugins/datatable/lang/es.json') }}"

                },
                columnDefs: [
                    {

                        "visible": false
                    }
                ]

            });
            $('#search-form').on('submit', function(e) {
                    table.draw();
                    e.preventDefault();
                    $("#colp").attr("class", "block-collapse collapsed");
                    $("#collapse-filter").attr("class", "collapse");
            });
            table.rows().remove();
        });
        $("#limpiar").click(function() {
            $('#search-form')[0].reset();
        });
    </script>

@endsection