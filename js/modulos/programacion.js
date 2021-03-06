$(document).ready(function() {

    limpiaForm($('#frm_programacion'), false);

    $("#fecha_inicia_alerta").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });

    $("#f_fecha_mensaje").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });
    
    $("#f_fecha_final").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });
    
    $("#f_fecha_mensaje_add").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });
    
    $("#f_fecha_final_add").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });
    
    $("#frm_programacion").validate({
        rules: {
            descripcion: {required: true},
            fecha_inicia_alerta: {required: true},
            id_plantilla_mensajes: {required: true},
            num_dias_entre_mensaje: {required: true},
            num_max_mensajes: {required: true},
            tipo_periodo: {required: true},
            num_unidades_periodo: {required: true},
            puntaje: {required: true}
        },
        messages: {
            descripcion: {required: "Ingrese descripcion"},
            fecha_inicia_alerta: {required: "Ingrese Inicia Alertas"},
            num_dias_entre_mensaje: {required: "Ingrese Dias Entre Mensajes"},
            num_max_mensajes: {required: "Ingrese Num Max Mensajes"},
            num_unidades_periodo: {required: "Ingrese Numero Periodo"},
            puntaje: {required: "Ingrese puntaje"}
        },
        // the errorPlacement has to take the layout into account
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent().find('label:first'));
        },
        submitHandler: function() {

            if ($("#num_dias_entre_mensaje").val() <= 0) {
                Mensaje('Dias entre mensaje solo puede ser mayor que 1');
                return;
            }

            $.post(
                    URLINDEX + '/programacion/guardar',
                    {
                        ajax: 'ajax',
                        descripcion: $("#descripcion").val().toUpperCase(),
                        fecha_inicia_alerta: '',
                        id_plantilla_mensajes: $("#id_plantilla_mensajes").val().toUpperCase(),
                        puntaje: $("#puntaje").val().toUpperCase(),
                        num_dias_entre_mensaje: 1,
                        num_max_mensajes: 0,
                        tipo_periodo: $('#tipo_periodo').val(),
                        num_unidades_periodo: 1,
                        id_programacion: $("#id_programacion").val()
                    }, //parametros
            function(response) { //funcion para procesar los datos

                if (response.code && response.code == 'ERROR') {
                    Mensaje(response.message);
                } else {
                    limpiaForm($('#frm_programacion'), false);
                    jQuery('#lsprogramacion').trigger('reloadGrid');
                    $('#dlgProgramacion').dialog('close');
                }
            },
                    'json'//tipo de dato devuelto
                    );

        },
        // set new class to error-labels to indicate valid fields
        success: function(label) {
            // set &nbsp; as text for IE
            label.html("&nbsp;").addClass("ok");
        }
    });

    $("#guardar_programacion").button()
            .click(function() {
                $("#frm_programacion").submit();
            });

    $("#cancelar_programacion").button()
            .click(function() {
                limpiaForm($('#frm_programacion'), false);
            });


    $("#nuevo_programacion").button()
            .click(function() {
                limpiaForm($('#frm_programacion'), true);
                $("#id_programacion").val(-1);
                $('#dlgProgramacion').dialog('open');
            });

    $("#modificar_programacion").button()
            .click(function() {

                var indexR = jQuery('#lsprogramacion').getGridParam("selrow");
                if (indexR != null) {

                    $.get(
                            URLINDEX + '/programacion/get',
                            {
                                ajax: 'ajax',
                                id_programacion: indexR
                            },
                    function(response) {
                        limpiaForm($('#frm_programacion'), true);

                        $("#descripcion").val(response.response.descripcion);
//                        $("#fecha_inicia_alerta").val(response.response.fecha_inicia_alerta);
                        $("#id_plantilla_mensajes").val(response.response.id_plantilla_mensajes);
                        $("#puntaje").val(response.response.puntaje);
//                        $("#num_dias_entre_mensaje").val(response.response.num_dias_entre_mensaje);
//                        $("#num_max_mensajes").val(response.response.num_max_mensajes);
                        $("#tipo_periodo").val(response.response.tipo_periodo);
//                        $("#num_unidades_periodo").val(response.response.num_unidades_periodo);
                        $("#id_programacion").val(response.response.id_programacion);
                        $('#dlgProgramacion').dialog('open');

                    },
                            'json'
                            );

                } else
                    Mensaje('Seleccione un valor de la grilla', 'Seleccione');
            });

    $("#anular_programacion")
            .button()
            .click(function() {

                var indexR = jQuery('#lsprogramacion').getGridParam("selrow");
                if (indexR != null) {

                    if (confirm('Desea anular el registro')) {

                        $.get(
                                URLINDEX + '/programacion/anular',
                                {
                                    ajax: 'ajax',
                                    id_programacion: indexR
                                },
                        function(response) {

                            jQuery('#lsprogramacion').trigger("reloadGrid");

                        },
                                'json'
                                );

                    }
                } else
                    Mensaje('Seleccione un valor de la grilla', 'Seleccione');

            });

    $('#dlgProgramacion').dialog({
        autoOpen: false,
        width: 450,
        position: 'top',
        modal: true,
        buttons: {
            Guardar: function() {

                $("#frm_programacion").submit();

            },
            Cancelar: function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            limpiaForm($('#oform'), false);
        }
    });

    $('#dlgCargos').dialog({
        autoOpen: false,
        width: 550,
        position: 'top',
        modal: true,
        buttons: {
            Cerrar: function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            limpiaForm($('#oform'), false);
        }
    });

    $("#asignar_cargos").button()
            .click(function() {

                var indexR = jQuery('#lsprogramacion').getGridParam("selrow");
                if (indexR != null) {

                    $.post(
                            URLINDEX + '/programacion/getCargos',
                            {
                                ajax: 'ajax',
                                id_programacion: indexR
                            }, //parametros

                    function(r) { //funcion para procesar los datos

                        $('#detalle tbody tr').remove();

                        $.each(r.response, function(idx, obj) {
                            var tr = '<tr>' +
                                    '<td width="45%">' + obj.oficina + '</td>' +
                                    '<td width="45%">' + obj.cargo + '</td>' +
                                    '<td width="10%"><a href="#" class="qCargo" id_cargo="' + obj.id_cargo + '" id_detalle="' + obj.id_cargos_asignados + '" title="Quitar Cargo"><img src="' + URLHOST + 'images/delete_otro.png"/></a></td>' +
                                    '</tr>';
                            $('#detalle tbody').append(tr);
                        });

                        $('#dlgCargos').dialog('open');
                    },
                            'json'//tipo de dato devuelto
                            );

                } else
                    Mensaje('Seleccione un valor de la grilla', 'Seleccione');
            });

    cargarCargos = function(idcargo) {

        $('#id_cargo option').remove();
        $('#id_cargo').append("<option value='-' >Cargando datos ....</option>");

        $.post(
                URLINDEX + '/oficina/getCargos',
                {
                    ajax: 'ajax',
                    id_oficina: $("#id_oficina").val()
                }, //parametros

        function(r) { //funcion para procesar los datos

            $('#id_cargo option').remove();
            var opcion;
            $.each(r.response, function(i) {

                opcion = "<option value='" + this.id_cargo + "' >" + this.descripcion + "</option>"
                $('#id_cargo').append(opcion);
            });

            $('#id_cargo').val(idcargo);

        },
                'json'//tipo de dato devuelto
                );

    };

    $("#agregar").button({
        icons: {
            primary: "ui-icon-document"
        },
        text: true
    }).bind('click', function(e) {

        if ($('#id_cargo').val() == null) {
            Mensaje('Seleccione un cargo');
            return;
        }

        var id_cargo = $('#id_cargo').val();

        var existe = false;
        $('#detalle tbody tr').each(function(idx, obj) {
            var id = $(this).find('.qCargo').attr('id_cargo');
            if (id == id_cargo) {
                existe = true;
            }
        });

        if (existe == true) {
            Mensaje('El cargo ya esta agregado');
            return;
        }

        var oficina = $("#id_oficina option:selected").text();
        var cargo = $("#id_cargo option:selected").text();

        var indexR = jQuery('#lsprogramacion').getGridParam("selrow");

        $.post(
                URLINDEX + '/programacion/agregarCargos',
                {
                    ajax: 'ajax',
                    id_cargo: id_cargo,
                    id_programacion: indexR
                }, //parametros

        function(r) { //funcion para procesar los datos

            var tr = '<tr>' +
                    '<td width="45%">' + $.trim(oficina) + '</td>' +
                    '<td width="45%">' + cargo + '</td>' +
                    '<td width="10%"><a href="#" class="qCargo" id_cargo="' + id_cargo + '" id_detalle="' + r.response.id_cargos_asignados + '" title="Quitar Cargo"><img src="' + URLHOST + 'images/delete_otro.png"/></a></td>' +
                    '</tr>';

            $('#detalle tbody').append(tr);

        },
                'json'//tipo de dato devuelto
                );

    });

    $(document).on('click', '.qCargo', function(e) {
        e.preventDefault();

        if (confirm("Desea quitar el cargo")) {
            var id = $(this).attr('id_detalle');
            var a = $(this);
            $.post(
                    URLINDEX + '/programacion/quitarCargos',
                    {
                        ajax: 'ajax',
                        id_cargos_asignados: id
                    }, //parametros

            function(r) { //funcion para procesar los datos

                $(a).parent().parent().remove();

            },
                    'json'//tipo de dato devuelto
                    );
        }
    });

    //////////////////////////////////////////////

    $(document).on('click', '.qPeriodo', function(e) {
        e.preventDefault();

        if (confirm("Desea quitar el periodo")) {

            var id = $(this).attr('id_periodo_programacion');
            var a = $(this);
            $.post(
                URLINDEX + '/programacion/quitarPeriodo',
                {
                    ajax: 'ajax',
                    id_periodo_programacion: id
                },
                function(r) { //funcion para procesar los datos
                    $(a).parent().parent().remove();
                },
                'json'//tipo de dato devuelto
            );
    
        }
    });
    
    $(document).on('click', '.qFecha', function(e) {
        e.preventDefault();

        if (confirm("Desea quitar la fecha")) {

            var id = $(this).attr('id_detalle_periodo');
            var a = $(this);
            $.post(
                URLINDEX + '/programacion/quitarFecha',
                {
                    ajax: 'ajax',
                    id_detalle_periodo: id
                },
                function(r) { //funcion para procesar los datos
                    $(a).parent().parent().remove();
                },
                'json'//tipo de dato devuelto
            );
    
        }
    });

    $(document).on('change', '.selPeriodo', function(e) {
        e.preventDefault();

        var id = $(this).attr('id_periodo_programacion');
        
        cargarFechas(id);

    });

    $('#dlgDetalle').dialog({
        autoOpen: false,
        width: 700,
        position: 'top',
        modal: true,
        buttons: {
            Cerrar: function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            limpiaForm($('#oform'), false);
        }
    });

    $('#dlgAddPeriodo').dialog({
        autoOpen: false,
        width: 200,
        position: 'top',
        modal: true,
        buttons: {
            Guardar: function() {
                var indexR = jQuery('#lsprogramacion').getGridParam("selrow");
                var mes = $('#mes').val();
                var anio = $('#anio').val();

                $.post(
                        URLINDEX + '/programacion/guardarPeriodo',
                        {
                            ajax: 'ajax',
                            id_programacion: indexR,
                            mes: mes,
                            anio: anio
                        }, //parametros
                function(response) { //funcion para procesar los datos
                    if (response.code && response.code == 'ERROR') {
                        Mensaje(response.message);
                    } else {
                        cargarPeriodo(indexR);
                        $('#dlgAddPeriodo').dialog('close');
                    }
                },
                        'json'//tipo de dato devuelto
                        );
            },
            Cerrar: function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            limpiaForm($('#oform'), false);
        }
    });

    $('#dlgFechas').dialog({
        autoOpen: false,
        width: 300,
        position: 'top',
        modal: true,
        buttons: {
            Guardar: function() {
                
                if ($('#f_fecha_mensaje').val() == ''){
                    Mensaje('Seleccione fecha envio');
                    return;
                }
                if ($('#f_fecha_final').val() == ''){
                    Mensaje('Seleccione fecha fin tarea');
                    return;
                }
                
                var id = $('.selPeriodo:checked').attr('id_periodo_programacion');
                
                $.post(
                        URLINDEX + '/programacion/guardarFecha',
                        {
                            ajax: 'ajax',
                            id_periodo_programacion: id,
                            fecha_mensaje: $('#f_fecha_mensaje').val(),
                            fecha_final: $('#f_fecha_final').val()
                        }, //parametros
                        function(response) { //funcion para procesar los datos
                            if (response.code && response.code == 'ERROR') {
                                Mensaje(response.message);
                            } else {
                                cargarFechas(id);
                                $('#dlgFechas').dialog('close');
                            }
                        },
                        'json'//tipo de dato devuelto
                );
            },
            Cerrar: function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            limpiaForm($('#oform'), false);
        }
    });
    
    $(".addPeriodo").click(function() {
        $('#dlgAddPeriodo').dialog('open');
    });

    $("#fechas_alertas").button().click(function() {
        var indexR = jQuery('#lsprogramacion').getGridParam("selrow");
        if (indexR != null) {

            var datos = jQuery('#lsprogramacion').getRowData(indexR);
            $('#nProgramacion').val(datos['p.descripcion']);

            cargarPeriodo(indexR);

            $('#dlgDetalle').dialog('open');
        } else
            Mensaje('Seleccione un valor de la grilla', 'Seleccione');
    });
    
    $(".addFechas").click(function() {
        
        if($('.selPeriodo:checked').length > 0){
            $('#dlgFechas').dialog('open');
        }else{
            Mensaje('Seleccione un periodo');
        }
        
    });

    $('#DlgMasivo').dialog({
        autoOpen: false,
        width: 320,
        position: 'top',
        modal: true,
        buttons: {
            Agregar: function() {
                
                if($('#lsFechasAdd tbody tr').length == 0){
                    Mensaje('Ingrese fechas');
                    return;
                }
                
                var fechas = [];
                $('#lsFechasAdd tbody tr').each(function(idx,obj){
                    fechas.push({
                        inicio : $(obj).find('.inicio').text(),
                        fin : $(obj).find('.fin').text()
                    });
                });
                
                $.post(
                        URLINDEX + '/programacion/asignarFechas',
                        {
                            ajax: 'ajax',
                            tipo_pe: $('#tipo_pe').val(),
                            anio_per: $('#anio_per').val(),
                            mes_per: $('#mes_per').val(),
                            fechas : fechas
                        }, //parametros
                        function(response) { //funcion para procesar los datos
                            if (response.code && response.code == 'ERROR') {
                                Mensaje(response.message);
                            } else {
                                Mensaje('Datos asignados correctamente<br/>Detalle:<br/>Total de alertas: ' + response.response.total + '<br/>Total Asignados: ' + response.response.registrados);
                                $('#DlgMasivo').dialog('open');
                            }
                        },
                        'json'//tipo de dato devuelto
                );
                
            },
            Cerrar: function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            limpiaForm($('#oform'), false);
        }
    });
    
    $('#dlgFechasAdd').dialog({
        autoOpen: false,
        width: 320,
        position: 'top',
        modal: true,
        buttons: {
            Agregar: function() {
                
                if($('#f_fecha_mensaje_add').val() == ''){
                    Mensaje('Seleccione fecha mensaje');
                    return;
                }
                if($('#f_fecha_final_add').val() == ''){
                    Mensaje('Seleccione fecha final');
                    return;
                }
                
                var tr = '<tr>' +
                        '<th width="45%" style="text-align: left;"><label class="inicio">' + $('#f_fecha_mensaje_add').val() + '</label></th>' +
                        '<th width="45%" style="text-align: left;"><label class="fin">' + $('#f_fecha_final_add').val() + '</label></th>' +
                        '<th width="5%"><a href="#" title="Quitar Fecha" class="qFechaAdd" ><img src="' + URLHOST + 'images/delete_otro.png"/></a></th>' +
                '</tr>';

                $('#lsFechasAdd tbody').append(tr);
                
                $(this).dialog("close");
            },
            cerrar: function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            limpiaForm($('#oform'), false);
        }
    });

    $(".addFechasAdd").click(function() {
        $('#dlgFechasAdd').dialog('open');   
        $('#f_fecha_mensaje_add').val('');
        $('#f_fecha_final_add').val('');
    });
    
    $("#fechas_masivas").button().click(function() {
        $('#DlgMasivo').dialog('open');
        $('#lsFechasAdd tbody tr').remove();
    });
    
    $(document).on('click', '.qFechaAdd', function(e) {
        e.preventDefault();

        $(this).parent().parent().remove();
        
    });

});

