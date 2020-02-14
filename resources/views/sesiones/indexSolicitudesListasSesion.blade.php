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
<input type="hidden" value="{{$sesion}}" id="sesion">

  <div class="table-responsive">
    <table width="100%" style="table-layout: fixed;" class="table table-hover" id="dt-solApro">
      <thead>
      <tr>
        <th>Número de Solicitud</th>
        <th>Tipo de Solicitud</th>
        <th>Nombre Comercial</th>
        <th>Estado</th>
        <th>Aprobar <input type="checkbox" name"all" onclick="seleccionar();" /></th>
      </tr>      
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
<form name="solicitudesApro" method="POST"  role="form" enctype="multipart/form-data" action="{{route('aprobarSolicitudesAsesion')}}">
  <div id="sol"></div>
  <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" class="form-control"/>
  <input type="hidden" id="nomsesion" name="nomsesion"/>
  <input type="submit" value="Aprobar" id="agregarSol" class="btn btn-success">
</form>

</div>


@endsection

@section('js')

<script>
$(document).ready(function(){
  var idsesion=$('#sesion').val();
 // alert(idsesion);
  var token=$('#token').val();
  var table = $('#dt-solApro').DataTable({
        filter:true,
        processing: true,
        serverSide: false,           
        scrollY: '450',
        paging: false,        
        lengthChange: false,
        ajax:{
          processing: true,
          url: "{{route('dt.row.data.sol.listas')}}",
          data: {"idsesion": idsesion },
          type: 'GET',
        },
        columns:[
            {data:'idSolicitud', name:'idSolicitud',orderable:false},
            {data:'nombreTramite', name:'nombreTramite',orderable:false},
            {data:'nombreComercial', name:'nombreComercial',orderable:false},
            {data:'estado', name:'estado',orderable:false},
            {data:'agregar', name:'agregar',orderable:false}

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

$('#agregarSol').click(function(){
  var sol=[];
  var nomsesion=$('#sesion').val();
  $('#nomsesion').val(nomsesion);

  $('input[name="solChek[]"]:checked').each(function(){
    var input="";
    input+='<input type="hidden" name="sol[]" value="'+$(this).val()+'">';
    $('#sol').append(input);

  });
});

</script>

@endsection