$(document).ready(function(){

        // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!

        limpiaForm($('#frm_municipalidad'),false);
        
        $("#frm_municipalidad").validate({
            rules: {
                razon_social:  {required: true},
                direccion:  {required: true},
                ruc:  {required: true}
            },
            messages: {
                                
                razon_social: {required: "Ingrese la Razon Social"},
                direccion: {required: "Ingrese Direccion"},
                ruc: {required: "Ingrese RUC"}
            },
            // the errorPlacement has to take the layout into account
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent().find('label:first'));
            },
            submitHandler: function() {

                    $.post(
                        URLINDEX + '/municipalidad/guardar',
                        {
                            ajax:'ajax',                            
                            razon_social :$("#razon_social").val().toUpperCase(),          
                            direccion :$("#direccion").val().toUpperCase(),
                            ruc :$("#ruc").val(),
                            telefonos :$("#telefonos").val(),
                            id_municipalidad :$("#id_municipalidad").val()
                        },//parametros
                        function(response){ //funcion para procesar los datos
                            limpiaForm($('#frm_municipalidad'),false);
                            if (response.code && response.code == 'ERROR'){
                                Mensaje(response.message);
                            }else{
                                jQuery('#lsmunicipalidad').trigger('reloadGrid');
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

        $( "#guardar_municipalidad" ).button()
                .click(function() {
                    $("#frm_municipalidad").submit(); 
                });
        
        $( "#cancelar_municipalidad" ).button()
                .click(function() {
                    limpiaForm($('#frm_municipalidad'),false);
                });
        

        $( "#nuevo_municipalidad" ).button()
                .click(function() {
                        limpiaForm($('#frm_municipalidad'),true);
                        $("#id_municipalidad").val(-1)
                });

        $( "#modificar_municipalidad" ).button()
                .click(function() {

                    var indexR = jQuery('#lsmunicipalidad').getGridParam("selrow");
                    if (indexR != null){

                        $.get(
                            URLINDEX + '/municipalidad/get',
                            {
                                ajax:'ajax',
                                id_municipalidad:indexR
                            },

                            function(response){
                                limpiaForm($('#frm_municipalidad'),true);                  
                                $("#razon_social").val(response.response.razon_social),
                                $("#direccion").val(response.response.direccion),
                                $("#ruc").val(response.response.ruc),
                                $("#telefonos").val(response.response.telefonos),
                                $("#id_municipalidad").val(response.response.id_municipalidad)

                            },
                            'json'
                        );

                    }else
                        Mensaje('Seleccione un valor de la grilla','Seleccione');
                });

        $( "#anular_municipalidad" )
                .button()
                .click(function() {

                    var indexR = jQuery('#lsmunicipalidad').getGridParam("selrow");
                    if (indexR != null){

                        if(confirm('Desea anular el registro')){

                            $.get(
                                URLINDEX + '/municipalidad/anular',
                                {
                                    ajax:'ajax',
                                    id_municipalidad:indexR
                                },

                                function(response){

                                    jQuery('#lsmunicipalidad').trigger("reloadGrid");

                                },
                                'json'
                            );

                        }
                    }else
                        Mensaje('Seleccione un valor de la grilla','Seleccione');
                    
                });

});