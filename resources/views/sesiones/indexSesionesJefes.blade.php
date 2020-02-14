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

function mensaje(){
  alertify.alert("Mensaje de sistema",'Esta sesión ya se cerro!');
}

</script>

@endsection