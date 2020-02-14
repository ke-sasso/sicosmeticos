var tipoProducto;

$('#tipoTramite').change(function(){
    $('#docs').empty();
    $('#tramitesDiv').empty();
    var idTramite=$(this).val();

    var selected = $(this).find('option:selected');
    var mandamientoCos = selected.data('mancos');
    var mandamientoHig = selected.data('manhig');
    $('#mancos').val(mandamientoCos);
    $('#manhig').val(mandamientoHig);
    var tipopro = $('input:radio[name=tipoProducto]:checked').val();
    var idpro= $('#searchbox-producto').val();
    data = {idTra: idTramite};
    getRequisitos(data);

    //console.log(idpro);
    if(idTramite==7){ /*fragancia*/
        fragancianew();
    }
    else if(idTramite==8){ /*tono*/
        tononew();
    }else if(idTramite==22){ /*fecha reconocimiento*/
        fechareconew();
    }else if(idTramite==16 || idTramite==18){ /*cambio de presentación*/
        if(idpro){
               presentacionesnew(idpro,tipopro);
        }else{
              alertify.alert("Mensaje del Sistema","¡Seleccionar un producto para ese tipo de trámite!");
        }
    }else if(idTramite==11 || idTramite==17){ /*cambio de formulación*/
        if(idpro){
               formulacionnew(idpro,tipopro);
        }else{
              alertify.alert("Mensaje del Sistema","¡Seleccionar un producto para ese tipo de trámite!");
        }
    }else if(idTramite==14 || idTramite==23){ /*cambio de formulación*/
         cambionombrenew();
    }
});
$('#searchbox-producto').change(function(){
    var idpro=$(this).val();
    var idTramite= $('#tipoTramite').val();
    var tipopro = $('input:radio[name=tipoProducto]:checked').val();
    if(idTramite==16 || idTramite==18){ /*cambio de presentación*/
        if(idpro){
               presentacionesnew(idpro,tipopro);
        }else{
              alertify.alert("Mensaje del Sistema","¡Seleccionar un producto para ese tipo de trámite!");
        }
    }else if(idTramite==11 || idTramite==17){ /*cambio de formulación*/
        if(idpro){
               formulacionnew(idpro,tipopro);
        }else{
              alertify.alert("Mensaje del Sistema","¡Seleccionar un producto para ese tipo de trámite!");
        }
    }
});

// funcion para validar el mandamiento
$('#validarMandamiento').click(function(event){
    var mandamiento = $('#mandamiento').val();
    var mandcos = $('#mancos').val();
    var mandhig = $('#manhig').val();
    var genero = $('#generoMandamiento').val();
    if(!$("input[name='tipoProducto']").is(':checked')){
            alertify.alert("Mensaje del Sistema","¡Seleccionar un tipo de producto!");
    }else if(mandcos=='' && mandhig==''){
            alertify.alert("Mensaje del Sistema","¡Seleccionar un tipo de tramite!");
    }else{
         pro = $('input:radio[name=tipoProducto]:checked').val();
         validarMandamiento(mandamiento,mandcos,mandhig,pro,true,genero);
    }
});

function validarMandamiento(mandamiento,cos,hig,tipo,alert,genero){
    $.ajax({
        data:{ mandamiento: mandamiento, mancos:cos,manhig:hig,tipoPro:tipo,generoMandamiento:genero},
        url:  route('validar.mandamiento.post'),
        type:  'POST',
        success:  function (r){
            if(r.status == 200){
                if(alert) {
                    alertify.alert("Mensaje de sistema", 'El mandamiento es válido para usar en este trámite');
                }
                $('#mandamiento').prop('readonly', true);
                var total=0;
                $('#idMand').val(r.data[0].id_mandamiento);
                $('#idCliente').val(r.data[0].id_cliente);
                $('#nombreMand').val(r.data[0].a_nombre);
                $('#pago').val(r.data[0].fecha);
                $('#detMand').empty();
                for(var i=0;i<r.data.length;i++){
                    detalle="";
                    if(r.data[i].valorDet>0) {
                        detalle="<div class='col-xs-12'>-"+r.data[i].nombre_tipo_pago+"- $"+r.data[i].valorDet+" <br><b>"+r.data[i].COMENTARIOS+"</b></div><br/>";
                        total=total+parseFloat(r.data[i].valorDet);
                    }
                    $('#detMand').append(detalle);

                }
                $('#totalMand').val(total);

            }
            else if(r.status == 404)
            {   if(alert)
                    alertify.alert("Mensaje de sistema - Advertencia", r.message);
            }
        },

    });
}

