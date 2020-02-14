<div class="nav-stacked">
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-6">
				<label>¿El producto poseerá coempaque? </label><br>
				<input type="radio" name="coempaque" value="1"
				@if($solicitud->poseeCoempaque==1)
				checked @endif>Si
				<input type="radio" name="coempaque" value="0"
				@if($solicitud->poseeCoempaque==0)
				checked @endif>No 
			</div>

			<div class="col-xs-6">
				<label>Detalle el Nombre Comercial del otro producto que compone el coempaque </label>
				<textarea type="text" class="form-control" name="nomCoempaque" id="nomCoempaque" 
				@if($solicitud->descripcionCoempaque!=null)
				value="{{$solicitud->descripcionCoempaque}}"
				@else
				value=""
				@endif> @if($solicitud->descripcionCoempaque!=null){{$solicitud->descripcionCoempaque}}@endif</textarea>
			</div>
		</div>
	</div>

</div>			