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



<div class="panel-body" style="margin-top: 30px;">
    <div class="table-responsive">
        <table width="100%"  id="dt-classHig" class="table table-hover table-striped">
            <thead class="the-box dark full">
            <tr>
                <th>Identificador</th>
                <th>Clasificación</th>
                <th>Aplica Tono</th>
                <th>Aplica Fragancia</th>
                <th>Estado</th>
                <th>Opciones</th>
                
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        {!!link_to_route('getCrearClas', $title = "Crear Clasificación", $parameters = null, $attributes = ['class'=>'btn btn-success'])!!}
    </div>

</div>

@endsection

@section('js')
<script>

$( document ).ready(function() {
    var table = $('#dt-classHig').DataTable({
        filter: true,
        searching:true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dt.class.hig') }}",
        },
        columns: [
             
            {data: 'idClasificacion', name: 'idClasificacion',orderable:true},
            {data: 'nombreClasificacion', name: 'nombreClasificacion',orderable:true},
            {data: 'poseeTono', name: 'poseeTono',orderable:true},
            {data: 'poseeFragancia', name: 'poseeFragancia',orderable:true},
            {data: 'estado', name: 'estado',orderable:true},
             {data:'opciones', name: 'estado',orderable:true}            
           


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