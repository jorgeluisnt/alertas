$(document).ready(function(){

        // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!

        limpiaForm($('#frm_tipo_oficina'),false);
        
        $("#frm_tipo_oficina").validate({
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
                        URLINDEX + '/tipo_oficina/guardar',
                        {
                            ajax:'ajax',                            
                            descripcion :$("#descripcion").val().toUpperCase(),
                            id_tipo_oficina :$("#id_tipo_oficina").val()
                        },//parametros
                        function(response){ //funcion para procesar los datos
                            limpiaForm($('#frm_tipo_oficina'),false);
                            if (response.code && response.code == 'ERROR'){
                                Mensaje(response.message);
                            }else{
                                jQuery('#lstipo_oficina').trigger('reloadGrid');
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

        $( "#guardar_tipo_oficina" ).button()
                .click(function() {
                    $("#frm_tipo_oficina").submit(); 
                });
        
        $( "#cancelar_tipo_oficina" ).button()
                .click(function() {
                    limpiaForm($('#frm_tipo_oficina'),false);
                });
        

        $( "#nuevo_tipo_oficina" ).button()
                .click(function() {
                        limpiaForm($('#frm_tipo_oficina'),true);
                        $("#id_tipo_oficina").val(-1)
                });

        $( "#modificar_tipo_oficina" ).button()
                .click(function() {

                    var indexR = jQuery('#lstipo_oficina').getGridParam("selrow");
                    if (indexR != null){

                        $.get(
                            URLINDEX + '/tipo_oficina/get',
                            {
                                ajax:'ajax',
                                id_tipo_oficina:indexR
                            },

                            function(response){
                                limpiaForm($('#frm_tipo_oficina'),true);                  
                                $("#descripcion").val(response.response.descripcion),
                                $("#id_tipo_oficina").val(response.response.id_tipo_oficina)

                            },
                            'json'
                        );

                    }else
                        Mensaje('Seleccione un valor de la grilla','Seleccione');
                });

        $( "#anular_tipo_oficina" )
                .button()
                .click(function() {

                    var indexR = jQuery('#lstipo_oficina').getGridParam("selrow");
                    if (indexR != null){

                        if(confirm('Desea anular el registro')){

                            $.get(
                                URLINDEX + '/tipo_oficina/anular',
                                {
                                    ajax:'ajax',
                                    id_tipo_oficina:indexR
                                },

                                function(response){

                                    jQuery('#lstipo_oficina').trigger("reloadGrid");

                                },
                                'json'
                            );

                        }
                    }else
                        Mensaje('Seleccione un valor de la grilla','Seleccione');
                    
                });

});