@extends('master')

@section('css')
{!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!}

@endsection



@section('contenido')
<input type="hidden" name="idTramite" id="idTramite" value="{{$solicitud->tipoSolicitud}}"/>
<input type="hidden" name="idsol" id="idsol" value="{{$solicitud->idSolicitud}}"/>
<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
<div class="panel-body">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="panel with-nav-tabs panel-success">
					<div class="panel-heading">
						<ul class="nav nav-tabs">
						@if(isset($detalleCos))
						  <li class="active"><a href="#generalesCos" data-toggle="tab">Generales</a></li>
						@else
						  <li class="active"><a href="#generalesHig" data-toggle="tab">Generales</a></li>
						@endif
						@if($solicitud->tipoSolicitud==3||$solicitud->tipoSolicitud==5)
						 	<li><a href="#reconocimiento" data-toggle="tab">Reconocimiento</a></li>
						@endif
						  <li><a href="#propietario" data-toggle="tab">Propietario</a></li>
              <li><a href="#persona" data-toggle="tab">Persona Contacto</a></li>
						  <li><a href="#profesional" data-toggle="tab">Profesional</a></li>
						  <li><a href="#presentaciones" data-toggle="tab">Presentaciones</a></li>
              <li id="formu"><a href="#formula" data-toggle="tab">Fórmula</a></li>


						@if(isset($frag))
						  <li><a href="#fragancias" data-toggle="tab">Fragancias</a></li>
						@endif
						@if(isset($tonos))
						  <li><a href="#tonos" data-toggle="tab">Tonos</a></li>
						@endif

						  <li><a href="#fab" data-toggle="tab">Fabricantes</a></li>

						@if(isset($importadores))
						  <li><a href="#importadores" data-toggle="tab">Importadores</a></li>
						@endif
						@if(isset($distribuidores))
						  <li><a href="#distribuidores" data-toggle="tab">Distribuidores</a></li>
						@endif

						  <li><a href="#archivos" data-toggle="tab">Documentos Anexos</a></li>
						@if($tipo==1 || $tipo == 2)
						  <li id="dict"><a href="#dictamen" data-toggle="tab">Dictamen</a></li>
						@endif
                        </ul>
					</div>

					<div id="panel-collapse-1" class="collapse in">
						<div class="panel-body">
							<div class="tab-content">
                                    @if(isset($detalleCos))
                               			 @include('solicitudes.panelesDetalle.detGeneralesCos')
                               		@else
                               			 @include('solicitudes.panelesDetalle.detGeneralesHig')
                               		@endif
                               		@include('solicitudes.panelesDetalle.detReconocimiento')
                                    @include('solicitudes.panelesDetalle.detTitular')
                                    @include('solicitudes.panelesDetalle.detPersona')

                                    @include('solicitudes.panelesDetalle.detProfesional')
                                    @if(isset($frag))
                                    	@include('solicitudes.panelesDetalle.detFragancias')
                                    @endif
                                  	@if(isset($tonos))
                                    	@include('solicitudes.panelesDetalle.detTonos')
                                    @endif
                                     @include('solicitudes.panelesDetalle.detPresentaciones')

                                     @include('solicitudes.panelesDetalle.detFormulas')
                                     @include('solicitudes.paneles.modalFormulaCos')

 									                   @include('solicitudes.panelesDetalle.detDistribuidores')
                                     @include('solicitudes.panelesDetalle.detFabricantes')
                                     @include('solicitudes.panelesDetalle.detImportadores')
                                     @include('solicitudes.panelesDetalle.detDocumentos')
                                     @if($tipo==1)
                                     	@include('dictamenes.NuevoDictamenCosmetico')
                                     @elseif($tipo==2)
                                     	@include('solicitudes.solicitudDictamenes')
                                     @endif

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

<script type="text/javascript">

$(document).ready(function() {
    $('#txtEmail').selectize({
      create: true
    });
    @if($solicitud->estado!=9)
     $('#correspondencia').hide();
    @endif
  });



