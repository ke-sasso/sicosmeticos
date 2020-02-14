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


    <div class="panel panel-success" id="search-panel">
        <div class="panel-heading" >
            <h3 class="panel-title">                
                    B&uacute;squeda Avanzada de Solicitudes              
            </h3>
        </div>



        
            <div class="panel-body">

                {{-- COLLAPSE CONTENT --}}
                <form role="form" id="search-form">
                    <div class="row">
                        
                        <div class="col-xs-6">
                        <label>Número de presentación:</label><br>
                            <input class="form-control" name="numPresentacion" id="numPresentacion">
                        </div> 
                        <div class="col-xs-6">
                        <label>Número de registro:</label><br>
                            <input class="form-control" name="numRegistro" id="numRegistro">
                        </div>                                                
                    </div>
                    <br>
                    <div class="row">
                         
                        <div class="col-xs-6">
                        <label>ID Solicitud:</label><br>
                            <input class="form-control" name="idsolicitud" id="idsolicitud">
                        </div> 
                        <div class="col-xs-6">
                        <label>Estado de la Solicitud:</label><br>
                            <select class="form-control" name="estadoSol" id="estadoSol"> 
                                    <option></option> 
                                    @foreach($estadoSol as $est)
                                        <option id="idEstado" value="{{$est->idEstado}}">{!!$est->estado!!}</option>
                                    @endforeach                                                    
                            </select>
                        </div>                         
                    </div>
                    <br>
                    <div class="row">                           
                        <label>Origen Fabricante:</label>                        
                        <div id="tipoFab">
                                <input type="radio" id="origen" name="origen" value="1" > Nacional 
                                <input type="radio" id="origen" name="origen" value="2" > Extranjero
                        </div>
                        <div>
                            <div class="col-xs-6">
                                <label>Nombre Fabricante: </label>
                                <select class="form-control input-sm" name="NOMBRE_FAB"  id="NOMBRE_FAB"  placeholder="Buscar por nombre de fabricante:"></select>
                            </div>
                        </div>
                      
                        <div class="col-xs-6">
                        <label>Técnico Asiganado:</label><br>
                            <input class="form-control" name="tecAsignado" id="tecAsignado">
                        </div>                         
                    </div>
                    <br>
                    <div class="row">
                        
                        <div class="col-xs-6">
                        <label>Nombre Solicitud:</label><br>
                            <select class="form-control" name="nomSolicitud" id="nomSolicitud"> 
                                    <option value=""></option>                                
                                    <option value="2">Nuevo Registro Cosmético</option>  
                                    <option value="3">Nuevo Reconomiento de Cosmético</option>  
                                    <option value="4">Nuevo Registro Higiénico</option>  
                                    <option value="5">Nuevo Reconocimiento de Higiénico</option>                     
                            </select>
                        </div> 
                        <div class="col-xs-6">
                        <label>Nombre comercial:</label><br>
                            <input class="form-control" name="nomComercial" id="nomComercial">
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
                    <br>
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
                    <br>
                    <div class="row">
                        
                        <div class="col-xs-6">
                        <label>Fecha inicio del proceso de Cosmeticos:</label><br>
                            <input type="date" class="form-control" name="fechaInicioCos" id="fechaInicioCos">
                        </div> 
                        <div class="col-xs-6">
                        <label>Fecha fin del proceso de Cosmeticos:</label><br>
                            <input type="date" class="form-control" name="fechaFinCos" id="fechaFinCos">
                        </div>                         
                    </div>
                    <br>
                    <div class="row">
                        
                        <div class="col-xs-6">
                        <label>Fecha inicio del proceso de Higienicos:</label><br>
                            <input type="date" class="form-control" name="fechaInicioHig" id="fechaInicioHig">
                        </div> 
                        <div class="col-xs-6">
                        <label>Fecha fin del proceso de Higienicos:</label><br>
                            <input type="date" class="form-control" name="fechaFinHig" id="fechaFinHig">
                        </div>                         
                    </div>
                    <br>
                    <div class="row">
                        
                        <div class="col-xs-6">
                        <label>Fecha inicio de ingreso de solicitud:</label><br>
                            <input type="date" class="form-control" name="fechaInicio" id="fechaInicio">
                        </div> 
                        <div class="col-xs-6">
                        <label>Fecha fin de ingreso de solicitud:</label><br>
                            <input type="date" class="form-control" name="fechaFin" id="fechaFin">
                        </div>                         
                    </div>
                    <br>
                    

                    <div class="modal-footer" >
                        <div align="center">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                            <button type="submit" class="btn btn-success btn-perspective"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </form>
                {{-- /.COLLAPSE CONTENT --}}
            </div><!-- /.panel-body -->
        
    </div>

    <div class="panel panel-success" style="display: none" id="table-panel">

        <div class="panel-heading">
            <h3 class="panel-title">TRAZABILIDAD DE SOLICITUDES</h3>
        </div>
        <div class="panel-body">
            
            <div class="table-responsive">
                <table style="font-size: 12px;" id="dt-trazabilidad" class="table table-hover table-striped" role="group" width="100%">
                    <thead>
                    <tr>
                        <th>ID TRAMITE</th>
                        <th>N° SOLICITUD</th>
                        <th>N° REGISTRO</th>
                        <th>NOMBRE PRODUCTO</th>
                        <th>NOMBRE SOLICITUD</th>
                        <th>FECHA INGRESO</th>
                        <th>USUARIO INGRESA</th>
                        <th>ESTADO</th>   
                        <th>ID TITULAR</th>   
                        <th>NOMBRE TITULAR</th>
                        <th>ID FABRICANTE</th>
                        <th>NOMBRE FABRICANTE</th>
                        <th>ID PROFESIONAL</th>  
                        <th>NOMBRE PROFESIONAL</th>   
                        <th>FECHA DICTAMEN</th>
                        <th>TÉCNICO</th>              
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div><br>
            <button class="btn btn-info" id="btn-regresar">Regresar</button>
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
           

    $('#search-form').on('submit', function(e) {
        $('#search-panel').hide();
        $('#table-panel').show();

        var table = $('#dt-trazabilidad').DataTable({
        processing: true,
        scrollX: true,
        serverSide: false,
        searching: true,
        dom: 'Bfrtip',
        buttons: [
                {
                    extend: 'excel',
                    title: 'Reporte de trazabilidad de Solicitudes'
                }],
        ajax: {
            url: "{{route('dt.trazabilidad.sol')}}",
            data: function (d) {
                d.fechaInicio= $('#fechaInicio').val();
                d.fechaFin= $('#fechaFin').val();
                d.idTitular= $('#nombre_propietario').val();
                d.idProfesional= $('#ID_PODER').val();
                d.numPresentacion= $('#numPresentacion').val();
                d.numRegistro= $('#numRegistro').val();
                d.nomSolicitud= $('#nomSolicitud ').val();
                d.nomComercial= $('#nomComercial ').val();
                d.idsolicitud= $('#idsolicitud ').val();
                d.tecAsignado= $('#tecAsignado ').val();
                d.fechaInicioCos= $('#fechaInicioCos').val();
                d.fechaFinCos= $('#fechaFinCos').val();
                d.fechaInicioHig= $('#fechaInicioHig').val();
                d.fechaFinHig= $('#fechaFinHig').val();
                d.idFabricante= $('#NOMBRE_FAB').val();
                d.estadoSol= $('#estadoSol').val();
            }
        },
        columns: [
            {data: 'numeroSolicitud', name: 'numeroSolicitud'},
            {data: 'numeroPresentacion', name: 'numeroPresentacion'},
            {data: 'idProducto', name: 'idProducto'},
            {data: 'nombreProducto', name: 'nombreProducto'},
            {data: 'nombreTramite', name: 'nombreTramite'},
            {data: 'fecha', name: 'fecha'},
            {data: 'idUsuarioCrea', name: 'idUsuarioCrea'},
            {data: 'nombreEstado', name: 'nombreEstado'},
            {data: 'idTitular', name: 'idTitular'},
            {data: 'titularProducto', name: 'titularProducto'},
            {data: 'idFabricante', name: 'idFabricante'},
            {data: 'nombreFabricante', name: 'nombreFabricante'},
            {data: 'idProfesional', name: 'idProfesional'},
            {data: 'nombreProfesional', name: 'nombreProfesional',orderable:false},                    
            {data: 'fechaProceso', name: 'fechaProceso'},
            {data: 'tecnico', name: 'tecnico'}    
        ],
        language: {
            "sProcessing": '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
        },
        order: [[ 0, "asc" ]]

        }); //fin Datatable               
        e.preventDefault();                
    });

});

