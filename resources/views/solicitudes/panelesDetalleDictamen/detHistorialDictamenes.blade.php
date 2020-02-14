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
			<td>{{ $dictamen->observacion }}</td>
			<td>{{ $dictamen->idUsuarioCrea }}</td>
			<th>
				<a href="{{ route('pdfDictamen',$dictamen->idDictamen) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-legal" aria-hidden="true"></i></a>
				@if ($dictamen->resolucion == 4)
				<a href="{{ route('verResolucionDic',[$dictamen->idSolicitud,$dictamen->idDictamen]) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print" aria-hidden="true"></i></a>
				@endif
			</th>
		</tr>
		@endforeach
	</tbody>
</table>