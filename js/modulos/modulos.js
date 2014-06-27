$(document).ready(function(){

        // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!

        limpiaForm($('#frm_Modulos'),false);
        
        $("#frm_Modulos").validate({
            rules: {
                descripcion:  {
				required: true
			},
                url  : {
				required: true
			},
                orden  : {
				required: true
			},
                id_padre :{
                    required: true
                }
            },
            messages: {
                descripcion: {
				required: "Ingrese Descripcion"
			},
                url: {
				required: "Ingrese Url"
			},
                orden: {
				required: "Ingrese Orden"
			}
            },
            // the errorPlacement has to take the layout into account
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent().find('label:first'));
            },
            submitHandler: function() {

                    $.post(
                        URLINDEX + '/modulos/guardar',
                        {
                            ajax:'ajax',
                            descripcion :$("#descripcion").val(),
                            url :$("#url").val(),
                            id_padre :$("#id_padre").val(),
                            orden :$("#orden").val(),
                            id_modulos :$("#id_modulos").val()
                        },//parametros
                        function(response){ //funcion para procesar los datos
                            limpiaForm($('#frm_Modulos'),false);
                            if (response.code && response.code == 'ERROR'){
                                Mensaje(response.message);
                            }else{
                                jQuery('#lsmodulos').trigger('reloadGrid');
                                actualizarCombo('id_padre','modulos/getModulos','id_modulos','descripcion',null,'0','Ninguno');
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
        
        $( "#guardar_modulos" ).button()
                .click(function() {
                    $("#frm_Modulos").submit(); 
                });
        
        $( "#cancelar_modulos" ).button()
                .click(function() {
                    limpiaForm($('#frm_Modulos'),false);
                });
        

        $( "#nuevo_modulos" ).button()
                .click(function() {
                        limpiaForm($('#frm_Modulos'),true);
                        $("#id_modulos").val(-1)
                });

        $( "#modificar_modulos" ).button()
                .click(function() {

                    var indexR = jQuery('#lsmodulos').getGridParam("selrow");
                    if (indexR != null){
                        
                        $.get(
                            URLINDEX + '/modulos/get',
                            {
                                ajax:'ajax',
                                id_modulos:indexR
                            },

                            function(response){
                                limpiaForm($('#frm_Modulos'),true);
                                $("#descripcion").val(response.response.descripcion),
                                $("#url").val(response.response.url),
                                $("#id_padre").val(response.response.id_padre),
                                $("#orden").val(response.response.orden),
                                $("#id_modulos").val(response.response.id_modulos)

                            },
                            'json'
                        );

                    }else
                        Mensaje('Seleccione un valor de la grilla','Seleccione');
                });

        $( "#anular_modulos" )
                .button()
                .click(function() {

                    var indexR = jQuery('#lsmodulos').getGridParam("selrow");
                    if (indexR != null){

                        if(confirm('Desea anular el registro')){

                            $.get(
                                'modulos/anular',
                                {
                                    ajax:'ajax',
                                    id_modulos:indexR
                                },

                                function(response){
                                    actualizarCombo('id_padre','modulos/getModulos','id_modulos','descripcion','0','Ninguno');
                                    jQuery('#lsmodulos').trigger("reloadGrid");

                                },
                                'json'
                            );

                        }
                    }else
                        Mensaje('Seleccione un valor de la grilla','Seleccione');
                    
                });

});