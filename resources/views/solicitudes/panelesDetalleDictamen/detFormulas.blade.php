<div class="the-box full no-border">
	<div class="container-fluid">
		<div>
			<label>SUSTANCIAS DE FORMULA INCI</label>
			<table id="dtformula" class="table table-hover table-striped" cellspacing="0" width="100%">
		        <thead>
		        
		                <th>N° CAS</th>
		                <th>NOMBRE SUSTANCIA</th>
		                <th>PORCENTAJE</th>
		              			     
		        </thead>
		        <tbody>
		        	@for ($i = 0; $i < count($formula); $i++)
			        	@if($sust[$i]!=null)
							 <tr>
								 <td>
									{!!$sust[$i]->numeroCAS!!}
								</td>		
								<td>
									@if($solicitud->tipoSolicitud==2 || $solicitud->tipoSolicitud==3)
										{!!$sust[$i]->denominacionINCI!!} 
									@else
										{!!$sust[$i]->nombreSustancia!!} 
									@endif							 
								</td>			
								<td>
									{!!$formula[$i]->porcentaje!!}

								</td>	
							
							</tr>
						@endif
					@endfor	

					
		        	
		        </tbody>
		    </table>

		</div>
	</div>
</div>