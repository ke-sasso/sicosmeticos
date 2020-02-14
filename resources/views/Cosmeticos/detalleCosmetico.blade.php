@extends('master')

@section('css')


@endsection



@section('contenido')

<div class="panel-body">
	@include('Cosmeticos.tabsCosmeticos')
</div>


@endsection

@section('js')
<script type="text/javascript">
	function modalDetCoempaque($id){
		console.log($id);
		$('#dt-coempaque tbody tr').remove();
		 $.ajax({
		 	 	data:{ id: $id },	
              url:"{{ route('getDetalleCoempaques') }}",
              type: 'get',
              success: function(data){
               console.log(data);
              // console.log(data.length);
               $fila="";
		                  	for($i=0; $i<data.length; $i++){
		                  		$fila='<tr><td>'+data[$i].nombreComercial+'</td><td>'+  data[$i].textoPresentacion+'</td></tr>';
		                  		$('#dt-coempaque tbody').append($fila);
		                  	}
                        }
                  	
                });
	}
</script>



@endsection