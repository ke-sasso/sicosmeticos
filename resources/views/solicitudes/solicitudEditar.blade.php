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
              <li class="active"><a href="#detalle" class="detalle" data-toggle="tab">Datos Generales</a></li>
               <li><a href="#detalleAdicional"  class="detalleAdicional" data-toggle="tab" >Detalle de Solicitud</a></li>
            </ul>
          </div>

           <div id="panel-collapse-1" class="collapse in">
            <div class="panel-body">
              <div class="tab-content">



                <div class="tab-pane fade in active" id="detalle">
                  <div class="panel-body">
                    <div class="the-box full no-border">
                      <div class="container-fluid">
                        <form id="guardarSolicitud" method="POST" action="{{route('guardarsolNuevoCos')}}">
                        <input type="hidden" name="idTramite" id="idTramite" value="{{$tipoSol}}"/>
                        <input type="hidden" name="idclas" id="idclas" value="{{$idclas}}"/>
                        <input type="hidden" name="idforma" id="idforma" value="{{$idforma}}"/>

              <input type="hidden" name="idSol" id="idSol" value="{{$solicitud->idSolicitud}}"/>
              <input type="hidden" name="idDetalleSol" id="idDetalleSol" value="{{$solicitud->detalleSolicitud->idDetalle}}" />

                            <h4 class="tituloSol"></h4>
                              <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="panel panel-success">
                                  <div class="panel-heading">GENERALES</div>
                                    <div class="panel-body">
                                      @include('solicitudes.panelesEditar.generales')
                                      @include('solicitudes.panelesEditar.generalesCos')
                                      @include('solicitudes.panelesEditar.generalesHig')

                                    </div>
                                </div>

                                <div class="panel panel-success reconocimientos" style="display:none">
                                    <div class="panel-heading">RECONOCIMIENTO</div>
                                        <div class="panel-body">
                                          @include('solicitudes.panelesEditar.reconocimiento')
                                        </div>
                                </div>

                                <div class="panel panel-success">
                                  <div class="panel-heading">VALIDAR MANDAMIENTO</div>
                                   <div class="panel-body">
                                      <div class="row">
                                        <div class="col-xs-4">
                                       <label>No. Mandamiento:</label>
                                         <input type="text" id="mandamiento" name="mandamiento" class="form-control" required="true"
                                         @if($solicitud->idMandamiento!=null)
                                            value="{{$solicitud->idMandamiento}}"
                                         @endif />
                                      </div><br/>
                                         <div class="col-xs-4">
                                          <button  type="button" name="validar" id="validar" class="btn btn-primary btn-perspective">Validar</button>
                                        </div>
                                       </div>
                                      </div>
                                        @include('solicitudes.panelesEditar.mandamiento')
                                </div>



                                <div class="panel panel-success">
                                    <div class="panel-heading">TITULAR</div>
                                        <div class="panel-body">
                                          @include('solicitudes.panelesEditar.titular')
                                        </div>
                                </div>

                                <div class="panel panel-success">
                                    <div class="panel-heading">PROFESIONAL RESPONSABLE</div>
                                        <div class="panel-body">
                                          @include('solicitudes.panelesEditar.profesional')
                                        </div>
                                </div>

                                <div class="panel panel-success">
                                    <div class="panel-heading">PERSONA DE CONTACTO</div>
                                        <div class="panel-body">
                                          @include('solicitudes.panelesEditar.personaContacto')
                                        </div>
                                </div>

                                <div class="panel panel-success coempaqueDiv">
                                  <div class="panel-heading">COEMPAQUES</div>
                                  <div class="panel-body">
                                    @include('solicitudes.panelesEditar.coempaque')
                                  </div>
                                </div>

                              <button type="button" name="guardar" id="saveSol" class="btn btn-success" style="margin-left:40%">Guardar Generales</button>
                              <button type="button" name="siguiente" id="siguiente" class="btn btn-info" style="margin-left:40%;display:none;">Continuar</button>


                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="tab-pane fade" id="detalleAdicional">
                  <form name="solicitud" method="post"  role="form" enctype="multipart/form-data" action="{{route('guardarSolicitudCosDetalle')}}">
                    <input type="hidden" name="idSolicitud" id="idSolicitud" value="{{$solicitud->idSolicitud}}" />

                     <input type="hidden" name="_token" value="{{ csrf_token() }}" ></input>
                    <div class="container-fluid">
                            <div class="panel panel-success">
                              <div class="panel-heading">PRESENTACIONES</div>
                              <div class="panel-body">
                                @include('solicitudes.panelesEditar.presentacionesCos')
                              </div>
                            </div>

                            <div class="panel panel-success">
                              <div class="panel-heading">FORMULA</div>
                              <div class="panel-body">
                                @include('solicitudes.panelesEditar.formulaCosmeticos')
                              </div>
                            </div>

                            <div class="panel panel-success" style="display:none" id="panelTono">
                              <div class="panel-heading">TONOS</div>
                                  <div class="panel-body">
                                    @include('solicitudes.panelesEditar.tonos')
                                  </div>
                            </div>

                            <div class="panel panel-success" style="display:none" id="panelFrag">
                              <div class="panel-heading">FRAGANCIAS</div>
                                  <div class="panel-body">
                                    @include('solicitudes.panelesEditar.fragancias')
                                  </div>
                            </div>
                              <div class="panel panel-success">
                                <div class="panel-heading">FABRICANTES</div>
                                    <div class="panel-body">
                                      @include('solicitudes.panelesEditar.fabricantes')
                                    </div>
                            </div>

                            <div class="panel panel-success">
                                <div class="panel-heading">IMPORTADORES</div>
                                    <div class="panel-body">
                                      @include('solicitudes.panelesEditar.importadores')
                                    </div>
                            </div>

                            <div class="panel panel-success">
                              <div class="panel-heading">DISTRIBUIDORES</div>
                                  <div class="panel-body">
                                    @include('solicitudes.panelesEditar.distribuidores')
                                  </div>
                            </div>
                            <div class="panel panel-success">
                                <div class="panel-heading">ANEXOS</div>
                                    <div class="panel-body">
                                      @include('solicitudes.panelesEditar.anexos')
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

