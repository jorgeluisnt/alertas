jQuery.bind = function(object, method){
  var args = Array.prototype.slice.call(arguments, 2);
  return function() {
    var args2 = [this].concat(args, $.makeArray( arguments ));
    return method.apply(object, args2);
  };
};

var IDTIPOUBIGEO;
var idDefDpto = '17742-22-00-00-0-SAN MARTIN';
(function($) {

  BuscarUbigeo = {
      
    cargarCiudades : function (request, response){
            $.post(
                URLINDEX + '/searchUbigeo', 
                {
                    ajax:'ajax',
                    nombre: request.term
                },
                function(r){
                    if ( r.response.length == 0 ) 
                        return false; 
                    $.each( r.response, function(i){
                            this.label = this.nombre;
                            this.id = this.id_ubigeo;
                            this.value = this.nombre;
                    });
                    response(r.response);
                    },'json'
                );
    },
    
    initialize:function(tipo,divubigeo,showdesc,acepfunction,cancelfunction,showbtn){

        IDTIPOUBIGEO = tipo;

        var div=  "<div>";
        
        if ( showdesc != undefined && showdesc != null){
            
            if (showdesc == true){
                div +=    "   <input type='text' name='txtdescubi' id='txtdescubi' readonly='readonly' class='text ui-widget-content ui-corner-all' style='text-transform: none;font-size: 12px;width:88%'/>";
            }
            
        }else{
            div +=    "   <input type='text' name='txtdescubi' id='txtdescubi' readonly='readonly' class='text ui-widget-content ui-corner-all' style='text-transform: none;font-size: 12px;width:88%'/>";
        }
        
        if ( showbtn != undefined && showbtn != null){
            
            if (showbtn == true){
                div +=    "   <a href='' id='btnubigeo'><img alt='' src='" + URLHOST + "images/ubi.png' title='Buscar ubigeo'></a>";
            }else{
                div +=    "   <a href='' style='display:none;' id='btnubigeo'><img alt='' src='" + URLHOST + "images/ubi.png' title='Buscar ubigeo'></a>";
            }
            
        }else{
            div +=    "   <a href='' id='btnubigeo'><img alt='' src='" + URLHOST + "images/ubi.png' title='Buscar ubigeo'></a>";
        }
        
//        div +=    "   <a href='' id='btnubigeo'><img alt='' src='" + URLHOST + "images/ubi.png' title='Buscar ubigeo'></a>";
        div +=    "  <input type='hidden' name='idubigeo' id='idubigeo' value='' />";
                
        div +=    "</div>";
        var cadena=    "<div id='frmubigeo' title='Seleccionar ubigeo'>";
        cadena +=    "  <table style='font-size: 12px'>";

        if (IDTIPOUBIGEO == 1 || IDTIPOUBIGEO == 2 || IDTIPOUBIGEO == 3 || IDTIPOUBIGEO == 4){
        
            cadena +=    "      <tr>";
            cadena +=    "          <td>";
            cadena +=    "              <label for='cbdepartamento'>Departamento :</label>";
            cadena +=    "          </td>";
            cadena +=    "          <td>";
            cadena +=    "              <select name='cbdepartamento' id='cbdepartamento' style='width:200px' onchange='BuscarUbigeo.CargarProvincias();'>";
            cadena +=    "                  <option value='0'>SELECCIONE ...</option>";
            cadena +=    "              </select>";
            cadena +=    "              <input type='hidden' name='ubi_coddpto' id='ubi_coddpto' value='' />";
            cadena +=    "          </td>";
            cadena +=    "          <td>";
            cadena +=    "              <span id='imgdep'><img alt='' src='" + URLHOST + "images/ajax-loader.gif' ></span>";
            cadena +=    "          </td>";
            cadena +=    "      </tr>";

        }

        if (IDTIPOUBIGEO == 2 || IDTIPOUBIGEO == 3 || IDTIPOUBIGEO == 4){


            cadena +=    "      <tr>";
            cadena +=    "          <td>";
            cadena +=    "              <label for='cbprovincia'>Provincia :</label>";
            cadena +=    "          </td>";
            cadena +=    "          <td>";
            cadena +=    "              <select name='cbprovincia' id='cbprovincia'  style='width:200px' onchange='BuscarUbigeo.CargarDistritos();'>>";
            cadena +=    "                  <option value='0'>SELECCIONE ...</option>";
            cadena +=    "              </select>";
            cadena +=    "              <input type='hidden' name='ubi_codprov' id='ubi_codprov' value='' />";
            cadena +=    "          </td>";
            cadena +=    "          <td>";
            cadena +=    "              <span id='imgprov'><img alt='' src='" + URLHOST + "images/ajax-loader.gif' ></span>";
            cadena +=    "          </td>";
            cadena +=    "      </tr>";

        }

        if (IDTIPOUBIGEO == 3 || IDTIPOUBIGEO == 4){
            
            cadena +=    "      <tr>";
            cadena +=    "          <td>";
            cadena +=    "              <label for='cbdistrito'>Distrito :</label>";
            cadena +=    "          </td>";
            cadena +=    "          <td>";
            cadena +=    "              <select name='cbdistrito' id='cbdistrito' style='width:200px' onchange='BuscarUbigeo.CargarCCPP();'>";
            cadena +=    "                  <option value='0'>SELECCIONE ...</option>";
            cadena +=    "              </select>";
            cadena +=    "              <input type='hidden' name='ubi_coddist' id='ubi_coddist' value='' />";
            cadena +=    "          </td>";
            cadena +=    "          <td>";
            cadena +=    "              <span id='imgdist'><img alt='' src='" + URLHOST + "images/ajax-loader.gif'></span>";
            cadena +=    "          </td>";
            cadena +=    "      </tr>";

        }

        if (IDTIPOUBIGEO == 4){
            
            cadena +=    "      <tr>";
            cadena +=    "          <td>";
            cadena +=    "              <label for='cbccpp'>Centro Poblado :</label>";
            cadena +=    "          </td>";
            cadena +=    "          <td>";
            cadena +=    "              <select name='cbccpp' id='cbccpp' style='width:200px'>";
            cadena +=    "                  <option value='0'>SELECCIONE ...</option>";
            cadena +=    "              </select><button id='btn_cpp'>agregar</button>";
            cadena +=    "              <input type='hidden' name='ubi_codccpp' id='ubi_codccpp' value='' />";
            cadena +=    "          </td>";
            cadena +=    "          <td>";
            cadena +=    "              <span id='imgccpp'><img alt='' src='" + URLHOST + "images/ajax-loader.gif' ></span>";
            cadena +=    "          </td>";
            cadena +=    "      </tr>";
            cadena +=    "      <tr>";
            cadena +=    "          <td>";
            cadena +=    "              <label for='chksolo_distrito'>Solo distrito </label>";
            cadena +=    "          </td>";
            cadena +=    "          <td>";
            cadena +=    "              <input type='checkbox' id='chksolo_distrito' name='chksolo_distrito' value='ON' />";
            cadena +=    "          </td>";
            cadena +=    "          <td>";
            cadena +=    "              ";
            cadena +=    "          </td>";
            cadena +=    "      </tr>";

        }
        
        cadena +=    "  </table>";
        cadena +=    "</div>";

        divubigeo.html(div);
        
        $('body').append(cadena);

        $('#imgdep').css('display','none');
        $('#imgprov').css('display','none');
        $('#imgdist').css('display','none');
        $('#imgccpp').css('display','none');
        
        this.frmUbigeo = $('#frmubigeo');

        this.frmUbigeo.dialog({
            autoOpen: false,
            height: 250,
            width: 380,
            position:'top',
            modal: true,
            buttons: {
                    Aceptar: function() {

                        var ok = false;
                        var idubi;

                        if (IDTIPOUBIGEO == 1){

                            idubi = $("#cbdepartamento").val();

                            if ( idubi == '0' ){
                                Mensaje('Seleccione un departamento', 'Seleccionar');
                            }else
                                ok = true;

                        }

                        if (IDTIPOUBIGEO == 2){

                            idubi = $("#cbprovincia").val();

                            if ( idubi == '0' ){
                                Mensaje('Seleccione una provincia', 'Seleccionar');
                            }else
                                ok = true;

                        }

                        if (IDTIPOUBIGEO == 3){

                            idubi = $("#cbdistrito").val();

                            if ( idubi == '0' ){
                                Mensaje('Seleccione un distrito', 'Seleccionar');
                            }else
                                ok = true;

                        }

                        if (IDTIPOUBIGEO == 4){
                            
                            if($('#chksolo_distrito').is(':checked')){
                                
                                idubi = $("#cbdistrito").val();

                                if ( idubi == '0' ){
                                    Mensaje('Seleccione un distrito', 'Seleccionar');
                                }else
                                    ok = true;
                                
                            }else{
                                
                                idubi = $("#cbccpp").val();

                                if ( idubi == '0' ){
                                    Mensaje('Seleccione un centro poblado', 'Seleccionar');
                                }else
                                    ok = true;
                                
                            }
                            
                        }

                        if (ok){
                            
                            $("#ubi_codccpp").val(idubi.split("-")[4]);
                            
                            $("#idubigeo").val(idubi.split("-")[0])
                            $("#txtdescubi").val(idubi.split("-")[5])
                            $('#frmubigeo').dialog( "close" );
                            
                            if($.isFunction(acepfunction)){
                                acepfunction(
                                    idubi.split("-")[0],
                                    $('#cbdepartamento option:selected').html(),
                                    $('#cbprovincia option:selected').html(),
                                    $('#cbdistrito option:selected').html(),
                                    $('#cbccpp option:selected').html(),
                                    idubi
                                );
                            }
                            
                        }

                    },
                    Cancelar: function() {
                           $('#frmubigeo').dialog( "close" );
                           if($.isFunction(cancelfunction))
                                cancelfunction();
                    }
            },
            close: function() {
                
            }
        });
          
        $('#btnubigeo').bind('click', function(e){

                e.preventDefault();

              if ($('#cbdepartamento option').length == 1){

                      $('#imgdep').css('display','block');

                      $.post(
                      URLINDEX + '/getUbigeo',
                      {
                        ajax:'ajax',
                        coddpto:'-',
                        tipo:1
                      },
                      function(r){

                           $('#cbdepartamento option').remove();
                           $('#cbdepartamento').append("<option value='0'>SELECCIONE ...</option>");

                           var opcion;

                           $.each( r.response, function(i){

                               var value = this.id_ubigeo + '-' + this.cod_dpto + '-' + this.cod_prov + '-' + this.cod_dist+ '-' + '0' + '-' + this.nombre;
                               
                                opcion = "<option value='" + value + "' >" + this.nombre + "</option>"
                                $('#cbdepartamento').append(opcion);

                            });
                            
                           $("#cbdepartamento").val(idDefDpto);
                           $("#cbdepartamento").change();

                            $('#imgdep').css('display','none');
                      },
                      'json');

              }else{

                  $("#cbdepartamento").val(idDefDpto);
                  
                  $('#cbprovincia option').remove();
                  $('#cbprovincia').append("<option value='0'>SELECCIONE ...</option>");

                  $('#cbdistrito option').remove();
                  $('#cbdistrito').append("<option value='0'>SELECCIONE ...</option>");

                  $('#cbccpp option').remove();
                  $('#cbccpp').append("<option value='0'>SELECCIONE ...</option>");

                  $("#cbdepartamento").change();
              }

            $('#frmubigeo').dialog( "open" );
        });

	$("#txtdescubi").autocomplete({
			source: BuscarUbigeo.cargarCiudades,
			select: function(e, ui){
                            $("#idubigeo").val(ui.item.id_ubigeo);
                            
                            if (IDTIPOUBIGEO == 1){
                                $("#ubi_coddpto").val(ui.item.cod_dpto);
                            }
                            if (IDTIPOUBIGEO == 2){
                                $("#ubi_coddpto").val(ui.item.cod_dpto);
                                $("#ubi_codprov").val(ui.item.cod_prov);
                            }
                            if (IDTIPOUBIGEO == 3){
                                $("#ubi_coddpto").val(ui.item.cod_dpto);
                                $("#ubi_codprov").val(ui.item.cod_prov);
                                $("#ubi_coddist").val(ui.item.cod_dist);
                            }
                            if (IDTIPOUBIGEO == 4){
                                $("#ubi_coddpto").val(ui.item.cod_dpto);
                                $("#ubi_codprov").val(ui.item.cod_prov);
                                $("#ubi_coddist").val(ui.item.cod_dist);
                                $("#ubi_codccpp").val(ui.item.codccpp);
                            }
			}
		});
   //////////////////////////////FUNCION PARA AGREGAR CPP SI EN CASO NO EXISTE ///////////////////////////////////
            $("#btn_cpp").button({
                icons: {
                    primary: "ui-icon-document"
                },
                text: false
             }).click(function(e){
                    e.preventDefault();
                     

                            if ($("#cbdepartamento").val() == '0' ){
                                Mensaje('Seleccione un departamento', 'Seleccionar');
                                return
                            }
                            if ( $("#cbprovincia").val() == '0' ){
                                Mensaje('Seleccione una provincia', 'Seleccionar');
                                return
                            }
                            if ( $("#cbdistrito").val() == '0' ){
                                Mensaje('Seleccione un distrito', 'Seleccionar');
                                return
                            }
                    $.post(URLINDEX + '/distancias/datos',"",function(data)
                            {
                            $('body').append(data);
                              $("#frm_cpp").dialog({
                                width:'300px',
                                autoOpen:true,
                                modal:true,
                                buttons:{
                                        "Guardar":function(){
                                          if ($("#nombre").val() == '' ){
                                                Mensaje('ingrese descripcion', 'Seleccionar');
                                                return
                                            }
                                              var CodDpto = $('#cbdepartamento').val().split("-")[1];
                                              var CodProv = $('#cbprovincia').val().split("-")[2];
                                              var CodDist = $('#cbdistrito').val().split("-")[3];
                                              $("#frm_cpp").dialog('close');
                                                   $.post(
                                                    URLINDEX + '/saveubigeo',
                                                    {
                                                        ajax:'ajax',
                                                        coddpto:CodDpto,
                                                        codprov:CodProv,
                                                        coddist:CodDist,
                                                        nombre:$("#nombre").val()
                                                    },
                                                    function(r){
                                                          BuscarUbigeo.CargarCCPP()
                                                      $("#cbccpp").val(r.response.codccpp);
                                                       $("#nombre").val("");
                                                      

                                                    },
                                                    'json');
                                            $("#frm_cpp").dialog('close');
                                          //BuscarUbigeo.CargarCCPP();
                                        },
                                        "Cancelar":function(){
                                           $(this).dialog('close');
                                            }
                                     }
                              });
                              
                            }
                           
                      );
                    
                  
             });
           //////////////////////dialog cpppp//////////////////7777777777777777
                
                
    },

    CargarProvincias:function(){

          var CodDep = $('#cbdepartamento').val().split("-")[1];
          
          $("#ubi_coddpto").val(CodDep);
          
          $('#imgprov').css('display','block');

          $.post(
          URLINDEX + '/getUbigeo',
          {
            ajax:'ajax',
            coddpto:CodDep,
            tipo:2
          },
          function(r){

              $('#cbdistrito option').remove();
              $('#cbdistrito').append("<option value='0'>SELECCIONE ...</option>");

              $('#cbccpp option').remove();
              $('#cbccpp').append("<option value='0'>SELECCIONE ...</option>");

               $('#cbprovincia option').remove();
               $('#cbprovincia').append("<option value='0'>SELECCIONE ...</option>");

               var opcion;

               $.each( r.response, function(i){

                   var value = this.id_ubigeo + '-' + this.cod_dpto + '-' + this.cod_prov + '-' + this.cod_dist+ '-' + '0' + '-' + this.nombre;

                    opcion = "<option value='" + value + "' >" + this.nombre + "</option>"
                    $('#cbprovincia').append(opcion);
                    
                });

                $('#imgprov').css('display','none');

          },
          'json');

    },


    CargarDistritos:function(){

          var CodDpto = $('#cbdepartamento').val().split("-")[1];
          var CodProv = $('#cbprovincia').val().split("-")[2];
          
          $("#ubi_codprov").val(CodProv);
          
          $('#imgdist').css('display','block');

          $.post(
          URLINDEX + '/getUbigeo',
          {
            ajax:'ajax',
            coddpto:CodDpto,
            codprov:CodProv,
            tipo:3
          },
          function(r){

              $('#imgdist').css('display','none');

              $('#cbccpp option').remove();
              $('#cbccpp').append("<option value='0'>SELECCIONE ...</option>");
              
               $('#cbdistrito option').remove();
               $('#cbdistrito').append("<option value='0'>SELECCIONE ...</option>");

               var opcion;

               $.each( r.response, function(i){

                   var value = this.id_ubigeo + '-' + this.cod_dpto + '-' + this.cod_prov + '-' + this.cod_dist+ '-' + '0' + '-' + this.nombre;

                    opcion = "<option value='" + value + "' >" + this.nombre + "</option>"
                    $('#cbdistrito').append(opcion);

                });

          },
          'json');

    },

    CargarCCPP:function(){

          var CodDpto = $('#cbdepartamento').val().split("-")[1];
          var CodProv = $('#cbprovincia').val().split("-")[2];
          var CodDist = $('#cbdistrito').val().split("-")[3];

          $("#ubi_coddist").val(CodDist);
          
          $('#imgccpp').css('display','block');

          $.post(
          URLINDEX + '/getUbigeo',
          {
            ajax:'ajax',
            coddpto:CodDpto,
            codprov:CodProv,
            coddist:CodDist,
            tipo:4
          },
          function(r){

              $('#imgccpp').css('display','none');

               $('#cbccpp option').remove();
               $('#cbccpp').append("<option value='0'>SELECCIONE ...</option>");

               var opcion;

               $.each( r.response, function(i){

                   var value = this.id_ubigeo + '-' + this.cod_dpto + '-' + this.cod_prov + '-' + this.cod_dist+ '-' + this.codccpp + '-' + this.nombre;

                    opcion = "<option value='" + value + "' >" + this.nombre + "</option>"
                    $('#cbccpp').append(opcion);

                });

          },
          'json');

    },
    setUbigeo:function(id_ubigeo){
        
          $.post(
          URLINDEX + '/Ubigeo',
          {
            ajax:'ajax',
            id_ubigeo:id_ubigeo
          },
          function(r){

            if (r.code && r.code == 'ERROR'){
                Mensaje(r.message,'Error');
            }else{
                
                $('#txtdescubi').val(r.response.nombre);
                $('#idubigeo').val(r.response.id_ubigeo);
                if (IDTIPOUBIGEO == 1){
                    $("#ubi_coddpto").val(r.response.cod_dpto);
                }
                if (IDTIPOUBIGEO == 2){
                    $("#ubi_coddpto").val(r.response.cod_dpto);
                    $("#ubi_codprov").val(r.response.cod_prov);
                }
                if (IDTIPOUBIGEO == 3){
                    $("#ubi_coddpto").val(r.response.cod_dpto);
                    $("#ubi_codprov").val(r.response.cod_prov);
                    $("#ubi_coddist").val(r.response.cod_dist);
                }
                if (IDTIPOUBIGEO == 4){
                    $("#ubi_coddpto").val(r.response.cod_dpto);
                    $("#ubi_codprov").val(r.response.cod_prov);
                    $("#ubi_coddist").val(r.response.cod_dist);
                    $("#ubi_codccpp").val(r.response.codccpp);
                }
            }

          },
          'json');
          
    },
    show:function(){
        $('#btnubigeo').click();
    }
    
  }
  
})(jQuery);
