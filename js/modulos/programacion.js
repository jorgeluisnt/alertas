$(document).ready(function() {

    limpiaForm($('#frm_programacion'), false);

    $("#fecha_inicia_alerta").datepicker({
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
            num_unidades_periodo: {required: true}
        },
        messages: {
            descripcion: {required: "Ingrese descripcion"},
            fecha_inicia_alerta: {required: "Ingrese Inicia Alertas"},
            num_dias_entre_mensaje: {required: "Ingrese Dias Entre Mensajes"},
            num_max_mensajes: {required: "Ingrese Num Max Mensajes"},
            num_unidades_periodo: {required: "Ingrese Numero Periodo"}
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
                        fecha_inicia_alerta: $("#fecha_inicia_alerta").val().toUpperCase(),
                        id_plantilla_mensajes: $("#id_plantilla_mensajes").val().toUpperCase(),
                        num_dias_entre_mensaje: $("#num_dias_entre_mensaje").val().toUpperCase(),
                        num_max_mensajes: $("#num_max_mensajes").val().toUpperCase(),
                        tipo_periodo: $("#tipo_periodo").val().toUpperCase(),
                        num_unidades_periodo: $("#num_unidades_periodo").val().toUpperCase(),
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
                        $("#fecha_inicia_alerta").val(response.response.fecha_inicia_alerta);
                        $("#id_plantilla_mensajes").val(response.response.id_plantilla_mensajes);
                        $("#num_dias_entre_mensaje").val(response.response.num_dias_entre_mensaje);
                        $("#num_max_mensajes").val(response.response.num_max_mensajes);
                        $("#tipo_periodo").val(response.response.tipo_periodo);
                        $("#num_unidades_periodo").val(response.response.num_unidades_periodo);
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
            var id = $(this).find('.id_cargos_asignados').val();
            if (id == id_cargo) {
                existe = true;
            }
        });

        if (existe == true) {
            Mensaje('El cargo ya esta agregado');
            return;
        }

        var indexR = jQuery('#lsprogramacion').getGridParam("selrow");

        $.post(
                URLINDEX + '/programacion/agregarCargos',
                {
                    ajax: 'ajax',
                    id_cargo: id_cargo,
                    id_programacion: indexR
                }, //parametros

        function(r) { //funcion para procesar los datos

            

        },
                'json'//tipo de dato devuelto
                );

    });

});