$(document).ready(function() {

    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $('#mensaje').jqte();
        
    limpiaForm($('#frm_plantilla_mensajes'), false);

    $("#frm_plantilla_mensajes").validate({
        rules: {
            descripcion: {required: true}
        },
        messages: {
            descripcion: {required: "Ingrese descripcion"}
        },
        // the errorPlacement has to take the layout into account
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent().find('label:first'));
        },
        submitHandler: function() {

            $.post(
                    URLINDEX + '/plantilla_mensajes/guardar',
                    {
                        ajax: 'ajax',
                        descripcion: $("#descripcion").val().toUpperCase(),
                        id_plantilla_mensajes: $("#id_plantilla_mensajes").val()
                    }, //parametros
            function(response) { //funcion para procesar los datos
                limpiaForm($('#frm_plantilla_mensajes'), false);
                if (response.code && response.code == 'ERROR') {
                    Mensaje(response.message);
                } else {
                    jQuery('#lsplantilla_mensajes').trigger('reloadGrid');
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

    $("#guardar_plantilla_mensajes").button()
            .click(function() {
                $("#frm_plantilla_mensajes").submit();
            });

    $("#cancelar_plantilla_mensajes").button()
            .click(function() {
                limpiaForm($('#frm_plantilla_mensajes'), false);
            });


    $("#nuevo_plantilla_mensajes").button()
            .click(function() {
                limpiaForm($('#frm_plantilla_mensajes'), true);
                $("#id_plantilla_mensajes").val(-1)
            });

    $("#modificar_plantilla_mensajes").button()
            .click(function() {

                var indexR = jQuery('#lsplantilla_mensajes').getGridParam("selrow");
                if (indexR != null) {

                    $.get(
                            URLINDEX + '/plantilla_mensajes/get',
                            {
                                ajax: 'ajax',
                                id_plantilla_mensajes: indexR
                            },
                    function(response) {
                        limpiaForm($('#frm_plantilla_mensajes'), true);
                        $("#descripcion").val(response.response.descripcion),
                                $("#id_plantilla_mensajes").val(response.response.id_plantilla_mensajes)

                    },
                            'json'
                            );

                } else
                    Mensaje('Seleccione un valor de la grilla', 'Seleccione');
            });

    $("#anular_plantilla_mensajes")
            .button()
            .click(function() {

                var indexR = jQuery('#lsplantilla_mensajes').getGridParam("selrow");
                if (indexR != null) {

                    if (confirm('Desea anular el registro')) {

                        $.get(
                                URLINDEX + '/plantilla_mensajes/anular',
                                {
                                    ajax: 'ajax',
                                    id_plantilla_mensajes: indexR
                                },
                        function(response) {

                            jQuery('#lsplantilla_mensajes').trigger("reloadGrid");

                        },
                                'json'
                                );

                    }
                } else
                    Mensaje('Seleccione un valor de la grilla', 'Seleccione');

            });

    $('#dlgPlantilla').dialog({
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
    
    $('#dlgFormato').dialog({
        autoOpen: false,
        width: 750,
        height : 400,
        position: 'top',
        modal: true,
        buttons: {
            Guardar: function() {
                
                if ($('#numero').val() == ''){
                    Mensaje('Ingrese un numero de mensaje');
                    return;
                }
                if ($('#mensaje').val().trim() == ''){
                    Mensaje('Ingrese un mensaje');
                    return;
                }
                
                var indexR = jQuery('#lsplantilla_mensajes').getGridParam("selrow");
                
                $.post(
                    URLINDEX + '/plantilla_mensajes/guardarDetalle',
                    {
                        ajax: 'ajax',
                        numero: $("#numero").val().toUpperCase(),
                        mensaje: $("#mensaje").val().trim(),
                        id_detalle_plantilla: $("#numero").data('id_detalle_plantilla'),
                        id_plantilla_mensajes : indexR
                    }, //parametros
                    function(response) { //funcion para procesar los datos

                        if (response.code && response.code == 'ERROR') {
                            Mensaje(response.message);
                        } else {
                            CargarDetalles(indexR);
                            $('#dlgFormato').dialog('close');
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
            $('#numero').val('');
            $('#mensaje').jqteVal('');
        }
    });
    
    $('#plantilla').button().click(function(){
        
        var indexR = jQuery('#lsplantilla_mensajes').getGridParam("selrow");
        if (indexR != null) {
            
            CargarDetalles(indexR);
            $("#numero").data('id_detalle_plantilla','-1');
            $('#dlgPlantilla').dialog('open');

        } else
            Mensaje('Seleccione un valor de la grilla', 'Seleccione');

    });
    
    $('.addDetalle').click(function(){
        
        $('#numero').data('id_detalle_plantilla','-1');
        $('#dlgFormato').dialog('open');

    });
    
    $(document).on('click', '.qDetalle', function(e) {
        e.preventDefault();

        var id = $(this).attr('id_detalle_plantilla');
        var a = $(this);
        
        if (confirm('Desea anular el registro')) {

            $.get(
                URLINDEX + '/plantilla_mensajes/anularDetalle',
                {
                    ajax: 'ajax',
                    id_detalle_plantilla: id
                },
                function(response) {

                    $(a).parent().parent().remove();

                },
                'json'
            );

        }

    });
    
    $(document).on('click', '.mDetalle', function(e) {
        e.preventDefault();

        var id = $(this).attr('id_detalle_plantilla');
        var a = $(this);
        
        $.get(
            URLINDEX + '/plantilla_mensajes/getDetalleObj',
            {
                ajax: 'ajax',
                id_detalle_plantilla: id
            },
            function(response) {

                $('#numero').val(response.response.numero);
                $('#numero').data('id_detalle_plantilla',response.response.id_detalle_plantilla);
                $('#mensaje').jqteVal(response.response.mensaje);
                $('#dlgFormato').dialog('open');
                
            },
            'json'
        );

    });
    
});

function CargarDetalles(id_plantilla_mensajes){
    $.post(
        URLINDEX + '/plantilla_mensajes/getDetalle',
        {
            ajax: 'ajax',
            id_plantilla_mensajes: id_plantilla_mensajes
        }, //parametros
        function(response) { //funcion para procesar los datos
            if (response.code && response.code == 'ERROR') {
                Mensaje(response.message);
            } else {

                $('#lsDetalles tbody tr').remove();

                $.each(response.response, function(idx, obj) {
                    var tr = '<tr>' +
                            '<th width="10%"><label>' + obj.numero + '</label></th>' +
                            '<th width="80%"><label style="float: left;text-align: left;">' + obj.mensaje + '</label></th>' +
                            '<th width="10%">' +
                                '<a href="#" title="Modificar Detalle" class="mDetalle" id_detalle_plantilla="' + obj.id_detalle_plantilla + '"><img src="' + URLHOST + 'images/editar.png"/></a>' + 
                                '&nbsp;&nbsp;&nbsp;<a href="#" title="Quitar Detalle" class="qDetalle" id_detalle_plantilla="' + obj.id_detalle_plantilla + '"><img src="' + URLHOST + 'images/delete_otro.png"/></a>' + 
                                '</th>' +
                    '</tr>';

                    $('#lsDetalles tbody').append(tr);

                });

            }
        },
        'json'//tipo de dato devuelto
    );
}