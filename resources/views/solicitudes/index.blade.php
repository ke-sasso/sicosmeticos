@extends('master')

@section('css')

{!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!} 




@endsection


@section('contenido')


@if(Session::has('message'))
    <div class="alert alert-success">
      <strong>Hecho!</strong> {!! Session::get('message') !!}
    </div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger">
  <strong>Advertencia!</strong> {!! Session::get('error') !!}
</div>
@endif


<div class="panel-body">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="panel with-nav-tabs panel-success">
					<div class="panel-heading">
						<ul class="nav nav-tabs">
						  <li class="active"><a href="#tipot" data-toggle="tab">Tipo de Trámite</a></li>
						    <li><a href="#detalle" class="detalle" data-toggle="tab" style="display:none;">Datos Generales</a></li>
					     <li><a href="#detalleAdicional"  class="detalleAdicional" data-toggle="tab" style="display:none;" >Detalle de Solicitud</a></li>
              		
					
						</ul>
            		</div>

           <div id="panel-collapse-1" class="collapse in">
						<div class="panel-body">
							<div class="tab-content">
  									<div class="tab-pane fade in active" id="tipot">
									    <div class="panel-body">
										    <div class="the-box full no-border">
												<div class="container-fluid">
												
														<div class="row">
															<h4>SELECCIONE EL TRÁMITE A REALIZAR</h4>
																<div class="group-radio">
																@foreach($tramites as $t)
																<div class="radio" >
																   <label>
                                      <input type="radio" id="tramite" name="nomTram" onclick="getSol({{$t->idTramite}})" value="{{$t->idTramite}}" required>{!!$t->nombreTramite!!}
                                    </label>
																</div>
																@endforeach
																</div>
														</div>
												
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="detalle">
                    <form id="guardarSolicitud" method="POST" action="{{route('guardarsolNuevoCos')}}">
                      <div class="container-fluid">
                        <h4 class="tituloSol"></h4>
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          <input type="hidden" name="idTramite" id="idTramite" value="" />
                            <div class="panel panel-success">
                              <div class="panel-heading">GENERALES</div>
                                <div class="panel-body">
                                  @include('solicitudes.paneles.generales')
                                  @include('solicitudes.paneles.generalesCos')
                                  @include('solicitudes.paneles.generalesHig')
                                </div>
                            </div>

                            <div class="panel panel-success reconocimientos" style="display:none">
                                <div class="panel-heading">RECONOCIMIENTO</div>
                                    <div class="panel-body">
                                      @include('solicitudes.paneles.reconocimiento')
                                    </div>
                            </div>

                            <div class="panel panel-success">
                              <div class="panel-heading">VALIDAR MANDAMIENTO</div>
                               <div class="panel-body">
                                  <div class="row">
                                    <div class="col-xs-4">
                                   <label>No. Mandamiento:</label>
                                     <input type="text" id="mandamiento" name="mandamiento" class="form-control" required="true"/>
                                  </div><br/>
                                     <div class="col-xs-4">
                                      <button  type="button" name="validar" id="validar" class="btn btn-primary btn-perspective">Validar</button>
                                    </div>
                                   </div>
                                  </div>
                                    @include('solicitudes.paneles.mandamiento')
                            </div>
                           
                            
                          
                            <div class="panel panel-success">
                                <div class="panel-heading">TITULAR</div>
                                    <div class="panel-body">
                                      @include('solicitudes.paneles.titular')
                                    </div>
                            </div>

                            <div class="panel panel-success">
                                <div class="panel-heading">PROFESIONAL RESPONSABLE</div>
                                    <div class="panel-body">
                                      @include('solicitudes.paneles.profesional')
                                    </div>
                            </div>

                            <div class="panel panel-success">
                                <div class="panel-heading">PERSONA DE CONTACTO</div>
                                    <div class="panel-body">
                                      @include('solicitudes.paneles.personaContacto')
                                    </div>
                            </div> 

                            <div class="panel panel-success coempaqueDiv">
                              <div class="panel-heading">COEMPAQUES</div>
                              <div class="panel-body">
                                @include('solicitudes.paneles.coempaque')
                              </div>
                            </div>
                         
                          <button type="button" name="guardar" id="saveSol" class="btn btn-success" style="margin-left:40%">Guardar Generales</button>
                          <button type="button" name="siguiente" id="siguiente" class="btn btn-info" style="margin-left:40%;display:none;">Continuar</button>
                        
                    </div>
                </form>
                </div>
                 <div class="tab-pane fade" id="detalleAdicional">
                  <form name="solicitud" method="post"  role="form" enctype="multipart/form-data" action="{{route('guardarSolicitudCosDetalle')}}">
                    <input type="hidden" name="idSolicitud" id="idSolicitud" value="" />

                     <input type="hidden" name="_token" value="{{ csrf_token() }}" ></input>
                    <div class="container-fluid">
                            <div class="panel panel-success">
                              <div class="panel-heading">PRESENTACIONES</div>
                              <div class="panel-body">
                                @include('solicitudes.paneles.presentacionesCos')
                              </div>
                            </div>
                           
                            <div class="panel panel-success">
                              <div class="panel-heading">FORMULA</div>
                              <div class="panel-body">
                                @include('solicitudes.paneles.formulaCosmeticos')
                              </div>
                            </div>

                            <div class="panel panel-success" style="display:none" id="panelTono">
                              <div class="panel-heading">TONOS</div>
                                  <div class="panel-body">
                                    @include('solicitudes.paneles.tonos')
                                  </div>
                            </div>

                            <div class="panel panel-success" style="display:none" id="panelFrag">
                              <div class="panel-heading">FRAGANCIAS</div>
                                  <div class="panel-body">
                                    @include('solicitudes.paneles.fragancias')
                                  </div>
                            </div> 
                              <div class="panel panel-success">
                                <div class="panel-heading">FABRICANTES</div>
                                    <div class="panel-body">
                                      @include('solicitudes.paneles.fabricantes')
                                    </div>
                            </div>

                            <div class="panel panel-success">
                                <div class="panel-heading">IMPORTADORES</div>
                                    <div class="panel-body">
                                      @include('solicitudes.paneles.importadores')
                                    </div>
                            </div>  

                            <div class="panel panel-success">
                              <div class="panel-heading">DISTRIBUIDORES</div>
                                  <div class="panel-body">
                                    @include('solicitudes.paneles.distribuidores')
                                  </div>
                            </div>
                            <div class="panel panel-success">
                                <div class="panel-heading">ANEXOS</div>
                                    <div class="panel-body">
                                      @include('solicitudes.paneles.anexos')
                                    </div>
                            </div>
                             <button  name="guardar" id="guardard" class="btn btn-success">FINALIZAR SOLICITUD</button>
                    </div>
                  </form>
                </div>  
            </div>
          </div>
        </div>
			</div>
		</div>
  </div>