function getTabsProducto(id){
    $('#dataProducto').empty();

    $.ajax({
        url:  route('gnralproducto.post'),
        data: {idProducto: id,tipoProducto:tipoProducto},
        type: 'POST',
        beforeSend: function() {
            $('body').modalmanager('loading');
        },
        success:  function (r){
            $('body').modalmanager('loading');
            $('#dataProducto').html(r.data);
        },
        error: function(data){
            // Error...
            $('body').modalmanager('loading');
            alertify.alert("Mensaje del Sistema","No se ha podido realizar la carga de los datos del producto!, por favor contacte al administrador del sistema!");
            var errors = $.parseJSON(data.message);
            console.log(errors);

        }
    });
}

$('input[type=radio][name=tipoProducto]').change(function(){


    tipoProducto=$(this).val();
    var urlprod= route('productos.post');
    $('#searchbox-producto').selectize()[0].selectize.destroy();
    $('#searchbox-producto').selectize({

        valueField: 'idCosmetico',
        inputClass: 'form-control selectize-input',
        labelField: 'nombreComercial',
        searchField: ['idCosmetico','nombreComercial'],
        maxOptions: 50,
        preload: true,
        options: [],
        create: false,
        render: {
            option: function(item, escape) {
                return '<div>' +escape(item.idCosmetico)+' - '+ escape(item.nombreComercial) +'</div>';
            }
        },
        load: function(query, callback) {

            $.ajax({
                url: urlprod,
                type: 'GET',
                dataType: 'json',
                data: {
                    q: query,
                    tipoProducto: tipoProducto,
                },
                error: function() {
                    callback();
                },
                success: function(res) {

                    if(res.status == 200){
                        callback(res.data);
                    }
                    else if (res.status == 404){
                        alertify.alert("Mensaje de sistema",res.message + ".");
                        console.warn(res.message);
                    }else{//Unknown
                        alertify.alert("Mensaje de sistema",res.message);
                        console.warn("No se han podido cargar los productos");
                    }

                }
            });
        }
    });
});

$('#searchbox-producto').change(function(){
    $('#dataProducto').empty();
    var id = $(this).val();
    getGeneralProducto(id);
});

function getGeneralProducto(id){
    $('#dataProducto').empty();

    $.ajax({
        url:  route('dataproducto.post'),
        data: {idProducto: id,tipoProducto:tipoProducto},
        type: 'POST',
        beforeSend: function() {
            $('body').modalmanager('loading');
        },
        success:  function (r){
            $('body').modalmanager('loading');
            $('#dataProducto').html(r.data);
        },
        error: function(data){
            // Error...
            $('body').modalmanager('loading');
            alertify.alert("Mensaje del Sistema","No se ha podido realizar la carga de los datos del producto!, por favor contacte al administrador del sistema!");
            var errors = $.parseJSON(data.message);
            console.log(errors);

        }
    });
}

function fragancianew(){
    ruta = route('ampliacionfragancia.post');
    //console.log(ruta);
    ajax(ruta,{});
}

function tononew(){
    ruta = route('ampliaciontono.post');
    ajax(ruta,{});
}

function fechareconew(){
    ruta = route('fechareconocimiento.post');
    ajax(ruta,{});
}
function presentacionesnew(idproducto,tipo){
    ruta = route('cambiopresentacion.post');
    var parametros = {idproducto:idproducto,tipo:tipo};
    ajax(ruta,parametros);
}
function formulacionnew(idproducto,tipo){
    ruta = route('cambioformulacion.post');
    var parametros = {idproducto:idproducto,tipo:tipo};
    ajax(ruta,parametros);
}
function cambionombrenew(){
    ruta = route('cambiodenombre.post');
    ajax(ruta,{});
}