@endsection

@section('js')
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}

<script type="text/javascript">



$(document).ready(function(){
  $('.persona').prop('required',false);
  var idTramite = $('#idTramite').val();
  var idSol=$('#idSol').val();
  console.log(idSol);
  @if($solicitud->distribuidorTitular==1)
    $('#NOMBRE_DIS')[0].selectize.disable();
    $("#disTitular input[name='disTitu'][value='{{$solicitud->distribuidorTitular}}']").attr('checked', true);
  @else
    $('#NOMBRE_DIS')[0].selectize.enable();
    $("#disTitular input[name='disTitu'][value='{{$solicitud->distribuidorTitular}}']").attr('checked', true);
  @endif

  @if($solicitud->fabricante->isNotEmpty())
    $("#tipoFab input[name='origen'][value='{{$solicitud->fabricante[0]->tipoFabricante}}']").attr('checked',true).change();

  @endif

  $('input[type=radio][name=origen]').change(function() {
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

      $('#NOMBRE_FAB').selectize()[0].selectize.clearOptions();
  });




    /*$('.anexos').remove();
       //Trae items del tramite solicitado.
        $.ajax({
            url:"{{ route('buscarItemsEditar') }}",
        data:{_token: '{{ csrf_token() }}',
            id: idTramite, idSol: idSol},
        type: 'post',
        success: function(data){
          console.log(data.items);
           console.log(data.docs);
          for(var i=0,l=data.items.length;i<l;i++){

            var nuevaFila="";
            var items="";
               nuevaFila+="<tr class='anexos'><td width='1%' hidden>"+data.items[i].idItem+"</td><td width='49%'>"+data.items[i].nombreItem+"</td><td><input type='file' id='docs' value='"+data.items[i].idItem+"' name='files["+data.items[i].idItem+"]' ></td><td><input ><a class='btn btn-success verpdf'> VER DOCUMENTO<i class='fa fa-download' aria-hidden='true'></i></a></td></tr>";
                  $('.documentos').append(nuevaFila);
                  $('.documentos').append(items);
              }
            }
          });*/






  if(idTramite==2){
    //$('.form-control').val("");
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

//Trae las clasificaciones de cosmeticos disponibles al ingresar

    var id= $('#area').val();
    var idclas= $('#idclas').val();
    var idforma= $('#idforma').val();
    //console.log(idclas);
    //console.log(idforma);
      $.ajax({
          url:"{{ route('getDataClassSol') }}",
          data:{_token: '{{ csrf_token() }}',
              id: id },
          type: 'post',
          success: function(data){
            $('#class').html(data);
            $('#class').val(idclas).change();

          }
        });

//completa el select de clasificacion al seleccionar un area
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

 //Llena el combobox de forma al ingresar


     $.ajax({ //consulto si la clasificacion posee tono y/o fragancia
        url:"{{ route('consultarClassSolCos') }}",
        data:{_token: '{{ csrf_token() }}',
            id: idclas },
        type: 'get',
        success: function(data){
          console.log(data[0].poseeTono);
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


//Llena el combobox de forma de acuerdo a la clasificacion seleccionada
$('#class').change(function(){
  var idforma= $('#idforma').val();
  var id= $('#class').val();
 // console.log(id);
    $.ajax({
        url:"{{ route('getGrupoFormasSol') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'post',
        success: function(data){
          $('#forma').html(data);
          $('#forma').val(idforma);
            //  console.log(data);
                  }
            })


    $.ajax({ //consulto si la clasificacion posee tono y/o fragancia
        url:"{{ route('consultarClassSolCos') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'get',
        success: function(data){
        //  console.log(data[0].poseeTono);
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



//LLENA EL PANEL DE MANDAMIENTO
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
                  //alertify.alert("Mensaje de sistema",'El mandamiento es válido para usar en este trámite');

                  $('#guardar').show();
                  $('#idMand').val(r.data[0].id_mandamiento);
                  $('#totalMand').val(r.data[0].total_cobrado);
                  $('#idCliente').val(r.data[0].id_cliente);
                  $('#nombreMand').val(r.data[0].a_nombre);
                  $('#pago').val(r.data[0].fecha);
                  for(var i=0;i<r.data.length;i++){
                    detalle="";

                    detalle="<div class='col-xs-12'><input class='form-control' value='"+r.data[i].nombre_tipo_pago+"- $"+r.data[i].valorDet+"'></input></div><br/>";

                    $('#detMand').append(detalle);

                  }
                  //document.getElementById("mandamiento").readOnly = true;

                } else (r.status == 404)
                    //alertify.alert("Mensaje de sistema - Advertencia",r.message);

            },

        });

//llena el panel de propietario
  var nitOrPp= $('#idTitular').val();
  var tipo=$("#titularTipo").val();

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
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.idPropietario);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#TELEFONO_TITULAR').val(data.data.telefonosContacto);
                      $('#PAIS_TITULAR').val(data.data.PAIS);
                      if(data.data.telefonosContacto != ''){
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                        $('#TELEFONO_TITULAR').val(telefono);
                        $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }

                    } else if (tipo==2){ //si es juridico
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.nit);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "){
                       var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                       $('#TELEFONO_TITULAR').val(telefono);
                       $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }
                    } else {  // si es natural
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.nit);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "||data.data.telefonosContacto!=null){
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                        $('#TELEFONO_TITULAR').val(telefono);
                        $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }
                    }
                  }
            });

 //llena el panel de profesional
  var id= $('#poderProfesional').val();
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
                      $('#PODER_PROF').val(data[0].ID_PODER);
                      $('#DUI').val(data[0].DUI);
                      $('#NIT').val(data[0].NIT);
                      $('#DIRECCION_PRO').val(data[0].DIRECCION);
                      $('#EMAIL_PRO').val(data[0].EMAIL);
                      $('#TELEFONO_PRO').val(data[0].TELEFONO_1);

                  }
        }
      });

