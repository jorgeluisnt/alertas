var per_id;
var usuario_per = false;
$(document).ready(function() {
    if ($("#perfil_id").val() == 1) {
        usuario_per = true;
    }
    $('#nuevo,#modificar,#eliminar,#inactivo_btn,#habilitar_btn,#atras').css({"width": "150px", 'height': '25px', 'font-size': '12px', 'margin-bottom': '5px'});

    $('#inactivo_btn').button({
        icons: {
            primary: "ui-icon-search"
        },
        text: true
    }).click(function(e) {//ui-icon ui-icon-search
        e.preventDefault();
        window.location.href = document.URL + '?inactivo=1';
    });
    $('#habilitar_btn').button({
        icons: {
            primary: "ui-icon-pencil"
        },
        text: true
    }).click(function(e) {//ui-icon ui-icon-search
        e.preventDefault();
        var indexR = jQuery('#TTabla').getGridParam("selrow");
        if (indexR != null) {
            if (confirm('Seguro de habilitar el registro')) {

                $.post(
                        URLINDEX + '/funcionario/anular',
                        {
                            ajax: 'ajax',
                            id_funcionario: indexR
                        }, //parametros

                function(response) { //funcion para procesar los datos
                    jQuery('#TTabla').trigger('reloadGrid');
                },
                        'json'//tipo de dato devuelto
                        );
            }

        } else {
            Mensaje("Seleccione un registro para habilitar");
        }
    });
    $("#atras").button({
        icons: {
            primary: "ui-icon-refresh"
        },
        text: true
    }).click(function(e) {//ui-icon ui-icon-search
        e.preventDefault();
        window.location.href = document.URL.substr(0, document.URL.indexOf('?'));
    });
    $('#id_cargo').comboEdit(
            {
                form: '#cargosform',
                alto: 200,
                ancho: 380,
                titulo: 'Cargos',
                url_form: URLINDEX + '/cargo/datos',
                url_js: URLHOST + 'js/modulos/cargo.js',
                url_guardar: URLINDEX + '/cargo/guardar',
                url_datos: 'oficina/getCargos',
                url_get: URLINDEX + '/cargo/get',
                fn_antes_nuevo: function() {
                    if ($('#id_oficina').val() == null || $('#id_oficina').val() == '') {
                        Mensaje('Seleccione una oficina', 'Mensaje');
                        return false;
                    } else {
                        return true;
                    }
                },
                campo: 'descripcion',
                id: 'id_cargo',
                defecto: null,
                params: [$('#id_oficina')]
            }
    );

    $("#oform").validate({
        rules: {
            nombres: {
                required: true,
                minlength: 2,
                maxlength: 150
            },
            apellidos: {
                required: true,
                minlength: 2,
                maxlength: 150
            },
            direccion: {
                required: true,
                minlength: 10,
                maxlength: 200
            },
            dni: {
                required: true,
                minlength: 8,
                maxlength: 8
            },
            email: {
                required: true,
                email: true
            },
            id_oficina: {
                required: true
            },
            id_cargo: {
                required: true
            },
            id_funcionario_jefe: {
                required: true
            }
        },
        messages: {
            nombres: {
                required: "Ingrese nombre",
                minlength: "Ingrese mas de 2 caracteres",
                maxlength: "Ingrese menos de 150 caracteres"
            },
            apellidos: {
                required: "Ingrese apellidos",
                minlength: "Ingrese mas de 2 caracteres",
                maxlength: "Ingrese menos de 150 caracteres"
            },
            direccion: {
                required: "Ingrese direccion",
                minlength: "Ingrese mas de 10 caracteres",
                maxlength: "Ingrese menos de 200 caracteres"
            },
            dni: {
                required: "Ingrese dni",
                minlength: "Ingrese 8 caracteres",
                maxlength: "Ingrese 8 caracteres"
            },
            email: {
                email: "Ingrese un email correcto",
                required: "Ingrese un email",
            }
        },
        // the errorPlacement has to take the layout into account
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent().find('label:first'));
        },
        submitHandler: function() {
            
            var usuario = '--';
            var clave = '--';
            
            if ( $('#es_usuario').is(':checked') ){
                if ($('#usuario').val() == ''){
                    Mensaje('Ingrese un usuario');
                    return;
                }
                if ($('#clave').val() == ''){
                    Mensaje('Ingrese una clave');
                    return;
                }
                
                usuario = $('#usuario').val();
                clave = $('#clave').val();
            }
            
            $.post(
                    URLINDEX + '/funcionario/guardar',
                    {
                        ajax: 'ajax',
                        nombres: $("#nombres").val().toUpperCase(),
                        apellidos: $("#apellidos").val().toUpperCase(),
                        direccion: $("#direccion").val().toUpperCase(),
                        dni: $("#dni").val().toUpperCase(),
                        email: $("#email").val().toLowerCase(),
                        usuario: usuario,
                        clave: clave,
                        id_oficina: $("#id_oficina").val(),
                        id_funcionario: $("#id_funcionario").val(),
                        id_funcionario_jefe: $("#id_funcionario_jefe").val(),
                        id_cargo: $("#id_cargo").val()
                    }, //parametros

            function(response) { //funcion para procesar los datos

                if (response.code && response.code == 'ERROR') {
                    Mensaje(response.message, 'Error');
                } else {

                    if (response.response.tipo == 'ERROR') {
                        Mensaje(response.response.mensaje, 'Mensaje');
                    } else {
                        limpiaForm($('#oform'), false);
                        jQuery('#TTabla').trigger('reloadGrid');
                        $('#frm_funcionario').dialog("close");
                        actualizarCombo('id_funcionario_jefe','funcionario/getFuncionarioAll','id_funcionario','funcionario',null,'0','NINGUNO');
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

    $('#frm_funcionario').dialog({
        autoOpen: false,
        width: 560,
        position: 'top',
        modal: true,
        buttons: {
            Guardar: function() {

                $("#oform").submit();

            },
            Cancelar: function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            limpiaForm($('#oform'), false);
        }
    });

    $("#nuevo").button({
        icons: {
            primary: "ui-icon-document"
        },
        text: true
    }).bind('click', function(e) {
        e.preventDefault();
        limpiaForm($('#oform'), true);
        $("#id_funcionario").val(-1)
        $('#frm_funcionario').dialog("open");
        $('#es_usuario').remove('checked');
        $("#usuario").val('');
        $("#clave").val('');
        $('#es_usuario').change();
    });


    
    $("#modificar").button({
        icons: {
            primary: "ui-icon-pencil"
        },
        text: true
    }).bind('click', function(e) {

        var indexR = jQuery('#TTabla').getGridParam("selrow");

        if (indexR != null) {

            $.post(
                    URLINDEX + '/funcionario/get',
                    {
                        ajax: 'ajax',
                        id_funcionario: indexR
                    }, //parametros

            function(response) { //funcion para procesar los datos
                limpiaForm($('#oform'), true);

                $("#nombres").val(response.response.nombres);
                $("#apellidos").val(response.response.apellidos);
                $("#direccion").val(response.response.direccion);
                $("#dni").val(response.response.dni);
                $("#email").val(response.response.email);
                $("#usuario").val(response.response.usuario);
                $("#clave").val(response.response.clave);
                $("#id_oficina").val(response.response.id_oficina);
                $("#id_funcionario").val(response.response.id_funcionario);
                $("#id_funcionario_jefe").val(response.response.id_funcionario_jefe);

                cargarCargos(response.response.id_cargo);
                $('#frm_funcionario').dialog("open");
                
                if(response.response.usuario == '--'){
                    $('#es_usuario').remove('checked');
                    $("#usuario").val('');
                    $("#clave").val('');
                }else{
                    $('#es_usuario').attr('checked','checked');
                }
                $('#es_usuario').change();
            },
                    'json'//tipo de dato devuelto
                    );

        } else {
            Mensaje("Seleccione un registro para modificar");
        }

    });

    $("#eliminar").button({
        icons: {
            primary: "ui-icon-trash"
        },
        text: true
    }).bind('click', function(e) {

        var indexR = jQuery('#TTabla').getGridParam("selrow");

        if (indexR != null) {

            if (confirm('Seguro de anular el registro')) {

                $.post(
                        URLINDEX + '/funcionario/anular',
                        {
                            ajax: 'ajax',
                            id_funcionario: indexR
                        }, //parametros

                function(response) { //funcion para procesar los datos
                    jQuery('#TTabla').trigger('reloadGrid');
                },
                        'json'//tipo de dato devuelto
                        );
            }

        } else {
            Mensaje("Seleccione un registro para eliminar");
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
    
    $('#es_usuario').change(function(){
        
        if ($('#es_usuario').is(':checked')){
            $('#trUsuario').show();
        }else{
            $('#trUsuario').hide();
        }
        
    });
    
});