</div>

@include('solicitudes.paneles.modalPresentacion')
@include('solicitudes.paneles.modalFormulaCos')
@include('modals.personaContacto')

@endsection

@section('js')
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}

<script type="text/javascript">



function getSol(idTramite){
	//console.log(idTramite);
  $('.persona').prop('required',false);
  $('#idTramite').val(idTramite);
	if(idTramite==2){
    $('.form-control').val("");    
    $('.tituloSol').text('SOLICITUD NUEVO REGISTRO SANITARIO DE PRODUCTOS COSMETICOS');
  	$('.detalle').show();
    $('.reconocimientos').hide();
  	$('#cos').show();
    $('#hig').hide();
    $('#guardar').hide();
    //validaciones segun tipos de solicitud
    $('.cos').prop('required',true);
    $('.hig').prop('required',false);
    $('.coempaqueDiv').show();

    //Trae las areas de aplicacion de cosmeticos disponibles
    $('#area').change(function(){
      var id= $('#area').val();
        $.ajax({
            url:"{{ route('getDataClassSol') }}",
            data:{_token: '{{ csrf_token() }}',
                id: id },
            type: 'post',
            success: function(data){
              $('#class').html(data);
                
                      }
                });
  });
  
  }
	if(idTramite==3){
    $('.form-control').val("");  
    $('.tituloSol').text('SOLICITUD DE RECONOCIMIENTO MUTUO DEL REGISTRO SANITARIO DE PRODUCTOS COSMETICOS');
  	$('.detalle').show();
    $('.reconocimientos').show();
    $('#cos').show();
    $('#hig').hide();
    $('#guardar').hide();
    $('.coempaqueDiv').show();
    $('.cos').prop('required',true);
    $('.hig').prop('required',false);
 
      $.ajax({                 // trae catalogo de paises cuando es reconocimiento
      url:"{{ route('getPaises') }}",
      type: 'get',
      success: function(data){
        $('#paisOrigen').html(data);
      }
   
      });
       //Trae las areas de aplicacion de cosmeticos disponibles
      $('#area').change(function(){
        var id= $('#area').val();
          $.ajax({
              url:"{{ route('getDataClassSol') }}",
              data:{_token: '{{ csrf_token() }}',
                  id: id },
              type: 'post',
              success: function(data){
                $('#class').html(data);
                  
                        }
                });
 	    });
  }
	if(idTramite==4){
    $('.form-control').val("");  
    $('.tituloSol').text('SOLICITUD NUEVO REGISTRO SANITARIO DE PRODUCTOS HIGIENICOS');
    $('.detalle').show();
  	$('.reconocimientos').hide();
    $('#cos').hide();
    $('#hig').show();
    $('#guardar').hide();
    $('.pres').prop('required',false);
    $('.cos').prop('required',false);
    $('.hig').prop('required',true);
    $('.coempaqueDiv').hide();

      $.ajax({ //traigo clasificacion de Higienicos
          url:"{{ route('getClassHig') }}",
          type: 'get',
          success: function(data){
            $('#classHig').html(data);
          }
       
      });


	}

  if(idTramite==5){
    $('.form-control').val("");  
    $('.tituloSol').text('SOLICITUD DE RECONOCIMIENTO MUTUO DEL REGISTRO SANITARIO DE PRODUCTOS HIGIENICOS');
    $('.detalle').show();
    $('.reconocimientos').show();
    $('#cos').hide();
    $('#hig').show();
    $('#guardar').hide();
    $('.pres').prop('required',false);
    $('.cos').prop('required',false);
    $('.hig').prop('required',true);
    $('.coempaqueDiv').hide();
      $.ajax({                              // trae catalogo de paises cuando es reconocimiento
          url:"{{ route('getPaises') }}",
          type: 'get',
          success: function(data){
            $('#paisOrigen').html(data);
          }
       
      });
      $.ajax({ //traigo clasificacion de Higienicos
          url:"{{ route('getClassHig') }}",
          type: 'get',
          success: function(data){
            $('#classHig').html(data);
          }
       
      });
  }
  $('.detalle').show();
  $('.nav-tabs a[href="#detalle"]').tab('show');
}



