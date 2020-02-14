@extends('master')

@section('css')
</style>
@endsection

@section('contenido')

@if(Session::has('message'))
<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{Session::get('message')}}
</div>
@endif


<div class="panel-body" style="margin-top: 20px;">
<input type="hidden" value="{{$sesion}}" id="sesion">

  <div class="table-responsive">
    <table width="100%"  id="dt-solSes" class="table table-hover table-striped">
      <thead class="the-box dark full">
      <tr>
        <th>Número de Solicitud</th>
        <th>Tipo de Solicitud</th>
        <th>Nombre Comercial</th>
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
  var idsesion=$('#sesion').val();
// alert(idsesion);
  var token=$('#token').val();
  var table = $('#dt-solSes').DataTable({
        filter: true,
        searching:true,
        processing: true,
        serverSide: true,
        ajax:{
          
          url: "{{route('dt.row.data.sol.ses')}}",
          data: {"idsesion": idsesion },
          type: 'GET',
        },
        columns:[
            {data:'idSolicitud', name:'idSolicitud',orderable:true},
            {data:'nombreTramite', name:'nombreTramite',orderable:true},
            {data:'nombreComercial', name:'nombreComercial',orderable:true},
            {data:'estado', name:'estado',orderable:true}


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