//llena panel de persona de contacto
  var id = $('#nitContacto').val();
  $.ajax({
        url:"{{ route('buscarPersonasAjaxPorId') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'post',
        success: function(data){
             var tel= jQuery.parseJSON(data[0].telefonosContacto);
          console.log(tel);
                       if(data[0].telefonosContacto == ''){
                          var telefono='';
                        } else {
                          var telefono= jQuery.parseJSON(data[0].telefonosContacto);

                        }
                      $('#nombrePersona').val({{$solicitud->nitSolicitante}});
                      $('#nomPersona').val(data[0].NOMBRE_PERSONA);
                      $('#idPersona').val(data[0].NIT);
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


  }
  if(idTramite==3){
    //$('.form-control').val("");
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
        $('#paisOrigen').val({{$solicitud->detalleSolicitud->idPais}}).change();
      }

      });
       //Trae las areas de aplicacion de cosmeticos disponibles
     //Trae las clasificaciones de cosmeticos disponibles al ingresar
    var id= $('#area').val();
    var idclas= $('#idclas').val();
    var idforma= $('#idforma').val();
      $.ajax({
          url:"{{ route('getDataClassSol') }}",
          data:{_token: '{{ csrf_token() }}',
              id: id },
          type: 'post',
          success: function(data){
            $('#class').html(data);
            $('#class').val(idclas).change();

                    }
              });

