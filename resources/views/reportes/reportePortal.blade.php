@extends('master')

@section('css')
    {!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!}
    {!! Html::style('plugins/bootstrap-modal/css/bootstrap-modal.css') !!}
    {!! Html::style('plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') !!}
    <style type="text/css">

        body {

        }
        .dlgwait {
            display:    inline;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .3 )
            url("{{ asset('/img/ajax-loader.gif') }}")
            50% 50%
            no-repeat;
        }
        .modal {
            width:      100%;
            background: rgba( 255, 255, 255, .8 );
        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .dlgwait {
            display: block;
        }
        td.details-control {
            background: url("{{ asset('/plugins/datatable/images/details_open.png') }}") no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url("{{ asset('/plugins/datatable/images/details_close.png') }}") no-repeat center center;
        }


    </style>
@endsection

@section('contenido')

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
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
            <strong>Enhorabuena!</strong>
            {{ Session::get('msnExito') }}
        </div>
    @endif
    {{-- MENSAJE DE ERROR --}}
    @if(Session::has('msnError'))
        <div id="error" class="alert alert-danger square fade in alert-dismissable">
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
            <strong>Error:</strong>
            Algo ha salido mal{!! Session::get('msnError') !!}
        </div>
    @endif

    <div class="panel panel-success">
        <div class="panel-heading" >
            <h3 class="panel-title">
                <a class="block-collapse collapsed" id='colp' data-toggle="collapse" href="#collapse-filter">
                    B&uacute;squeda Avanzada de Solicitudes de Portal en Linea
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
                    <div class="row">
                        
                        <div class="col-xs-6">
                        <label>Fecha de inicio:</label><br>
                            <input type="date" class="form-control" name="fechaInicio" id="fechaInicio">
                        </div> 
                        <div class="col-xs-6">
                        <label>Fecha fin:</label><br>
                            <input type="date" class="form-control" name="fechaFin" id="fechaFin">
                        </div>                         
                    </div>
                    <br>

                    <div class="group-control" id="tipoTitular">
                        <div>
                             <label>Tipo de Titular:</label>
                        </div>
                        <input type="radio" name="tipoT" value="1"> Persona Natural
                        <input type="radio" name="tipoT" value="2"> Persona Jurídica
                        <input type="radio" name="tipoT" value="3"> Extranjero
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <label>Nombre Titular: </label>
                            <select class="form-control input-sm" name="nombre_propietario" value="" id="nombre_propietario" placeholder="Buscar por nombre de Titular:"></select>
                        </div>   
                        <div class="col-xs-6">
                            <label>Poder de Profesional: </label>
                            <select class="form-control input-sm" name="ID_PODER" value="" id="ID_PODER"
                                    placeholder="Buscar por número de Poder:"></select>

                        </div>
                    </div>

                    <div class="modal-footer" >
                        <div align="center">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                            <button type="submit" class="btn btn-success btn-perspective"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </form>
                {{-- /.COLLAPSE CONTENT --}}
            </div><!-- /.panel-body -->
        </div><!-- /.collapse in -->
    </div>

    <div class="panel panel-success">

        <div class="panel-heading">
            <h3 class="panel-title">SOLICITUDES DE PORTAL EN LINEA</h3>
        </div>
        <div class="panel-body">
            
            <div class="table-responsive">
                <table style="font-size: 12px;" id="dt-solicitudportal" class="table table-hover table-striped" role="group" width="100%">
                    <thead>
                    <tr>
                        <th>N° SOLICITUD</th>
                        <th>N° PRESENTACIÓN</th>
                        <th>NOMBRE PREFESIONAL</th>
                        <th>NOMBRE PRODUCTO</th>
                        <th>TITULAR PRODUCTO</th>
                        <th>PRESENTACIONES</th>                        
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@section('js')
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
{!! Html::script('https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js') !!}
{!! Html::script('https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js') !!}
{!! Html::script('https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js') !!}
{!! Html::script('https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js ') !!}
    <script type="text/javascript">


        $( document ).ready(function() {

            var table = $('#dt-solicitudportal').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                dom: 'Bfrtip',
                buttons: [
                        {
                            extend: 'excel',
                            title: 'Reporte Solicitudes Portal'
                        }],
                ajax: {
                    url: "{{route('solportal.dtrows-sol')}}",
                    data: function (d) {
                        d.fechaInicio= $('#fechaInicio').val();
                        d.fechaFin= $('#fechaFin').val();
                        d.idTitular= $('#nombre_propietario').val();
                        d.idProfesional= $('#ID_PODER').val();
                    }
                },
                columns: [
                    {data: 'numeroSolicitud', name: 'numeroSolicitud'},
                    {data: 'numeroPresentacion', name: 'numeroPresentacion'},
                    {data: 'nombreProfesional', name: 'nombreProfesional',orderable:false},
                    {data: 'nombreProducto', name: 'nombreProducto'},
                    {data: 'titularProducto', name: 'titularProducto'},
                    {data: 'presentaciones', name: 'presentaciones'}                    


                ],
                language: {
                    "sProcessing": '<div class=\"dlgwait\"></div>',
                    "url": "{{ asset('plugins/datatable/lang/es.json') }}"
                },
                order: [[ 0, "asc" ]]

            }); //en Datatable

            $('#search-form').on('submit', function(e) {

                table.draw();
                e.preventDefault();
                $("#colp").attr("class", "block-collapse collapsed");
                $("#collapse-filter").attr("class", "collapse");
            });

            table.rows().remove();

            $('.table').on("click", '.btnEliminarSolCos', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')     // SET TOKEN BEFORE DELETE
                    }
                });
                var elemento = $(this);
                var id = $(this).val();
                var deleteUrl = "{{url('pre-sol-cos/eliminar-solCosm')}}/" + id;
         
                console.log(deleteUrl);
                alertify.confirm("Mensaje de sistema", "Esta a punto de eliminar esta solicitud! no podrá recuperarla. ¿Está seguro que desea eliminarla?", function (asc) {
                if (asc) {
                    $.ajax({
                        type: "GET",
                        url: deleteUrl,
                        success: function (data) {
                            elemento.parent('td').parent('tr').remove();
                            alertify.alert("Mensaje de sistema","Se eliminó su solicitud correctamente!");
                            console.log(elemento.val() +'dsadsa');
                        },
                        error: function (data) {
                            console.log('Error:', "No se pudo eliminar la solicitud, contacte a DNM Informática!");
                        }
                    });
                } else {
                }
            }, "Default Value").set('labels', {ok: 'SI', cancel: 'NO'});
                
            });

        });

        //Búsqueda de propietarios tipo juridico o natural
