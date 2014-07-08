$(document).ready(function(){
    
    $("#fecha_fin").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });
    
    $('#dlgMensajesEnviados').dialog({
        autoOpen: false,
        width: 500,
        position: 'top',
        modal: true,
        buttons: {
            Cerrar: function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            $('#fecha_fin').val('');
            $('#observaciones').val('');
        }
    });
                        
        $( "#nuevo_alertas" ).button().click(function() {
            var indexR = jQuery('#lsalertas').getGridParam("selrow");
            if (indexR != null){
                
                $.post(
                    URLINDEX + '/alertas/getListaMensajes',
                    {
                        ajax: 'ajax',
                        id_alertas:indexR
                    }, //parametros
                    function(response) { //funcion para procesar los datos
                        
                        $('#lsMensajesEnviados tbody tr').remove();

                        $.each(response.response, function(idx, obj) {
                            var tr = '<tr>' +
                                    '<th width="10%" style="text-align: left;"><label>' + obj.fecha_envio + '</label></th>' +
                                    '<th width="85%" style="text-align: left;"><label>' + obj.destinatario + '</label></th>' +
                                    '<th width="5%"><a href="#" title="Ver Mensaje" class="vMensaje" id_mensajes_enviados="' + obj.id_mensajes_enviados + '"><img src="' + URLHOST + 'images/editar.png"/></a></th>' +
                            '</tr>';

                            $('#lsMensajesEnviados tbody').append(tr);

                        });
                        
                        $('#dlgMensajesEnviados').dialog('open');
                    },
                    'json'//tipo de dato devuelto
                );
                
                
            }else
                Mensaje('Seleccione un valor de la grilla','Seleccione');
        });
                
        $( "#recepcionar_alertas" ).button()
                .click(function() {

                    var indexR = jQuery('#lsalertas').getGridParam("selrow");
                    if (indexR != null){
                        
                        $('#dlgRecepcionar').dialog({
                            autoOpen: true,
                            width: 500,
                            position: 'top',
                            modal: true,
                            buttons: {
                                Recepcionar: function() {

                                    if ($('#fecha_fin').val() == ''){
                                        Mensaje('Seleccione fecha fin');
                                        return;
                                    }
                                    if ($('#observaciones').val() == ''){
                                        Mensaje('Ingrese observaciones');
                                        return;
                                    }
                                    
                                    $.post(
                                        URLINDEX + '/alertas/recepcionar',
                                        {
                                            ajax: 'ajax',
                                            id_alertas:indexR,
                                            fecha_fin: $('#fecha_fin').val(),
                                            observaciones: $('#observaciones').val()
                                        }, //parametros
                                        function(response) { //funcion para procesar los datos
                                            jQuery('#lsalertas').trigger('reloadGrid');
                                            $('#dlgRecepcionar').dialog("close");
                                        },
                                        'json'//tipo de dato devuelto
                                    );

                                },
                                Cerrar: function() {
                                    $(this).dialog("close");
                                }
                            },
                            close: function() {
                                $('#fecha_fin').val('');
                                $('#observaciones').val('');
                            }
                        });

                    }else
                        Mensaje('Seleccione un valor de la grilla','Seleccione');
                });
                
    $(document).on('click', '.vMensaje', function(e) {
        e.preventDefault();

            var id = $(this).attr('id_mensajes_enviados');
            var a = $(this);
            $.post(
                    URLINDEX + '/alertas/getMensaje',
                    {
                        ajax: 'ajax',
                        id_mensajes_enviados: id
                    }, //parametros

            function(r) { //funcion para procesar los datos

                $('#valMsg').html(r.response.mensaje);

                $('#dlgVerMensaje').dialog({
                    autoOpen: true,
                    width: 500,
                    position: 'top',
                    modal: true,
                    buttons: {
                        Cerrar: function() {
                            $(this).dialog("close");
                        }
                    },
                    close: function() {
                        $('#fecha_fin').val('');
                        $('#observaciones').val('');
                    }
                });

            },
                    'json'//tipo de dato devuelto
                    );
    });
              
    $( "#reenviar_alertas" ).button().click(function() {
        var s;
	s = jQuery("#lsalertas").jqGrid('getGridParam','selarrrow');
        s = s + '';
        
        if (s != ''){
            
            $.post(
                URLINDEX + '/programacion/reenviarMensajes',
                {
                    ajax: 'ajax',
                    alertas:s
                }, //parametros
                function(response) { //funcion para procesar los datos
                    Mensaje('Alertas reenviadas');
                },
                'json'//tipo de dato devuelto
            );
            
        }else{
            Mensaje('Seleccione una alerta');
        }
    });
});