function getRequisitos(data){
    $.ajax({
        url:  route('requisitos.tramite.post'),
        data: data,
        type: 'GET',
        beforeSend: function() {
            $('body').modalmanager('loading');
        },
        success:  function (r){
            $('body').modalmanager('loading');
            $('#docs').html(r.data);
            $.each($('input[type=file]'), function () {
                $('#' + $(this).attr('id')).fileinput({
                    theme: 'fa',
                    language: 'es',
                    allowedFileExtensions: ['pdf'],
                    showUpload : false
                });

            });
        },
        error: function(data){
            // Error...
            $('body').modalmanager('loading');
            alertify.alert("Mensaje del Sistema","No se ha podido realizar la carga de los datos del producto!, por favor contacte al administrador del sistema!");
            var errors = $.parseJSON(data.message);
            console.log(errors);

        }
    });
}


function ajax(ruta,parametros){
    $.ajax({
        type: 'GET',
        url:  ruta,
        data:parametros,
        success:  function (r){
            $('#tramitesDiv').html(r.data);
        },
        error: function(data){
            // Error...
            //alertify.alert("Mensaje del Sistema","No se ha podido realizar la consulta!, por favor contacte al administrador del sistema!");
            var errors = $.parseJSON(data.message);
            console.log(errors);
        }
    });
}



if(document.getElementById("nombrePersona")) {
//datos persona de contacto
    $('#nombrePersona').selectize({
        valueField: 'NIT',
        labelField: 'NOMBRE_PERSONA',
        searchField: ['NOMBRE_PERSONA', 'NIT'],
        maxOptions: 10,
        options: [],
        create: false,
        render: {
            option: function (item, escape) {
                return '<div>' + escape(item.NIT) + ' (' + escape(item.NOMBRE_PERSONA) + ')</div>';
            }
        },
        load: function (query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: route('buscarPersonasAjax'),
                type: 'GET',
                dataType: 'json',
                data: {
                    q: query
                },
                error: function () {
                    callback();
                },
                success: function (res) {

                    callback(res.data);
                }
            });
        }

    });
    $('#nombrePersona').selectize()[0].selectize.clearOptions();

    $('#nombrePersona').change(function () {
        var id = $(this).val();

        $.ajax({
            url: route('buscarPersonasAjaxPorId'),
            data: {id: id},
            type: 'post',
            success: function (data) {
                //var tel= jQuery.parseJSON(data[0].telefonosContacto);
                //console.log(tel);
                if (data[0].telefonosContacto == '') {
                    var telefono = '';
                } else {
                    var telefono = jQuery.parseJSON(data[0].telefonosContacto);

                }
                $('#idPersona').val(data[0].NIT);
                $('#telefonoPersona').val(telefono);

                if (data[0].emailsContacto == '' || data[0].emailsContacto == 'null') {
                    var email = '';
                } else {
                    var email = data[0].emailsContacto;
                }
                $('#emailPersona').val(email);

                if (telefono[0] == '' || telefono[0] == 'null' || telefono[0] == null) {
                    if (telefono[1] == '' || telefono[1] == 'null' || telefono[1] == null) {
                        var telContacto = '';
                    } else {
                        var telContacto = telefono[1];
                    }
                } else {
                    if (telefono[1] == '' || telefono[1] == 'null' || telefono[1] == null) {
                        var telContacto = telefono[0];
                    } else {
                        var telContacto = telefono[0] + ', ' + telefono[1];
                    }
                }
                $('#telefonoPersona').val(telContacto);

            }
        });

    });
}

$('#generarMandamiento').click(function(event){
    var mandamientocos = $('#mancos').val();
    var mandamientohig = $('#manhig').val();
    var producto = $('input:radio[name=tipoProducto]:checked').val();
    var idProfesional = $('#idpro').length;
    if(!idProfesional){
            alertify.alert("Mensaje del Sistema","¡Debe de seleccionar un producto!");
    }else if($('#idpro').val()=='0'){
            alertify.alert("Mensaje del Sistema","¡El producto no tiene un profesional para generar mandamiento!");

    }else if(mandamientohig=="" && mandamientocos==""){
            alertify.alert("Mensaje del Sistema","¡Seleccionar un tipo de tramite!");
    }else{
       var pro = $('#idpro').val();
       data = {idProducto: producto,mandamientocos:mandamientocos,mandamientohig:mandamientohig,idProfesional:pro};
         alertify.confirm('Mensaje de sistema','¿Esta seguro que desea generar mandamiento?',function(){
            $('#generoMandamiento').val(1);
            generarPdfMandamiento(data);
       },null).set('labels', {ok:'SI', cancel:'NO'});

    }

});

