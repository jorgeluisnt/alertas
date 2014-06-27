$(document).ready(function(){
	/* setup navigation, content boxes, etc... */
        
        limpiaForm($('#oform'),false)
        
        $('#id_tipo_oficina').comboEdit(
            {
                form:'#frm_tipo_oficina',
                alto:200,
                ancho:300,
                titulo:'Tipo Oficina',
                url_form:URLINDEX + '/tipo_oficina/datos',
                url_js:URLHOST + '/js/modulos/tipo_oficina.js',
                url_guardar:URLINDEX + '/tipo_oficina/guardar',
                url_datos:'tipo_oficina/getDatos',
                url_get:URLINDEX + '/tipo_oficina/get',
                fn_antes_nuevo:null,
                campo:'descripcion',
                id:'id_tipo_oficina',
                defecto:null,
                params:[]
            }
            );
	
        $("#oform").validate({
            rules: {
                nombre:  {
				required: true,
				minlength: 2,
                                maxlength: 100
			},
                 abreviatura:  {
				required: true }
                            ,
                 id_tipo_oficina:  {
				required: true }
                            ,
                 id_municipalidad:  {
				required: true }
                            ,
                 padre:  {
				required: true }
            },
            messages: {
                nombre: {
				required: "Ingrese Nombre",
				minlength: "Ingrese mas de 2 caracteres",
                                maxlength: "Ingrese menos de 100 caracteres"
			},
                abreviatura: {
				required: "Ingrese abreviatura"
			}
            },
            // the errorPlacement has to take the layout into account
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent().find('label:first'));
            },
            submitHandler: function() {

                    $.post(
                        URLINDEX + '/oficina/guardar',
                        {
                            ajax:'ajax',
                            telefono:$("#telefono").val().toUpperCase(),
                            nombre:$("#nombre").val().toUpperCase(),
                            padre:$("#padre").val(),
                            id_oficina:$("#id_oficina").val(),
                            id_tipo_oficina:$('#id_tipo_oficina').val(),
                            id_municipalidad:$('#id_municipalidad').val(),
                            abreviatura:$('#abreviatura').val().toUpperCase()
                        },//parametros
                        function(r){ //funcion para procesar los datos
                            limpiaForm($('#oform'),false);
                            if (r.code && r.code == 'ERROR'){
                                Mensaje(r.message,'Error');
                            }else{
                                actualizarCombo('padre','oficina/getOficinas','id_oficina','nombre',null,'0','NINGUNA',null);
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

        $("#nuevo").button().bind('click', function(e){
                        limpiaForm($('#oform'),true);
                        $("#id_oficina").val(-1)
        });

        $( "#guardar" ).button()
                .click(function() {
                    $("#oform").submit(); 
                });
        
        $( "#cancelar" ).button()
                .click(function() {
                    limpiaForm($('#oform'),false);
                });

        $("#modificar").button().bind('click', function(e){

            var indexR = jQuery('#TTabla').getGridParam("selrow");

            if(indexR != null){

                $.post(
                    URLINDEX + '/oficina/get',
                    {
                        ajax:'ajax',
                        id_oficina:indexR
                    },//parametros

                    function(response){ //funcion para procesar los datos
                        limpiaForm($('#oform'),true);
                        $("#nombre").val(response.response.nombre);
                        $("#padre").val(response.response.padre);
                        $("#telefono").val(response.response.telefono);
                        $("#id_oficina").val(response.response.id_oficina);
                        $("#id_tipo_oficina").val(response.response.id_tipo_oficina);
                        $("#id_municipalidad").val(response.response.id_municipalidad);
                        $('#abreviatura').val(response.response.abreviatura);
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
                        URLINDEX + '/oficina/anular',
                        {
                            ajax:'ajax',
                            id_oficina:indexR
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
