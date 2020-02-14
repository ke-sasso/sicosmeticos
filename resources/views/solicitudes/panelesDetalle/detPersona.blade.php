<div class="tab-pane fade" id="persona">
    <div class="panel-body">
    	<div class="form-group">
		    <div class="row">
		        <div class="col-md-6">
		            <div class="">
		                <div class="input-group">
		                    <b>Nombre:</b>
		                </div>
		                <input type="text" name="nomPersona" value="{{$persona[0]->NOMBRE_PERSONA}}"
		                       class="form-control" readonly>
		            </div>
		        </div>
		        <div class="col-md-5">
		            <div class="">
		                <div class="input-group">
		                    <b>NIT:</b>
		                </div>
		                <input type="text" name="nitPersona" value="{{$persona[0]->NIT}}" class="form-control" readonly>
		            </div>
		        </div>
		    </div>
		    <div class="row">
		        <div class="col-md-6">
		            <div class="">
		                <div class="input-group">
		                    <b>Email:</b>
		                </div>
		                <input type="text" class="form-control" value="{{$persona[0]->emailsContacto}}" readonly/>
		            </div>
		        </div>
		        <div class="col-md-5">
		            <div class="">
		                <div class="input-group">
		                    <b>Teléfono de Contacto::</b>
		                </div>
		                <input type="text" class="form-control" 
						@if($persona!=null) 
		                    @if(count($persona[0]->telefonosContacto)==1)
		                        value="{{$persona[0]->telefonosContacto[0]}}"
		                    @else 
		                        value="{{$persona[0]->telefonosContacto[0]}},{{$persona[0]->telefonosContacto[1]}}"
		                    @endif
                		@endif readonly="true">
		            </div>
		        </div>        
		    </div>
		</div>
    </div>
</div>