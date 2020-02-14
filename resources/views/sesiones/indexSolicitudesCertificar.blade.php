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
<input type="hidden" value="{{$sesion }}" id="sesion">

  <div class="table-responsive">
    <table width="100%" id="dt-solCert" class="table table-hover table-striped">
      <thead>
      <tr>
        <th>Número de Solicitud</th>
        <th>Tipo de Solicitud</th>
        <th>No. Producto</th>
        <th>Nombre Comercial</th>
        <th>Estado</th>
        <th>Certificar<input type="checkbox" name="all" onclick="seleccionar();" /></th>
      </tr>

      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
<form id="solicitudesCer" name="solicitudesCer" method="POST" role="form" enctype="multipart/form-data" action="{{route('certificarSolicitudes')}}">
  <div id="sol"></div>
  <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" class="form-control"/>
  <input type="hidden" id="nomsesion" name="nomsesion" value="{{$sesion}}"/>
  <div align="right"> <button type="submit"  class="btn btn-primary">CERTIFICAR SOLICITUDES</button></div>
  {{--<a href="{{route("imprimir.solicitudes",['sesion'=>$sesion])}}" id="imprimir" target="_blank" class="btn btn-success impr">IMPRIMIR TODAS</a>--}}
  <label>Tamaño de fuente:</label>
  <select name="fuente" id="fuente">
    <option value="14">14</option>
    @for($i=10;$i<=20;$i++)
      <option value="{{$i}}">{{$i}}</option>
    @endfor
  </select>
</form>
<!--modal coempaque-->
<div id="coemp" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="modal-header">
           <input type="hidden" id="idsolicitud" name="idsolicitud"  class="form-control"/>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
              <b><h3 class="modal-title" align="center">Agregar Coempaque <label id="textoP"></label></h3></b>
          <div class="modal-body">
            <div class="form-group" align="center">

              <label>Ingrese un nombre para el Coempaque:</label>
              <input class="form-control coemp" type="text" id='nombreCoempaque'/><br/>
              <label>Seleccione las presentaciones que componen el coempaque:</label>
            <table id="dt-coProd" class="table table-hover table-striped" cellspacing="0" width="100%">
                  <thead>
                          <th>N° registro</th>
                          <th>Nombre Comercial</th>
                          <th>N° presentación</th>
                          <th>Texto Presentación</th>
                          <th>Seleccione</th>
                  </thead>
              <tbody>


              </tbody>
          </table>
          </div>
             <button type="button" style="margin-left:45%" class="btn btn-primary" data-dismiss="modal" id="saveCoempaque">Registrar Coempaque</button>
          </div>
        </div>
      </div>
  </div>
</div>
<!-- fin modal coempaque-->

</div>


@endsection

@section('js')

<script>
   var table;
