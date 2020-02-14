<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Identificador Titular:</b>
                </div>
                <input type="text" class="form-control" name="id_propietario" 
                 @if($titular!=null) value="{{$titular->idPropietario}}" @endif readonly="true">
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Nombre Titular:</b>
                </div>
                <input type="text" class="form-control" name="nombre_propietario" @if($titular!=null) value="{{$titular->nombre}}" @endif readonly="true">
            </div>
        </div>      
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Dirección:</b>
                </div>
                <input type="text" class="form-control" name="DIRECCION_TITULAR" @if($titular!=null) value="{{$titular->direccion}}" @endif readonly="true">
            </div>
        </div>  
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Email:</b>
                </div>
                <input type="text" class="form-control" name="EMAIL_TITULAR" @if($titular!=null) value="{{$titular->emailsContacto}}" @endif readonly="true">
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <div class="input-group">
                    <b>Teléfono de Contacto:</b>
                </div>
                <input type="text" class="form-control" name="TELEFONO_TITULAR" 
                @if($titular!=null) 
                    @if(count($titular->telefonosContacto)==1)
                        value="{{$titular->telefonosContacto[0]}}"
                    @else 
                        value="{{$titular->telefonosContacto[0]}},{{$titular->telefonosContacto[1]}}"
                    @endif
                @endif readonly="true">
            </div>
        </div>  
    </div>
</div>