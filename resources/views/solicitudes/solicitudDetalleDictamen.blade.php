@extends('master')

@section('css')
{!! Html::style('plugins/selectize-js/dist/css/selectize.bootstrap3.css') !!}
<style type="text/css">
div.scroll_vertical {
		height: 500px;
		overflow: auto;
		padding: 8px;
	}

</style>
@endsection



@section('contenido')

<input type="hidden" name="idTramite" id="idTramite" value="{{$solicitud->tipoSolicitud}}"/>
<input type="hidden" name="idsol" id="idsol" value="{{$solicitud->idSolicitud}}"/>
<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
@if($solicitud->estado==11 || $solicitud->estado==4)
<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">HISTORIAL DE DICTAMENES</h3>
	</div>
	<div class="panel-body">
		@include('solicitudes.panelesDetalleDictamen.detHistorialDictamenes')
	</div>
</div>
@endif




<div class="panel row">
	<div class="scroll_vertical col-md-6">
		<div class="">
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
                                      </div>
                                         <div class="col-xs-4">
                                         	 <label>No. Recibo:</label>
                                         	  <input type="text" name="idrecibo" id="idrecibo"  class="form-control" value="">
                                         </div>
                                       </div>
                                      </div>
                                       @include('solicitudes.panelesEditar.mandamiento')
              </div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">GENERALES</h3>
				</div>
				<div class="panel-body">

				@if(isset($detalleCos))
           			 @include('solicitudes.panelesDetalleDictamen.detGeneralesCos')
           		@else
           			 @include('solicitudes.panelesDetalleDictamen.detGeneralesHig')
           		@endif
				</div>
			</div>
			@if($solicitud->tipoSolicitud==3||$solicitud->tipoSolicitud==5)
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">RECONOCIMIENTO</h3>
					</div>
					<div class="panel-body">
						@include('solicitudes.panelesDetalleDictamen.detReconocimiento')
					</div>
				</div>
			@endif
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">PROPIETARIO</h3>
				</div>
				<div class="panel-body">
					@include('solicitudes.panelesDetalleDictamen.detTitular')
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">PROFESIONAL</h3>
				</div>
				<div class="panel-body">
					@include('solicitudes.panelesDetalleDictamen.detProfesional')
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">PERSONA DE CONTACTO</h3>
				</div>
				<div class="panel-body">
					@include('solicitudes.panelesDetalleDictamen.detPersona')
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">PRESENTACIONES</h3>
				</div>
				<div class="panel-body">
					@include('solicitudes.panelesDetalleDictamen.detPresentaciones')
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">FÓRMULA</h3>
				</div>
				<div class="panel-body">
					@if($solicitud->solicitudPortal==1)
						@include('solicitudes.panelesDetalleDictamen.detFormulasPortal')
					@else
						 @include('solicitudes.panelesDetalleDictamen.detFormulas')
					@endif
				</div>
			</div>
			@if(isset($frag))
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">FRAGANCIAS</h3>
				</div>
				<div class="panel-body">
					@include('solicitudes.panelesDetalleDictamen.detFragancias')
				</div>
			</div>
			@endif
			@if(isset($tonos))
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">TONOS</h3>
				</div>
				<div class="panel-body">
					@include('solicitudes.panelesDetalleDictamen.detTonos')
				</div>
			</div>
			@endif
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">FABRICANTES</h3>
				</div>
				<div class="panel-body">
					@include('solicitudes.panelesDetalleDictamen.detFabricantes')
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">IMPORTADORES</h3>
				</div>
				<div class="panel-body">
					@include('solicitudes.panelesDetalleDictamen.detImportadores')
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">DISTRIBUIDORES</h3>
				</div>
				<div class="panel-body">
					@include('solicitudes.panelesDetalleDictamen.detDistribuidores')
				</div>
			</div>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">DOCUMENTOS ANEXOS</h3>
				</div>
				<div class="panel-body">
					@include('solicitudes.panelesDetalleDictamen.detDocumentos')
				</div>
			</div>
		</div>
	</div>
	<div class="scroll_vertical col-md-6">
		<div class="">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">DICTAMEN</h3>
				</div>
				<div class="panel-body">
					@if($tipo==1)
	                 	@include('solicitudes.panelesDetalleDictamen.NuevoDictamenCosmetico')
	                @elseif($tipo==2)
	                 	@include('solicitudes.solicitudDictamenes')
	                @endif
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

$(document).ready(function(){

  @if($solicitud->solicitudPortal==0)
    $('#formu').css('display','block');
    $('#formuPorta').css('display','none');
  @else
    $('#formu').css('display','none');
    $('#formuPorta').css('display','block');
  @endif


  var form={{count($formula)}};
  console.log(form);


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
                  $('#idrecibo').val(r.data[0].ID_RECIBO);
                  $('#idMand').val(r.data[0].id_mandamiento);
                  $('#totalMand').val(r.data[0].total_cobrado);
                  $('#idCliente').val(r.data[0].id_cliente);
                  $('#nombreMand').val(r.data[0].a_nombre);
                  $('#pago').val(r.data[0].fecha);

                  for(var i=0;i<r.data.length;i++){
                    detalle="";

                    detalle="<div class='col-xs-12'>-"+r.data[i].nombre_tipo_pago+"- $"+r.data[i].valorDet+" <br><b>"+r.data[i].COMENTARIOS+"</b></div><br/>";

                    $('#detMand').append(detalle);

                  }
                  //document.getElementById("mandamiento").readOnly = true;

                } else (r.status == 404)
                    //alertify.alert("Mensaje de sistema - Advertencia",r.message);

            },

        });




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
                        tipotramite: {{$solicitud->tipoSolicitud}}
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
  console.log(idsol);
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
    var tr=$(this).closest('tr');
    var idsol=$('#idsol').val();


    alertify.confirm("Mensaje de sistema", "¿Esta seguro que desea eliminar esta formula?", function (asc) {
        if (asc) {
             $.ajax({
              data:{_token: '{{ csrf_token() }}',
                id: id,
                idsol: idsol
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


</script>
@endsection