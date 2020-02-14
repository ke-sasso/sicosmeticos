    var Ziggy = {
        namedRoutes: JSON.parse('{"debugbar.openhandler":{"uri":"_debugbar\/open","methods":["GET","HEAD"],"domain":null},"debugbar.clockwork":{"uri":"_debugbar\/clockwork\/{id}","methods":["GET","HEAD"],"domain":null},"debugbar.assets.css":{"uri":"_debugbar\/assets\/stylesheets","methods":["GET","HEAD"],"domain":null},"debugbar.assets.js":{"uri":"_debugbar\/assets\/javascript","methods":["GET","HEAD"],"domain":null},"crearenvase":{"uri":"catalogos\/administrador\/crearenvase","methods":["GET","HEAD"],"domain":null},"guardarenvase":{"uri":"catalogos\/administrador\/guardarenvase","methods":["POST"],"domain":null},"indexenvases":{"uri":"catalogos\/administrador\/verenvases","methods":["GET","HEAD"],"domain":null},"editarenvase":{"uri":"catalogos\/administrador\/editarenvase\/{id}","methods":["GET","HEAD"],"domain":null},"actualizarenvase":{"uri":"catalogos\/administrador\/actualizarenvase","methods":["POST"],"domain":null},"crearmarca":{"uri":"catalogos\/administrador\/crearmarca","methods":["GET","HEAD"],"domain":null},"guardarmarca":{"uri":"catalogos\/administrador\/guardarmarca","methods":["POST"],"domain":null},"indexmarcas":{"uri":"catalogos\/administrador\/vermarcas","methods":["GET","HEAD"],"domain":null},"editarmarca":{"uri":"catalogos\/administrador\/editarmarca\/{id}","methods":["GET","HEAD"],"domain":null},"actualizarmarca":{"uri":"catalogos\/administrador\/actualizarmarca","methods":["POST"],"domain":null},"crearmaterial":{"uri":"catalogos\/administrador\/crearmaterial","methods":["GET","HEAD"],"domain":null},"guardarmaterial":{"uri":"catalogos\/administrador\/guardarmaterial","methods":["POST"],"domain":null},"indexmateriales":{"uri":"catalogos\/administrador\/vermateriales","methods":["GET","HEAD"],"domain":null},"editarmaterial":{"uri":"catalogos\/administrador\/editarmaterial\/{id}","methods":["GET","HEAD"],"domain":null},"actualizarmaterial":{"uri":"catalogos\/administrador\/actualizarmaterial","methods":["POST"],"domain":null},"indexsustanciascos":{"uri":"catalogos\/administrador\/versustanciascos","methods":["GET","HEAD"],"domain":null},"indexsustanciashig":{"uri":"catalogos\/administrador\/versustanciashig","methods":["GET","HEAD"],"domain":null},"crearsustancias":{"uri":"catalogos\/administrador\/crearsustancias","methods":["GET","HEAD"],"domain":null},"savesustancias":{"uri":"catalogos\/administrador\/guardarsustancias","methods":["POST"],"domain":null},"dt.sust.cos":{"uri":"catalogos\/administrador\/getsustanciasCos","methods":["GET","HEAD"],"domain":null},"dt.sust.hig":{"uri":"catalogos\/administrador\/getSustanciasHig","methods":["GET","HEAD"],"domain":null},"indexfabricantesext":{"uri":"catalogos\/administrador\/verFabricantesExt","methods":["GET","HEAD"],"domain":null},"dt.fab.ext":{"uri":"catalogos\/administrador\/getFabricantesExt","methods":["GET","HEAD"],"domain":null},"getCrearFabExt":{"uri":"catalogos\/administrador\/getFabExt","methods":["GET","HEAD"],"domain":null},"saveFabExt":{"uri":"catalogos\/administrador\/guardarFabExt","methods":["POST"],"domain":null},"editarFabExt":{"uri":"catalogos\/administrador\/editarFabExt\/{id}","methods":["GET","HEAD"],"domain":null},"actualizarFabExt":{"uri":"catalogos\/administrador\/actualizarFabExt","methods":["POST"],"domain":null},"getFabricantesEstado":{"uri":"catalogos\/administrador\/getFabricantesEstado","methods":["GET","HEAD"],"domain":null},"creararea":{"uri":"cosmeticos\/administrador\/creararea","methods":["GET","HEAD"],"domain":null},"guardararea":{"uri":"cosmeticos\/administrador\/guardararea","methods":["POST"],"domain":null},"indexareas":{"uri":"cosmeticos\/administrador\/verareas","methods":["GET","HEAD"],"domain":null},"editararea":{"uri":"cosmeticos\/administrador\/editararea\/{id}","methods":["GET","HEAD"],"domain":null},"actualizararea":{"uri":"cosmeticos\/administrador\/actualizararea","methods":["POST"],"domain":null},"crearc":{"uri":"cosmeticos\/administrador\/crearclasificacion","methods":["GET","HEAD"],"domain":null},"guardar":{"uri":"cosmeticos\/administrador\/guardarclasificacion","methods":["POST"],"domain":null},"index":{"uri":"cosmeticos\/administrador\/verclasificaciones","methods":["GET","HEAD"],"domain":null},"editar":{"uri":"cosmeticos\/administrador\/verclasificaciones\/{id}","methods":["GET","HEAD"],"domain":null},"dt.row.data.class":{"uri":"cosmeticos\/administrador\/getdataclass","methods":["GET","HEAD"],"domain":null},"actualizar":{"uri":"cosmeticos\/administrador\/actualizarclass","methods":["POST"],"domain":null},"indexcosmeticos":{"uri":"cosmeticos\/administrador\/cosmeticos","methods":["GET","HEAD"],"domain":null},"dt.row.data.cos":{"uri":"cosmeticos\/tecnico\/cosmeticos","methods":["GET","HEAD"],"domain":null},"vercosmetico":{"uri":"cosmeticos\/tecnico\/vercosmeticos\/{idCosmetico}\/{opcion}","methods":["GET","HEAD"],"domain":null},"generalescos":{"uri":"cosmeticos\/administrador\/generales-cosmeticos","methods":["GET","HEAD"],"domain":null},"getDetalleCoempaques":{"uri":"cosmeticos\/administrador\/detalleCoempaque","methods":["GET","HEAD"],"domain":null},"vercosmetico.edicion":{"uri":"cosmeticos\/tecnico\/edicionCos","methods":["GET","HEAD"],"domain":null},"editarClas":{"uri":"cosmeticos\/tecnico\/actualizarClas","methods":["POST"],"domain":null},"editarGenenalesCos":{"uri":"cosmeticos\/tecnico\/actualizarGenerales","methods":["POST"],"domain":null},"editarMarca":{"uri":"cosmeticos\/tecnico\/actualizarMarca","methods":["POST"],"domain":null},"editarPropietarioCos":{"uri":"cosmeticos\/tecnico\/actualizarPropietario","methods":["POST"],"domain":null},"editarProfesionalCos":{"uri":"cosmeticos\/tecnico\/actualizarProfesional","methods":["POST"],"domain":null},"editarFormulaCos":{"uri":"cosmeticos\/tecnico\/actualizarFormula","methods":["POST"],"domain":null},"editarTonosCos":{"uri":"cosmeticos\/tecnico\/actualizarTonos","methods":["POST"],"domain":null},"editarFraganciaCos":{"uri":"cosmeticos\/tecnico\/actualizarFragancias","methods":["POST"],"domain":null},"editarFabCos":{"uri":"cosmeticos\/tecnico\/actualizarFab","methods":["POST"],"domain":null},"editarDisCos":{"uri":"cosmeticos\/tecnico\/actualizarDis","methods":["POST"],"domain":null},"editarImpCos":{"uri":"cosmeticos\/tecnico\/actualizarImp","methods":["POST"],"domain":null},"actualizar.presentacion":{"uri":"cosmeticos\/tecnico\/savePresentacion","methods":["POST"],"domain":null},"get.presentacionesCos":{"uri":"cosmeticos\/tecnico\/getPresentacionesCos","methods":["GET","HEAD"],"domain":null},"borrar.presentacionesCos":{"uri":"cosmeticos\/tecnico\/deletePresentaciones","methods":["GET","HEAD"],"domain":null},"indexAdmonNotificacion":{"uri":"dictamenes\/AdmonNotificaciones","methods":["GET","HEAD"],"domain":null},"dt.row.data.noti":{"uri":"dictamenes\/getSolicitudeNotificacion","methods":["GET","HEAD"],"domain":null},"registroNotificacion":{"uri":"dictamenes\/registroNotificacion\/{idSol}","methods":["GET","HEAD"],"domain":null},"guardarNuevaNoti":{"uri":"dictamenes\/guardarNuevaNotificacion","methods":["POST"],"domain":null},"guardarNoti":{"uri":"dictamenes\/guardarNotificacion","methods":["POST"],"domain":null},"versolicitudDic":{"uri":"dictamenes\/nuevoDic\/consultarSol\/{idSol}\/{tipo}\/{solicitudPortal}","methods":["GET","HEAD"],"domain":null},"nuevadictamen":{"uri":"dictamenes\/nuevoDic\/nuevadic","methods":["GET","HEAD"],"domain":null},"guardarDictamen":{"uri":"dictamenes\/nuevoDic\/saveDic","methods":["POST"],"domain":null},"guardarResolucion":{"uri":"dictamenes\/nuevoDic\/saveResolucion","methods":["POST"],"domain":null},"pdfDictamen":{"uri":"dictamenes\/nuevoDic\/verDictamen\/{id}","methods":["GET","HEAD"],"domain":null},"pdfResolucion":{"uri":"dictamenes\/nuevoDic\/verResolucion\/{id}","methods":["GET","HEAD"],"domain":null},"verResolucionDic":{"uri":"dictamenes\/nuevoDic\/verResolucionDic\/{id}\/{idDic}","methods":["GET","HEAD"],"domain":null},"enviar.correspondencia":{"uri":"dictamenes\/nuevoDic\/enviarcorrespondencia","methods":["POST"],"domain":null},"indexhigienicos":{"uri":"higienicos\/tecnico\/higienicos","methods":["GET","HEAD"],"domain":null},"dt.row.data.hig":{"uri":"higienicos\/tecnico\/higienicodata","methods":["GET","HEAD"],"domain":null},"verhigienico":{"uri":"higienicos\/tecnico\/verhigienico\/{indexhigienico}\/{opcion}","methods":["GET","HEAD"],"domain":null},"guardarClasHig":{"uri":"higienicos\/tecnico\/higienicoclas","methods":["POST"],"domain":null},"getCrearClas":{"uri":"higienicos\/tecnico\/getClasHig","methods":["GET","HEAD"],"domain":null},"indexClass":{"uri":"higienicos\/tecnico\/indexClassHig","methods":["GET","HEAD"],"domain":null},"dt.class.hig":{"uri":"higienicos\/tecnico\/getClassHig","methods":["GET","HEAD"],"domain":null},"editarClassHig":{"uri":"higienicos\/tecnico\/verclasificacion\/{id}","methods":["GET","HEAD"],"domain":null},"actualizarClassHig":{"uri":"higienicos\/tecnico\/actualizarClassHig","methods":["POST"],"domain":null},"editarTonosHig":{"uri":"higienicos\/tecnico\/actualizarTonos","methods":["POST"],"domain":null},"editarFraganciaHig":{"uri":"higienicos\/tecnico\/actualizarFragancias","methods":["POST"],"domain":null},"editarFabHig":{"uri":"higienicos\/tecnico\/actualizarFab","methods":["POST"],"domain":null},"editarDisHig":{"uri":"higienicos\/tecnico\/actualizarDis","methods":["POST"],"domain":null},"editarImpHig":{"uri":"higienicos\/tecnico\/actualizarImp","methods":["POST"],"domain":null},"editarGenenalesHig":{"uri":"higienicos\/tecnico\/actualizarGenerales","methods":["POST"],"domain":null},"editarPropietarioHig":{"uri":"higienicos\/tecnico\/actualizarPropietario","methods":["POST"],"domain":null},"editarProfesionalHig":{"uri":"higienicos\/tecnico\/actualizarProfesional","methods":["POST"],"domain":null},"editarClasHig":{"uri":"higienicos\/tecnico\/actualizarClas","methods":["POST"],"domain":null},"editarMarcaHig":{"uri":"higienicos\/tecnico\/actualizarMarca","methods":["POST"],"domain":null},"editarFormulaHig":{"uri":"higienicos\/tecnico\/actualizarFormula","methods":["POST"],"domain":null},"actualizar.presentacionHig":{"uri":"higienicos\/tecnico\/savePresentacion","methods":["POST"],"domain":null},"borrar.presentacionesHig":{"uri":"higienicos\/tecnico\/deletePresentaciones","methods":["GET","HEAD"],"domain":null},"indexReportePortal":{"uri":"reportes\/reporte\/reportePortal","methods":["GET","HEAD"],"domain":null},"generarReporte":{"uri":"reportes\/reporte\/generarReporte","methods":["POST"],"domain":null},"solportal.dtrows-sol":{"uri":"reportes\/reporte\/dtrows\/solicitudes","methods":["GET","HEAD"],"domain":null},"indexReporteTrazabilidad":{"uri":"reportes\/reporte\/reporteTrazabilidad","methods":["GET","HEAD"],"domain":null},"dt.trazabilidad.sol":{"uri":"reportes\/reporte\/dtrows\/trazabilidad","methods":["GET","HEAD"],"domain":null},"indexSesiones":{"uri":"sesiones\/sesion\/getsesiones","methods":["GET","HEAD"],"domain":null},"dt.row.data.sesiones":{"uri":"sesiones\/sesion\/versesiones","methods":["GET","HEAD"],"domain":null},"verSesion":{"uri":"sesiones\/sesion\/detalleSesion\/{id}","methods":["GET","HEAD"],"domain":null},"consultarSolicitudes":{"uri":"sesiones\/sesion\/consultarSol\/{sesion}","methods":["GET","HEAD"],"domain":null},"agregarSolicitudesAsesion":{"uri":"sesiones\/sesion\/agregarSol","methods":["POST"],"domain":null},"indexSesionesCertificar":{"uri":"sesiones\/sesion\/getsesionesCertificaciones","methods":["GET","HEAD"],"domain":null},"dt.row.data.sesiones.certificar":{"uri":"sesiones\/sesion\/versesionesParaCertificar","methods":["GET","HEAD"],"domain":null},"getSolicitudesCertificar":{"uri":"sesiones\/sesion\/detalleSesionCertificar\/{id}","methods":["GET","HEAD"],"domain":null},"certificarSolicitudes":{"uri":"sesiones\/sesion\/certificarSol","methods":["POST"],"domain":null},"dt.row.data.sol.certificar":{"uri":"sesiones\/sesion\/getSolicitudesParaCertificar","methods":["GET","HEAD"],"domain":null},"indexSesionesAprobar":{"uri":"sesiones\/sesion\/indexSesionesAprobar","methods":["GET","HEAD"],"domain":null},"dt.row.data.sesiones.aprobar":{"uri":"sesiones\/sesion\/getSol","methods":["GET","HEAD"],"domain":null},"indexSolicitudesAprobar":{"uri":"sesiones\/sesion\/indexSolAprobar\/{id}","methods":["GET","HEAD"],"domain":null},"dt.row.data.sol.listas":{"uri":"sesiones\/sesion\/aprobarSol","methods":["GET","HEAD"],"domain":null},"aprobarSolicitudesAsesion":{"uri":"sesiones\/sesion\/aprobarSolicitudes","methods":["POST"],"domain":null},"dt.row.data.sol.ses":{"uri":"sesiones\/sesion\/consultarSolSes","methods":["GET","HEAD"],"domain":null},"imprimirCertificado":{"uri":"sesiones\/sesion\/imprimir","methods":["GET","HEAD"],"domain":null},"imprimir.solicitudes":{"uri":"sesiones\/sesion\/imprimir\/solicitudes","methods":["GET","HEAD"],"domain":null},"solicitudes.nueva.asignaciones":{"uri":"solicitudes\/nueva\/asignaciones\/{idSolicitud}","methods":["GET","HEAD"],"domain":null},"solicitudes.nueva.asignaciones.store":{"uri":"solicitudes\/nueva\/asignaciones\/store\/{idSolicitud}","methods":["POST"],"domain":null},"nuevasol":{"uri":"solicitudes\/nueva\/nuevasol","methods":["GET","HEAD"],"domain":null},"getDataClassSol":{"uri":"solicitudes\/nueva\/getDataClass","methods":["POST"],"domain":null},"getClassHig":{"uri":"solicitudes\/nueva\/getDataClassHig","methods":["GET","HEAD"],"domain":null},"getGrupoFormasSol":{"uri":"solicitudes\/nueva\/getFormas","methods":["POST"],"domain":null},"consultarClassSolCos":{"uri":"solicitudes\/nueva\/consultarClassC","methods":["GET","HEAD"],"domain":null},"consultarClassSolHig":{"uri":"solicitudes\/nueva\/consultarClassH","methods":["GET","HEAD"],"domain":null},"buscarFormulasAjax":{"uri":"solicitudes\/nueva\/buscarFormulaCos","methods":["GET","HEAD"],"domain":null},"buscarTitularAjax":{"uri":"solicitudes\/nueva\/buscarTitular","methods":["GET","HEAD"],"domain":null},"buscarTitularAjaxPorId":{"uri":"solicitudes\/nueva\/getTitular","methods":["GET","HEAD"],"domain":null},"buscarProfesionalesAjax":{"uri":"solicitudes\/nueva\/buscarProfesionales","methods":["GET","HEAD"],"domain":null},"buscarProfesionalAjaxPorId":{"uri":"solicitudes\/nueva\/buscarProfesional","methods":["POST"],"domain":null},"buscarPersonasAjax":{"uri":"solicitudes\/nueva\/buscarPersonas","methods":["GET","HEAD"],"domain":null},"buscarPersonasAjaxPorId":{"uri":"solicitudes\/nueva\/buscarPersona","methods":["POST"],"domain":null},"buscarItems":{"uri":"solicitudes\/nueva\/getItems","methods":["POST"],"domain":null},"buscarItemsEditar":{"uri":"solicitudes\/nueva\/getItemsEditar","methods":["POST"],"domain":null},"guardarsolNuevoCos":{"uri":"solicitudes\/nueva\/guardarSolNuevoCosmetico","methods":["POST"],"domain":null},"actualizarSol":{"uri":"solicitudes\/nueva\/actualizarSol","methods":["POST"],"domain":null},"envases.presentaciones":{"uri":"solicitudes\/nueva\/getEnvases","methods":["GET","HEAD"],"domain":null},"materiales.presentaciones":{"uri":"solicitudes\/nueva\/getMateriales","methods":["GET","HEAD"],"domain":null},"unidades.presentaciones":{"uri":"solicitudes\/nueva\/getUnidades","methods":["GET","HEAD"],"domain":null},"municipios":{"uri":"solicitudes\/nueva\/getMunicipios","methods":["GET","HEAD"],"domain":null},"departamentos":{"uri":"solicitudes\/nueva\/getDepartamentos","methods":["GET","HEAD"],"domain":null},"tratamientos":{"uri":"solicitudes\/nueva\/getTratamientos","methods":["GET","HEAD"],"domain":null},"dt.row.data.sol":{"uri":"solicitudes\/nueva\/getSolicitudes","methods":["GET","HEAD"],"domain":null},"indexsol":{"uri":"solicitudes\/nueva\/getSolicitudesIngresadas","methods":["GET","HEAD"],"domain":null},"versolicitud":{"uri":"solicitudes\/nueva\/consultarSol\/{idSol}\/{tipo}","methods":["GET","HEAD"],"domain":null},"editarsolicitud":{"uri":"solicitudes\/nueva\/editarSol\/{idSol}\/{tipo}\/{tipoSol}","methods":["GET","HEAD"],"domain":null},"getPaises":{"uri":"solicitudes\/nueva\/paises","methods":["GET","HEAD"],"domain":null},"guardarSolicitudCos":{"uri":"solicitudes\/nueva\/guardarSolCos","methods":["GET","HEAD"],"domain":null},"guardarSolicitudCosDetalle":{"uri":"solicitudes\/nueva\/guardarSolCosDetalle","methods":["POST"],"domain":null},"validar.mandamiento":{"uri":"solicitudes\/nueva\/validarMand","methods":["POST"],"domain":null},"ver.documento":{"uri":"solicitudes\/nueva\/verDocumentos\/{idDoc}","methods":["GET","HEAD"],"domain":null},"eliminar.documento":{"uri":"solicitudes\/nueva\/eliminarDocumento","methods":["POST"],"domain":null},"eliminar.formula":{"uri":"solicitudes\/nueva\/eliminarFormula","methods":["POST"],"domain":null},"eliminar.fragancia":{"uri":"solicitudes\/nueva\/eliminarFragancia","methods":["POST"],"domain":null},"eliminar.tono":{"uri":"solicitudes\/nueva\/eliminarTono","methods":["POST"],"domain":null},"guardarNuevaPersona":{"uri":"solicitudes\/nueva\/guardarNuevaPersona","methods":["POST"],"domain":null},"buscarFormulajaxPorId":{"uri":"solicitudes\/nueva\/buscarFormula","methods":["POST"],"domain":null},"buscarFormulaHigjaxPorId":{"uri":"solicitudes\/nueva\/buscarFormulaHig","methods":["POST"],"domain":null},"dt.row.data.sol.fav":{"uri":"solicitudes\/nueva\/getSolicitudesFav","methods":["GET","HEAD"],"domain":null},"indexsolFavorables":{"uri":"solicitudes\/nueva\/getSolicitudesSesion","methods":["GET","HEAD"],"domain":null},"cargar.clasificacion":{"uri":"solicitudes\/nueva\/getClasificaciones","methods":["GET","HEAD"],"domain":null},"guardar.presentacion":{"uri":"solicitudes\/nueva\/savePresentaciones","methods":["POST"],"domain":null},"borrar.presentaciones":{"uri":"solicitudes\/nueva\/deletePresentaciones","methods":["GET","HEAD"],"domain":null},"get.presentacionesSol":{"uri":"solicitudes\/nueva\/getPresentacionesSol","methods":["GET","HEAD"],"domain":null},"get.coempaqueSol":{"uri":"solicitudes\/nueva\/getCoempaquesSol","methods":["GET","HEAD"],"domain":null},"get.coempaqueProducto":{"uri":"solicitudes\/nueva\/getCoempaquesProducto","methods":["GET","HEAD"],"domain":null},"crear.coempaque":{"uri":"solicitudes\/nueva\/crearCoempaque","methods":["POST"],"domain":null},"borrar.coempaque":{"uri":"solicitudes\/nueva\/deleteCoempaque","methods":["GET","HEAD"],"domain":null},"ingresarFormula":{"uri":"solicitudes\/nueva\/ingresarFormula","methods":["POST"],"domain":null},"buscarPaises":{"uri":"consultas\/tools\/getPaises","methods":["GET","HEAD"],"domain":null},"buscarPropietarios":{"uri":"consultas\/tools\/getPropietarios","methods":["GET","HEAD"],"domain":null},"get.titular":{"uri":"consultas\/tools\/obtenerPropietario","methods":["GET","HEAD"],"domain":null},"buscar.marcas":{"uri":"consultas\/tools\/getMarcas","methods":["GET","HEAD"],"domain":null},"buscar.clasificacion":{"uri":"consultas\/tools\/getClasificaciones","methods":["GET","HEAD"],"domain":null},"get.profesional":{"uri":"consultas\/tools\/getProfesional","methods":["GET","HEAD"],"domain":null},"buscarDistribuidoresAjaxPorId":{"uri":"consultas\/tools\/buscarDistribuidor","methods":["POST"],"domain":null},"buscarDistribuidoresAjax":{"uri":"consultas\/tools\/buscarDistribuidores","methods":["GET","HEAD"],"domain":null},"buscarFabricantesAjax":{"uri":"consultas\/tools\/buscarFabricantes","methods":["GET","HEAD"],"domain":null},"buscarFabricanteAjaxPorId":{"uri":"consultas\/tools\/getFabricante","methods":["POST"],"domain":null},"buscarImportadorAjaxPorId":{"uri":"consultas\/tools\/getImportador","methods":["POST"],"domain":null},"buscarImportadoresAjax":{"uri":"consultas\/tools\/buscarImportadores","methods":["GET","HEAD"],"domain":null},"nuevasolicitud.post":{"uri":"solicitudesPost\/nuevaSolicitud","methods":["GET","HEAD"],"domain":null},"administrador.post":{"uri":"solicitudesPost\/administrador","methods":["GET","HEAD"],"domain":null},"productos.post":{"uri":"solicitudesPost\/productos","methods":["GET","HEAD"],"domain":null},"doLogin":{"uri":"\/","methods":["GET","HEAD"],"domain":null},"login":{"uri":"login","methods":["POST"],"domain":null},"doInicio":{"uri":"inicio","methods":["GET","HEAD"],"domain":null},"log-viewer::dashboard":{"uri":"log-viewer","methods":["GET","HEAD"],"domain":null},"log-viewer::logs.list":{"uri":"log-viewer\/logs","methods":["GET","HEAD"],"domain":null},"log-viewer::logs.delete":{"uri":"log-viewer\/logs\/delete","methods":["DELETE"],"domain":null},"log-viewer::logs.show":{"uri":"log-viewer\/logs\/{date}","methods":["GET","HEAD"],"domain":null},"log-viewer::logs.download":{"uri":"log-viewer\/logs\/{date}\/download","methods":["GET","HEAD"],"domain":null},"log-viewer::logs.filter":{"uri":"log-viewer\/logs\/{date}\/{level}","methods":["GET","HEAD"],"domain":null},"log-viewer::logs.search":{"uri":"log-viewer\/logs\/{date}\/{level}\/search","methods":["GET","HEAD"],"domain":null}}'),
        baseUrl: 'http://localhost/',
        baseProtocol: 'http',
        baseDomain: 'localhost',
        basePort: false
    };

    export {
        Ziggy
    }
