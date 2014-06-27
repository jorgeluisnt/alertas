$(document).ready(function(){
        
        $('#nuevo,#modificar,#eliminar,#detalle').css({"width":"150px",'height':'25px','font-size':'12px','margin-bottom':'5px'});
        
        $("#oform").validate({
            rules: {
                descripcion : {
				required: true,
				minlength: 2,
                                maxlength: 150
			}
            },
            messages: {
                descripcion : {
				required: "Ingrese un Servicio",
				minlength: "Ingrese mas de 2 caracteres",
                                maxlength: "Ingrese menos de 150 caracteres"
			}
            },
            // the errorPlacement has to take the layout into account
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent().find('label:first'));
            },
            submitHandler: function() {

                    $.post(
                        URLINDEX + '/perfil/guardar',
                        {
                            ajax:'ajax',
                            descripcion:$("#descripcion").val().toUpperCase(),
                            id_perfil:$("#id_perfil").val()
                        },//parametros

                        function(response){ //funcion para procesar los datos
                            
                            if (response.code && response.code == 'ERROR'){
                                Mensaje(response.message,'Error');
                            }else{
                                
                                if (response.response.tipo == 'ERROR'){
                                    Mensaje(response.response.mensaje,'Mensaje');
                                }else{
                                    limpiaForm($('#oform'),false);
                                    jQuery('#TTabla').trigger('reloadGrid');
                                    $( '#frm_perfil' ).dialog( "close" );   
                                }                                
                                
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

        $('#frm_perfil').dialog({
                autoOpen: false,
                height: 200,
                width: 380,
                position:'top',
                modal: true,
                buttons: {
                        Guardar: function() {

                            $("#oform").submit(); 
                                
                        },
                        Cancelar: function() {
                                $( this ).dialog( "close" );
                        }
                },
                close: function() {
                        limpiaForm($('#oform'),false);
                }
        });

        $("#nuevo").button({
          icons: {
              primary: "ui-icon-document"
          }
      }).click(function(e){
            limpiaForm($('#oform'),true);
            $("#id_perfil").val(-1)
            $('#frm_perfil').dialog( "open" );
        });

        $("#modificar").button({
          icons: {
              primary: "ui-icon-pencil"
          }
      }).click(function(e){

            var indexR = jQuery('#TTabla').getGridParam("selrow");

            if(indexR != null){

                $.post(
                    URLINDEX + '/perfil/get',
                    {
                        ajax:'ajax',
                        id_perfil:indexR
                    },//parametros

                    function(response){ //funcion para procesar los datos
                        limpiaForm($('#oform'),true);

                        $("#descripcion").val(response.response.descripcion);
                        $("#id_perfil").val(response.response.id_perfil);
                        
                        $('#frm_perfil').dialog( "open" );
                        
                    },
                    'json'//tipo de dato devuelto
                );

            }else{
                Mensaje("Seleccione un registro para modificar");
            }

        });

        $("#eliminar").button({
          icons: {
              primary: "ui-icon-trash"
          }
      }).click(function(e){

            var indexR = jQuery('#TTabla').getGridParam("selrow");

            if(indexR != null){

                if(confirm('Seguro de anular el registro')){

                    $.post(
                        URLINDEX + '/perfil/anular',
                        {
                            ajax:'ajax',
                            id_perfil:indexR
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


        $( "#anio_fabricacion" ).datepicker({
			changeMonth: true,
			changeYear: true,
                        dateFormat: 'dd/mm/yy'
		});
});