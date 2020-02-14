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

<div class="group-control" id="tipoTitular">
    <label>Ver Fabricantes Extranjeros:</label><br>
    <input type="radio" name="estadoF" value="A"> Activos
    <input type="radio" name="estadoF" value="I"> Inactivos
    <input type="radio" name="estadoF" value="T"> Todos
</div>



<div class="panel-body" style="margin-top: 30px;">
    <div class="table-responsive">
        <table width="100%"  id="dt-fabExt" class="table table-hover table-striped">
            <thead class="the-box dark full">
            <tr>
                <th>Número Registro</th>
                <th>Nombre Fabricante</th>
                <th>Pais</th>
                <th>Teléfonos</th>
                <th>Correo Electronico</th>
                <th>Estado</th>
                <th>Opciones</th>
                
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        {!!link_to_route('getCrearFabExt', $title = "Crear Fabricante Extranjero", $parameters = null, $attributes = ['class'=>'btn btn-success'])!!}
    </div>

</div>

@endsection

@section('js')
<script>

$( document ).ready(function() {
    var table = $('#dt-fabExt').DataTable({
        filter: true,
        searching: true,
        destroy: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('getFabricantesEstado') }}",
            data: function (d) {
                d.estado= 'A';
            }
        },
        columns: [
             
            {data: 'idFabricanteExtranjero', name: 'idFabricanteExtranjero',orderable:true},
            {data: 'nombreFabricante', name: 'nombreFabricante',orderable:true},
            {data: 'nombre', name: 'nombre',orderable:true},
            {data: 'telefonos', name: 'telefonos',orderable:true},
            {data: 'correoElectronico', name: 'correoElectronico',orderable:true},
            {data: 'estado', name: 'estado',orderable:true}, 
            {data: 'opciones', name: 'opciones'}           


        ],
        language: {
            Processing: '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
            
        },
         columnDefs: [
            {
                
                "visible": false
            }
        ]        
    });
 });


$('input[type=radio][name=estadoF]').change(function(){
    var estado=$(this).val();
    console.log(estado);
  if (estado=='A'){
    var table = $('#dt-fabExt').DataTable({
        filter: true,
        searching:true,
        destroy: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('getFabricantesEstado') }}",
            data: function (d) {
                d.estado= estado;
            }
        },
        columns: [
             
            {data: 'idFabricanteExtranjero', name: 'idFabricanteExtranjero',orderable:true},
            {data: 'nombreFabricante', name: 'nombreFabricante',orderable:true},
            {data: 'nombre', name: 'nombre',orderable:true},
            {data: 'telefonos', name: 'telefonos',orderable:true},
            {data: 'correoElectronico', name: 'correoElectronico',orderable:true},
            {data: 'estado', name: 'estado',orderable:true}, 
            {data: 'opciones', name: 'opciones'}           


        ],
        language: {
            Processing: '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
            
        },
         columnDefs: [
            {
                
                "visible": false
            }
        ]        
    });
  }
  if(estado=='I'){
    var table = $('#dt-fabExt').DataTable({
        filter: true,
        searching:true,
        destroy: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('getFabricantesEstado') }}",
            data: function (d) {
                d.estado= estado;
            }
        },
        columns: [
             
            {data: 'idFabricanteExtranjero', name: 'idFabricanteExtranjero',orderable:true},
            {data: 'nombreFabricante', name: 'nombreFabricante',orderable:true},
            {data: 'nombre', name: 'nombre',orderable:true},
            {data: 'telefonos', name: 'telefonos',orderable:true},
            {data: 'correoElectronico', name: 'correoElectronico',orderable:true},
            {data: 'estado', name: 'estado',orderable:true}, 
            {data: 'opciones', name: 'opciones'}           


        ],
        language: {
            Processing: '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
            
        },
         columnDefs: [
            {
                
                "visible": false
            }
        ]        
    });
  } 
  if(estado=='T') {
    var table = $('#dt-fabExt').DataTable({
        filter: true,
        searching:true,
        destroy: true,
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('dt.fab.ext') }}",            
        },
        columns: [
             
            {data: 'idFabricanteExtranjero', name: 'idFabricanteExtranjero',orderable:true},
            {data: 'nombreFabricante', name: 'nombreFabricante',orderable:true},
            {data: 'nombre', name: 'nombre',orderable:true},
            {data: 'telefonos', name: 'telefonos',orderable:true},
            {data: 'correoElectronico', name: 'correoElectronico',orderable:true},
            {data: 'estado', name: 'estado',orderable:true}, 
            {data: 'opciones', name: 'opciones'}           


        ],
        language: {
            Processing: '<div class=\"dlgwait\"></div>',
            "url": "{{ asset('plugins/datatable/lang/es.json') }}"
            
        },
         columnDefs: [
            {
                
                "visible": false
            }
        ]        
    });
  }
});

</script>
@endsection