function cargarFechas(id_periodo_programacion){
    $.post(
            URLINDEX + '/programacion/getFechasPeriodo',
            {
                ajax: 'ajax',
                id_periodo_programacion: id_periodo_programacion
            }, //parametros
    function(response) { //funcion para procesar los datos
        if (response.code && response.code == 'ERROR') {
            Mensaje(response.message);
        } else {

            $('#lsFechas tbody tr').remove();

            $.each(response.response, function(idx, obj) {
                var tr = '<tr>' +
                        '<th width="5%"></th>' +
                        '<th width="45%" style="text-align: left;"><label for="rb_' + obj.id_detalle_periodo + '">' + ponerformatofecha(obj.fecha_mensaje) + '</label></th>' +
                        '<th width="45%" style="text-align: left;"><label for="rb_' + obj.id_detalle_periodo + '">' + ponerformatofecha(obj.fecha_final) + '</label></th>' +
                        '<th width="5%"><a href="#" title="Quitar Fecha" class="qFecha" id_detalle_periodo="' + obj.id_detalle_periodo + '"><img src="' + URLHOST + 'images/delete_otro.png"/></a></th>' +
                '</tr>';

                $('#lsFechas tbody').append(tr);

            });

        }
    },
            'json'//tipo de dato devuelto
            );
}

