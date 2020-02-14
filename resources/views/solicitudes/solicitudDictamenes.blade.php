<div class="tab-pane fade" id="dictamen">
	<div align="center">
		<button type="button" class="btn btn-primary btn-info correspondencia" data-toggle="modal" data-target="#modalCorres" id="correspondencia">Correspondencia</button><br/><br/>
	</div>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Fecha Resolución</th>
			<th>Descripción Resolución</th>
			<th>Observaciones</th>
			<th>Usuario</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($dictamenes as $dictamen)
		<tr>
			<td>{{ $dictamen->fechaCreacion }}</td>
			<td>{{ $dictamen->estado }}</td>
			<td>{{ strip_tags($dictamen->observacion, '<br>')}}</td>
			<td>{{ $dictamen->idUsuarioCrea }}</td>
			<th>
				<a href="{{ route('pdfDictamen',$dictamen->idDictamen) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-legal" aria-hidden="true"></i></a>
				@if ($dictamen->resolucion == 4 || $dictamen->resolucion==5)
				<a href="{{ route('verResolucionDic',[$dictamen->idSolicitud,$dictamen->idDictamen]) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print" aria-hidden="true"></i></a>
				@endif
			</th>
		</tr>
		@endforeach
	</tbody>
</table>

<div class="modal fade" id="modalCorres">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Notificaciones</h4>
			</div>
			<div class="modal-body">
				<fieldset class="form-group">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="input-group">
							<div class="input-group-addon">Nombre</div>
							<label class="form-control">{{$persona[0]->NOMBRE_PERSONA}}</label>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="input-group">
							<div class="input-group-addon">NIT:</div>
							<label class="form-control">{{$persona[0]->NIT}}</label>
						</div>
					</div>
				</fieldset>
				<fieldset class="form-group">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="input-group">
							<div class="input-group-addon">Teléfonos Contacto</div>
							 @if(count($persona[0]->telefonosContacto)==1)
		                        <label class="form-control">{{$persona[0]->telefonosContacto[0]}}</label>
		                    @else
		                    	<label class="form-control">{{$persona[0]->telefonosContacto[0]}}</label>
		                        <label class="form-control">{{$persona[0]->telefonosContacto[1]}}</label>
		                    @endif
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="input-group">
							<div class="input-group-addon">Dirección</div>
							<textarea class="form-control" rows="4" readonly="readonly">{{$persona[0]->direccion}}</textarea>
						</div>
					</div>

				</fieldset>
				<fieldset class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Correo Electrónico</div>
						<input type="text" name="txtEmail" id="txtEmail" class="form-control" value="{{$persona[0]->emailsContacto}}" required="required">
					</div>
				</fieldset>
				<fieldset class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Observaciones</div>
						<textarea name="notiObservacion" id="notiObservacion" class="summernote-sm" rows="1"></textarea>
					</div>
				</fieldset>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" id="btnNotifica" class="btn btn-primary">Enviar</button>
			</div>
		</div>
	</div>
</div>
</div>