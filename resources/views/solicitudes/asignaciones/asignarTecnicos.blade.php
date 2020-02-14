@extends('master')

@section('css')

@endsection

@section('contenido')

    @if(Session::has('message'))
        <div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <strong>{{Session::get('message')}}</strong>
        </div>
    @endif
    <div class="row">
            <div class="col-md-12">
                <form name="asignarSolUsuario" id="asignarSolUsuario" method="POST" role="form" action="{{route('solicitudes.pre.asignaciones.store')}}">
                    <div id="sol"></div>
                    <div class="col-md-6">
                            @if($asignados)
                           <select id="usuario" name="usuario[]" class="form-control chosen-select" multiple data-placeholder="Seleccionar uno o más usuarios...">
                             @foreach($usuarios as $usu)
                               @if(in_array($usu->idUsuario, $asignados))
                                  <option value="{{$usu->idUsuario}}" selected >{{$usu->idUsuario}}</option>
                               @else
                                 <option value="{{$usu->idUsuario}}"  >{{$usu->idUsuario}}</option>
                               @endif
                             @endforeach
                          </select>
                          @else
                               <select id="usuario" name="usuario[]" class="form-control chosen-select" multiple data-placeholder="Seleccionar uno o más usuarios...">
                                 @foreach($usuarios as $usu)
                                  <option value="{{$usu->idUsuario}}">{{$usu->idUsuario}}</option>
                                 @endforeach
                              </select>
                          @endif
                    </div>
                    <div class="col-md-6">
                         <input type="hidden" name="idSolicitud" id="idSolicitud" value="{{$idSolicitud}}">
                         <button type="submit" id="aprobarSol"  class="btn btn-primary">Enviar datos</button>
                          <a href="{{route('solicitudes.nueva.asignaciones')}}" class="btn btn-info"><b><i class="fa  fa-mail-reply"></i></b>Regresar</a>
                    </div>
                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                </form>

            </div>


    </div>
@endsection

@section('js')

    <script>

        $('#asignarSolUsuario').submit(function(e){
             e.preventDefault();
                var formObj = $(this);
                var formURL = formObj.attr("action");
                var formData = new FormData(this);
                $.ajax({
                    data:formData,
                    url:  formURL,
                    type:  'POST',
                    mimeType:"multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData:false,
                    success:  function (r){
                         var data =  $.parseJSON(r);
                        if(data["status"] ==200){
                                alertify.alert("Mensaje de Sistema",data["message"],function(){
                                    location.reload();
                                });
                        }else if(data["status"]==404){
                                alertify.alert("Mensaje de sistema - Advertencia", data["message"]);
                        }
                    },
                    error: function(data){
                        // Error...
                        alertify.alert("Mensaje del Sistema","No se ha podido realizar la carga de los datos, por favor contacte al administrador del sistema!");
                        var errors = $.parseJSON(data.message);
                        console.log(errors);

                    }

                });

        });


    </script>

@endsection