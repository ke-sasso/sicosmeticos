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

<form role ="form" method="POST" action="{{route('guardarResolucion')}}" id="resolForm" target="_blank">
	<input type="hidden" name="idSolicitud" value="{{$numDictamen->idSolicitud}}"  class="form-control"/>
	<input type="hidden" name="idDictamen" value="{{$numDictamen->idDictamen}}"  class="form-control"/>
	<input type="hidden" name="_token" value="{{ csrf_token() }}"  class="form-control"/>
				<div class="panel panel-success">
                    	<div class="panel-heading">RESOLUCIÓN</div>
                        	<div class="panel-body">
                        		<table width="100%" style="font-size: 12px;" id="dt-revision" class="table table-hover table-striped">
										<thead class="the-box dark full">
											<tr class="info">
												<th>RESOLUCIÓN</th>
												<th>OBSERVACIÓN</th>

											</tr>
										</thead>
									<tbody>
										<tr>
											<td><label class="radio-inline"><input type="radio" name="resolucion" value="3" />FAVORABLE</label><br/>
												<label class="radio-inline"><input type="radio" name="resolucion" value="5"/>DESFAVORABLE</label><br/>
												<label class="radio-inline"><input type="radio" name="resolucion" value="4"/>PREVENIDO</label>
											</td>
											<td>
												<textarea class="form-control obs" row="3" name="obs" style="display:none;"></textarea>
											</td>

										</tr>
									</tbody>
								</table>

                        	</div>
                    </div>

					<input type="submit" value="Guardar" id="dictamen" class="btn btn-success"/>

					<a href="{{route('verResolucionDic',['id'=>$numDictamen->idSolicitud,'idDic'=>$numDictamen->idDictamen])}}" class="btn btn-primary resolucion" id="res" target="_blank" style="display:none;" ><b>RESOLUCION</b></a>

					<!--<input style="display" type="submit" id="resolucion" value="Generar Resolución" target="_blank" class="btn btn-success"/>-->
</form>

@endsection

@section('js')
<script type="text/javascript">
    var va;
	$('input[name="resolucion"]').change(function(){
        va=$(this).val();
		if(va!=3){

			$('textarea[name="obs"]').show();
		} else{
			$('textarea[name="obs"]').hide();
		}

	});


  $('#resolForm').submit(function(event) {
        //alertify.alert(va);
        event.preventDefault(); //this will prevent the default submit
        if(va!=3){
          if($('textarea[name="obs"]').val()==""){
              console.log($('textarea[name="obs"]').val());
              alertify.alert("Mensaje del Sistema","Debe digitar una observacion si el estado de la resolución es diferente de FAVORABLE!")
              return false;
          }
          else{
              $(this).unbind('submit').submit(); // continue the submit unbind preventDefault
              $('#dictamen').hide();

              $('input[type=checkbox]').attr('disable','true');

              var res=$('input[name="resolucion"]:checked').val();
              console.log(res);
              if(res==4){
                setTimeout(function(){
                  $ruta = "{{url('dictamenes/nuevoDic/verResolucionDic')}}/"+{{$numDictamen->idSolicitud}}+"/"+{{$numDictamen->idDictamen}};
                  window.open($ruta);
                  }, 2000);


              }
              $('#res').show();
          }
        }
        else{
            $(this).unbind('submit').submit(); // continue the submit unbind preventDefault
            $('#dictamen').hide();

            $('input[type=checkbox]').attr('disable','true');

            var res=$('input[name="resolucion"]:checked').val();
            console.log(res);
            if(res==4){
             setTimeout(function(){
                  $ruta = "{{url('dictamenes/nuevoDic/verResolucionDic')}}/"+{{$numDictamen->idSolicitud}}+"/"+{{$numDictamen->idDictamen}};
                  window.open($ruta);
                  }, 2000);
               $('#res').show();
            }
        }
  });


</script>

@endsection