//completa el select de clasificacion al seleccionar un area
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

 //Llena el combobox de forma al ingresar


     $.ajax({ //consulto si la clasificacion posee tono y/o fragancia
        url:"{{ route('consultarClassSolCos') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'get',
        success: function(data){
        //  console.log(data[0].poseeTono);
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


//Llena el combobox de forma de acuerdo a la clasificacion seleccionada
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
          $('#forma').val(idforma);            //  console.log(data);
                  }
            })

     $.ajax({ //consulto si la clasificacion posee tono y/o fragancia
        url:"{{ route('consultarClassSolCos') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'get',
        success: function(data){
        //  console.log(data[0].poseeTono);
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

//LLENA EL PANEL DE MANDAMIENTO
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
                  //alertify.alert("Mensaje de sistema",'El mandamiento es válido para usar en este trámite');

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
                  //document.getElementById("mandamiento").readOnly = true;

                } else (r.status == 404)
                    //alertify.alert("Mensaje de sistema - Advertencia",r.message);

            },

        });

//llena el panel de propietario
  var nitOrPp= $('#idTitular').val();
  var tipo=$("#titularTipo").val();

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
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.idPropietario);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#TELEFONO_TITULAR').val(data.data.telefonosContacto);
                      $('#PAIS_TITULAR').val(data.data.PAIS);
                      if(data.data.telefonosContacto != ''){
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                        $('#TELEFONO_TITULAR').val(telefono);
                        $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }

                    } else if (tipo==2){ //si es juridico
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.nit);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "){
                       var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                       $('#TELEFONO_TITULAR').val(telefono);
                       $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }
                    } else {  // si es natural
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.nit);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "||data.data.telefonosContacto!=null){
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                        $('#TELEFONO_TITULAR').val(telefono);
                        $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }
                    }
                  }
            });

 //llena el panel de profesional
  var id= $('#poderProfesional').val();
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
                      $('#PODER_PROF').val(data[0].ID_PODER);
                      $('#DUI').val(data[0].DUI);
                      $('#NIT').val(data[0].NIT);
                      $('#DIRECCION_PRO').val(data[0].DIRECCION);
                      $('#EMAIL_PRO').val(data[0].EMAIL);
                      $('#TELEFONO_PRO').val(data[0].TELEFONO_1);

                  }
        }
      });

//llena panel de persona de contacto
  var id = $('#nitContacto').val();
  $.ajax({
        url:"{{ route('buscarPersonasAjaxPorId') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'post',
        success: function(data){
          //   var telefono= jQuery.parseJSON(data[0].telefonosContacto);
          //console.log(data);
                       if(data[0].telefonosContacto == ''){
                          var telefono='';
                        } else {
                          var telefono= jQuery.parseJSON(data[0].telefonosContacto);

                        }
                      $('#nombrePersona').val({{$solicitud->nitSolicitante}});
                      $('#nomPersona').val(data[0].NOMBRE_PERSONA);
                      $('#idPersona').val(data[0].NIT);
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
  }

  if(idTramite==4){
    //$('.form-control').val("");
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


  //LLENA EL PANEL DE MANDAMIENTO
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
                  //alertify.alert("Mensaje de sistema",'El mandamiento es válido para usar en este trámite');

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
                  //document.getElementById("mandamiento").readOnly = true;

                } else (r.status == 404)
                    //alertify.alert("Mensaje de sistema - Advertencia",r.message);

            },

        });

   var idclasHig=$('#classHig').val();
   $.ajax({ //consulto si la clasificacion posee tono y/o fragancia
        url:"{{ route('consultarClassSolHig') }}",
        data:{_token: '{{ csrf_token() }}',
            id: idclasHig },
        type: 'get',
        success: function(data){
          console.log(data[0].poseeTono);
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

//llena el panel de propietario
  var nitOrPp= $('#idTitular').val();
  var tipo=$("#titularTipo").val();

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
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.idPropietario);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#TELEFONO_TITULAR').val(data.data.telefonosContacto);
                      $('#PAIS_TITULAR').val(data.data.PAIS);
                      if(data.data.telefonosContacto != ''){
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                        $('#TELEFONO_TITULAR').val(telefono);
                        $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }

                    } else if (tipo==2){ //si es juridico
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.nit);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "){
                       var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                       $('#TELEFONO_TITULAR').val(telefono);
                       $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }
                    } else {  // si es natural
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.nit);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "||data.data.telefonosContacto!=null){
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                        $('#TELEFONO_TITULAR').val(telefono);
                        $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }
                    }
                  }
            });

 //llena el panel de profesional
  var id= $('#poderProfesional').val();
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
                      $('#PODER_PROF').val(data[0].ID_PODER);
                      $('#DUI').val(data[0].DUI);
                      $('#NIT').val(data[0].NIT);
                      $('#DIRECCION_PRO').val(data[0].DIRECCION);
                      $('#EMAIL_PRO').val(data[0].EMAIL);
                      $('#TELEFONO_PRO').val(data[0].TELEFONO_1);

                  }
        }
      });

