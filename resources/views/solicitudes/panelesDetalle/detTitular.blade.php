<div class="tab-pane fade" id="propietario">

    <div class="panel-body">
        <div class="row">
            <div class="col-xs-4">
                <label>Identificador Titular:</label>
                <input type="text" class="form-control" name="id_propietario" 
                @if($titular!=null) value="{{$titular->idPropietario}}" @endif
                       readonly="true">
            </div>

            <div class="col-xs-8">
                <label>Nombre Titular: </label>
                <input type="text" class="form-control" name="nombre_propietario" 
                @if($titular!=null) value="{{$titular->nombre}}" @endif
                       readonly="true">
            </div>
        </div>
        <br/>
        <div class="row">

            <div class="col-xs-4">
                <label>Dirección: </label>
                <input type="text" class="form-control" name="DIRECCION_TITULAR" 
                @if($titular!=null) value="{{$titular->direccion}}" @endif
                       readonly="true">
            </div>
            <div class="col-xs-4">
                <label>Email: </label>
                <input type="text" class="form-control" name="EMAIL_TITULAR" 
                @if($titular!=null) value="{{$titular->emailsContacto}}" @endif
                       readonly="true">
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-4">
                <label>Telefono de Contacto: </label>
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