function generarPdfMandamiento(datos){
    $.ajax({
        url:  route('generar.mandamiento.post'),
        data: datos,
        type: 'POST',
        success:  function (r){
            var numMand =  $.parseJSON(r.mandamiento);
            $('#mandamiento').val(numMand);
            $("#validarMandamiento").click();
            $ruta = route('pdf.mandamiento.boleta');
            window.open($ruta);
            $('#validarMandamiento').hide();
        },
        error: function(data){
            // Error...
            alertify.alert("Mensaje del Sistema","No se ha podido realizar la carga de los datos, por favor contacte al administrador del sistema!");
            var errors = $.parseJSON(data.message);
            console.log(errors);

        }
    });
}

$(document).on('click', '.btnEliminar', function () {
    $(this).closest('tr').remove();
});

function btnAddFragancia(){
   $('#tablefragancias tbody').append('<tr><td><input type="text" name="fragancianew[]" class="form-control" id="fragancianew"/></td><td><button class="btn btn-sm btn-danger btnEliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>');
}

function btnAddTono(){
   $('#tabletono tbody').append('<tr><td><input type="text" name="tononew[]" class="form-control" id="tononew"/></td><td><button class="btn btn-sm btn-danger btnEliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>');
}

function btnAddFormula(){
      var tipoproducto = $('input:radio[name=tipoProducto]:checked').val();
      var tipotram=0;
      if(tipoproducto==='COS'){
        tipotram=2;
      }else{
        tipotram=4;
      }
      var ruta =route('buscarFormulasAjax');
      $('#formulaSelect').selectize()[0].selectize.destroy();
      $('#formulaSelect').selectize({
        valueField: 'idDenominacion',
        inputClass: 'form-control selectize-input',
        labelField: 'denominacionINCI',
        searchField: ['numeroCAS','denominacionINCI'],
        maxOptions: 10,
        preload: true,
        options: [],
        create: false,
        render:{
          option: function(item, escape) {
             return "<div  class=\"option\" data-numeroCAS='"+escape(item.numeroCAS)+"' data-denominacionINCI='"+escape(item.denominacionINCI)+"' >(" +escape(item.numeroCAS)+") "+escape(item.denominacionINCI) +"</div>";
            },
           item: function (data, escape) {
             return "<div class=\"item\" data-numeroCAS='" + escape(data['numeroCAS']) + "' data-denominacionINCI='" + escape(data['denominacionINCI']) + "' > ("+escape(data['numeroCAS'])+") "+escape(data['denominacionINCI'])+"</div>";
            }
         },
         load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
              url:ruta,
              type: 'GET',
              dataType: 'json',
              data: {
                    q: query.toUpperCase(),
                    tipotramite: tipotram
              },
              error: function() {
                            callback();
               },
               success: function(res) {
                        callback(res.data);
                }
              });
        }

      });
}

function agregarFormulaPost(){

    var selectize = $('#formulaSelect').get(0).selectize;
    var idformula = selectize.getValue();
    var option = selectize.options[idformula];
    var numcas = option['numeroCAS'];
    var nomform = option['denominacionINCI'];
    var porcen = document.getElementById("portcen").value;
    $('#portcen').val(0);
    $('#tableformula tbody').append('<tr><td><input type="hidden" name="ncas[]"  id="ncas" value="'+numcas+'">'+numcas+'</td><td><input type="hidden" name="nombreDenominacion[]"  id="nombreDenominacion" value="'+nomform+'"><input type="hidden" name="idDenominacion[]" id="idDenominacion" value="'+idformula+'">'+nomform+'</td><td><input type="hidden" name="porcentaje[]" class="form-control" id="porcentaje" value="'+porcen+'">'+porcen+'%</td><td><button class="btn btn-sm btn-danger btnEliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>');
}