//llena panel de persona de contacto
  var id = $('#nitContacto').val();
  $.ajax({
        url:"{{ route('buscarPersonasAjaxPorId') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'post',
        success: function(data){
          //   var telefono= jQuery.parseJSON(data[0].telefonosContacto);
          //console.log(data);
                       if(data[0].telefonosContacto == ''){
                          var telefono='';
                        } else {
                          var telefono= jQuery.parseJSON(data[0].telefonosContacto);

                        }
                      $('#nombrePersona').val({{$solicitud->nitSolicitante}});
                      $('#nomPersona').val(data[0].NOMBRE_PERSONA);
                      $('#idPersona').val(data[0].NIT);
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


  }

  if(idTramite==5){
    //$('.form-control').val("");
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
      $.ajax({                 // trae catalogo de paises cuando es reconocimiento
      url:"{{ route('getPaises') }}",
      type: 'get',
      success: function(data){
        $('#paisOrigen').html(data);
        $('#paisOrigen').val({{$solicitud->detalleSolicitud->idPais}}).change();
      }

      });


//LLENA EL PANEL DE MANDAMIENTO
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
                  //alertify.alert("Mensaje de sistema",'El mandamiento es válido para usar en este trámite');

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
                  //document.getElementById("mandamiento").readOnly = true;

                } else (r.status == 404)
                    //alertify.alert("Mensaje de sistema - Advertencia",r.message);

            },

        });

  var idclasHig=$('#classHig').val();
   $.ajax({ //consulto si la clasificacion posee tono y/o fragancia
        url:"{{ route('consultarClassSolHig') }}",
        data:{_token: '{{ csrf_token() }}',
            id: idclasHig },
        type: 'get',
        success: function(data){
          console.log(data[0].poseeTono);
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

//llena el panel de propietario
  var nitOrPp= $('#idTitular').val();
  var tipo=$("#titularTipo").val();

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
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.idPropietario);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#TELEFONO_TITULAR').val(data.data.telefonosContacto);
                      $('#PAIS_TITULAR').val(data.data.PAIS);
                      if(data.data.telefonosContacto != ''){
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                        $('#TELEFONO_TITULAR').val(telefono);
                        $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }

                    } else if (tipo==2){ //si es juridico
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#id_propietario').val(data.data.nit);
                      $('#nompro').val(data.data.nombre);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "){
                       var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                       $('#TELEFONO_TITULAR').val(telefono);
                       $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }
                    } else {  // si es natural
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").attr('checked', true);
                      $("#tipoTitular input[name='tipoT'][value='{{$solicitud->detalleSolicitud->tipoTitular}}']").change();
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.nit);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "||data.data.telefonosContacto!=null){
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                      $('#TELEFONO_TITULAR').val(telefono);
                      $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }
                    }
                  }
            });

 //llena el panel de profesional
  var id= $('#poderProfesional').val();
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
                      $('#PODER_PROF').val(data[0].ID_PODER);
                      $('#DUI').val(data[0].DUI);
                      $('#NIT').val(data[0].NIT);
                      $('#DIRECCION_PRO').val(data[0].DIRECCION);
                      $('#EMAIL_PRO').val(data[0].EMAIL);
                      $('#TELEFONO_PRO').val(data[0].TELEFONO_1);

                  }
        }
      });

