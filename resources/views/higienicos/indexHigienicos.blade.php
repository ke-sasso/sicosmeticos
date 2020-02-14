@extends('master')

@section('css')
{!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!}
@endsection

@section('contenido')

<div class="panel panel-success">
        <div class="panel-heading" >
            <h3 class="panel-title">
                <a class="block-collapse collapsed" id='colp' data-toggle="collapse" href="#collapse-filter">
                    B&uacute;squeda Avanzada de Productos Higiénicos
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
                        <div class="form-group col-sm-6 col-md-3">
                            <label>N° Higiénico:</label>
                            <input type="text" class="form-control" name="nhigienico" id="nhigienico" autocomplete="off">
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <label>Nombre Comercial:</label>
                            <input type="text" name="nomComercial" id="nomComercial" class="form-control" autocomplete="off" >
                        </div>
                        <div class="form-groupcol-sm-6 col-md-3">
                            <label>Tipo:</label>
                            <select name="tipo" id="tipo" class="form-control">
                              <option value="">-- Seleccione --</option>
                              <option value="1">REGISTRO HIGIÉNICO</option>
                              <option value="2">RECONOCIMIENTO HIGIÉNICO</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-8 col-md-8">
                         <div class="form-group form-inline">
                            <label>Seleccione el tipo de Titular antes de buscarlo:</label><br> 
                            <label class="radio-inline">
                                <input type="radio" name="tipoTitular" id="inlineRadio1" value="1" required form="RegistroPreStep3"> Persona Natural
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="tipoTitular" id="inlineRadio2" value="2" required form="RegistroPreStep3"> Persona Jurídica
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="tipoTitular" id="inlineRadio3" value="3" required form="RegistroPreStep3"> Extranjero
                            </label>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="input-group ">
                                      <div class="input-group-addon" for="titular"><b>B&uacute;squeda del Titular:</b></div>
                                      <select id="searchbox-titular" form="RegistroPreStep3" name="titular" placeholder="Buscar por nit o por nombre del titular" class="form-control" required></select>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group form-inline">
                                    <label>Seleccione el tipo de fabricante antes de buscarlo:</label><br>
                                    <div class="radio">
                                        <label class="radio-inline">
                                            <input type="radio" name="origenFab" id="inlineRadio1" class="origenFab" value="1"> Nacional
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label class="radio-inline">
                                            <input type="radio" name="origenFab" id="inlineRadio2" class="origenFab" value="0"> Extranjero
                                        </label>
                                    </div>
                                </div>
                                <label>Nombre Fabricante: </label>
                                <select class="form-control input-sm" name="fabricante"  id="fabricante"  placeholder="Buscar por nombre de fabricante:"></select>
                        </div>

                        
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Profesional: </label>
                            <select class="form-control input-sm" name="profesional" value="" id="ID_PROFESIONAL"
                                    placeholder="Buscar por número de Poder:">
                            </select>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <label> País de Origen: </label>
                            <select class="form-control" id="idPais" name="idPais">
                                <option value="">--Seleccione--</option>
                                @foreach($allPaises as $paisCA)
                                    <option value="{{$paisCA->codigoId}}">{!!$paisCA->nombre!!}</option>
                                @endforeach
                            </select>
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

@if(Session::has('message'))
<div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{Session::get('message')}}
</div>
@endif


<div class="panel-body" style="margin-top: 30px;">
	<div class="table-responsive">
		<table width="100%" id="dt-hig" class="table table-hover table-striped">
			<thead class="the-box dark full">
			<tr>
				<th>Número de Higiénico</th>
				<th width="30%">Nombre Comercial</th>
				<th>Tipo</th>
				<th>Vigencia</th>
				<th>Estado</th>
                <th>Opciones</th>
				
			</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>

</div>


@endsection