function btnAddPresentacion(){
    $('#emapaquesecundario').hide();
    $('#cep').hide();
    $('#dlgPresentacion').modal('toggle');

    if($('#emppri option').size()==0 && $('#empsec option').size()==0){
        var fetchEmpPri = function () {

            $.ajax({
                url: route('get.envases.producto'),
                type: 'get',
                success: function (r) {
                    if (r.status == 200) {
                        $('#emppri').append(r.data);
                        $('#empsec').append(r.data);
                    }
                    else if (r.status == 400) {
                        console.warn(r.message);
                    } else {//Unknown
                        console.warn("No se han podido cargar los envases presentacion!");
                    }
                },
                error: function (data) {
                    console.error(data.responseJSON.message);
                    setTimeout(function () {
                        fetchEmpPri();
                    }, 2000)
                }
            });
        }
        fetchEmpPri();
    }

    if($('#matpri option').size()==0 && $('#matsec option').size()==0) {
        var fecthMatPri = function () {
            $.ajax({
                url: route('get.material.producto'),
                type: 'get',
                success: function (r) {
                    if (r.status == 200) {
                        $('#matpri').append(r.data);
                        $('#matsec').append(r.data);

                    }
                    else if (r.status == 400) {
                        console.warn(r.message);
                    } else {//Unknown
                        console.warn("No se han podido cargar los materiales de presentación!");
                    }
                },
                error: function (data) {
                    console.error(data.responseJSON.message);
                    setTimeout(function () {
                        fecthMatPri();
                    }, 2000)
                }
            });
        }
        fecthMatPri();
    }

    if($('#unidadmedidapri option').size()==0 && $('#medida option').size()==0) {

       var fetchMedidas = function () {
           $.ajax({
               url: route('get.unidad.producto'),
               type: 'get',
               success: function (r) {
                   if (r.status == 200) {
                       $('#unidadmedidapri').append(r.data);
                       $('#medida').append(r.data);
                   }
                   else if (r.status == 400) {
                       console.warn(r.message);
                   } else {//Unknown
                       console.warn("No se han podido cargar las unidades de medidas!");
                   }
               },
               error: function (data) {
                   console.error(data.responseJSON.message);
                   setTimeout(function () {
                       fetchMedidas();
                   }, 2000)
               }
           });
       }

       fetchMedidas();

    }

};
$('input[type=radio][name=checkempsec]').change(function(){
    console.log("SS");
    var val = $(this).val();

    if(val==1){
        $('#empesectrue').attr('checked', true);
        $('#empesecfalse').removeAttr('checked');
        $('#emapaquesecundario').show();

    }
    else if(val==0){
        $('#empesecfalse').attr('checked', true);
        $('#empesectrue').removeAttr('checked');
        $('#emapaquesecundario').hide();
    }
});
function armarPresentacion(){

    $('#textoPres').css('background-color','#a9f0d3');
    $('#textoPres').css('border-color','#08f59f');
    $('#textoPres').css('border','15');
    p1=$('#empsec option:checked').text();
    p2=$('#matsec option:checked').text();
    p3=$('#contsec').val();
    p4=$('#emppri option:checked').text();
    p5=$('#matpri option:checked').text();
    p6=$('#contpri').val();
    p7=$('#unidadmedidapri option:checked').text();
    nombre=$('#nombrePres').val();
    if(nombre!=""){
        nombre=" ("+nombre+" )";
    }

    p9=$('#peso').val();
    if(p9!=""){
        p8="DE "+p9 + " "+$('#medida option:checked').text();
    } else {
        p8=" ";
    }

    unidad=$('#unidadmedidapri option:checked').val();

    if(unidad!=11){
        p8=" ";
    }

    var valor= $("input[name='checkempsec']:checked").val();
    if(valor==1){  //tiene empaque secundario
        texto=p1+" DE "+p2+" X "+p3+" "+p4+" DE "+p5+" X "+p6+" "+p7+" "+p8+nombre;

    } else if (unidad==11) {
        texto=p3+" "+p4+" DE "+p5+" X "+p6+" "+p7+" "+p8+nombre;

    } else {
        texto=p3+" "+p4+" DE "+p5+" X "+p6+" "+p7+nombre;
    }

    $('#textoPres').val(texto);
}



