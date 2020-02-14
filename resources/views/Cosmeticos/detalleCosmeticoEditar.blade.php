@extends('master')

@section('css')
{!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!} 


@endsection



@section('contenido')



<div class="panel-body">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="panel with-nav-tabs panel-success">
					<div class="panel-heading">
						<ul class="nav nav-tabs">
						  <li class="active"><a href="#generales" data-toggle="tab">Generales</a></li>
						  <li><a href="#propietario" data-toggle="tab">Propietario</a></li>
						  <li><a href="#profesional" data-toggle="tab">Profesional</a></li>
						  <li><a href="#class" data-toggle="tab">Clasificación</a></li>
						  <li><a href="#marca" data-toggle="tab">Marca</a></li>
						  <li><a href="#formula" data-toggle="tab">Formula</a></li>
						  <li><a href="#presentaciones" data-toggle="tab" id="tab-presentaciones">Presentaciones</a></li>
						  <li><a href="#fragancia" data-toggle="tab">Fragancias</a></li>
						  <li><a href="#tonos" data-toggle="tab">Tonos</a></li>
						  <li><a href="#fab" data-toggle="tab">Fabricantes</a></li>
						  <li><a href="#imp" data-toggle="tab">Importadores</a></li>
						  <li><a href="#dist" data-toggle="tab">Distribuidores</a></li>
                        </ul>
					</div>

					<div id="panel-collapse-1" class="collapse in">
						<div class="panel-body">
							<div class="tab-content">
              <input type="hidden" name="idCosmetico" id="idCosmetico" value="{{$cos->idCosmetico}}" />
                                     

                                         @include('Cosmeticos.panelesEdicion.clasificacion-editar')

                                         @include('Cosmeticos.panelesEdicion.generales-editar')

                                         @include('panelesGenerales-editar.propietario-editar')

                                         @include('panelesGenerales-editar.profesional-editar')

                                         @include('Cosmeticos.panelesEdicion.marca-editar')

                                         @include('Cosmeticos.panelesEdicion.formula-editar')

                                         @include('Cosmeticos.panelesEdicion.presentacionesCos')

                                         @include('panelesGenerales-editar.fragancias-editar')

                                         @include('panelesGenerales-editar.tonos-editar')

                                         @include('panelesGenerales-editar.fabricantes-editar')

                                       	 @include('panelesGenerales-editar.importadores-editar')

                                         @include('panelesGenerales-editar.distribuidores-editar')




                            </div>

                      	</div>
            		</div>
            	</div>
			</div>
		</div>
</div>


@endsection

@section('js')
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
<script type="text/javascript">

$(document).ready(function(){
  @if(count($cos->presentaciones)==0)
      $('#agregarcoempaque').hide();
  @endif

	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	});

	$('#btnFragancia').click(function(){
	  var input='';
	      input+='<input type="text" class="form-control fragancias" name="fragancias[]"><br/>';
	      
	  $('#fraganciasDiv').append(input);
	});

	$('#btnTono').click(function(){
	  var input='';
	      input+='<input type="text" class="form-control tonos" name="tonos[]"><br/>';
	 
	  $('#tonosDiv').append(input);
	});

	$('#btnEliminarTono').click(function(){
		$('.tonos').last().remove();
	});

	$('#btnEliminarFragancia').click(function(){
		$('.fragancias').last().remove();
	});

	$('#area').change(function (){
		var idArea=$('#area option:selected').val();
   		//var idClas=$('#idClas').val();
 
		$.ajax({
			   url:"{{ route('getDataClassSol') }}",
			   data:{_token: '{{ csrf_token() }}',
			   			id: idArea },
			   type: 'post',
				  success: function(data){
				  	$('#clas').html(data);
				  	//$('#clas option[value="'+idClas+'"]').attr('selected',true);
				   }
		});
	
	});

	//Llena el combobox de clasificacion de productos de acuerdo al area seleccionada
	$('#clas').click(function(){
		var id= $('#clas').val();
	    $.ajax({
		    	url:"{{ route('getGrupoFormasSol') }}",
		    	data:{_token: '{{ csrf_token() }}',
		    			id: id },
	    		type: 'post',
	    		success: function(data){
	    			$('#forma').html(data);
	            //	console.log(data);
	              		}
	            });
	});  

 //BUSQUEDA DE FABRICANTES

