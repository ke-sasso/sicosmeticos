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
        <table width="100%"  id="dt-sustHig" class="table table-hover table-striped">
            <thead class="the-box dark full">
            <tr>
                <th>Identificador</th>
                <th>Número CAS</th>
                <th>Nombre Sustancia</th>
                <th>Estado</th>
                
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        {!!link_to_route('crearsustancias', $title = "Crear Sustancia", $parameters = null, $attributes = ['class'=>'btn btn-success'])!!}
    </div>

</div>

@endsection

@section('js')
<script>

$( document ).ready(function() {
    var table = $('#dt-sustHig').DataTable({
        filter: true,
        searching:true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dt.sust.hig') }}",
        },
        columns: [
             
            {data: 'idDenominacion', name: 'idDenominacion',orderable:true},
            {data: 'numeroCAS', name: 'numeroCAS',orderable:true},
            {data: 'nombreSustancia', name: 'nombreSustancia',orderable:true},
            {data: 'estado', name: 'estado',orderable:true}
            


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