$('.select').change(function(){

	var index=this.id.split('-');

	var val=$(this).val();

	if(val==0){
	//	alert(val);
		$('.tx'+index[1]).removeAttr('readonly');
		$('.tx'+index[1]).attr('required','true');

	} else {
		$('.tx'+index[1]).attr('readonly','true');
		$('.tx'+index[1]).removeAttr('required');
	}
	//alert("hola");
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
  if(por=="")
    por=0;
  var idsol=$('#idsol').val();
  var inputSus='';
  var inputPor='';
  console.log(idDen);
  console.log(por);

   $.ajax({
        url:"{{ route('ingresarFormula') }}",
        data:{_token: '{{ csrf_token() }}',
                  id: idDen,
                  por: por,
                  idsol: idsol
            },
        type: 'post',

        success: function(data){

                if(data.status == 200){

                  $('#dict').css('display','block');
                  console.log(data.data.form1);
                  var nuevaFila="";
                  nuevaFila+="<tr><input type='hidden' name='idDenominacion[]' value='"+data.data.form1[0].idDenominacion+"'><input type='hidden' name='numeroCAS[]' value='"+data.data.form1[0].numeroCAS+"'><input type='hidden' name='denominacionINCI[]' value='"+data.data.form1[0].denominacionINCI+"'><input type='hidden' name='porcentaje[]' value='"+por+"'><td>"+data.data.form1[0].numeroCAS+"</td><td>"+data.data.form1[0].denominacionINCI+"</td><td>"+por+"%</td><td><a class='btn btn-danger btnEliminarFor' data-id='"+data.data.form.idCorrelativo+"'><i class='fa fa-times' aria-hidden='true'>Eliminar</i></a></td></tr>";
                  $('#dtformulaEdicion tbody').append(nuevaFila);
                  alertify.alert("Mensaje de sistema","La información se Guardo con éxito");
                } else if(data.status == 404){
                  alertify.alert("Mensaje de error", data.message);
                } else {
                  alertify.alert("Mensaje de error", "Ocurrio un error");
                }

            }
        });
});




$("#dtformulaEdicion").on('click', '.btnEliminarFor', function () {
    var id= $(this).data('id');
    //var sol= $(this).data('sol');
    var tr=$(this).closest('tr');


    alertify.confirm("Mensaje de sistema", "¿Esta seguro que desea eliminar esta formula?", function (asc) {
        if (asc) {
             $.ajax({
              data:{_token: '{{ csrf_token() }}',
                id: id
              },
            url:   "{{route('eliminar.formula')}}",
            type:  'POST',
            success:  function (r){
              if(r.status==200){
                tr.empty();
                //td.append('<input id="docs" name="files['+id+']" type="file" value="'+id+'">');
                alertify.alert("Mensaje de sistema","Se ha eliminado la formula correctamente");
              }
              else{
                alertify.alert("Mensaje de sistema","Error al eliminar la formula");
              }
             }
             });

        } else {
        }
    }, "Default Value").set('labels', {ok: 'SI', cancel: 'NO'});


});

$('#btnNotifica').on('click', function(event) {
    event.preventDefault();

    alertify.confirm('¿Esta segur@ que desea continuar?, esté proceso enviará la notificación a los correos ingresados',function(e){
      if(e)
      {
        var idsol = $('#idsol').val();
        var emails = $('#txtEmail').val();
        var obs = $('#notiObservacion').val()
        console.log(emails);
        console.log(obs);
        console.log(idsol);


        $.ajax({
              data:{_token: '{{ csrf_token() }}',
                idsol: idsol,
                emails: emails,
                obs: obs
              },
            url:   "{{route('enviar.correspondencia')}}",
            type:  'POST',
            success:  function (r){
              if(r.status==200){
                //tr.empty();
                //td.append('<input id="docs" name="files['+id+']" type="file" value="'+id+'">');
                alertify.alert("Mensaje de sistema","Se ha enviado la correspondencia correctamente");
              }
              else{
                alertify.alert("Mensaje de sistema","Error al enviar correspondencia");
              }
             }
             });


      }
    });



  });


</script>
@endsection