//Muestra el detalle del tramite seleccionado
$('.group-radio').change(function(){
	$('.detalle').show();
  var id=$('input:radio[name=nomTram]:checked').val();
  $('.anexos').remove();
   //Trae items del tramite solicitado.
    $.ajax({
        url:"{{ route('buscarItems') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'post',
        success: function(data){
          for(var i=0,l=data.length;i<l;i++){
         //   console.log(data.idItem);
            var nuevaFila="";
            //var items="";
               nuevaFila+="<tr class='anexos'><td width='1%' hidden>"+data[i].idItem+"</td><td width='49%'>"+data[i].nombreItem+"</td><td><input type='file' id='docs' value='"+data[i].idItem+"' name='files["+data[i].idItem+"]' ></td></tr>";
                  $('.documentos').append(nuevaFila);
                  //$('.documentos').append(items);                  
              }
            }
          });
});

$('#classHig').change(function(){
  var id= $(this).val();
  $.ajax({ //consulto si la clasificacion posee tono y/o fragancia
        url:"{{ route('consultarClassSolHig') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'get',
        success: function(data){
       // console.log(data[0].poseeTono);
          $('input[name="poseeT"]').val(data[0].poseeTono);
          $('input[name="poseeF"]').val(data[0].poseeFragancia);
    
          if($('input[name="poseeT"]').val()==1)
            $('#panelTono').show();
          else 
            $('#panelTono').hide();
          if($('input[name="poseeF"]').val()==1)
            $('#panelFrag').show();
          else 
            $('#panelFrag').hide();
                  }
            });

});



//Llena el combobox de clasificacion de productos de acuerdo al area seleccionada
$('#class').change(function(){
	var id= $('#class').val();
 // console.log(id);
    $.ajax({
	    	url:"{{ route('getGrupoFormasSol') }}",
	    	data:{_token: '{{ csrf_token() }}',
	    			id: id },
    		type: 'post',
    		success: function(data){
    			$('#forma').html(data);
            	//console.log(data);
              		}
            })

     $.ajax({ //consulto si la clasificacion posee tono y/o fragancia
        url:"{{ route('consultarClassSolCos') }}", 
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'get',
        success: function(data){
          console.log(id);
          console.log(data[0].poseeTono);
          console.log(data[0].poseeFragancia);
          $('input[name="poseeT"]').val(data[0].poseeTono);
          $('input[name="poseeF"]').val(data[0].poseeFragancia);
    
          if($('input[name="poseeT"]').val()==1)
            $('#panelTono').show();
          else 
            $('#panelTono').hide();
          if($('input[name="poseeF"]').val()==1)
            $('#panelFrag').show();
          else 
            $('#panelFrag').hide();
                  }
            });
	});