@section('js')
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
<script>
$(document).ready(function(){
  var table = $('#dt-hig').DataTable({
  	    filter: true,
        searching:false,
        processing: true,
        serverSide: true,
        ordering: false,
        order: [[ 0, "asc" ]],
        ajax:{
        	url: "{{route('dt.row.data.hig')}}",
            data: function(d){
                d.nhigienico = $('#nhigienico').val();
                d.nomComercial = $('#nomComercial').val();
                d.tipo = $('#tipo').val();
                d.titular = $('#searchbox-titular').val();
                d.fabricante = $('#fabricante').val();
                d.profesional = $('#ID_PROFESIONAL').val();
                d.idPais = $('#idPais').val();
            }
        },
        columns:[
        		{data:'idHigienico', name:'idHigienico',orderable:true},
        		{data:'nombreComercial', name:'nombreComercial',orderable:true},
        		{data:'tipo', name:'tipo',orderable:true},
        		{data:'vigenteHasta', name:'vigenteHasta',orderable:true},
        		{data:'estado', name:'estado',orderable:true},
        		{data:'opciones', name:'opciones',searchable:false,orderable:true}
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

    $('#search-form').on('submit', function(e) {
        table.draw();
        e.preventDefault();
        $("#colp").attr("class", "block-collapse collapsed");
        $("#collapse-filter").attr("class", "collapse");
    });

    //Busqueda de Titular
    $('input[type=radio][name=tipoTitular]').change(function () {

        var tipotitular = $(this).val();
        $('#searchbox-titular').selectize()[0].selectize.destroy();
        $('#searchbox-titular').selectize({

            valueField: 'ID_PROPIETARIO',
            inputClass: 'form-control selectize-input',
            labelField: 'NOMBRE_PROPIETARIO',
            searchField: ['NIT', 'NOMBRE_PROPIETARIO'],
            maxOptions: 10,
            preload: false,
            options: [],
            create: true,
            render: {
                option: function (item, escape) {
                    return '<div>' + escape(item.NIT) + ' (' + escape(item.NOMBRE_PROPIETARIO) + ')</div>';
                },
                item: function(item, escape) {
                    return '<div>' + escape(item.NIT) + ' (' + escape(item.NOMBRE_PROPIETARIO) + ')</div>';
              }
            },
            load: function (query, callback) {

                $.ajax({
                    url: "{{route('buscarTitularAjax')}}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query,
                        tipoTitular: tipotitular,
                        idUnidad: 'COS'
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {

                        if (res.status == 200) {
                            callback(res.data);
                        }
                        else if (res.status == 404) {
                            alertify.alert("Mensaje de sistema", res.message + " Contacte con la Unidad de Jurídico para solventar su incoveniente con el titular del producto.");
                            console.warn(res.message);
                        } else {//Unknown
                            alertify.alert("Mensaje de sistema", res.message);
                            console.warn("No se han podido cargar los titulares");
                        }

                    }
                });
            }
        });
    });

    //Busca fabricante SELECCIONADO
    $('input[type=radio][name=origenFab]').change(function() {
        var origen=$(this).val();  //para verificar si es 1=nacional o 2=extra

        $('#fabricante').selectize()[0].selectize.destroy();
        var fab = $('#fabricante').selectize({
            valueField: 'idEstablecimiento',
            labelField: 'nombreFab',
            searchField: ['idEstablecimiento', 'nombreFab'],
            maxOptions: 10,
            options: [],
            create: true,
            render: {
                option: function (item, escape) {
                    return '<div>' + escape(item.idEstablecimiento) + ' (' + escape(item.nombreFab) + ')</div>';
                }
            },
            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: "{{route('buscarFabricantesAjax')}}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query,
                        o: origen
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res.data);
                        // console.log(res);
                    }
                });
            }

        });

        $('#fabricante').selectize()[0].selectize.clearOptions();
    });

    $('#fabricante').change(function(){
       var id = $(this).val();
       var array=[];
       var origen =$('input[type=radio][name=origenFab]:checked').val(); //si es 1=nacional si es 2= extranjero
     // console.log(origen);
      $.ajax({
            url:"{{ route('buscarFabricanteAjaxPorId') }}",
            data:{_token: '{{ csrf_token() }}',
                id: id,
                origen:origen},
            type: 'post',
            success: function(data){
                console.log(data);
              if(data.length>0){
                    if(origen==1){ // si el fab es Nacional decodifica el campo telefono
              
                          if(data[0].telefonosContacto === ''){
                            var telefono='';
                          } else {  
                            var telefono= jQuery.parseJSON(data[0].telefonosContacto);
                          }
                            var input=''; 
                            var nuevaFila="";
                            nuevaFila+="<tr><input type='hidden' name='fabricantes[]' value="+data[0].idEstablecimiento+"><td>"+data[0].idEstablecimiento+"</td><td>"+data[0].nombreFab+"</td><td> "+telefono+"</td> <td>"+data[0].direccion+"</td><td>"+data[0].vigenteHasta+"</td><td>"+data[0].emailContacto+"</td><td><a class=' btn btn-xs btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a></td></tr>";
                          $('#dt-fab').append(nuevaFila);
                         /* input+='<input type="hidden" name="ID_FABR[]" value="'+data[0].idEstablecimiento+'">';
                          $('#fabricantes').append(input);*/
                    }else { 
                          var nuevaFila="";
                            nuevaFila+="<tr><input type='hidden' name='fabricantes[]' value="+data[0].idEstablecimiento+"><td>"+data[0].idEstablecimiento+"</td><td>"+data[0].nombreFab+"</td><td> "+data[0].telefonosContacto+"</td> <td>"+data[0].direccion+"</td><td>N/A</td><td>"+data[0].emailContacto+"</td><td><a class='btn btn-xs btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a></td></tr>";
                          $('#dt-fab').append(nuevaFila);
                       /* input+='<input type="hidden" name="ID_FABR[]" value="'+data[0].idEstablecimiento+'">';
                          $('#fabricantes').append(input);*/
                    }
                 
              }
                    }
        });
    });

    //Buscar Profesional
    $('#ID_PROFESIONAL').selectize({
        valueField: 'ID_PROFESIONAL',
        labelField: 'ID_PROFESIONAL',
        searchField: ['ID_PROFESIONAL','NOMBRE_PROFESIONAL'], 
        maxOptions: 10,
            options: [],
            create: true,
        render:{
            option: function(item, escape) {
                    return '<div>' +escape(item.ID_PROFESIONAL)+' ('+ escape(item.NOMBRE_PROFESIONAL) +')</div>';
                  },
            item: function(item, escape) {
                    return '<div>' +escape(item.ID_PROFESIONAL)+' ('+ escape(item.NOMBRE_PROFESIONAL) +')</div>';
              }
        },
         load: function(query, callback) {
                    if (!query.length) return callback();    
                $.ajax({
                    url:"{{route('buscarProfesionalesAjaxPorIdProf')}}",
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

   /* $('#dt-cos').on('submit',function(e) {

        table.draw();
        e.preventDefault();

    });

    table.rows().remove();*/
});

</script>

@endsection