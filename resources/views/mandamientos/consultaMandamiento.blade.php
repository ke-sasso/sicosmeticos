@extends('master')

@section('css')

@endsection

@section('contenido')

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading">VALIDAR MANDAMIENTO</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-4 form-group">
                            <label>No. Mandamiento:</label>
                            <input type="text" id="mandamiento" name="mandamiento" class="form-control" required="true"/>
                        </div>
                        <div class="help-block with-errors"></div>
                        <br/>
                        <div class="col-xs-4">
                            <button  type="button" name="validar" id="validarMandamiento" class="btn btn-primary btn-perspective">Consultar</button>
                        </div>
                    </div>

                </div>
                @include('solicitudes.paneles.mandamiento')
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
    @routes()
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

$('#validarMandamiento').click(function(event){
    var mandamiento = $('#mandamiento').val();
    var alert=true;
    var pago="";
    validarMandamiento(mandamiento,true);
});


        function validarMandamiento(mandamiento,alert){
    $.ajax({
        data:{ mandamiento: mandamiento },
        url:  route('validar.mandamiento'),
        type:  'POST',
        success:  function (r){
            if(r.status == '200'){

                var total=0;
                $('#idMand').val(r.data[0].id_mandamiento);
                $('#idCliente').val(r.data[0].id_cliente);
                $('#nombreMand').val(r.data[0].a_nombre);
                $('#pago').val(r.data[0].fecha);
                $('#detMand').empty();
                for(var i=0;i<r.data.length;i++){
                    detalle="";
                    if(r.data[i].valorDet>0) {
                        detalle="<div class='col-xs-12'>-"+r.data[i].nombre_tipo_pago+"- $"+r.data[i].valorDet+" <br><b>"+r.data[i].COMENTARIOS+"</b></div><br/>";;
                        total=total+parseFloat(r.data[i].valorDet);
                    }
                    $('#detMand').append(detalle);

                }
                $('#totalMand').val(total);

            } else if(r.status == '404'){
                alertify.alert("Mensaje de sistema - Advertencia",'MANDAMIENTO NO ENCONTRADO');
            }
        },

    });
}


    </script>

@endsection
