$(document).ready(function(){
        
        
        $("#id_oficina").comboEdit( {           
            form:'#oform',
            alto:400,
            ancho:380,
            titulo:'Oficinas',
            url_form:URLINDEX + '/oficina/datos',
            url_js: URLHOST+ 'js/modulos/oficina.js',
            url_guardar:URLINDEX + '/oficina/guardar',
            url_datos:'oficina/getOficinas',
            url_get:URLINDEX + '/oficina/get',
            fn_antes_nuevo:null,
            campo:'nombre',
            id:'id_oficina',
            defecto:null,
            params:[]
        });
        
	/* setup navigation, content boxes, etc... */
	limpiaForm($('#cargosform'),false);

        $("#cargosform").validate({
            rules: {
                descripcion:  {
				required: true,
				minlength: 2,
                                maxlength: 100
			},
                id_oficina  : {
				required: true
			},
                id_perfil  : {
				required: true
			}
            },
            messages: {
                descripcion: {
				required: "Ingrese telefono",
				minlength: "Ingrese mas de 2 caracteres",
                                maxlength: "Ingrese menos de 100 caracteres"
			}
            },
            // the errorPlacement has to take the layout into account
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent().find('label:first'));
            },
            submitHandler: function() {

                    $.post(
                        URLINDEX + '/cargo/guardar',
                        {
                            ajax:'ajax',
                            descripcion:$("#descripcion").val().toUpperCase(),
                            id_oficina:$("#id_oficina").val(),
                            id_perfil:$("#id_perfil").val(),
                            id_cargo:$("#id_cargo").val()
                        },//parametros

                        function(response){ //funcion para procesar los datos
                            limpiaForm($('#cargosform'),false);
                            if (response.code && response.code == 'ERROR'){
                                Mensaje(response.message,'Error');
                            }else{
                                jQuery('#TTabla').trigger('reloadGrid');
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


        $( "#nuevo" ).button()
                .click(function() {
                        limpiaForm($('#cargosform'),true);
                        $("#id_cargo").val(-1)
                });

        $( "#guardar_modulos" ).button()
                .click(function() {
                    $("#cargosform").submit(); 
                });
        
        $( "#cancelar_modulos" ).button()
                .click(function() {
                    limpiaForm($('#cargosform'),false);
                });

        $("#modificar").button().bind('click', function(e){

            var indexR = jQuery('#TTabla').getGridParam("selrow");

            if(indexR != null){

                $.post(
                    URLINDEX + '/cargo/get',
                    {
                        ajax:'ajax',
                        id_cargo:indexR
                    },//parametros

                    function(response){ //funcion para procesar los datos
                        limpiaForm($('#cargosform'),true);
                        $("#descripcion").val(response.response.descripcion);
                        $("#id_oficina").val(response.response.id_oficina);
                        $("#id_perfil").val(response.response.id_perfil);
                        $("#id_cargo").val(response.response.id_cargo);
                    },
                    'json'//tipo de dato devuelto
                );

            }else{
                Mensaje("Seleccione un registro para modificar");
            }

        });

        $("#eliminar").button().bind('click', function(e){

            var indexR = jQuery('#TTabla').getGridParam("selrow");

            if(indexR != null){

                if(confirm('Seguro de anular el registro')){

                    $.post(
                        URLINDEX + '/cargo/anular',
                        {
                            ajax:'ajax',
                            id_cargo:indexR
                        },//parametros

                        function(response){ //funcion para procesar los datos
                            jQuery('#TTabla').trigger('reloadGrid');
                        },
                        'json'//tipo de dato devuelto
                    );
                }

            }else{
                Mensaje("Seleccione un registro para eliminar");
            }

        });
        
});