$('#btn-regresar').click(function (){
    $('#search-panel').show();
    $('#table-panel').hide();
    $('#dt-trazabilidad').dataTable().fnDestroy();


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

$("#tipoFab input[name='origen']").change(function(){
  var origen=$(this).val();
  if(origen==1){// si es nacional

 $('#NOMBRE_FAB').selectize()[0].selectize.destroy();
  var fab =$('#NOMBRE_FAB').selectize({
    valueField: 'idEstablecimiento',
    labelField: 'nombreFab',
    searchField: ['idEstablecimiento','nombreFab'], 
    maxOptions: 10,
        options: [],
        create: false,
    render:{
        option: function(item, escape) {
                return '<div>' +escape(item.idEstablecimiento)+' ('+ escape(item.nombreFab) +')</div>';
              }
        },
     load: function(query, callback) {
                if (!query.length) return callback();    
            $.ajax({
                url:"{{route('buscarFabricantesAjax')}}",
                type: 'GET',
                dataType: 'json',
                data: {
                        q: query,
                        o: origen
                    },
                error: function() {
                        callback();
                    },
                success: function(res) {
                        callback(res.data);
                       // console.log(res);
                    }
            });
    }   

    });

} else { //si es extranjero
  $('#NOMBRE_FAB').selectize()[0].selectize.destroy();
  var fab =$('#NOMBRE_FAB').selectize({
    valueField: 'idFabricanteExtranjero',
    labelField: 'fabricante',
    searchField: ['idFabricanteExtranjero','fabricante'], 
    maxOptions: 10,
        options: [],
        create: false,
    render:{
      option: function(item, escape) {
                return '<div>' + escape(item.fabricante) +'</div>';
              }
        },
     load: function(query, callback) {
                if (!query.length) return callback();    
        $.ajax({
          url:"{{route('buscarFabricantesAjax')}}",
          type: 'GET',
                dataType: 'json',
                data: {
                        q: query,
                        o: origen
                    },
          error: function() {
                        callback();
                    },
                success: function(res) {
                        callback(res.data);
                       // console.log(res);
                    }
          });
    } 

  });

}

 $('#NOMBRE_FAB').selectize()[0].selectize.clearOptions();
  
});
</script>

@endsection