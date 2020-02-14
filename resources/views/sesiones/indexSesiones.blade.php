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
<div class="panel panel-success">
        <div class="panel-heading" >
            <h3 class="panel-title">
                <a class="block-collapse collapsed" id='colp' data-toggle="collapse" href="#collapse-filter">
                    B&uacute;squeda Avanzada
                    <span class="right-content">
                <span class="right-icon"><i class="fa fa-plus icon-collapse"></i></span>
            </span>
                </a>
            </h3>
        </div>

        <div id="collapse-filter" class="collapse" style="height: 0px;">
            <div class="panel-body">

                {{-- COLLAPSE CONTENT --}}
                <form name="busquedaProduct" id="busquedaProduct" method="POST" role="form" action="{{route('find.producto.pre.sesion')}}">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                          <label>Búsqueda de producto en sesiones:</label>
                          <input type="text" class="form-control" name="search" id="search" autocomplete="off" placeholder="Ingresar número de registro o nombre del producto">
                        </div>
                    </div>
                    <div class="row">
                       <div class="form-group col-sm-12 col-md-12" id="respuesta">


                        </div>
                        <!-- 1.Solicitudes PRE 2. Solicitudes POST -->
                        <input type="hidden" name="idTipo" value="{{$idTipo}}">
                    </div>
                    <div class="modal-footer" >
                        <div align="center">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                            <button type="submit" class="btn btn-success btn-perspective"><i class="fa fa-search"></i> Buscar</button>
                            <a onclick="limpiar();"  class="btn btn-warning btn-perspective"><i class="fa fa-search"></i> Limpiar</a>
                        </div>
                    </div>
                </form>
                {{-- /.COLLAPSE CONTENT --}}
            </div><!-- /.panel-body -->
        </div><!-- /.collapse in -->
    </div>

<div class="panel-body" style="margin-top: 20px;">
  <div class="table-responsive" width="60%">
  <input type="hidden" value="{{$ruta}}" id="ruta">
    <table id="dt-ses" class="table table-hover table-striped">
      <thead class="the-box dark full">
      <tr>
        <th>Sesión</th>
        <th>Fecha de Sesión</th>
        <th>Estado</th>

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
$(document).ready(function(){
  var ruta=$('#ruta').val();
 // alert(ruta);
  var table = $('#dt-ses').DataTable({
        filter: true,
        searching:true,
        processing: true,
        serverSide: true,
        order: [1, "desc"],
        ajax:{
          url: "{{route($ruta)}}"

        },
        columns:[
            {data:'nombreSesion', name:'nombreSesion',orderable:true},
            {data:'fechaSesion', name:'fechaSesion',orderable:true},
            {data:'estadoSesion', name:'estadoSesion',orderable:true}
        ],
        language: {
            //"sProcessing": '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"

        },
         columnDefs: [
            {

                "visible": false,

            }
        ]

  });

   /* $('#dt-cos').on('submit',function(e) {

        table.draw();
        e.preventDefault();

    });

    table.rows().remove();*/
});

       $('#busquedaProduct').submit(function(e){
                e.preventDefault();
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
                                  alertify.alert("Mensaje de sistema - Advertencia", data["message"]);
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

function mensaje(){
  alertify.alert("Mensaje de sistema",'Esta sesión ya se cerro!');
}
function limpiar(){
  $("#search").val("");
}

</script>

@endsection