//llena panel de persona de contacto
  var id = $('#nitContacto').val();
  $.ajax({
        url:"{{ route('buscarPersonasAjaxPorId') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'post',
        success: function(data){
          //   var telefono= jQuery.parseJSON(data[0].telefonosContacto);
          //console.log(data);
                       if(data[0].telefonosContacto == ''){
                          var telefono='';
                        } else {
                          var telefono= jQuery.parseJSON(data[0].telefonosContacto);

                        }
                      $('#nombrePersona').val({{$solicitud->nitSolicitante}});
                      $('#nomPersona').val(data[0].NOMBRE_PERSONA);
                      $('#idPersona').val(data[0].NIT);
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

  }
  $('.detalle').show();
  $('.nav-tabs a[href="#detalle"]').tab('show');
});



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
            var items="";
               nuevaFila+="<tr class='anexos'><td width='1%' hidden>"+data[i].idItem+"</td><td width='49%'>"+data[i].nombreItem+"</td><td><input type='file' id='docs' value='"+data[i].idItem+"' name='files["+data[i].idItem+"]' ></td></tr>";
                  $('.documentos').append(nuevaFila);
                  $('.documentos').append(items);
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
            //	console.log(data);
              		}
            })

     $.ajax({ //consulto si la clasificacion posee tono y/o fragancia
        url:"{{ route('consultarClassSolCos') }}",
        data:{_token: '{{ csrf_token() }}',
            id: id },
        type: 'get',
        success: function(data){
        //  console.log(data[0].poseeTono);
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
                      $('#nompro').val(data.data.nombre);
                      $('#id_propietario').val(data.data.idPropietario);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#TELEFONO_TITULAR').val(data.data.telefonosContacto);
                      $('#PAIS_TITULAR').val(data.data.PAIS);
                      if(data.data.telefonosContacto != ''){
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                        $('#TELEFONO_TITULAR').val(telefono);
                        $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }

                    } else if (tipo==2){ //si es juridico
                      $('#id_propietario').val(data.data.nit);
                      $('#nompro').val(data.data.nombre);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "){
                       var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                       $('#TELEFONO_TITULAR').val(telefono);
                       $('#nombre_propietario').selectize()[0].selectize.clearOptions();
                      }
                    } else {  // si es natural
                      $('#id_propietario').val(data.data.nit);
                      $('#nompro').val(data.data.nombre);
                      $('#DIRECCION_TITULAR').val(data.data.direccion);
                      $('#EMAIL_TITULAR').val(data.data.emailsContacto);
                      $('#PAIS_TITULAR').val("EL SALVADOR");
                      if(data.data.telefonosContacto!=" "||data.data.telefonosContacto!=null){
                        var telefono= jQuery.parseJSON(data.data.telefonosContacto);
                        $('#TELEFONO_TITULAR').val(telefono);
                        $('#nombre_propietario').selectize()[0].selectize.clearOptions();
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
                      $('#PODER_PROF').val(data[0].ID_PODER);
                      $('#DUI').val(data[0].DUI);
                      $('#NIT').val(data[0].NIT);
                      $('#DIRECCION_PRO').val(data[0].DIRECCION);
                      $('#EMAIL_PRO').val(data[0].EMAIL);
                      $('#TELEFONO_PRO').val(data[0].TELEFONO_1);
                      $('#poderProfesional').val($('#ID_PODER').val());
                      $('#ID_PODER').selectize()[0].selectize.clearOptions();
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
                        tipotramite: $('#idTramite').val()
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

} else { // si es extranjero
  $('#NOMBRE_FAB').selectize()[0].selectize.destroy();
  var fab =$('#NOMBRE_FAB').selectize({
    valueField: 'idFabricanteExtranjero',
    labelField: 'fabricante',
    searchField: ['idFabricanteExtranjero','fabricante'],
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
   //var origen =$("#tipoFab input[name='origen']:checked").val();
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
          //   var telefono= jQuery.parseJSON(data[0].telefonosContacto);
          //console.log(data[0].emailsContacto);
                       if(data[0].telefonosContacto == ''){
                          var telefono='';
                        } else {
                          var telefono= jQuery.parseJSON(data[0].telefonosContacto);
                         //var telefono='';
                        }
                      $('#idPersona').val(data[0].NIT);
                      $('#nomPersona').val(data[0].NOMBRE_PERSONA);
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
                      $('#nitContacto').val(data[0].NIT);
                      $('#nombrePersona').selectize()[0].selectize.clearOptions();

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
     // input+='<br/><input type="text" class="form-control" name="fragancias[]">';
      input+='<tr><td><input type="text" class="form-control" name="fragancias[]"></td><td><a class="btn btn-danger borrar">Eliminar<i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>';

  $('#frag').append(input);
});

$('#btnTono').click(function(){
  var input='';
      input+='<tr><td><input type="text" class="form-control" name="tonos[]"></td><td><a class="btn btn-danger borrar">Eliminar<i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>';

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
  $('#detMand').empty();
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
                  //document.getElementById("mandamiento").readOnly = true;

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
             // console.log(r);
             if(r.status == 200){
                  alertify.alert("Mensaje de sistema","Se ha creado persona Natural correctamente, puede buscarla!");
                } else
                alertify.alert("Mensaje de sistema","Error al crear persona!");
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
          url: "{{route('actualizarSol')}}",
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

});


$("#documentos").on('click', '.btnEliminarDoc', function () {
    var nomdoc= $(this).data('nomdoc');
    var id= $(this).data('id');
    var td=$(this).closest('td');
    var idDoc=$(this).data('iddoc');

    alertify.confirm("Mensaje de sistema", "Esta seguro que desea eliminar el documento del requisito "+nomdoc+"?", function (asc) {
        if (asc) {
             $.ajax({
              data:{_token: '{{ csrf_token() }}',
                idDoc: idDoc
              },
            url:   "{{route('eliminar.documento')}}",
            type:  'POST',
            success:  function (r){
              if(r.status==200){
                td.empty();
                td.append('<input id="docs" name="files['+id+']" type="file" value="'+id+'">');
                alertify.alert("Mensaje de sistema","Se ha eliminado el documento correctamente");
              }
              else{
                alertify.alert("Mensaje de sistema","Error al eliminar el documento");
              }
             }
             });

        } else {
        }
    }, "Default Value").set('labels', {ok: 'SI', cancel: 'NO'});


});

$("#dtfragancia").on('click', '.btnEliminarFrag', function () {
    var id= $(this).data('id');
    //var sol= $(this).data('sol');
    var tr=$(this).closest('tr');


    alertify.confirm("Mensaje de sistema", "¿Esta seguro que desea eliminar esta fragancia?", function (asc) {
        if (asc) {
             $.ajax({
              data:{_token: '{{ csrf_token() }}',
                id: id
              },
            url:   "{{route('eliminar.fragancia')}}",
            type:  'POST',
            success:  function (r){
              if(r.status==200){
                tr.empty();
                //td.append('<input id="docs" name="files['+id+']" type="file" value="'+id+'">');
                alertify.alert("Mensaje de sistema","Se ha eliminado la fragancia correctamente");
              }
              else{
                alertify.alert("Mensaje de sistema","Error al eliminar la fragancia");
              }
             }
             });

        } else {
        }
    }, "Default Value").set('labels', {ok: 'SI', cancel: 'NO'});


});

$("#dtTono").on('click', '.btnEliminarTono', function () {
    var id= $(this).data('id');
    //var sol= $(this).data('sol');
    var tr=$(this).closest('tr');


    alertify.confirm("Mensaje de sistema", "¿Esta seguro que desea eliminar este tono?", function (asc) {
        if (asc) {
             $.ajax({
              data:{_token: '{{ csrf_token() }}',
                id: id
              },
            url:   "{{route('eliminar.tono')}}",
            type:  'POST',
            success:  function (r){
              if(r.status==200){
                tr.empty();
                //td.append('<input id="docs" name="files['+id+']" type="file" value="'+id+'">');
                alertify.alert("Mensaje de sistema","Se ha eliminado el tono correctamente");
              }
              else{
                alertify.alert("Mensaje de sistema","Error al eliminar el tono");
              }
             }
             });

        } else {
        }
    }, "Default Value").set('labels', {ok: 'SI', cancel: 'NO'});


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