//Búsqueda de propietarios tipo juridico o natural
$("#tipoTitular input[name='tipoT']").change(function(){
  var tipo=$(this).val();
 $('#nombre_propietario').selectize()[0].selectize.destroy();
 $('#nombre_propietario').selectize({
  	valueField: 'ID_PROPIETARIO',
  	labelField: 'NOMBRE_PROPIETARIO',
  	searchField: ['ID_PROPIETARIO','NOMBRE_PROPIETARIO'],	
  	maxOptions: 10,
        options: [],
        create: false,
  	render:{
  		option: function(item, escape) {
                return '<div>' +escape(item.ID_PROPIETARIO)+' ('+ escape(item.NOMBRE_PROPIETARIO) +')</div>';
              }
        },
     load: function(query, callback) {
                if (!query.length) return callback();    
		  	$.ajax({
		  		url:"{{route('buscarTitularAjax')}}",
		  		type: 'GET',
                dataType: 'json',
                data: {
                        q: query,
                        tipoTitular: tipo
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

 $('#nombre_propietario').selectize()[0].selectize.clearOptions();
});

//Llena datos de propietario seleccionado
 $('#nombre_propietario').change(function(){
	var nitOrPp= $('#nombre_propietario').val();
  var tipo=$("#tipoTitular input[name='tipoT']:checked").val();

    $.ajax({
	    	url:"{{ route('buscarTitularAjaxPorId') }}",
	    	data:{
    	    			nitOrPp: nitOrPp,
                tipoTitular: tipo
               },
    		type: 'get',
    		success: function(data){ 
        console.log(data);    
        console.log(data.data.telefonosContacto);                                 //completo vista  titular                
                    if(tipo==3){        //si el titular es extranjero
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      $('#id_propietario').val(data.data.idPropietario);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#TELEFONO_TITULAR').val(data.data.telefonosContacto); 
                      $('#PAIS_TITULAR').val(data.data.PAIS); 
                      if(data.data.telefonosContacto != ''){                 
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                        $('#TELEFONO_TITULAR').val(telefono);
                      }
                        
                    } else if (tipo==2){ //si es juridico
                      $('#id_propietario').val(data.data.nit);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "){
                       var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                       $('#TELEFONO_TITULAR').val(telefono);
                      } 
                    } else {  // si es natural
                      $('#id_propietario').val(data.data.nit);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "||data.data.telefonosContacto!=null){
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                        $('#TELEFONO_TITULAR').val(telefono);
                      }
                    }
              		} 
            });

	});

//Búsqueda de profesionales responsables
  $('#ID_PODER').selectize({
  	valueField: 'ID_PODER',
  	labelField: 'ID_PODER',
  	searchField: ['ID_PODER','NOMBRE_PROFESIONAL'],	
  	maxOptions: 10,
        options: [],
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

$('#ID_PODER').selectize()[0].selectize.clearOptions();


//LLena datos de profesional seleccionado
$('#ID_PODER').change(function(){
  var id= $('#ID_PODER').val();
  //console.log(id);
    $.ajax({
        url:"{{ route('buscarProfesionalAjaxPorId') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'post',
        success: function(data)
        {
                      //completo vista  'titular'
                  if(data.length > 0)
                  {
                      $('#ID_PROFESIONAL').val(data[0].ID_PROFESIONAL);
                      $('#NOMBRE_PROFESIONAL').val(data[0].NOMBRE_PROFESIONAL);
                      $('#DIRECCION_PRO').val(data[0].DIRECCION);
                      $('#EMAIL_PRO').val(data[0].EMAIL);
                      $('#TELEFONO_PRO').val(data[0].TELEFONO_1);
                  }    
        }
      });
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
                  console.log(res);
                        callback(res.data);
                    }
          });
    } 
    
});

 
$('#NOMBRE_DIS').change(function(){
  var poder= $('#NOMBRE_DIS').val();

  var input='';
  $('#NOMBRE_DIS').selectize()[0].selectize.clearOptions();
    $.ajax({
        url:"{{ route('buscarDistribuidoresAjaxPorId') }}",
        data:{_token: '{{ csrf_token() }}',
                poder: poder },
        type: 'post',
        success: function(data){
              if(data.length>0){
                      //completo vista 'DISTRIBUIDORES'
                     var nuevaFila="";
                        nuevaFila+="<tr class='fila'><td>"+data[0].idEstablecimiento+"</td><td>"+data[0].ID_PODER+"</td><td>"+data[0].nombreFab+"</td><td> "+data[0].telefonosContacto+"</td> <td>"+data[0].direccion+"</td><td>"+data[0].emailContacto+"</td><td><a class='btn btn-xs btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a></td></tr>";
                      $('#dt-dis').append(nuevaFila);
                    //input+='<input type="hidden" name="PODER_DIS[]" value="'+data[0].ID_PODER+'">';
                     // $('#distribuidores').append(input);
                      
                  }
                }
            });
  });

//Búsqueda de formula inci para selectize
 
$('#agregarSus').click(function (){
  //var tipotramite=$('input[name="nomTram"]:checked').val();
  //console.log(tipotramite);
  $('#porcentaje').val('');

  $('#formula').selectize({
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
                        tipotramite: $('input[name="nomTram"]:checked').val()
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
   $('#formula').selectize()[0].selectize.clearOptions();
 });


$('#agregarFormula').click(function(){
  var idDen=$('#formula').val();
  var nombreDen=$('#formula').text();
  var por=$('#porcentaje').val();
  if(por=="")
    por=0;
  console.log(por);
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
            nuevaFila+="<tr><td class='id'>"+data[0].idDenominacion+"</td><td>"+data[0].numeroCAS+"</td><td>"+data[0].denominacionINCI+"</td><td class='porc'>"+por+" %</td><td><a class='borrar'><i class='btn btn-xs btn-danger fa fa-times' aria-hidden='true'></i></a></td></tr>";
                                    $('#dtformula').append(nuevaFila);
            }
        });
});

//Búsqueda de fabricantes nacional o extranjeros llena selectize
$("#tipoFab input[name='origen']").change(function(){
  var origen=$(this).val();
  if(origen==1){// si es nacional

 $('#NOMBRE_FAB').selectize()[0].selectize.destroy();
  var fab =$('#NOMBRE_FAB').selectize({
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
		  		url:"{{route('buscarFabricantesAjax')}}",
		  		type: 'GET',
                dataType: 'json',
                data: {
                        q: query,
                        o: origen
                    },
		  		error: function() {
                        callback();
                    },
                success: function(res) {
                        callback(res.data);
                       // console.log(res);
                    }
  	  		});
  	}	

	});

} else { //si es extranjero
  $('#NOMBRE_FAB').selectize()[0].selectize.destroy();
  var fab =$('#NOMBRE_FAB').selectize({
    valueField: 'idEstablecimiento',
    labelField: 'nombreFab',
    searchField: ['idEstablecimiento','nombreFab'],
    maxOptions: 10,
        options: [],
        create: false,
    render:{
      option: function(item, escape) {
                return '<div>' + escape(item.fabricante) +'</div>';
              }
        },
     load: function(query, callback) {
                if (!query.length) return callback();    
        $.ajax({
          url:"{{route('buscarFabricantesAjax')}}",
          type: 'GET',
                dataType: 'json',
                data: {
                        q: query,
                        o: origen
                    },
          error: function() {
                        callback();
                    },
                success: function(res) {
                        callback(res.data);
                       // console.log(res);
                    }
          });
    } 

  });

}

 $('#NOMBRE_FAB').selectize()[0].selectize.clearOptions();
  
});