$('input[type=radio][name=origenFab]').change(function() {
    var origen=$(this).val();  //para verificar si es 1=nacional o 2=extra

    $('#NOMBRE_FAB').selectize()[0].selectize.destroy();
    var fab = $('#NOMBRE_FAB').selectize({
        valueField: 'idEstablecimiento',
        labelField: 'nombreFab',
        searchField: ['idEstablecimiento', 'nombreFab'],
        maxOptions: 10,
        options: [],
        create: false,
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
                    o: origen,
                    t: 'COS'
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

    $('#NOMBRE_FAB').selectize()[0].selectize.clearOptions();
});

//Busca fabricante SELECCIONADO
$('#NOMBRE_FAB').change(function(){

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

//BUSQUEDA DE MARCAS

	var id=$('#idMarca').val();
	var nombre=$('#nombreMarca').val();

	var marcasSelect=$('#marcaSelect').selectize({
   			valueField: 'idMarca',
		    labelField: 'nombreMarca',
		    searchField: ['idMarca','nombreMarca'], 
		    maxOptions: 10,
		        options: [{idMarca: id, nombreMarca: nombre}],
		        create: false,
		    render:{
		      option: function(item, escape) {
		                return '<div>'+ escape(item.nombreMarca) +'</div>';
		              }
		        },
		     load: function(query, callback) {
		                if (!query.length) return callback();    
		        $.ajax({
		          url:"{{route('buscar.marcas')}}",
		          type: 'GET',
		                dataType: 'json',
		                data: {
		                        q: query, 
		                    },
		          error: function() {
		                        callback();
		                    },
		                success: function(res) {
		                        callback(res.data);
		                        console.log("hola");

		                    }
		          });
		    }
	  	});
	   $('#marcaSelect').selectize()[0].selectize.setValue(id);	
});

//Búsqueda de propietarios tipo juridico o natural
$('input[type=radio][name=tipoT]').change(function(){
	var tipo=$(this).val();
	//console.log(tipo);
  if (tipo!=3){
    $('#th-id-propietario').text('NIT');
    var dtPropietarios =$('#dt-busquedaProp').DataTable({
                      processing: true,
                      filter:true,
                      serverSide: false,
                      destroy: true,
                      order: [ [0, 'asc'] ],
                      pageLength: 5,
                      ajax: {
                         url: '{{route("buscarPropietarios")}}',
                         data: function (d) {
                            d.tipo= tipo;
                        }
                      },
                  columns:[                        
                        {data: 'NIT',name:'NIT'}, 
                        {data: 'NOMBRE_PROPIETARIO',name:'NOMBRE_PROPIETARIO'},
                        {data: 'opciones', name:'opciones'},
                                                         
                    ],
                language: {
                processing: '<div class=\"dlgwait\"></div>',
                "url": "{{ asset('plugins/datatable/lang/es.json') }}" 
                },    
              });
  }
  else{
    $('#th-id-propietario').text('Id Propietario')
	var dtPropietarios =$('#dt-busquedaProp').DataTable({
	                    processing: true,
	                    filter:true,
	                    serverSide: false,
	                    destroy: true,
	                    order: [ [0, 'asc'] ],
	                    pageLength: 5,
	                    ajax: {
	                       url: '{{route("buscarPropietarios")}}',
	                       data: function (d) {
                            d.tipo= tipo;
                        }
	                    },
	                columns:[                        
	                      {data: 'ID_PROPIETARIO',name:'ID_PROPIETARIO'}, 
	                      {data: 'NOMBRE_PROPIETARIO',name:'NOMBRE_PROPIETARIO'},
	                      {data: 'opciones', name:'opciones'},
	                                                       
	                  ],
	              language: {
	              processing: '<div class=\"dlgwait\"></div>',
	              "url": "{{ asset('plugins/datatable/lang/es.json') }}" 
	              },    
	            });
  }



});

 var idPoder=$('#idPoderprof').val();
 var nombreProf=$('#nombreProfesional').val();
 $('#ID_PODER').selectize({
  	valueField: 'ID_PODER',
  	labelField: 'ID_PODER',
  	searchField: ['ID_PODER','NOMBRE_PROFESIONAL'],	
  	maxOptions: 10,
        options: [{ID_PODER:idPoder,NOMBRE_PROFESIONAL:nombreProf}],
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
 $('#ID_PODER').selectize()[0].selectize.setValue(idPoder);	


$('#ID_PODER').change(function (){
	var idPoder=$('#ID_PODER').val();
	if(idPoder!=''){
		 $.ajax({
	  			url: '{{route('get.profesional')}}',
	  			data: {poder:idPoder},
	  			type: 'get',
	  			success : function(r){
	  				console.log(r);
	  				if(r.status==200){
	  					$('#idProfesional').val(r.data.ID_PROFESIONAL);
		  				$('#nombreProfesional').val(r.data.NOMBRES+" "+r.data.APELLIDOS);
              $('#nombrePropietario').val(r.data.NOMBRE_PROPIETARIO);
		  				$('#telefonoProf').val(r.data.TELEFONO_1);
		  				$('#emailprof').val(r.data.EMAIL);

	  				} else {
	  					alertify.alert("Mensaje de error", r.message);	
	  				}
	  			}
		
	  });
	}
});


//Búsqueda de distribuidores
  $('#NOMBRE_DIS').selectize({
    valueField: 'ID_PODER',
    labelField: 'NOMBRE_COMERCIAL',
    searchField: ['ID_PODER','NOMBRE_COMERCIAL'], 
    maxOptions: 10,
        options: [],
        create: false,
    render:{
      option: function(item, escape) {
                return '<div>' +escape(item.ID_PODER)+' ('+ escape(item.NOMBRE_COMERCIAL) +')</div>';
              }
        },
     load: function(query, callback) {
                if (!query.length) return callback();    
        $.ajax({
          url:"{{route('buscarDistribuidoresAjax')}}",
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


$('#NOMBRE_DIS').selectize()[0].selectize.clearOptions();

$('#NOMBRE_DIS').change(function(){
  var poder= $('#NOMBRE_DIS').val();

    $.ajax({
        url:"{{ route('buscarDistribuidoresAjaxPorId') }}",
        data:{_token: '{{ csrf_token() }}',
                poder: poder },
        type: 'post',
        success: function(data){
        	//	console.log("poder");
        //	console.log(data);
                      //completo vista 'DISTRIBUIDORES'
                     var nuevaFila="";
                        nuevaFila+="<tr><input type='hidden' name='poderDistribuidores[]' value="+data[0].ID_PODER+"><td>"+data[0].idEstablecimiento+"</td><td>"+data[0].ID_PODER+"</td><td>"+data[0].nombreFab+"</td><td>"+data[0].direccion+"</td><td> "+data[0].telefonosContacto+"</td><td>"+data[0].emailContacto+"</td><td><a class='btn btn-xs btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a></td></tr>";
                      $('#dt-dist').append(nuevaFila);
               
                  }
                
            });
  });


//Llena selectize de importadores
 $('#NOMBRE_IMP').selectize({
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
          url:"{{route('buscarImportadoresAjax')}}",
          type: 'GET',
                dataType: 'json',
                data: {
                        q: query, 
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

 $('#NOMBRE_IMP').selectize()[0].selectize.clearOptions();

// llena datatable con datos de importador seleccionado
 $('#NOMBRE_IMP').change(function(){
   var id = $(this).val();
 // console.log(origen);
  $.ajax({
        url:"{{ route('buscarImportadorAjaxPorId') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'post',
        success: function(data){
          //console.log(data[0].telefonosContacto);
          if(data.length>0){
                if(data[0].telefonosContacto === ''){
                  //console.log("entro");
                  var telefono='';
                } else {
                var telefono= jQuery.parseJSON(data[0].telefonosContacto);
                }
                var input=''; 
                var nuevaFila="";
                    nuevaFila+="<tr><input type='hidden' name='importadores[]' value="+data[0].idEstablecimiento+"><td>"+data[0].idEstablecimiento+"</td><td>"+data[0].nombreFab+"</td> <td>"+data[0].direccion+"</td><td>"+telefono+"</td><td>"+data[0].emailContacto+"</td><td>"+data[0].vigenciaHasta+"</td><td><a class='btn btn-xs btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a></td></tr>";
                  $('#dt-imp').append(nuevaFila);
                /* input+='<input type="hidden" name="ID_IMP[]" value="'+data[0].idEstablecimiento+'"/>';
                $('#importadores').append(input);*/
               
                  }
                }
            });

  });

$('#buscarSustancia').click(function (){
  //var tipotramite=$('input[name="nomTram"]:checked').val();
  $('#porcentaje').val('');

  $('#formulaSelect').selectize({
    valueField: 'idDenominacion',
    labelField: 'denominacionINCI',
    searchField: ['numeroCAS','denominacionINCI'], 
    maxOptions: 10,
        options: [],
        create: false,
    render:{
      option: function(item, escape) {
               return '<div>' +escape(item.numeroCAS)+' ('+escape(item.denominacionINCI) +')</div>';
              }
        },
     load: function(query, callback) {
                if (!query.length) return callback(); 
        $.ajax({
          url:"{{route('buscarFormulasAjax')}}",
          type: 'GET',
                dataType: 'json',
                data: {
                        q: query.toUpperCase(),
                        tipotramite: 2
                    },
          error: function() {
                        callback();
                    },
                success: function(res) {
               console.log(res);
                        callback(res.data);
                         
                        
                    }
          });
    } 
    
  });
   $('#formulaSelect').selectize()[0].selectize.clearOptions();
 });

 

$('#agregarFormula').click(function(){
  var idDen=$('#formulaSelect').val();
  var nombreDen=$('#formulaSelect').text();
  var por=$('#porcentaje').val();
  var inputSus='';
  var inputPor='';
 
   $.ajax({
        url:"{{ route('buscarFormulajaxPorId') }}",
        data:{_token: '{{ csrf_token() }}',
                  id: idDen
            },
        type: 'post',
        success: function(data){
            var nuevaFila="";
            nuevaFila+="<tr><input type='hidden' name='idDenominacion[]' value='"+data[0].idDenominacion+"'><input type='hidden' name='numeroCAS[]' value='"+data[0].numeroCAS+"'><input type='hidden' name='denominacionINCI[]' value='"+data[0].denominacionINCI+"'><input type='hidden' name='porcentaje[]' value='"+por+"'><td>"+data[0].numeroCAS+"</td><td>"+data[0].denominacionINCI+"</td><td>"+por+"%</td><td><a class='btn btn-xs btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a></td></tr>";
                $('#dtformulaEdicion tbody').append(nuevaFila);
            }
        });
});


var idCos=$('#idCosmetico').val();
var tipoProducto=$('#idtipo').val();
var _token=$('#_token').val();


// METODO PARA GUARDAR
$('#generalesSave').click(function(){

	$.ajax({
		data: $('#frmGeneralesCos').serialize() +"&NoRegistro="+idCos+"&_token="+_token,
		url: "{{route('editarGenenalesCos')}}",
	
		type: 'POST',
		beforeSend: function() {
            $('body').modalmanager('loading');
                    },
		success: function (r){
			$('body').modalmanager('loading');
			if(r.status == 200){
		    		alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
		    	} else if(r.status == 404){
		    		alertify.alert("Mensaje de error", r.message);
		    	} else {
		    		alertify.alert("Mensaje de error", "Ocurrio un error");
		    	}
		}
	});

});

$('#clasificacionSave').click(function (){
	$.ajax({
		data: $('#frmClasificacionCos').serialize() +"&NoRegistro="+idCos+"&_token="+_token,
		url: "{{route('editarClas')}}",
	
		type: 'POST',
		beforeSend: function() {
            $('body').modalmanager('loading');
                    },
		success: function (r){
			$('body').modalmanager('loading');
			if(r.status == 200){
		    		alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
		    	} else if(r.status == 404){
		    		alertify.alert("Mensaje de error", r.message);
		    	} else {
		    		alertify.alert("Mensaje de error", "Ocurrio un error");
		    	}
		}
	});
});

$('#marcaSave').click(function (){
	var marca=$('#marcaSelect').val();

	$.ajax({
		data: "marca="+marca+"&NoRegistro="+idCos+"&_token="+_token,
		url: "{{route('editarMarca')}}",
	
		type: 'POST',
		beforeSend: function() {
            $('body').modalmanager('loading');
                    },
		success: function (r){
			$('body').modalmanager('loading');
			if(r.status == 200){
		    		alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
		    	} else if(r.status == 404){
		    		alertify.alert("Mensaje de error", r.message);
		    	} else {
		    		alertify.alert("Mensaje de error", "Ocurrio un error");
		    	}
		}
	});
});

$('#propietarioSave').click(function(){
	$.ajax({
		data: $('#frmPropietario').serialize() +"&NoRegistro="+idCos+"&_token="+_token,
		url: "{{route('editarPropietarioCos')}}",
	
		type: 'POST',
		beforeSend: function() {
            $('body').modalmanager('loading');
                    },
		success: function (r){
			$('body').modalmanager('loading');
			if(r.status == 200){
		    		alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
		    	} else if(r.status == 404){
		    		alertify.alert("Mensaje de error", r.message);
		    	} else {
		    		alertify.alert("Mensaje de error", "Ocurrio un error");
		    	}
		}
	});
});


$('#profesionalSave').click(function (){
	$.ajax({
		data: $('#frmProfesional').serialize() +"&NoRegistro="+idCos+"&_token="+_token,
		url: "{{route('editarProfesionalCos')}}",
	
		type: 'POST',
		beforeSend: function() {
            $('body').modalmanager('loading');
                    },
		success: function (r){
			$('body').modalmanager('loading');
			if(r.status == 200){
		    		alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
		    	} else if(r.status == 404){
		    		alertify.alert("Mensaje de error", r.message);
		    	} else {
		    		alertify.alert("Mensaje de error", "Ocurrio un error");
		    	}
		}
	});
});

$('#formulaSave').click(function (){
	$.ajax({
		data: $('#formulaFrm').serialize() +"&NoRegistro="+idCos+"&_token="+_token,
		url: "{{route('editarFormulaCos')}}",
	
		type: 'POST',
		beforeSend: function() {
            $('body').modalmanager('loading');
                    },
		success: function (r){
			$('body').modalmanager('loading');
			if(r.status == 200){
		    		alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
		    	} else if(r.status == 404){
		    		alertify.alert("Mensaje de error", r.message);
		    	} else {
		    		alertify.alert("Mensaje de error", "Ocurrio un error");
		    	}
		}
	});
});

$('#tonoSave').click(function (){
console.log("hola tonos");
	var tipo =$('#clasificacionProd').val();

	if(tipo=='COS')
		url="{{route('editarTonosCos')}}";
	else 
		url="{{route('editarTonosCos')}}";

	$.ajax({
		data: $('#tonosFrm').serialize() +"&NoRegistro="+idCos+"&_token="+_token,
		url: url,
	
		type: 'POST',
		beforeSend: function() {
            $('body').modalmanager('loading');
                    },
		success: function (r){
			$('body').modalmanager('loading');
			if(r.status == 200){
		    		alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
		    	} else if(r.status == 404){
		    		alertify.alert("Mensaje de error", r.message);
		    	} else {
		    		alertify.alert("Mensaje de error", "Ocurrio un error");
		    	}
		}
	});
});

$('#fraganciaSave').click(function (){
//	console.log("hola");
	var tipo =$('#clasificacionProducto').val();

	if(tipo=='COS')
		url="{{route("editarFraganciaCos")}}";
	else 
		url="{{route("editarFraganciaCos")}}";
	
	$.ajax({
		data: $('#fraganciaFrm').serialize() +"&NoRegistro="+idCos+"&_token="+_token,
		url: url,
	
		type: 'POST',
		beforeSend: function() {
            $('body').modalmanager('loading');
                    },
		success: function (r){
			$('body').modalmanager('loading');
			if(r.status == 200){
		    		alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
		    	} else if(r.status == 404){
		    		alertify.alert("Mensaje de error", r.message);
		    	} else {
		    		alertify.alert("Mensaje de error", "Ocurrio un error");
		    	}
		}
	});
});

$('#fabSave').click(function (){
	var tipo =$('#clasificacionProducto').val();
	if(tipo=='COS')
		url="{{route("editarFabCos")}}";
	else 
		url="{{route("editarFabCos")}}";
	
	
	$.ajax({
		data: $('#fabFrm').serialize() +"&NoRegistro="+idCos+"&_token="+_token,
		url: url,
	
		type: 'POST',
		beforeSend: function() {
            $('body').modalmanager('loading');
                    },
		success: function (r){
			$('body').modalmanager('loading');
			if(r.status == 200){
		    		alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
		    	} else if(r.status == 404){
		    		alertify.alert("Mensaje de error", r.message);
		    	} else {
		    		alertify.alert("Mensaje de error", "Ocurrio un error");
		    	}
		}
	});

});

$('#disSave').click(function (){
	var tipo =$('#clasificacionProducto').val();
	if(tipo=='COS')
		url="{{route("editarDisCos")}}";
	else 
		url="{{route("editarDisCos")}}";
	
	
	$.ajax({
		data: $('#disFrm').serialize() +"&NoRegistro="+idCos+"&_token="+_token,
		url: url,
	
		type: 'POST',
		beforeSend: function() {
            $('body').modalmanager('loading');
                    },
		success: function (r){
			$('body').modalmanager('loading');
			if(r.status == 200){
		    		alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
		    	} else if(r.status == 404){
		    		alertify.alert("Mensaje de error", r.message);
		    	} else {
		    		alertify.alert("Mensaje de error", "Ocurrio un error");
		    	}
		}
	});

});


$('#ImpSave').click(function (){
	var tipo =$('#clasificacionProducto').val();
	if(tipo=='COS')
		url="{{route("editarImpCos")}}";
	else 
		url="{{route("editarImpCos")}}";
	
	
	$.ajax({
		data: $('#impFrm').serialize() +"&NoRegistro="+idCos+"&_token="+_token,
		url: url,
	
		type: 'POST',
		beforeSend: function() {
            $('body').modalmanager('loading');
                    },
		success: function (r){
			$('body').modalmanager('loading');
			if(r.status == 200){
		    		alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
		    	} else if(r.status == 404){
		    		alertify.alert("Mensaje de error", r.message);
		    	} else {
		    		alertify.alert("Mensaje de error", "Ocurrio un error");
		    	}
		}
	});

});
// MÉTODOS PARA RECIBIR INFORMACION DE MODALS

$(document).on('click', '.prop', function () {
  var id = $(this).data('id');
  var tipo=$("input[name='tipoT']:checked").val();
  //var tipoTitular=$('input name["tipoT"]:checked').val();
  console.log("hola"+tipo);
  // write your ajax below
  $.ajax({
  			url: '{{route('get.titular')}}',
  			data: {nitOrPp:id, tipoTitular: tipo},
  			type: 'get',
  			success : function(r){
  				console.log(r);
  				if(r.status==200){
  					$('#idTitular').val(r.data.idPropietario);
	  				$('#nit').val(r.data.nit);
	  				$('#nombreTitular').val(r.data.nombre);
	  				$('#telefono').val(jQuery.parseJSON(r.data.telefonosContacto));
	  				$('#direccion').val(r.data.direccion);
	  				$('#email').val(r.data.emailsContacto);

	  				$('#titularTipo').val(r.data.tipoTitular);
	  				if(r.data.tipoTitular==1||r.data.tipoTitular==2){	  				 				
		  				$('#paisTitular').val('EL SALVADOR');
		  				$('#nit').val(r.data.nit);
		  			} else {
		  				$('#paisTitular').val(r.data.PAIS);
		  				$('#nit').val("N/A");
		  			}
  				} else {
  					alertify.alert("Mensaje de error", r.message);	
  				}
  			}
  });
  $("input[name='tipoT']").prop('checked', false);
  
});



 $(document).on('click', '.borrar', function (event) {
      event.preventDefault();
     
      $(this).closest('tr').remove();
      
    }); 

 // Lleno los combobox de envases, materiales y medidas en el modal de presentaciones
$('#btnPre').click(function(){
  $('input[name="check"] ').prop('checked', false);
  $('.mostrar').hide();
  $(".pres").val("");
  $.ajax({
    url: "{{route('envases.presentaciones')}}",
    type: 'get',
    success: function(data){
      $('.envase').html(data);
     // console.log(data);
    }
  });
  $.ajax({
    url: "{{route('materiales.presentaciones')}}",
    type: 'get',
    success: function(data){
      $('.material').html(data);
      //console.log(data);
    }
  });
    $.ajax({
    url: "{{route('unidades.presentaciones')}}",
    type: 'get',
    success: function(data){
      $('.unidad').html(data);
     // console.log(data);
    }
  });

$('.contenidoProducto').hide();
});


/*//Aseguro que el contenido del envase secundario coincida con el envase primario.  //ya no lo utilizo
$('#primario').change(function(){
   if($("#check").is(":checked")){ // solo si existe un envase secundario
    var cont = $('#primario option:selected').text();
   // $('#contSec').val(cont);
  }
});*/
$('#ayuda').click(function (){
  $(this).enable();
});



$("input[name='check']").change(function(){  //si existe envase secundario habilito los campos

  var valor= $("input[name='check']:checked").val();
  $('#textoPres').css('background-color','#d5dad8');
 
  if(valor==1){
    $(".mostrar").show();
    $(".ep").hide();
    $(".es").show();
    $("#materialSec").attr("required",true);
    $("#contenidoS").attr("required",true);
    $("#secundario").attr("required",true);
    $(".pre1").show();
    $(".pre2").hide();
  }else{ 
    $(".es").hide();
    $(".ep").hide(); 
    $(".mostrar").show();
    $("#materialSec").removeAttr("required",true);
    $("#contenidoS").removeAttr("required",true);
    $("#secundario").removeAttr("required",true);
    $("#materialSec").val("");
    $("#contenidoS").val("");
    $("#secundario").val("");
    $(".pre1").hide();
    $(".pre2").show();
  
  }
}); 

//Si seleccionan 'unidad' en la presentación habilito campos de producto.
$('#unidad').change(function (){
  var unidad=$(this).val();
  var tramite=$("input[name='nomTram']:checked").val();
  
  if(unidad==11){  // seleccionaron unidad
    $('.cep').show();  //CEP contenido empaque primario
    $('#peso').val("");
    $('#medida').val("");
    armarPresentacion();
  } else {
    $('.cep').hide(); 
    $('#peso').val("");
    $('#medida').val("");
     armarPresentacion();
  }
 // alert($('#medida option:checked').text()); 
});


function armarPresentacion(){

  $('#textoPres').css('background-color','#a9f0d3');
  $('#textoPres').css('border-color','#08f59f');
  $('#textoPres').css('border','15');
  p1=$('#secundario option:checked').text();
  p2=$('#materialSec option:checked').text();
  p3=$('#contenidoS').val();
  p4=$('#primario option:checked').text();
  p5=$('#materialPri option:checked').text();
  p6=$('#contenidoPri').val();
  p7=$('#unidad option:checked').text();
  nombre=$('#nombrePres').val();
  p8=" ";
  if(nombre!=""){
    nombre=" ("+nombre+" )";
  }
 
  
  if($('#peso').val()!=" "){

    p9=$('#peso').val()+" "+$('#medida option:checked').text();
 
    if(p9!=" "){
      p8="DE "+p9;
   
    } else {
      p8=" ";
    }
  } else {
    p8=" ";
  }

  var valor= $("input[name='check']:checked").val();
  if(valor==1){  //tiene empaque secundario
    texto=p1+" DE "+p2+" X "+p3+" "+p4+" DE "+p5+" X "+p6+" "+p7+" "+p8+nombre;
   // alert(texto);
  } else if (unidad==11) {
     texto=p3+" "+p4+" DE "+p5+" X "+p6+" "+p7+" "+p8+nombre;
  } else {
    texto=p3+" "+p4+" DE "+p5+" X "+p6+" "+p7+nombre;
  }

  $('#textoPres').val(texto);
 
}


$('#savePres').click(function(){
  var valor= $("input[name='check']:checked").val();
  if(valor==1){
    empaqueSec=$('#secundario option:checked').val();
    materialSec=$('#materialSec option:checked').val();
    contenidoSec=$('#contenidoS').val();
    totalPres=$('#totalPres').val();
  /*  if(empaqueSec=="0"){
       alertify.alert("Mensaje de sistema","Debe completar el campo 'Empaque Secundario (ES)'");
        break;
    } else if (materialSec=="0"){
      alertify.alert("Mensaje de sistema","Debe completar el campo 'Material Secundario (MS)'");
       break;
    } else {
      alertify.alert("Mensaje de sistema","Debe completar el campo 'Contenido Secundario (Contenido ES)'");
      break;
    }*/
  } else {
    empaqueSec=null;
    materialSec=null;
    contenidoSec=null;
  }
 
  empaquePri=$('#primario option:checked').val();
  materialPri=$('#materialPri option:checked').val();
  contenidoPri=$('#contenidoPri').val();
  unidad=$('#unidad option:checked').val();
  nombre=$('#nombrePres').val();
  texto=$('#textoPres').val();
  peso=$('#peso').val();
  medida=$('#medida option:checked').val();
  clas=valor;
  cosmetico=$('#idCosmetico').val();
  token=$('input[name="_token"]').val();

  $.ajax({
          url: "{{ route('actualizar.presentacion') }}",
           data: { idCosmetico:cosmetico, 
                  _token :token,
                  empaqueSec :empaqueSec,
                  materialSec :materialSec,
                  contenidoSec :contenidoSec,
                  empaquePri :empaquePri,
                  materialPri :materialPri,
                  contenidoPri:contenidoPri,
                  unidad :unidad,
                  nombre :nombre,
                  peso :peso,
                  medida :medida,
                  clas :clas,
                  texto :texto
                },
          type: 'POST',
          success:  function (r){
            var total=r.data['presentaciones'].length;
            var nuevaFila="";
                    nuevaFila+="<tr><td>"+total+"</td><td></td><td>"+r.data['presentaciones'][0].textoPresentacion+"</td><td><button type='button' class='btn btn-xs btn-danger borrarPres' data-idpres='"+r.data['presentaciones'][0].idPresentacion+"'><i class='fa fa-times' aria-hidden='true'></i></button> </td></tr>";
                    $('#dt-pres').append(nuevaFila);
                    $('#agregarcoempaque').show();


                      
             if(r.status == 200){
                alertify.alert("Mensaje de sistema",r.message);
               } else if(r.status == 404){
                  alertify.alert("Mensaje de error", r.data['message']);
                } else {
                  alertify.alert("Mensaje de error", "Ocurrio un error");
                }
              },
          
          
          });

});

$(document).on('click', '.borrarPres', function (event) {
      event.preventDefault();
      var fila= $(this).closest('tr');
      var idPresentacion=$(this).data('idpres');
      var id=$(this).closest('tr').find('td:first').html();

      var idCosmetico=$('#idCosmetico').val();
      console.log(fila);
      $.ajax({
              data: {idPresentacion:idPresentacion, idCosmetico:idCosmetico},
              url: '{{route("borrar.presentacionesCos")}}',
              type: 'get',
              beforeSend: function() {
                $('body').modalmanager('loading');
              },
              success:  function (r){

              $('body').modalmanager('loading');
              if(r.status == 200){
                alertify.alert("Mensaje de sistema",r.message);
                fila.remove();
               } else if(r.status == 400){
                  alertify.alert("Mensaje de error", r.message);
                } else {
                  alertify.alert("Mensaje de error", "Ocurrio un error");
                }
              },

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
            //console.log(r.data['coempaque']); 
             console.log(r.data['detalle']);
              console.log(r.data.nomPres);
              console.log(r.data.total);
              if(r.status == 200){
                var nuevaFila="";
                nuevaFila+="<tr><td>"+r.data.total+"</td><td>"+r.data['detalle'][0].nombreCoempaque+"</td><td>"+r.data.nomPres+"</td><td><button button type='button' class='btn btn-xs btn-danger borrarCoem' data-idcoem='"+r.data['detalle'][0].idCoempaque+"'><i class='fa fa-times' aria-hidden='true'></i></button> </td></tr>";
                    $('#dt-pres').append(nuevaFila);
               // alertify.success("Mensaje de sistema",r.message);
                //alertify.alert("<a type='button' class='btn btn-success' href='../imprimir/"+idSolicitud+"/"+sesion+"'>Imprimir Licencia</button>");
               // $('#agregarcoempaque').hide();

               // dtPres.fnReloadAjax();
               } else if(r.status == 404){
                    alertify.alert("Mensaje de error", r.data['message']);
                } else {
                  alertify.alert("Mensaje de error", "Ocurrio un error");
                }
              },

      });
});

$(document).on('click', '.borrarCoem', function (event) {
      event.preventDefault();
      var fila= $(this).closest('tr');
      var idcoem=$(this).data('idcoem');
      var id=$(this).closest('tr').find('td:first').html();

      //var idCosmetico=$('#idCosmetico').val();
     // console.log(idcoem);
      $.ajax({
              data: {idcoem:idcoem},
              url: '{{route("borrar.coempaque")}}',
              type: 'get',
              beforeSend: function() {
                $('body').modalmanager('loading');
              },
              success:  function (r){

              $('body').modalmanager('loading');
              if(r.status == 200){
                alertify.alert("Mensaje de sistema",r.message);
                fila.remove();
               } else if(r.status == 400){
                  alertify.alert("Mensaje de error", r.message);
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

 </script>

@endsection