{{-- */
	$permisos = App\UserOptions::getAutUserOptions();
/*--}}
<!-- BEGIN SIDEBAR LEFT -->
<div class="sidebar-left sidebar-nicescroller {{ (Session::get('cfgHideMenu',false))?'toggle':'' }}">
	<ul class="sidebar-menu">
		<li class="{{ (Request::is('inicio') || Request::is('/')) ? 'active selected' : '' }}">
			<a href="{{ url('/inicio') }}"><i class="fa fa-dashboard icon-sidebar"></i>Inicio</a>
		</li>
		@if (!Auth::user()->hasAnyRole(['tecnico_ciex']))
	     <li class="dropdown">
	     	<a href="#fakelink">
	        <i class="fa fa-pencil-square-o icon-sidebar"></i>
	        <i class="fa fa-angle-right chevron-icon-sidebar"></i>
			  Solicitudes Pre-Registro
	   	  	 </a>
	   	  <ul class="submenu">
			<li>
				<a href="{{route('nuevasol')}}">Nueva Solicitud</a>
				<a href="{{route('solicitudes.nueva.asignaciones')}}">Asignar</a>
				<a href="{{route('solicitudes.pre.tecnico')}}">Solicitudes asignadas</a>
				<a href="{{route('indexsol')}}">Administrador Solicitudes</a>
				<a href="{{route('indexSesiones')}}">Administrador Sesiones Pre</a>
				<a href="{{route('indexSesionesAprobar')}}">Aprobar Solicitudes a Sesión</a>
				<a href="{{route('indexSesionesCertificar')}}">Administrador de Certificaciones</a>
			</li>
		  </ul>
	   	</li>
		<li class="dropdown">
			<a href="#fakelink">
				<i class="fa fa-pencil-square-o icon-sidebar"></i>
				<i class="fa fa-angle-right chevron-icon-sidebar"></i>
				Solicitudes Post-Registro
			</a>
			<ul class="submenu">
				<li>
					<a href="{{route('nuevasolicitud.post')}}">Nueva Solicitud</a>
					<a href="{{route('solicitudes.post.nueva.asignaciones')}}">Asignar</a>
					<a href="{{route('solicitudes.tecnico.post')}}">Solicitudes asignadas</a>
					<a href="{{route('administrador.post')}}">Administrador Solicitudes</a>
					<a href="{{route('index.sesionespost')}}">Administrador Sesiones Post</a>
					<a href="{{route('index.aprobar.sesionespost')}}">Aprobar Solicitudes a Sesión</a>
					<a href="{{route('certificacion.sol.sesionespost')}}">Certificación Solicitudes Post</a>
					<a href="{{route('admin.certificacion.post')}}">Certificación de Solicitudes<br>Sin Sesión</a>
				</li>
			</ul>
		</li>
		{{--
		<li class="dropdown">
			<a href="#fakelink">
				<i class="fa fa-pencil-square-o icon-sidebar"></i>
				<i class="fa fa-angle-right chevron-icon-sidebar"></i>
				Sesiones
			</a>
			<ul class="submenu">
				<li>
					<a href="{{route('index.sesionespost')}}">Administrador Sesiones Post</a>
					<a href="{{route('certificacion.sol.sesionespost')}}">Certificación Solicitudes Post</a>
				</li>
			</ul>
		</li>--}}
		<li>
			<a href="{{route('consulta.mandamiento.tools')}}">
				<i class="fa fa-money icon-sidebar"></i>
				Consulta de Mandamientos
			</a>
		</li>
		<li class="dropdown">
			<a href="#fakelink">
				<i class="fa fa-cogs icon-sidebar"></i>
				<i class="fa fa-angle-right chevron-icon-sidebar"></i>
				Catálogos
			</a>
			<ul class="submenu">
				<li>
					<a href="{{route('indexcosmeticos')}}">Cosméticos</a>
					<a href="{{route('indexhigienicos')}}">Higiénicos</a>
					<a href="{{route('indexenvases')}}">Envases</a>
					<a href="{{route('indexmarcas')}}">Marcas</a>
					<a href="{{route('indexmateriales')}}">Materiales</a>
					<a href="{{route('indexareas')}}">Áreas de Aplicación</a>
					<a href="{{route('indexsustanciashig')}}">Sustancias Higiénicos</a>
					<a href="{{route('indexsustanciascos')}}">Sustancias Cosméticos</a>
					<a href="{{route('indexClass')}}">Clasificación de Higiénicos</a>
					<a href="{{route('index')}}">Clasificación de Cosméticos</a>
					<a href="{{route('indexfabricantesext')}}">Fabricantes Extranjeros</a>

				</li>
			</ul>
		</li>
	   	<li class="dropdown">
	      <a href="#fakelink">
	        <i class="fa fa-book fa-fw icon-sidebar"></i>
	        <i class="fa fa-angle-right chevron-icon-sidebar"></i>
	        Reportes
	      </a>
	      <ul class="submenu">
			<li>
				<a href="{{route('indexReportePortal')}}">Solicitudes Portal En Linea</a>
				<a href="{{route('indexReporteTrazabilidad')}}">Trazabilidad de Solicitudes</a>
			</li>
	      </ul>
	    </li>
		@if (Auth::user()->hasAnyRole('admin_it'))
				<li class="dropdown">
					<a href="#fakelink">
						<i class="fa fa-beer fa-fw icon-sidebar"></i>
						<i class="fa fa-angle-right chevron-icon-sidebar"></i>
						Admin IT
					</a>
					<ul class="submenu">
						<li>
							<a target="_blank" href="{{url('log-viewer')}}">Log Viewer</a>
						</li>
					</ul>
				</li>
		@endif
	    <!--
	    <li class="dropdown">
	      <a href="#fakelink">
	        <i class="fa fa-envelope-o icon-sidebar"></i>
	        <i class="fa fa-angle-right chevron-icon-sidebar"></i>
	        Notificaciones
	      </a>
	      <ul class="submenu">
			<li>
				<a href="{{route('indexAdmonNotificacion')}}">Administrador de notificaciones</a>
			</li>
	      </ul>
	    </li>
		-->
		@endif
		@if (Auth::user()->hasAnyRole('tecnico_ciex'))
			<li class="dropdown">
				<a href="#fakelink">
					<i class="fa fa-pencil-square-o icon-sidebar"></i>
					<i class="fa fa-angle-right chevron-icon-sidebar"></i>
					Solicitudes Pre-Registro
				</a>
				<ul class="submenu">
					<li>
						<a href="{{route('indexsol')}}">Administrador Solicitudes</a>
					</li>
				</ul>
			</li>
		@endif
	</ul>

</div><!-- /.sidebar-left -->
<!-- END SIDEBAR LEFT -->