function cargarPeriodo(id_programacion) {
    $.post(
            URLINDEX + '/programacion/getPeriodo',
            {
                ajax: 'ajax',
                id_programacion: id_programacion
            }, //parametros
    function(response) { //funcion para procesar los datos
        if (response.code && response.code == 'ERROR') {
            Mensaje(response.message);
        } else {

            $('#lsPeriodos tbody tr').remove();

            $.each(response.response, function(idx, obj) {
                var tr = '<tr>' +
                        '<th width="5%"><input type="radio" name="rbPeriodo" value="" id="rb_' + obj.id_periodo_programacion + '" id_periodo_programacion="' + obj.id_periodo_programacion + '" class="selPeriodo"/></th>' +
                        '<th width="90%" style="text-align: left;"><label for="rb_' + obj.id_periodo_programacion + '">' + mes(obj.mes) + ' - ' + obj.anio + '</label></th>' +
                        '<th width="5%"><a href="#" title="Quitar Periodo" class="qPeriodo" id_periodo_programacion="' + obj.id_periodo_programacion + '"><img src="' + URLHOST + 'images/delete_otro.png"/></a></th>' +
                '</tr>';

                $('#lsPeriodos tbody').append(tr);

            });

        }
    },
            'json'//tipo de dato devuelto
            );
}

function mes(mes) {
    var nMes = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
    return nMes[mes - 1];
}