//Busca fabricante seleccionado
$('#NOMBRE_FAB').change(function(){

   var id = $(this).val();
   var array=[];
   var origen =$("#tipoFab input[name='origen']:checked").val();
 // console.log(origen);
  $.ajax({
        url:"{{ route('buscarFabricanteAjaxPorId') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id,
            origen:origen},
        type: 'post',
        success: function(data){
          if(data.length>0){
                if(origen==1){ // si el fab es Nacional decodifica el campo telefono
                  console.log(data[0].telefonosContacto);
                      if(data[0].telefonosContacto === ''){
                        var telefono='';
                      } else {  
                        var telefono= jQuery.parseJSON(data[0].telefonosContacto);
                      }
                        var input=''; 
                        var nuevaFila="";
                        nuevaFila+="<tr class='fila'><td>"+data[0].idEstablecimiento+"</td><td>"+data[0].nombreFab+"</td><td> "+telefono+"</td> <td>"+data[0].direccion+"</td><td>"+data[0].emailContacto+"</td><td><a class='borrar'><i class='btn btn-xs btn-danger fa fa-times' aria-hidden='true'></i></a></td></tr>";
                      $('#dt-fab').append(nuevaFila);
                     /* input+='<input type="hidden" name="ID_FABR[]" value="'+data[0].idEstablecimiento+'">';
                      $('#fabricantes').append(input);*/
                }else { 
                      var nuevaFila="";
                        nuevaFila+="<tr class='fila'><td>"+data[0].idEstablecimiento+"</td><td>"+data[0].nombreFab+"</td><td> "+data[0].telefonosContacto+"</td> <td>"+data[0].direccion+"</td><td>"+data[0].emailContacto+"</td><td><a class='btn btn-xs btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a></td></tr>";
                      $('#dt-fab').append(nuevaFila);
                   /* input+='<input type="hidden" name="ID_FABR[]" value="'+data[0].idEstablecimiento+'">';
                      $('#fabricantes').append(input);*/
                }
             
          }
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
   var origen =$("#tipoFab input[name='origen']:checked").val();
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
                    nuevaFila+="<tr class='fila'><td class='id'>"+data[0].idEstablecimiento+"</td><td>"+data[0].nombreFab+"</td><td>"+telefono+"</td> <td>"+data[0].direccion+"</td><td>"+data[0].emailContacto+"</td><td><a class='btn btn-xs btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a></td></tr>";
                  $('#dt-imp').append(nuevaFila);
                /* input+='<input type="hidden" name="ID_IMP[]" value="'+data[0].idEstablecimiento+'"/>';
                $('#importadores').append(input);*/
               
                  }
                }
            });

  });
  
   $(document).on('click', '.borrar', function (event) {
      event.preventDefault();
     
      $(this).closest('tr').remove();
      
    }); 