$(document).ready(function(){

  var idsesion=$('#sesion').val();
 // alert(idsesion);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#token').val()
            }
        });
  var token=$('#token').val();
  table = $('#dt-solCert').DataTable({
        filter: true,
        searching:true,
        processing: true,
        scrollY: '400',
        paging: false,
        serverSide: true,
        lengthChange: false,
        ajax:{

          url: "{{route('dt.row.data.sol.certificar')}}",
          data: {"idsesion": idsesion },
          type: 'GET',
        },
        columns:[
            {data:'idSolicitud', name:'idSolicitud',orderable:false},
            {data:'nombreTramite', name:'nombreTramite',orderable:false},
            {data:'idProducto', name:'idProducto',orderable:false},
            {data:'nombreComercial', name:'nombreComercial',orderable:false},
            {data:'estado', name:'estado',orderable:false},
            {data:'certificar', name:'certificar',orderable:false}

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


function seleccionar(){
   if($('input[type=checkbox]').prop('checked')){
  //   alert("hola");
      $('.checkAll').prop('checked','true');
    } else {
      $('.checkAll').removeProp('checked');
    }

}
$('#solicitudesCer').submit(function(e){
               e.preventDefault();
                var sol = [];
                $('input[name="solChek[]"]:checked').each(function(){
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
                                  table.ajax.reload();
                                  $("#sol").empty();
                                });
                        }else if(data["status"]==404){
                                 $("#sol").empty();
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


$(document).on('click', '.coempaque', function (event) {
  event.preventDefault();
  $('input[name="solChek[]"]').attr('checked', false);
  $('.coemp').val();
  $('#idPresentacion').val($(this).val());
  $('#textoP').val($(this).val());
  //console.log($('#idPresentacion').val());
});

$('#saveCoempaque').click(function(){
  var idPres=[];
  var idSolicitud=$('#idsolicitud').val();
  var token =$('input[name="_token"]').val();
  var nombreCoempaque=$('#nombreCoempaque').val();
  var sesion=$('#sesion').val();
  $('input[name="solChek[]"]:checked').each(function(){
    idPres.push($(this).val());
  });

    $.ajax({
              data: {ids:idPres, idSolicitud:idSolicitud,_token:token,nombreCoempaque:nombreCoempaque},
              url: '{{route("crear.coempaque")}}',
              type: 'post',
              beforeSend: function() {
              //  $('body').modalmanager('loading');
              },
              success:  function (r){
              //  $('body').modalmanager('loading');
              if(r.status == 200){
                alertify.success("Mensaje de sistema",r.message);
                alertify.alert("<a type='button' class='btn btn-success' href='../imprimir/"+idSolicitud+"/"+sesion+"'>Imprimir Licencia</button>");
                $('#agregarcoempaque').hide();

               // dtPres.fnReloadAjax();
               } else if(r.status == 404){
                    alertify.alert("Mensaje de error", r.data['message']);
                } else {
                  alertify.alert("Mensaje de error", "Ocurrio un error");
                }
              },

      });
});


function modalCoempaque($solicitud){
 // origen=$(this).val();
 console.log($solicitud);
  $('#idsolicitud').val($solicitud);
 // url="{{route('get.coempaqueProducto')}}";
  $('#dt-coProd').DataTable({
              processing: true,
              filter:true,
              serverSide: false,
              retrieve: true,
              paging:false,
              scrollY: '325',
              order: [ [2, 'asc'] ],
              pageLength: 5,
              ajax: {
                url: "{{route('get.coempaqueProducto')}}",
                data:{idSol:$solicitud}
              },
              columns:[
                      {data: 'idProducto',name:'idProducto'},
                      {data: 'nombreComercial',name:'nombreComercial'},
                      {data: 'idPresentacion',name:'idPresentacion'},
                      {data: 'textoPresentacion',name:'textoPresentacion'},
                      {data: 'opciones',name:'opciones'}
                  ],
             language: {
              processing: '<div class=\"dlgwait\"></div>',
              "url": "{{ asset('plugins/datatable/lang/es.json') }}"

          },

        });


}

$('#frmCertificar').submit(function(event) {
  location.reload();
});


$('#imprimir').click(function(){
  var newurl=$('#imprimir').attr('href');
  var fuente=$('#fuente').val();
  var sesion=$('#sesion').val();

  $('a#imprimir').attr('href', '{{ route('imprimir.solicitudes') }}?sesion='+sesion+'&fuente='+fuente);

});

function printCert(id)
{
  var sesion=$('#sesion').val();
  var fuente=$('#fuente').val();
  window.open('{{ route('imprimirCertificado') }}?idSolicitud='+id+'&sesion='+sesion+'&tamanio='+fuente);
}

function actualizarDocumento(idSolicitud,tipoDocumento){
    alertify.confirm("Mensaje de sistema", "¿Esta seguro que desea volver a generar y guardar el documento de certificación de la solicitud número "+idSolicitud+"?", function (asc) {
        if (asc) {
              var token =$('input[name="_token"]').val();
              $.ajax({
                          data: {idSolicitud:idSolicitud, tipoDocumento:tipoDocumento,_token:token},
                          url: '{{route("solpre.pdf.certificacion.cambiarestado")}}',
                          type: 'post',
                          success:  function (r){
                            if(r.status == 200){
                                   alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>"+r.message+"</p></strong>",function(){
                                          if(tipoDocumento===3){
                                              //FAVORABLE
                                              printCert(idSolicitud);
                                          }else{
                                              //DESFAVORABLE
                                              $ruta = "{{url('dictamenes/nuevoDic/verResolucionDesfavorable')}}/"+r.idSolicitud;
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