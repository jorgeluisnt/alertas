$(document).ready(function(){

        // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!

        limpiaForm($('#frm_plantilla_mensajes'),false);
        
        $("#frm_plantilla_mensajes").validate({
            rules: {
                descripcion:  {required: true}
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
                            ajax:'ajax',                            
                            descripcion :$("#descripcion").val().toUpperCase(),
                            id_plantilla_mensajes :$("#id_plantilla_mensajes").val()
                        },//parametros
                        function(response){ //funcion para procesar los datos
                            limpiaForm($('#frm_plantilla_mensajes'),false);
                            if (response.code && response.code == 'ERROR'){
                                Mensaje(response.message);
                            }else{
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

        $( "#guardar_plantilla_mensajes" ).button()
                .click(function() {
                    $("#frm_plantilla_mensajes").submit(); 
                });
        
        $( "#cancelar_plantilla_mensajes" ).button()
                .click(function() {
                    limpiaForm($('#frm_plantilla_mensajes'),false);
                });
        

        $( "#nuevo_plantilla_mensajes" ).button()
                .click(function() {
                        limpiaForm($('#frm_plantilla_mensajes'),true);
                        $("#id_plantilla_mensajes").val(-1)
                });

        $( "#modificar_plantilla_mensajes" ).button()
                .click(function() {

                    var indexR = jQuery('#lsplantilla_mensajes').getGridParam("selrow");
                    if (indexR != null){

                        $.get(
                            URLINDEX + '/plantilla_mensajes/get',
                            {
                                ajax:'ajax',
                                id_plantilla_mensajes:indexR
                            },

                            function(response){
                                limpiaForm($('#frm_plantilla_mensajes'),true);                  
                                $("#descripcion").val(response.response.descripcion),
                                $("#id_plantilla_mensajes").val(response.response.id_plantilla_mensajes)

                            },
                            'json'
                        );

                    }else
                        Mensaje('Seleccione un valor de la grilla','Seleccione');
                });

        $( "#anular_plantilla_mensajes" )
                .button()
                .click(function() {

                    var indexR = jQuery('#lsplantilla_mensajes').getGridParam("selrow");
                    if (indexR != null){

                        if(confirm('Desea anular el registro')){

                            $.get(
                                URLINDEX + '/plantilla_mensajes/anular',
                                {
                                    ajax:'ajax',
                                    id_plantilla_mensajes:indexR
                                },

                                function(response){

                                    jQuery('#lsplantilla_mensajes').trigger("reloadGrid");

                                },
                                'json'
                            );

                        }
                    }else
                        Mensaje('Seleccione un valor de la grilla','Seleccione');
                    
                });

});