$("#tipoTitular input[name='tipoT']").change(function(){

  var tipo=$(this).val();
  console.log(tipo);
 $('#nombre_propietario').selectize()[0].selectize.destroy();
 $('#nombre_propietario').selectize({
    valueField: 'ID_PROPIETARIO',
    labelField: 'NOMBRE_PROPIETARIO',
    searchField: ['ID_PROPIETARIO','NOMBRE_PROPIETARIO'],   
    maxOptions: 10,
        options: [],
        create: false,
    render:{
        option: function(item, escape) {
                return '<div>' +escape(item.ID_PROPIETARIO)+' ('+ escape(item.NOMBRE_PROPIETARIO) +')</div>';
              }
        },
     load: function(query, callback) {
                if (!query.length) return callback();    
            $.ajax({
                url:"{{route('buscarTitularAjax')}}",
                type: 'GET',
                dataType: 'json',
                data: {
                        q: query,
                        tipoTitular: tipo
                    },
                error: function() {
                        callback();
                    },
                success: function(res) {
                        callback(res.data);

                    }
            });
    }   

  }); 
});


//Búsqueda de profesionales responsables
  $('#ID_PODER').selectize({
    valueField: 'ID_PROFESIONAL',
    labelField: 'ID_PODER',
    searchField: ['ID_PODER','NOMBRE_PROFESIONAL'], 
    maxOptions: 10,
        options: [],
        create: false,
    render:{
        option: function(item, escape) {
                return '<div>' +escape(item.ID_PODER)+' ('+ escape(item.NOMBRE_PROFESIONAL) +')</div>';
              }
        },
     load: function(query, callback) {
                if (!query.length) return callback();    
            $.ajax({
                url:"{{route('buscarProfesionalesAjax')}}",
                type: 'GET',
                dataType: 'json',
                data: {
                        q: query
                    },
                error: function() {
                        callback();
                    },
                success: function(res) {
                        callback(res.data);
                    }
            });
    }   
    
});
    </script>

@endsection