//datos persona de contacto
$('#nombrePersona').selectize({
    valueField: 'NIT',
    labelField: 'NOMBRE_PERSONA',
    searchField: ['NOMBRE_PERSONA','NIT'], 
    maxOptions: 10,
        options: [],
        create: false,
    render:{
      option: function(item, escape) {
                return '<div>' +escape(item.NIT)+' ('+ escape(item.NOMBRE_PERSONA) +')</div>';
              }
        },
     load: function(query, callback) {
                if (!query.length) return callback();    
        $.ajax({
          url:"{{route('buscarPersonasAjax')}}",
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
 $('#nombrePersona').selectize()[0].selectize.clearOptions();


$('#nombrePersona').change(function(){
   var id = $(this).val();

  $.ajax({
        url:"{{ route('buscarPersonasAjaxPorId') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'post',
        success: function(data){
             //var tel= jQuery.parseJSON(data[0].telefonosContacto);
          //console.log(tel);
                       if(data[0].telefonosContacto == ''){
                          var telefono='';                        
                        } else {  
                          var telefono= jQuery.parseJSON(data[0].telefonosContacto);
                         
                        }
                      $('#idPersona').val(data[0].NIT);                      
                      $('#telefonoPersona').val(telefono);

                      if(data[0].emailsContacto=='' || data[0].emailsContacto=='null'){
                        var email='';
                      } else {
                        var email=data[0].emailsContacto;
                      }
                      $('#emailPersona').val(email);

                      if(telefono[0]=='' || telefono[0]=='null' || telefono[0]==null){
                        if(telefono[1]=='' || telefono[1]=='null' || telefono[1]==null){
                          var telContacto='';
                        } else {
                          var telContacto=telefono[1];
                        }
                      } else {
                        if(telefono[1]=='' || telefono[1]=='null' || telefono[1]==null){
                          var telContacto=telefono[0];
                        } else {
                          var telContacto=telefono[0]+', '+telefono[1];
                        }
                      }                      
                      $('#telefonoPersona').val(telContacto);

                  }
            });

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
  solicitud=$('#idSolicitud').val();
  token=$('input[name="_token"]').val();

  $.ajax({
          url: "{{ route('guardar.presentacion') }}",
           data: { idsolicitud:solicitud, 
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
          
          beforeSend: function() {
            $('body').modalmanager('loading');
          },
          success:  function (r){
            $('body').modalmanager('loading');
           
             if(r.status == 200){
                alertify.alert("Mensaje de sistema",r.message);
               //  console.log(r.data['presentaciones'][0].textoPresentacion);
                dtPres = $('#dt-pres').DataTable({
                    processing: true,
                    filter:true,
                    serverSide: false,
                    destroy: true,
                    order: [ [2, 'asc'] ],
                    pageLength: 5,
                    ajax: {
                       url: '{{route("get.presentacionesSol")}}',
                      data:{idSol:solicitud, tipo:1}
                    },
                columns:[                        
                      {data: 'idPresentacion',name:'idPresentacion'}, 
                      {data: 'textoPresentacion',name:'textoPresentacion'},
                      {data: 'opciones',name:'opciones'},

                                                       
                  ],
              language: {
              processing: '<div class=\"dlgwait\"></div>',
              "url": "{{ asset('plugins/datatable/lang/es.json') }}" 
              },    
            });
                /* $('#dt-pres tr').each(function() {
                        $(this).remove();
                  });
                 for($i=0;$i<r.data['presentaciones'].length; $i++){
                //  console.log($i);
                    var nuevaFila="";
                    nuevaFila+="<tr><td>"+r.data['presentaciones'][$i].idPresentacion+"</td><td>"+r.data['presentaciones'][$i].textoPresentacion+"</td><td><a class='btn btn-xs btn-danger borrarPres'><i class='fa fa-times' aria-hidden='true'></i></a> <a class='btn btn-xs btn-info ' data-toggle='modal' data-target='#coemp' id='coempaque'>Agregar Coempaque</a></td></tr>";
                    $('#dt-pres').append(nuevaFila); } */
                 
               } else if(r.status == 404){
                  alertify.alert("Mensaje de error", r.data['message']);
                } else {
                  alertify.alert("Mensaje de error", "Ocurrio un error");
                }
              }
          });

});

$(document).on('click', '.borrarPres', function (event) {
      event.preventDefault();
      var fila= $(this).closest('tr');
      var id=$(this).closest('tr').find('td:first').html();

      var idSolicitud=$('#idSolicitud').val();
      
      $.ajax({
              data: {id:id, idSolicitud:idSolicitud},
              url: '{{route("borrar.presentaciones")}}',
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



$('#btnFrag').click(function(){
  var input='';
      input+='<br/><input type="text" class="form-control" name="fragancias[]">';
      
  $('#frag').append(input);
});

$('#btnTono').click(function(){
  var input='';
      input+='<br/><input type="text" class="form-control" name="tonos[]">';
      
  $('#tono').append(input);
});


var fila_clonada=""; //string de fila a duplicar.
var arrayPresentacion=[]; // array para guardar registro de presentaciones
var i=0;
$('#agregarPres').click(function(){ 
  i=i+1;
  var fila ="";                                                                  //Obtengo los valores de la presentacion completa
  var envase_primario=$('#primario option:selected').text();
  var envase_primarioVal=$('#primario option:selected').val();
  var materialPri=$('#materialPri option:selected').text();
  var materialPriVal=$('#materialPri option:selected').val();
  var contenidoPri=$('#contenidoPri').val();
  var unidad=$('#unidad option:selected').text();
  var unidadVal=$('#unidad').val();
  // alert(unidad)//$('#unidad').text(););
  // alert(unidadVal);
  var envase_secundario=$('#secundario option:selected').text();
  var envase_secundarioVal=$('#secundario option:selected').val();
  var materialSec=$('#materialSec option:selected').text();
  var materialSecVal=$('#materialSec option:selected').val();

  if($('#check').is(':checked')){                             // si hay envase secundario tomo valores sino los dejo como vacios.
    var contenidoSecVal=$('#contenidoS').val();
    var contenidoSec=$('#contSec').val();
                                                              //agrego la fila a la tabla de la presentacion completa
      fila+="<tr class='array'><td>"+i+"</td><td>"+envase_primario+"</td><td>"+materialPri+"</td><td>"+contenidoPri+"</td><td>"+unidad+"</td><td>"+envase_secundario+"</td><td>"+materialSec+"</td><td>"+contenidoSecVal+"</td><td>"+contenidoSec+"</td><td><a class='btn btn-xs btn-perspective btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a><a class='btn btn-xs btn-perspective btn-primary' onclick='agregarFilaPres();'><i class='fa fa-plus-circle' aria-hidden='true'></i></a></td></tr>"
          $('#pres tbody').append(fila);
                                                              //guardo la fila por si la clonan con td editable, verifico si existen registros de filtra clonada, sino lo inicializo nuevamente.      
      if(fila_clonada==""){  
        
          fila_clonada+="<td>"+envase_primario+"</td><td>"+materialPri+"</td><td contenteditable='true'>"+contenidoPri+"</td><td>"+unidad+"</td><td>"+envase_secundario+"</td><td>"+materialSec+"</td><td contenteditable='true'>"+contenidoSecVal+"</td><td>"+contenidoSec+"</td><td><a class='btn btn-xs btn-perspective btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a><a class='btn btn-xs btn-perspective btn-warning save' onclick='guardarFilaClonada();'><i class='fa fa-save' aria-hidden='true'></i></a></td></tr>"
      }
      else {
    
          fila_clonada="";
          fila_clonada+="<td>"+envase_primario+"</td><td>"+materialPri+"</td><td contenteditable='true'>"+contenidoPri+"</td><td>"+unidad+"</td><td>"+envase_secundario+"</td><td>"+materialSec+"</td><td contenteditable='true'>"+contenidoSecVal+"</td><td>"+contenidoSec+"</td><td><a class='btn btn-xs btn-perspective btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a><a class='btn btn-xs btn-perspective btn-warning save' onclick='guardarFilaClonada();'><i class='fa fa-save' aria-hidden='true'></i></a></td></tr>"
      }
  } else {
                                                                   //agrego la fila a la tabla con el valor de contenido secundario 0, para guardarlo en el array para el post
      var contenidoSecVal=0;
      var contenidoSec="";
                                                                     //agrego la fila a la tabla de la presentacion solo del envase primario
                                                                     
      fila+="<tr class='array'><td>"+i+"</td><td>"+envase_primario+"</td><td>"+materialPri+"</td><td>"+contenidoPri+"</td><td>"+unidad+"</td><td>"+envase_secundario+"</td><td>"+materialSec+"</td><td></td><td>"+contenidoSec+"</td><td><a class='btn btn-xs btn-perspective btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a><a class='btn btn-xs btn-perspective btn-primary' onclick='agregarFilaPres();'><i class='fa fa-plus-circle' aria-hidden='true'></i></a></td></tr>"
          $('#pres tbody').append(fila);
                                                                     //guardo la fila por si la clonan con td editable, verifico si existen registros de filtra clonada, sino lo inicializo nuevamente.      
      if(fila_clonada=="") {
          
          fila_clonada+="<td>"+envase_primario+"</td><td>"+materialPri+"</td><td contenteditable='true'>"+contenidoPri+"</td><td>"+unidad+"</td><td>"+envase_secundario+"</td><td>"+materialSec+"</td><td></td><td>"+contenidoSec+"</td><td><a class='btn btn-xs btn-perspective btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a><a class='btn btn-xs btn-perspective btn-warning save' onclick='guardarFilaClonada();'><i class='fa fa-save' aria-hidden='true'></i></a></td></tr>"
      } else {
        
          fila_clonada="";
          fila_clonada+="<td>"+envase_primario+"</td><td>"+materialPri+"</td><td contenteditable='true'>"+contenidoPri+"</td><td>"+unidad+"</td><td>"+envase_secundario+"</td><td>"+materialSec+"</td><td></td><td>"+contenidoSec+"</td><td><a class='btn btn-xs btn-perspective btn-danger borrar'><i class='fa fa-times' aria-hidden='true'></i></a><a class='btn btn-xs btn-perspective btn-warning save' onclick='guardarFilaClonada();'><i class='fa fa-save' aria-hidden='true'></i></a></td></tr>"
      }  
  }

                                                                       //armo array de presentacion para post
    if(arrayPresentacion===0){
      alert("entro el array esta vacio");
      arrayPresentacion.push(envase_primarioVal);
      arrayPresentacion.push(materialPriVal);
      arrayPresentacion.push(contenidoPri);
      arrayPresentacion.push(unidadVal);
      arrayPresentacion.push(envase_secundarioVal);
      arrayPresentacion.push(materialSecVal);
      arrayPresentacion.push(contenidoSecVal);
    } else {
      arrayPresentacion=[];
      arrayPresentacion.push(envase_primarioVal);
      arrayPresentacion.push(materialPriVal);
      arrayPresentacion.push(contenidoPri);
      arrayPresentacion.push(unidadVal);
      arrayPresentacion.push(envase_secundarioVal);
      arrayPresentacion.push(materialSecVal);
      arrayPresentacion.push(contenidoSecVal);
    }

  var pres='';
      pres+='<input type="hidden" name="pres[]" value="'+arrayPresentacion+'">';
      $('#presentaciones1').append(pres);
  console.log(arrayPresentacion);
  });
  
  function agregarFilaPres(){
    i=i+1;
    var index="<tr class='array'><td>"+i+"</td>";
    $('#pres tbody').append(index+fila_clonada);
      // console.log(arrayPresentacion);
  }


  function guardarFilaClonada(){

    var valores = [];
    $(".save").parents("tr").find("td").each(function(){
        valores.push($(this).html());
        $(this).removeAttr("contenteditable");

    });
   
    arrayPresentacion[2]=valores[3];
    arrayPresentacion[6]=valores[7];
   console.log(arrayPresentacion);
    var pres='';
      pres+='<input type="hidden" name="pres[]" value="'+arrayPresentacion+'">';
      $('#presentaciones1').append(pres);
    
      $(".save").remove();

  }

// funcion para validar el mandamiento 
$('#validar').click(function(event){
  var mandamiento = $('#mandamiento').val();
  var token =$('input[name="_token"]').val();
  var detalle="";
  var pago="";
 // console.log(token);
  $.ajax({
              data:{_token: '{{ csrf_token() }}',
            mandamiento: mandamiento },
            url:   "{{route('validar.mandamiento')}}",
            type:  'POST',
           
          
            success:  function (r){
           console.log(r.data);
                if(r.status == 200){
                  alertify.alert("Mensaje de sistema",'El mandamiento es válido para usar en este trámite');
                  
                  $('#guardar').show();
                  $('#idMand').val(r.data[0].id_mandamiento);
                  $('#totalMand').val(r.data[0].total_cobrado);
                  $('#idCliente').val(r.data[0].id_cliente);
                  $('#nombreMand').val(r.data[0].a_nombre);
                  $('#pago').val(r.data[0].fecha);
                  for(var i=0;i<r.data.length;i++){
                    detalle="";
              
                    detalle="<div class='col-xs-6'><input class='form-control' value='"+r.data[0].nombre_tipo_pago+"- $"+r.data[0].valorDet+"'></input></div><br/>";
                  
                    $('#detMand').append(detalle);
               
                  }
                  document.getElementById("mandamiento").readOnly = true;
                    
                } else (r.status == 404)
                    alertify.alert("Mensaje de sistema - Advertencia",r.message);
                
            },
            
        });

});

$('#depart').change(function(){
  var idDep=$(this).val();
  //alert(idDep);
 $.ajax({  
    url: "{{route('municipios')}}",
    data:{_token: '{{ csrf_token() }}',
                idDep: idDep
          },
    type: 'get',
    success: function(data){
      $('#municipio').html(data);
     // console.log(data);
    }
  });
});
$('#nuevapersona').click(function(){

  $.ajax({  
    url: "{{route('departamentos')}}",
    type: 'get',
    success: function(data){
      $('#depart').html(data);
     // console.log(data);
    }
  });

  $.ajax({
    url: "{{route('tratamientos')}}",
    type: 'get',
    success: function(data){
      $('#trat').html(data);
     // console.log(data);
    }
  });

  $('.persona').prop('required',true);

});

$('#guardarPersona').click(function(){

  $('.persona').prop('required',false);
  var nombres=$('#nombreNuevaPersona').val();
  var apellidos=$('#apellidoNuevaPersona').val();
  var nit=$('#nitPersona').val();
  var tipoDoc=$('#tipoDoc').val();
  var numeroDoc=$('#docPersona').val();
  var fechaNac=$('#fechaNac').val();
  var sexo=$('#sexo').val();
  var tratamiento=$('#trat').val();
  var direccion=$('#direccionPersona').val();
  var municipio=$('#municipio').val();
 // alert(municipio);
  var email=$('#emailNuevaPersona').val();
  var tel=$('#telNuevaPersona').val();

   $.ajax({
            data:{_token: '{{ csrf_token() }}',
                nombres: nombres,
                apellidos: apellidos,
                nit: nit,
                tipoDoc: tipoDoc,
                numeroDoc: numeroDoc,
                fechaNac: fechaNac,
                sexo: sexo,
                tratamiento: tratamiento,
                direccion: direccion,
                municipio: municipio,
                email: email,
                tel: tel
              },
            url:   "{{route('guardarNuevaPersona')}}",
            type:  'POST',

            success:  function (r){
               console.log(r);
             if(r.status == 200){
                  alertify.alert("Mensaje de sistema","Se ha creado persona Natural correctamente, puede buscarla!");
                } else {
                  alertify.alert("Mensaje de sistema","Error al crear persona!");
                }
            }
            

    });
});

$('#guardard').click(function(){
                                                                                  /* PREPARO PRESENTACIONES*/
  var pres=[];                   //array de los inputs pres[]
  var arrayIndex=[];               //array index de las filas que estan en la tabla

  arrayIndex.push(0);                   //agrego posicion 0

  $('input[name="pres[]"]').each(function(){
    pres.push($(this).val());
  });

  $('#pres tr.array').each(function () {  
      var valores=$(this).find("td").eq(0).html();
      arrayIndex.push(valores);
     
  });
 
  var size=pres.length;

  for(var i=0; i<size;i++){
      if(arrayIndex[i]!=i){

        pres.splice(i-1, 1);                 //elimino la posicion que no coincida con el index
      } 
  }

  for (var i=0; i<pres.length; i++){                    //preparo array final para post
     input='';
     input+='<input type="hidden" name="presFinal[]" value="'+pres[i]+'"/>';
        $('#presentaciones1').append(input);
  }

                  /*FIN PRESENTACION*/

  /*PREPARO FORMULA*/

  var arrayIndexFor=[];               //arrays index de las filas que estan en la tabla
  var arrayIndexPorc=[];      

  $('#dtformula tr').each(function () {                    //Busco columnas de id Denominacion
      var valores=$(this).find("td.id").eq(0).html();
      console.log(valores);
      arrayIndexFor.push(valores);
  });

  $('#dtformula tr').each(function () {                       //Busco columnas de porcentaje    
      var valores=$(this).find("td.porc").eq(0).html();
      arrayIndexPorc.push(valores);
  });


  for (var i=1; i<arrayIndexFor.length; i++){                    //preparo array final sustancias para post
     input='';
     input+='<input type="hidden" name="sustFinal[]" value="'+arrayIndexFor[i]+'"/>';
        $('#form').append(input);
  }
  for (var i=1; i<arrayIndexPorc.length; i++){                    //preparo array final porcentajes para post
     input='';
     input+='<input type="hidden" name="porc[]" value="'+arrayIndexPorc[i]+'"/>';
        $('#form').append(input);
  }



/* FIN FORMULA */



/*PREPARO DISTRUIBUIDOR, FABRICANTE E IMPORTADORES*/
   $('#dt-dis tr.fila').each(function () {
      input='';
      input2='';
      var valores=$(this).find("td").eq(1).html();
      var valIdDis=$(this).find("td").eq(0).html();
    
      input+='<input type="hidden" name="PODER_DIS[]" value="'+valores+'"/>';
      input2+='<input type="hidden" name="ID_DIS[]" value="'+valIdDis+'"/>';
       console.log(input);
       $('#distribuidores').append(input);
       $('#distribuidores').append(input2);
  });

  $('#dt-fab tr.fila').each(function () {
      input='';
      var valores=$(this).find("td").eq(0).html();
      
      input+='<input type="hidden" name="ID_FABR[]" value="'+valores+'">';

      $('#fabricantes').append(input);
  });     
  
  $('#dt-imp tr.fila').each(function () {
      input='';
      var valores=$(this).find("td").eq(0).html();
      
      input+='<input type="hidden" name="ID_IMP[]" value="'+valores+'"/>';
      $('#importadores').append(input);
  });     
/* FIN */   

});

$('#saveSol').click(function (){
 // console.log("entro");
  var formObj = $('#guardarSolicitud')[0];
 // var formURL = formObj.attr("action");
  var formData = new FormData(formObj);
  //alert(formData);
  $.ajax({
          data: formData,
          url: "{{route('guardarsolNuevoCos')}}",
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,
          beforeSend: function() {
            $('body').modalmanager('loading');
          },
          success:  function (r){
            $('body').modalmanager('loading');
           // console.log(response);
                if(r.status == 200){
                  $('#siguiente').show();
                  $('#saveSol').hide();
                  $('#idSolicitud').val(r.data['idSolicitud']);
                } else if(r.status == 404){
                  alertify.alert("Mensaje de error", r.data['message']);
                } else {
                  alertify.alert("Mensaje de error", "Ocurrio un error");
                }
              },
      
          });
            
});

$('#siguiente').click(function (){
  $('.detalleAdicional').show();
  $('.nav-tabs a[href="#detalleAdicional"]').tab('show');
  $('#NOMBRE_DIS')[0].selectize.disable();
});



$("#disTitular input[name='disTitu']").change(function(){
  var disTitu=$(this).val();
  if(disTitu==1){
    $('#NOMBRE_DIS')[0].selectize.disable();
    $('#dt-dis-body').empty();
    console.log(disTitu);

} else {
  $('#NOMBRE_DIS')[0].selectize.enable();
  console.log(disTitu);

}

});
</script>

@endsection