//Si seleccionan 'unidad' en la presentación habilito campos de producto.
$('#unidadmedidapri').change(function (){
    var unidad=$(this).val();

    if(unidad==11){  // seleccionaron unidad
        $('#cep').show();  //CEP contenido empaque primario
    }else{
        $('#cep').hide();
    }

});
$('#btnAgregarPresent').click(function(event) {

    var data= buildRequestStringData($('#presentacionDiv')).toString();

    var datasjson = data.replace(/"/g,'&quot;');
    var values=JSON.parse(data);

    var nombrePresentacion;
    var index = $("#presentacion > tbody > tr").length;
    var i= index +1;

    //solo empaque primario
    if(values.checkempsec==0){
        if(values.contpri.length > 0 && values.emppri.length > 0 && values.matpri.length > 0 && values.unidadmedidapri.length > 0){
            nombrePresentacion=$('#textoPres').val();
            $('#presentacion > tbody').append('<tr><input type="hidden" name="presentaciones[]" value="'+datasjson+'" ><td>'+nombrePresentacion+'</td><td><button class="btn btn-sm btn-danger btnEliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>');
            $('#presentacionForm').trigger("reset");
            $('#dlgPresentacion').modal('toggle');
        }
        else{
            console.error("Todos los campos para el empaque primario son requeridos");
        }
    }
    // empa sec y primario
    else if(values.checkempsec==1){
        //validacion empaque secundario
        if(values.contsec.length > 0 && values.empsec.length > 0 && values.matsec.length > 0){
            //validacion de empaque primario
            if(values.contpri.length > 0 && values.emppri.length > 0 && values.matpri.length > 0 && values.unidadmedidapri.length > 0){
                nombrePresentacion=$('#textoPres').val();
                $('#presentacion > tbody').append('<tr><input type="hidden" name="presentaciones[]" value="'+datasjson+'" "><td>'+nombrePresentacion+'</td><td><button class="btn btn-sm btn-danger btnEliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td></tr>');
                $('#presentacionForm').trigger("reset");
                $('#dlgPresentacion').modal('toggle');
            }
            else{
                console.error("Todos los campos para el empaque primario son requeridos");
            }
        }
        else{
            console.error("Todos los campos para el empaque secundario son requeridos");
        }
    }

});
function buildRequestStringData(form) {
    var select = form.find('select'),
        input = form.find('input'),
        requestString = '{';
    for (var i = 0; i < select.length; i++) {
        requestString += '"' + $(select[i]).attr('name') + '": "' +$(select[i]).val() + '",';
    }
    if (select.length > 0) {
        requestString = requestString.substring(0, requestString.length - 1)+ ',';
    }
    for (var i = 0; i < input.length; i++) {
        if ($(input[i]).attr('type') !== 'checkbox') {
            if($(input[i]).attr('type') === 'radio'){
                console.log($(input[i]).is(':checked'));
                if($(input[i]).is(':checked')){
                    requestString += '"' + $(input[i]).attr('name') + '":"' + $(input[i]).val() + '",';
                }
            }
            else {
                requestString += '"' + $(input[i]).attr('name') + '":"' + $(input[i]).val() + '",';
            }
        } else {
            if ($(input[i]).attr('checked')) {
                requestString += '"' + $(input[i]).attr('name') +'":"' + $(input[i]).val() +'",';
            }
        }
    }
    if (input.length > 0) {
        requestString = requestString.substring(0, requestString.length - 1);
    }
    requestString += '}';
    return requestString;
}

$(document).on('click', '.btnEliminarPresentacion', function () {
   var id1 = $(this).data('idpresentacion');
   var texti = $(this).data('texto');
   $(this).closest('tr').remove();
   $('#deletePresentaciones').append('<input name="deleIdPresentacion[]" type="hidden" value="'+id1+'"/><input name="deleteTexto[]" type="hidden" value="'+texti+'"/>');
});

$(document).on('click', '.btnEliminarFormula', function () {
   var id1 = $(this).data('idprimary');
   var id2 = $(this).data('iddenominacion');
   $(this).closest('tr').remove();
   $('#deleteFormulas').append('<input name="deleIdIdnominacion[]" type="hidden" value="'+id2+'"/><input  type="hidden" name="primaryFormula[]" value="'+id1+'"/> ');
});
