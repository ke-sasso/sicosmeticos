@extends('master')

@section('css')
    {!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!}
    {!! Html::style('plugins/bootstrap-modal/css/bootstrap-modal.css') !!}
    {!! Html::style('plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') !!}
    <style type="text/css">

        body {
            overflow-x: hidden;
            overflow-y: scroll !important;

        }
        .dlgwait {
            display:    inline;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .3 )
            url("{{ asset('/img/ajax-loader.gif') }}")
            50% 50%
            no-repeat;
        }
       #persona{
        width:0px;
        height: 0px;  
        position: center;
        top: 0%;
        left: 0%;
        margin-top: -0px;
        margin-left: 300px;
        padding: 0px;

        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .dlgwait {
            display: block;
        }
        td.details-control {
            background: url("{{ asset('/plugins/datatable/images/details_open.png') }}") no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url("{{ asset('/plugins/datatable/images/details_close.png') }}") no-repeat center center;
        }


    </style>
@endsection

@section('contenido')


    <div class="panel panel-success" id="search-panel">
        <div class="panel-heading" >
            <h3 class="panel-title">                
                    NOTIFICACIÓN AL USUARIO            
            </h3>
        </div>        
            <div class="panel-body">

                <fieldset class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">No. de Solicitud</div>
                            <label class="form-control">{{$sol->numeroSolicitud}}</label>                 
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">No. de Registro</div>
                            <label class="form-control">{{$sol->idProducto}}</label>                  
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">Nombre Comercial:</div>
                            <label class="form-control">{{$sol->detalleSolicitud->nombreComercial}}</label>                 
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">Tramite:</div>
                            <label class="form-control">{{$sol->tipotramite->nombreTramite}}</label>                  
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">Fecha de Presentación:</div>
                            <label class="form-control">{{$sol->fechaCreacion}}</label>                 
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">País de Origen:</div>
                            <label class="form-control">{{$sol->detallesolicitud->pais->nombre}}</label>                  
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">Presentado por:</div>
                            <label class="form-control">{{$persona[0]->NOMBRE_PERSONA}}</label>                 
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">NIT:</div>
                            <label class="form-control">{{$persona[0]->NIT}}</label>                  
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">Nombre titular:</div>
                            <label class="form-control">{{$titular->nombre}}</label>                 
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-addon">Identificador del Titular:</div>
                            <label class="form-control">{{$titular->nit}}</label>                  
                        </div>
                    </div>
                </fieldset>

              
            </div><!-- /.panel-body -->
        
    </div>

    <div class="panel panel-success">

        <div class="panel-heading">
            <h3 class="panel-title">PERSONA DE RETIRA</h3>
        </div>
        <div class="panel-body">
            <div class="nav-stacked" id="contacto">
            <form id="guardarNotificacion" method="POST" action="{{route('guardarNuevaNoti')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" ></input>
            <input type="hidden" name="idSol" value="{{$sol->idSolicitud}}" ></input>
                <div class="row">
                    <div class="col-xs-5">
                        <label>Buscar persona:</label>
                        <select class="form-control input-sm" value="" id="nombrePersona" name="idPersona"
                                placeholder="Buscar por nombre de persona:"></select>

                    </div>
                    <div class="col-xs-4"><br/>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#persona" id="nuevapersona">
                            <i class='fa fa-plus-circle' aria-hidden='true'></i></button>

                    </div>
                    </div>
                    <div class="row">
                    <div class="col-xs-5">
                        <label>Nombre:</label>
                        <input type="text" class="form-control" id="nomPersona" name="nombre" readonly>
                    </div>
                    
                        <div class="col-xs-5">
                            <label>NIT:</label>
                            <input type="text" class="form-control" id="idPersona" name="nit" readonly>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-xs-5">
                            <label>Email: </label>
                            <input type="text" class="form-control" name="emailPersona" id="emailPersona" value="" readonly>
                        </div>
                        <div class="col-xs-5">
                            <label>Telefono de Contacto: </label>
                            <input type="text" class="form-control" name="telefonoPersona" id="telefonoPersona" readonly>
                        </div>
                    </div><br>
                    <button type="submit" name="guardar" id="guardar" class="btn btn-success" style="margin-left:45%">Guardar</button>
                </form>

            </div>


            <div id="persona" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Agregar Persona de Contacto...</h4>

                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-xs-4">
                                        <label>NIT:</label>
                                        <input type="text" class="form-control persona" name="nitPersona" id="nitPersona"/>
                                    </div>
                                    <div class="col-xs-4">
                                        <label>Tipo de Documento:</label>
                                        <select class="form-control persona" id="tipoDoc"
                                                placeholder="Seleccione Tipo de Documento:">
                                            <option value="1">DUI</option>
                                            <option value="2">CARNET DE RESIDENTE</option>
                                            <option value="3">PASAPORTE</option>
                                        </select>

                                    </div>
                                    <div class="col-xs-4">
                                        <label>Número de Documento:</label>
                                        <input class="form-control persona" value="" id="docPersona"/>

                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <label>Fecha de Nacimiento: </label>
                                        <input type="date" class="form-control persona" id="fechaNac">
                                    </div>
                                    <div class="col-xs-4">
                                        <label>Sexo: </label>
                                        <select class="form-control persona" id="sexo">
                                            <option value="F">FEMENINO</option>
                                            <option value="M">MASCULINO</option>

                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <label>Tratamiento: </label>
                                        <select class="form-control persona" id="trat"
                                                placeholder="Seleccione Tratamiento para persona:">

                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label>Nombre:</label>
                                        <input class="form-control persona" id="nombreNuevaPersona"/>

                                    </div>
                                    <div class="col-xs-6">
                                        <label>Apellidos:</label>
                                        <input class="form-control persona" id="apellidoNuevaPersona"/>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-6">
                                        <label>Departamento:</label>
                                        <select class="form-control persona" id="depart" placeholder="Seleccione Departamento:">

                                        </select>
                                    </div>
                                    <div class="col-xs-6">
                                        <label>Municipio:</label>
                                        <select class="form-control persona" id="municipio" placeholder="Seleccione Municipio:">

                                        </select>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label>Dirección:</label>
                                        <textarea class="form-control persona" id="direccionPersona" rows="2"> </textarea>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label>Email:</label>
                                        <input type="text" class="form-control persona" name="emailPer" id="emailNuevaPersona"/>
                                    </div>
                                    <div class="col-xs-6">
                                        <label>Telefono de Contacto: </label>
                                        <input type="text" class="form-control persona" name="telPersona" id="telNuevaPersona"/>
                                    </div>
                                </div>
                                <br/>

                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarPersona">Guardar
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
                   
        </div>
    </div>
@endsection

@section('js')
{!! Html::script('plugins/selectize-js/dist/js/standalone/selectize.min.js') !!}
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
{!! Html::script('https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js') !!}
{!! Html::script('https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js') !!}
{!! Html::script('https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js') !!}
{!! Html::script('https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js ') !!}
<script type="text/javascript">


$( document ).ready(function() {
           
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

$('#guardar').click(function (){
 
  $.ajax({
          url: "{{route('guardarNoti')}}",
          type: 'POST',
          processData: false,
          contentType: false,
          cache: false,
          beforeSend: function() {
            $('body').modalmanager('loading');
          },
          success:  function (r){
            $('body').modalmanager('loading');
           
              },
      
          });
            
});



</script>

@endsection