/* 

datos_generales :datos del combo, url edicion,url obtener datos

datos_generales:
{
    form:'#idform',
    alto:120;
    ancho:120;
    titulo:'titulo';
    url_form:'url',
    url_js:'url',
    url_guardar:'url',
    url_datos:'url',
    url_get:'url'
}

datos_muestra:
{
    campo:'campo1',
    id:'campoid',
    defecto:id_defecto - 'Seleccione' - null
}

parametros
{
    params:[($('#parametro1'),....]
}
*/

(function($){

$.widget( "di.comboEdit", {
      options: {
            
            form:'#idform',
            alto:120,
            ancho:120,
            titulo:'titulo',
            url_form:'url',
            url_js:'url',
            url_guardar:'url',
            url_datos:'url',
            url_get:'url',
            fn_antes_nuevo:null,
            campo:'campo1',
            id:'campoid',
            defecto:null,
            
            params:[],
            
            boton_nuevo :null,
            boton_modificar : null,
            formulario : null,
            cargado : false,
            id_combo : -1,
            num_ident : 0,
            ventana : null
      },
  
      _create: function() {
          
            this.options.num_ident = Math.round(Math.random() * 200);
            this.options.boton_nuevo = $(document.createElement('button')).attr('id', 'btnNvo_' + this.options.num_ident).html('Nuevo Registro').css('width','23px').css('height','23px');
            this.options.boton_modificar = $(document.createElement('button')).attr('id', 'btnMod_' + this.options.num_ident).html('Modificar Registro').css('width','23px').css('height','23px');
            this.options.formulario = null;
            this.options.cargado = false;
            this.options.id_combo = -1;

            var este = this;

            this.options.ventana = $(document.createElement('div')).attr('id', 'frmVtn_' + this.options.num_ident).attr('title', this.options.titulo).html("<center><img src='"+URLHOST+"images/cargando.gif' alt='Cargando datos'/><br/>Cargando...</center>").append(this.options.formulario).dialog({
                    autoOpen: false,
                    position:'top',
                    height: este.options.alto,
                    width: este.options.ancho,
                    modal: true,
                    buttons: {
                            Guardar: function() {

                                este.options.formulario.submit();

                            },
                            Cerrar: function() {
                                    este.options.ventana.dialog( "close" );
                            }
                    },
                    close: function() {
                            este.options.ventana.empty();
                            este.options.cargado = false;
                            este.options.formulario = null;
                            este.options.id_combo = -1;
                    }
            });

            this.options.boton_nuevo.bind('click', function(e){
                    e.preventDefault();

                    if ($.isFunction(este.options.fn_antes_nuevo))
                        if(este.options.fn_antes_nuevo() == false)
                            return false;

                    este.options.ventana.dialog('open');

                    este._crear_ventana('N');

                });

             this.options.boton_modificar.bind('click', function(e){
                    e.preventDefault();

                    if ($('#' + este.element.attr('id')).val() != null && $('#' + este.element.attr('id')).val() != ''){

                        este.options.ventana.dialog('open');

                        este.options.id_combo = $('#' + este.element.attr('id')).val();

                        este._crear_ventana('M');

                    }else{
                        Mensaje('Seleccione un elemento','seleccione');
                    }

                });
            
            this._agregar_botones();
            
            setInterval(function(){
                este._timer();
            },500);
      },
      
      _agregar_botones : function(){
          
          this.options.boton_nuevo.button({
                icons: {
                    primary: "ui-icon-document"
                },
                text: false
            });
            
          this.options.boton_modificar.button({
                icons: {
                    primary: "ui-icon-pencil"
                },
                text: false
            });
            
          var ancho = this.element.width();
          
          this.element.css('width', (ancho - 50) + 'px');
          this.element.parent().append(this.options.boton_nuevo).append(this.options.boton_modificar);
      },
      
      _crear_ventana : function(t){
          
          var este = this;
          
            if (this.options.cargado == false){
                this.options.ventana.empty().load(this.options.url_form,{},function(){

                    $.getScript(este.options.url_js,function(){
                        este.options.cargado = false;

                        if (este.options.formulario == null){
                            este.options.formulario = $(este.options.form)
                            este.element = este.options.formulario.find('#'+este.element.attr('id'));
                        }
                        
                        limpiaForm(este.options.formulario,true);
                        
                        este.options.formulario.validate().settings.submitHandler = function(){

                            $.post(
                                este.options.url_guardar,
                                generarParametros('ajax',este.options.formulario,null),//parametros

                                function(response){ //funcion para procesar los datos
                                    
                                    limpiaForm(este.options.formulario,false);
                                    
                                    if (response.code && response.code == 'ERROR'){
                                        Mensaje(response.message,'Error');
                                    }else{
                                        
                                        var idsel = -1;
                                        $.each(response.response, function(i,d){
                                            
                                            if (i == este.options.id)
                                                idsel = d;

                                        });
                                        este.options.ventana.dialog( "close" );
                                        //cargar combo
                                        actualizarCombo(este.element.attr('id'),este.options.url_datos,este.options.id,este.options.campo,idsel,null,null,este.options.params);                                        
                                        
                                    }
                                },
                                'json'//tipo de dato devuelto
                            );
                        };

                        este.element.val(este.options.id_combo);
                        
                        if (t == 'M'){
                            este._cargar_get();
                        }else{
                                                    
                            if (este.options.id.indexOf('cod') < 0)
                                este.options.formulario.find('#'+este.options.id).val(-1);
                            else
                                este.options.formulario.find('#'+este.options.id).val('');
                            
                            $.each(este.options.params,function(i,d){
                                este.options.formulario.find('#'+d.attr('id')).val(d.val());
                            });
                        }
                    });

                });
                
            }else{
                limpiaForm(this.options.formulario,true);
                
                if (this.options.id.indexOf('cod') < 0)
                    this.options.formulario.find('#'+this.options.id).val(-1);
                else
                    this.options.formulario.find('#'+this.options.id).val('');
                
                this.element.val(this.options.id_combo);
                
                if (t == 'M'){
                    this._cargar_get();
                }else{
                    $.each(this.options.params,function(i,d){
                        este.options.formulario.find('#'+d.attr('id')).val(d.val());
                    });
                }
            }
            
      },
      
      _cargar_get : function(){
            var params = "ajax=ajax&" + this.options.id + '=' + this.element.val();

            this.options.ventana.dialog({title:'CARGANDO DATOS'});

            var este = this;
            
            $.post(
                this.options.url_get,
                params,//parametros

                function(response){ //funcion para procesar los datos
                    limpiaForm(este.options.formulario,true);
                    if (response.code && response.code == 'ERROR'){
                        Mensaje(response.message,'Error');
                    }else{
                        
                        if (response.response != null){
                        
                            $.each(response.response, function(i,d){

                                este.options.formulario.find('#' + i).val(d);

                            });
                        
                            este.options.ventana.dialog({title:este.options.titulo});
                        }else{
                            este.options.ventana.dialog( "close" );
                            Mensaje('No se encontro el registro','Error');
                        }
                        
                    }
                
                },
                'json'//tipo de dato devuelto
            );
      },
      
      _timer : function(){
          
           if (this.element.attr('disabled') != undefined){
               this.options.boton_nuevo.addClass('ui-state-disabled');
               this.options.boton_nuevo.attr('disabled', 'disabled');
               
               this.options.boton_modificar.addClass('ui-state-disabled');
               this.options.boton_modificar.attr('disabled', 'disabled');
           }else{
               this.options.boton_nuevo.removeClass('ui-state-disabled');
               this.options.boton_nuevo.removeAttr('disabled');
               
               this.options.boton_modificar.removeClass('ui-state-disabled');
               this.options.boton_modificar.removeAttr('disabled');
           }
           
        },
        
      destroy: function() {
          // llama a la función base destroy
          $.Widget.prototype.destroy.call(this);
      }
  });
  
  })(jQuery);