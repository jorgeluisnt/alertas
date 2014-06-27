function getNombreMes(mes){
    switch(mes){
          case 1 : return 'ENERO'  ;break;
          case 2 : return 'FEBRERO'  ;break;
          case 3 : return 'MARZO'  ;break;
          case 4 : return 'ABRIL'  ;break;
          case 5 : return 'MAYO'  ;break;
          case 6 : return 'JUNIO'  ;break;
          case 7 : return 'JULIO'  ;break;
          case 8 : return 'AGOSTO'  ;break;
          case 9 : return 'SETIEMBRE'  ;break;
          case 10 : return 'OCTUBRE'  ;break;    
          case 11 : return 'NOVIEMBRE'  ;break;
          case 12 : return 'DICIEMBRE'  ;break;
    }
}

function ucWords(string){
    var arrayWords;
    var returnString = "";
    var len;


    if(string == null)
        return string;
     
    arrayWords = string.split(" ");
    len = arrayWords.length;
    for(i=0;i < len ;i++){
        if(i != (len-1)){
            returnString = returnString+ucFirst(arrayWords[i])+" ";
        }
        else{
            returnString = returnString+ucFirst(arrayWords[i]);
        }
    }
    return returnString;
}

function ucFirst(string){
    return string.toUpperCase();
}

function trim(cadena,campo)
{


    for(i=0; i<cadena.length; )
    {
        if(cadena.charAt(i)==" ")
            cadena=cadena.substring(i+1, cadena.length);
        else
            break;
    }

    for(i=cadena.length-1; i>=0; i=cadena.length-1)
    {
        if(cadena.charAt(i)==" ")
            cadena=cadena.substring(0,i);
        else
            break;
    }

    document.getElementById(campo).value=cadena;
    
    return cadena;
}

function BorrarEspacio(cadena)
{


    for(i=0; i<cadena.length; )
    {
        if(cadena.charAt(i)==" ")
            cadena=cadena.substring(i+1, cadena.length);
        else
            break;
    }

    for(i=cadena.length-1; i>=0; i=cadena.length-1)
    {
        if(cadena.charAt(i)==" ")
            cadena=cadena.substring(0,i);
        else
            break;
    }

    return cadena;
}

function completaCadena(cadena,longitud,caracter){
    
    cadena = cadena + '';
    cadena = $.trim(cadena);
    var l = longitud - cadena.length;
    
    if (cadena.length == 0)
        return cadena;
    
    for (var i = l ; i > 0 ; i--){
        cadena = caracter + cadena;
    }
    
    return cadena;
    
}

function DiferenciaFechas(CadenaFecha1,CadenaFecha2) {  
   
    //Obtiene los datos del formulario  
    //CadenaFecha1 = '30/09/2010';  
    //CadenaFecha2 = '14/09/2010';   
      
    //Obtiene dia, mes y año  
    var fecha1 = new formatofecha( CadenaFecha1 )     
    var fecha2 = new formatofecha( CadenaFecha2 )  
      
    //Obtiene objetos Date  
    var miFecha1 = new Date( fecha1.anio, fecha1.mes, fecha1.dia )  
    var miFecha2 = new Date( fecha2.anio, fecha2.mes, fecha2.dia )  
    //var m1=parseInt(fecha1.mes,10);
    //var m2=parseInt(fecha2.mes,10);
    //var mes=m1-m2;
    //Resta fechas y redondea  
    var diferencia = miFecha1.getTime() - miFecha2.getTime()  
    var dias = Math.floor(diferencia/(1000 * 60 * 60 * 24))  
    var segundos = Math.floor(diferencia/1000)  
    //alert ('La diferencia es de ' + dias + ' dias')  
      
    return dias  
}

/*
 *mas_parametros = [
                    {id:'responsable',valor:res},
                    {id:'entrada_salida',valor:'E'},
                    {id:'tipo_operacion',valor:'E'},
                    {id:'observaciones',valor:''},
                    {id:'documento',valor:doc}
                ]
 */

function modValores(texto,tipo){
    
    texto = texto + "";
    
    if (tipo == 1) //UPPER
        return texto.toUpperCase();
    
    if (tipo == 2) //LOWER
        return texto.toLowerCase();   
    
    return texto;
}

function generarParametros(tipo,formulario,mas_parametros,agregados,isUpper){
    
    tipo = 0;
    
    if (isUpper  != undefined && isUpper  != null)
        tipo = isUpper;
    
    if (tipo != 1 && tipo != 2)
        isUpper = 0;
    
    var datos_ = formulario.serializeArray();

    var datos = [];

    datos.push({
        'name' : 'ajax',
        'value' : tipo
    });

    $.each(datos_, function(i,d){
       
       
        var enf = $('#'+ d.name, '#' +formulario.attr('id')).hasClass('noform');
        
        if (!enf){
            datos.push({
                'name' : d.name,
                'value' : modValores(d.value,tipo)
            });
        }
        
    });
    
    if (mas_parametros != null)
        $.each(mas_parametros, function(i,d){
            datos.push({
                'name' : d.id,
                'value' : modValores(d.valor,tipo)
            });
        });
 
    var resultado = '';
    
    $.each(datos, function(i,d){

        resultado = resultado + d.name + '=' + modValores(d.value,tipo) + '&';
        
    });
    
    if (agregados != null)
        resultado = resultado + agregados;
    else
        resultado = resultado.substring(0,resultado.length - 1);
    
    return resultado;
 
}
   
   
function formatofecha( cadena ) {  
   
    //Separador para la introduccion de las fechas  
    var separador = "/"  
   
    //Separa por dia, mes y año  
    if ( cadena.indexOf( separador ) != -1 ) {  
        var posi1 = 0  
        var posi2 = cadena.indexOf( separador, posi1 + 1 )  
        var posi3 = cadena.indexOf( separador, posi2 + 1 )  
        this.dia = cadena.substring( posi1, posi2 )  
        this.mes = cadena.substring( posi2 + 1, posi3 )  
        this.anio = cadena.substring( posi3 + 1, cadena.length )  
    } else {  
        this.dia = 0  
        this.mes = 0  
        this.anio = 0     
    }  
}
 
function ponerformatofecha( cadena ) {  
  
    if ( cadena.indexOf( '-' ) != -1 ) {  
        var arrayFecha =  cadena.split('-'); 
         
        return arrayFecha[2] + '/' + arrayFecha[1] + '/' + arrayFecha[0];
    } else {  
        return cadena; 
    }     
}
 
function sumaDiasx(fec, diasSumar){ 
    var fech=new Date(fec);
    var milisecSumar= parseInt(diasSumar *24*60*60*1000); 
    fech.setTime(fech.getTime()+milisecSumar); 
    dia=fech.getDate();
    if(dia<10) dia='0'+dia;
    mes=fech.getMonth()+1;
    if(mes<10) mes='0'+mes;
    anio=fech.getFullYear();
    return dia+'/'+mes+'/'+anio; 
}
function sumarmeses(fechaini,meses)
{
    //recortamos la cadena separandola en
    //tres variables de dia, mes y año
    var fecha1 = new formatofecha(fechaini);     
    //var fecha2 = new fecha( CadenaFecha2 ) 
    /* Mensaje(fecha1.dia);
 Mensaje(fecha1.mes);
 Mensaje(fecha1.anio);*/
    dia=parseInt(fecha1.dia,10);
    mes=parseInt(fecha1.mes,10);
    anio=parseInt(fecha1.anio,10);
    //Mensaje(mes);
    //Sumamos los meses requeridos
    tmpanio=Math.floor(meses/12);
    tmpmes=meses%12;
    anionew=anio+tmpanio;
    mesnew=mes+tmpmes;
 
    //Comprobamos que al sumar no nos hayamos
    //pasado del año, si es así incrementamos
    //el año
    if (mesnew>12)
    {
        mesnew=mesnew-12;
        if (mesnew<10)
            mesnew="0"+mesnew;
        anionew=anionew+1;
    }

    if(dia < 10)
        dia = '0' + dia;
    if(mesnew < 10)
        mesnew = '0' + mesnew;
    //Ponemos la fecha en formato americano y la devolvemos
    $fecha=dia+'/'+mesnew+'/'+anionew;
    return $fecha;
}

function ValidarFecha(Cadena,caja){
    var Fecha= new String(Cadena)   // Crea un string
    
    if (Fecha.lastIndexOf("/") < 0 )
        return 'Error';
    
    // Cadena Año
    var Ano= new String(Fecha.substring(Fecha.lastIndexOf("/")+1,Fecha.length))
    // Cadena Mes
    var Mes= new String(Fecha.substring(Fecha.indexOf("/")+1,Fecha.lastIndexOf("/")))
    // Cadena Día
    var Dia= new String(Fecha.substring(0,Fecha.indexOf("/")))

    // Valido el año
    if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){
        return 'Año inválido de ' + caja;
    }
    // Valido el Mes
    if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){
        return 'Mes inválido de ' + caja;
    }
    // Valido el Dia
    if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){
        return 'Día inválido de ' + caja;
    }
    if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {

        var diasF = 28;

        if(Ano%4 == 0 && Ano%100 != 0){
            diasF = 29;
        }

        if ((Mes==2 && Dia > diasF) || Dia>30) {
            return 'Día inválido de ' + caja;
        }
    }

    //para que envie los datos, quitar las  2 lineas siguientes
    //  Mensaje("Fecha correcta.")
    return true
}



function validarNumeros(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2

    //        Mensaje(tecla);

    if (tecla==8 || tecla==13 || tecla==0 || tecla==46) return true; // 3
    patron =/\d/; // 4
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
}

function validarLetras(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2

    if (tecla==8 || tecla==13 || tecla==0 || tecla==46) return true; // 3
    patron =/\d/; // 4
    te = String.fromCharCode(tecla); // 5
    return !patron.test(te); // 6
}

//Mensajes

//var loading;
//
//function Loading(msg){
//
//    var load = document.getElementById("load");
//
//    loading = document.createElement("span");
//    $(loading).html("<img alt='Cargando' src='" + URLHOST + "/images/ajax-loader.gif'><strong>" + msg + "</strong>");
//    $(load).append(loading);
//}
//
//function QuitarLoading(){
//    $(loading).remove();
//}
    
    
    
function popup(url,ancho,alto) {
    var posicion_x;
    var posicion_y;
    posicion_x=(screen.width/2)-(ancho/2);
    posicion_y=(screen.height/2)-(alto/2);
    window.open(url, "", "width="+ancho+",height="+alto+",menubar=0,toolbar=0,directories=0,resizable=no,left="+posicion_x+",top="+posicion_y+"");
}

function limpiaForm(miForm,activo) {
    // recorremos todos los campos que tiene el formulario
    $(':input', miForm).each(function() {
        var type = this.type;
        var tag = this.tagName.toLowerCase();
        //limpiamos los valores de los campos…
        if (type == 'text' || type == 'password' || tag == 'textarea'){
            this.value = '';
            
            if (activo != null)
                if(activo){
                    //$(this).('readonly');
                    this.removeAttribute('readonly');
                    $(this).removeClass('ui-state-disabled');
                }else{
                    //$(this).attr('readonly','readonly');
                    this.setAttribute('readonly','readonly');
                    $(this).addClass('ui-state-disabled');
                }
        }
        // excepto de los checkboxes y radios, le quitamos el checked
        // pero su valor no debe ser cambiado
        else if (type == 'checkbox' || type == 'radio'){
            this.checked = false;
            
            if (activo != null)
                if(activo){
                    $(this).removeAttr('readonly');
                    $(this).removeClass('ui-state-disabled');
                }else{
                    $(this).attr('readonly','readonly');
                    $(this).addClass('ui-state-disabled');
                }
            
        }
        // los selects le ponesmos el indice a -
        else if (tag == 'select'){
            this.selectedIndex = -1;
            
            if (activo != null)
                if(activo){
                    $(this).removeAttr('disabled');
                    $(this).removeClass('ui-state-disabled');
                }else{
                    $(this).attr('disabled','true');
                    $(this).addClass('ui-state-disabled');
                }
            
        }
    });
    $(":input:first",miForm).focus();
}


//exepciones = ['idexepxion1',idexepxion2,...]
//opciones = [{id:'idobjeto',min:2,max:3,longitud:8,numeros:true,letras:true,email:true,fecha:true,hora:true'},{},...]

function validarForm(miForm,opciones,exepciones) {
    // recorremos todos los campos que tiene el formulario
    
    var corecto = true;
    var obj;
    var mensaje;
    
    $(':input', miForm).each(function() {
        
        obj = this;
                        
        var type = this.type;
        var tag = this.tagName.toLowerCase();
        var id = this.id;
        //Verificamos las exepciones
        
        var exepcion = false;
        
        if (exepciones != undefined && exepciones !=null){
            $.each(exepciones, function(a,b){
                if (id == b){
                    exepcion = true;
                    
                    if ($.trim($('#'+id,miForm).val()) != ''){
                        exepcion = false;
                    }
                    return;
                }
            });
        }
        
        if ($('#'+id).hasClass('noObligatorio'))
            exepcion = true;
        
        if (exepcion == false){
            
            if (type == 'text' || type == 'password' || tag == 'textarea'){

                if ( $.trim($(this).val()) == ''){
                    corecto = false;
                    mensaje = 'Ingrese ' + obj.title;
                    return false;
                }
                
                 if (opciones != undefined && opciones !=null){

                    var valor = $.trim($(this).val());

                    $.each(opciones, function(a,b){
                        
                        if (id == b.id){
                            
                            if (b.min != undefined && b.min !=null && isNaN(b.min) == false){
                                if (valor.length < b.min){
                                    mensaje = 'Longitud minima de ' + obj.title + ' debe ser ' + b.min;
                                    corecto = false;
                                    return false;
                                }
                            }

                            if (b.max != undefined && b.max !=null && isNaN(b.max) == false){
                                if (valor.length > b.max){
                                    mensaje = 'Longitud maxima de ' + obj.title + ' debe ser ' + b.max;
                                    corecto = false;
                                    return false;
                                }
                            }

                            if (b.longitud != undefined && b.longitud !=null && isNaN(b.longitud) == false){
                                if (valor.length != b.longitud){
                                    mensaje = 'Longitud de ' + obj.title + ' debe ser ' + b.longitud;
                                    corecto = false;
                                    return false;
                                }
                            }
                            
                            var regexp;
                            
                            if (b.numeros != undefined && b.numeros !=null && b.numeros == true){
                                regexp = /^([0-9])+$/i;
                                if ( !( regexp.test( valor ) ) ) {
                                    mensaje = obj.title + ' debe ser solo numeros';
                                    corecto = false;
                                    return false;
                                }
                            }
                            
                            if (b.letras != undefined && b.letras !=null && b.letras == true){
                                regexp = /^[a-zA-Z]([a-zA-Z\d\s])+$/i;
                                if ( !( regexp.test( valor ) ) ) {
                                    mensaje = obj.title + ' debe ser solo letras';
                                    corecto = false;
                                    return false;
                                }
                            }
                            
                            if (b.email != undefined && b.email !=null && b.email == true){
                                regexp = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
                                if ( !( regexp.test( valor ) ) ) {
                                    mensaje = obj.title + ' esta mal ingresado (Ej: ejemplo@correo.com)';
                                    corecto = false;
                                    return false;
                                }
                            }
                            
                            if (b.fecha != undefined && b.fecha !=null && b.fecha == true){
                                if ( ValidarFecha( valor , obj.title ) != true ) {
                                    mensaje = obj.title + ' esta mal ingresado (Ej: 27/05/2000)';
                                    corecto = false;
                                    return false;
                                }
                            }
                        }
                    });
                    
                 } 

                if ( corecto == false){
                    return false;
                }
            }
            // excepto de los checkboxes y radios, le quitamos el checked
            // pero su valor no debe ser cambiado
//            else if (type == 'checkbox' || type == 'radio'){
//                if (this.checked == false){
//                    mensaje = obj.title + ' debe estar marcado';
//                    corecto = false;
//                    return false;
//                }
//
//            }
            // los selects le ponesmos el indice a -
            else if (tag == 'select'){
                if( $(this).val() == null || $(this).val() == ''){
                    mensaje = obj.title;
                    corecto = false;
                    return false;
                }
            }
        
        }
    });
    
    if (corecto == false){
        var msg = "<div id='msgerror' style='display:none;'><div class='box box-error'>"+ mensaje +"</div></div>";
        
        $(miForm).find('table').before(msg);
        
        $('#msgerror').fadeIn(10)
        setTimeout(function(){
            $('#msgerror').fadeOut(1000,function(){
               $('#msgerror').remove(); 
            });
        }, 1000);
        
        $.backgroundAlert($(obj), 'red');
        
        obj.focus();
    }
    
    return corecto;

}

function actualizarCombo(combo,url,idcombo,descombo,seleccion,iddefecto,desdefecto,params,mas_params,otro_id,funcion){
    
    var opcion;

    $('#' + combo + ' option').remove();

    $('#' + combo).append("<option value='-' >Cargando...</option>");
    
    var param = "ajax=ajax&";
    
    if (params != null){
        $.each(params, function(i,d){
            param = param + d.attr('id') + '=' + d.val() + '&';
        });
    }
    
    if (mas_params != undefined && mas_params != null){
        $.each(mas_params, function(i,d){
            param = param + d.id + '=' + d.val + '&';
        });
    }    
    
    param = param.substring(0,param.length - 1);

    $.post(
        URLINDEX + '/' + url,
        param,
        function(r){
            
            $('#' + combo + ' option').remove();

            if(iddefecto != null && desdefecto !=null){
                opcion = "<option value='" + iddefecto + "' >" + desdefecto + "</option>"
                $('#' + combo).append(opcion);
            }
            
            if ( otro_id == undefined || otro_id == null){
                $.each( r.response, function(i,d){
                    opcion = "<option value='" + d[idcombo] + "' >" + d[descombo] + "</option>"
                    $('#' + combo).append(opcion);
                });
            }else{
                $.each( r.response, function(i,d){
                    opcion = "<option value='" + d[idcombo] + '@' + d[otro_id] + "' >" + d[descombo] + "</option>"
                    $('#' + combo).append(opcion);
                });                
            }
            
            if (seleccion != null){
                $('#' + combo).val(seleccion);
            }else{
                if(iddefecto != null && desdefecto !=null){
                    $('#' + combo).val(iddefecto);
                }else{
                    $('#' + combo).val(-1);
                }
            }
            
            if($.isFunction(funcion)){
                funcion();
            }
            
        },
        'json');
    

}
function actualizarComboN(combo,url,idcombo,descombo,seleccion,iddefecto,desdefecto,params,mas_params,otro_id){
    //'id_padre','modulos/getModulos','id_modulos','descripcion','0','Ninguno'
    var opcion;

    $('#' + combo + ' option').remove();

    $('#' + combo).append("<option value='-' >Cargando...</option>");
    
    var param = "ajax=ajax&";
    
    if (params != null){
        $.each(params, function(i,d){
            param = param + d.attr('id') + '=' + d.val() + '&';
        });
    }
    
    if (mas_params != undefined && mas_params != null){
        $.each(mas_params, function(i,d){
            param = param + d.id + '=' + d.val + '&';
        });
    }    
    
    param = param.substring(0,param.length - 1);

    $.post(
        URLINDEX + '/' + url,
        param,
        function(r){
            
            $('#' + combo + ' option').remove();
            $('#' + combo).append("<option value=\"0\" >Ninguno</option>");
            if(iddefecto != null && desdefecto !=null){
                opcion = "<option value='" + iddefecto + "' >" + desdefecto + "</option>"
                $('#' + combo).append(opcion);
            }
            
            if ( otro_id == undefined || otro_id == null){
                $.each( r.response, function(i,d){
                    opcion = "<option value='" + d[idcombo] + "' >" + d[descombo] + "</option>"
                    $('#' + combo).append(opcion);
                });
            }else{
                $.each( r.response, function(i,d){
                    opcion = "<option value='" + d[idcombo] + '@' + d[otro_id] + "' >" + d[descombo] + "</option>"
                    $('#' + combo).append(opcion);
                });                
            }
            
            if (seleccion != null){
                $('#' + combo).val(seleccion);
            }else{
                if(iddefecto != null && desdefecto !=null){
                    $('#' + combo).val(iddefecto);
                }else{
                    $('#' + combo).val(-1);
                }
            }
            
        },
        'json');
    

}
var Mensaje;
var Loading;
var divLoading;

$(document).ready(function(){
    
    Mensaje = function(msg,title, icon, fpostprocess){

        var div = document.createElement("div");
        $(div).html(msg);

        $(document).append(div);


        $(div).dialog({
            title: title,
            modal: true,
            buttons: {
                "OK": function() {
                    $(this).dialog("close");
                    $(this).dialog("destroy");
                    $(div).remove();
                    if ( typeof(fpostprocess) == 'function' ) fpostprocess();
                }
            },
            open: function(e,ui){
                $(div).find("button").focus();
            },
            close: function(e,ui) {
                if ( typeof(fpostprocess) == 'function' ) fpostprocess();
            }
        });
    };
           
    function cargarDni(request, response){
        $.post(
            URLINDEX + '/solicitante/searchSolicitante', 
            {
                ajax:'ajax',
                dni: request.term
            },
            function(r){
                if ( r.response.length == 0 ) 
                    return false; 
                $.each( r.response, function(i){
                    this.label = this.num_documento;
                    this.id = this.id_solicitante;
                    this.value = this.num_documento;
                });
                response(r.response);
            },'json'
            );
    };
    
    $("#s_num_documento").autocomplete({
        source: cargarDni,
        select: function(e, ui){
            $("#s_id_solicitante").val(ui.item.id_solicitante);
        }
    });
})
    
///FUNCIONES PARA EL LOGIN
var cadena="";

function concatenar(id,txt){
    dato=document.getElementById(id).value;
    cadena=cadena+dato;
    document.getElementById(txt).value=cadena;

}
function limpiar(id1,id2){
    document.getElementById(id1).value="";
    document.getElementById(id2).value="";
    cadena="";
}
function validar(){
    clave=document.getElementById("textfield2").value;
    Mensaje(clave);
}
function cambiarEstadoMensajes(id,tipo){
    
    var clas = '';
    
    if (tipo == 'error'){
        clas = 'box-error';
    }
    if (tipo == 'info'){
        clas = 'box-info';
    }
    if (tipo == 'warning'){
        clas = 'box-warning';
    }
    
    $('#' + id + '_div').removeClass('box-warning');
    $('#' + id + '_div').removeClass('box-info');
    $('#' + id + '_div').removeClass('box-error');
    
    $('#' + id + '_msg').removeClass('box-warning-msg');
    $('#' + id + '_msg').removeClass('box-info-msg');
    $('#' + id + '_msg').removeClass('box-error-msg');
    
    $('#' + id + '_div').addClass(clas);
    $('#' + id + '_msg').addClass(clas + '-msg');
}

function generarMensaje(tipo,titulo,mensaje){
    
    var clas;
    if (tipo == 'error'){
        clas = 'box-error';
    }
    if (tipo == 'info'){
        clas = 'box-info';
    }
    if (tipo == 'warning'){
        clas = 'box-warning';
    }
    
    var html = "<div class='box " + clas + "'>" + titulo + "</div><div class='box " + clas + "-msg'><ol><li><span>" + mensaje + "</span></li></ol></div>";
    
    return html;
}
completa0=function(numero,ceros){

    if(numero==undefined)numero=0;
    numero=numero+="";
    if(ceros>numero.length){
        temp=numero;
        numero="";
        for(var i=0;i<=(ceros-strlen(numero));i++){
            numero+="0";
        }
        numero+=temp;
    }
    return numero;
    
}
function strlen (string) {
    // Get string length  
    // 
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/strlen
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Sakimori
    // +      input by: Kirk Strobeck
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +    revised by: Brett Zamir (http://brett-zamir.me)
    // %        note 1: May look like overkill, but in order to be truly faithful to handling all Unicode
    // %        note 1: characters and to this function in PHP which does not count the number of bytes
    // %        note 1: but counts the number of characters, something like this is really necessary.
    // *     example 1: strlen('Kevin van Zonneveld');
    // *     returns 1: 19
    // *     example 2: strlen('A\ud87e\udc04Z');
    // *     returns 2: 3
    var str = string + '';
    var i = 0,
        chr = '',
        lgth = 0;
 
    if (!this.php_js || !this.php_js.ini || !this.php_js.ini['unicode.semantics'] || this.php_js.ini['unicode.semantics'].local_value.toLowerCase() !== 'on') {
        return string.length;
    }
 
    var getWholeChar = function (str, i) {
        var code = str.charCodeAt(i);
        var next = '',
            prev = '';
        if (0xD800 <= code && code <= 0xDBFF) { // High surrogate (could change last hex to 0xDB7F to treat high private surrogates as single characters)
            if (str.length <= (i + 1)) {
                throw 'High surrogate without following low surrogate';
            }
            next = str.charCodeAt(i + 1);
            if (0xDC00 > next || next > 0xDFFF) {
                throw 'High surrogate without following low surrogate';
            }
            return str.charAt(i) + str.charAt(i + 1);
        } else if (0xDC00 <= code && code <= 0xDFFF) { // Low surrogate
            if (i === 0) {
                throw 'Low surrogate without preceding high surrogate';
            }
            prev = str.charCodeAt(i - 1);
            if (0xD800 > prev || prev > 0xDBFF) { //(could change last hex to 0xDB7F to treat high private surrogates as single characters)
                throw 'Low surrogate without preceding high surrogate';
            }
            return false; // We can pass over low surrogates now as the second component in a pair which we have already processed
        }
        return str.charAt(i);
    };
 
    for (i = 0, lgth = 0; i < str.length; i++) {
        if ((chr = getWholeChar(str, i)) === false) {
            continue;
        } // Adapt this line at the top of any loop, passing in the whole string and the current iteration and returning a variable to represent the individual character; purpose is to treat the first part of a surrogate pair as the whole character and then ignore the second part
        lgth++;
    }
    return lgth;
}

function frmclave(){

    var div = document.createElement("div");

    var html = "<table style='font-size: 12px'>";
    html    += "    <tr>";
    html    += "        <td>";
    html    += "            <label for='claveactual'>Clave Actual :</label>";
    html    += "        </td>";
    html    += "        <td width='250'>";
    html    += "            <input type='password' maxlength='35' name='claveactual' id='claveactual' class='text ui-widget-content ui-corner-all' style='text-transform: none;font-size: 12px;width: 100%'/>";
    html    += "        </td>";
    html    += "    </tr>";
    html    += "    <tr>";
    html    += "        <td>";
    html    += "            <label for='nuevaclave'>Clave Nueva :</label>";
    html    += "        </td>";
    html    += "        <td>";
    html    += "            <input type='password' maxlength='35' name='nuevaclave' id='nuevaclave' class='text ui-widget-content ui-corner-all' style='text-transform: none;font-size: 12px;width: 100%' />";
    html    += "        </td>";
    html    += "    </tr>";
    html    += "    <tr>";
    html    += "        <td>";
    html    += "        </td>";
    html    += "        <td>";
    html    += "            <p id='cambiarclaveimg' ><img alt='' src='" + URLHOST +"images/ajax-loader.gif'><b>Procesando...</b></p>";
    html    += "        </td>";
    html    += "    </tr>";
    html    += "</table>";

    $(div).html(html);

    $(document).append(div);

    $(div).dialog({
        title: 'Cambiar Clave',
        modal: true,
        height: 200,
        width: 370,
        buttons: { 
            "Cambiar": function() {

                if ($("#claveactual").val().length == 0){
                    Mensaje('Ingrese clave actual','Error');
                    return;
                }

                if ($("#nuevaclave").val().length == 0){
                    Mensaje('Ingrese nueva clave','Error');
                    return;
                }

                $("#cambiarclaveimg").css('display','block');

                $.post(
                    URLINDEX + '/funcionario/cambiarclave', //URL
                    {
                        ajax:'ajax',
                        claveactual:$("#claveactual").val(),
                        nuevaclave:$("#nuevaclave").val()
                    },//parametros

                    function(response){//funcion para procesar los datos

                        $("#cambiarclaveimg").css('display','none');
                                            
                        if (response.code != undefined && response.code != 'OK'){
                            Mensaje(response.message, 'Error')
                        }else{
                                                
                            if (response.response.error != undefined){
                                Mensaje(response.response.error, 'Error')
                            }else{
                                Mensaje('Clave cambiada.', 'Clave')
                                $(this).dialog("close");
                                $(this).dialog("destroy");
                                $(div).remove();
                            }
                                                
                        }

                    },
                    'json'//tipo de dato debuelto
                    );

            },
            "Cerrar": function() { 
                $(this).dialog("close");
                $(this).dialog("destroy");
                $(div).remove(); 
            }
        },
        open: function(e,ui){ 
            $(div).find("button").focus();
            $("#cambiarclaveimg").css('display','none');
        },
        close: function(e,ui) {
            if ( typeof(fpostprocess) == 'function' ) fpostprocess();
        }
    });
};
            
decimales=function(numero,num){
    var pot = Math.pow(10,num); 
    return parseInt(parseFloat(numero) * pot) / pot;
}

///FUNCIONES DE VALIDACION DE JQUERY UI

function updateTips(tips, t ) {
    tips.text( t ).addClass( "ui-state-highlight" );
    setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
    }, 500 );
}
        
function checkLength( o, n, min, max ,tips) {
    if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( tips,"Longitud de " + n + " debe estar entre " +
            min + " y " + max + "." );
        return false;
    } else {
        return true;
    }
}

function checkRegexp( o, regexp, n,tips ) {
    if (o.val().length > 0){
        if ( !( regexp.test( o.val() ) ) ) {
            o.addClass( "ui-state-error" );
            updateTips(tips, n );
            return false;
        } else {
            return true;
        }
    }else
        return true;
}

function checkEmail( o,tips ) {
    return checkRegexp( o, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Ej. persona@mimail.com" ,tips );
}

function checkLetrasNumeros(o,tips ) {
    return checkRegexp( o, /^[a-zA-Z]([0-9a-z_\d\s])+$/i, "Campo debe contener a-z, 0-9.",tips );
}

function checkNumeros(o,tips ) {
    return checkRegexp( o, /^([0-9])+$/i, "Campo debe contener solo numeros.",tips );
}

function checkLetras(o,tips ) {
    return checkRegexp( o, /^[a-zA-Z]([a-zA-Z\d\s])+$/i, "Campo debe contener solo letras.",tips );
}

function checkDireccion(o,tips ) {
    return checkRegexp( o, /[A-Za-z.#\d\s]/, "Campo direccion incorrecto.",tips );
}

jQuery(function($){
        $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '&#x3c;Ant',
                nextText: 'Sig&#x3e;',
                currentText: 'Hoy',
                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
                'Jul','Ago','Sep','Oct','Nov','Dic'],
                dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
                dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                yearRange: "1900:" + (new Date().getFullYear() + 10),
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['es']);
});

function gup( name ){
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp ( regexS );
	var tmpURL = window.location.href;
	var results = regex.exec( tmpURL );
	if( results == null )
		return null;
	else
		return results[1];
}

function getWindowData(){ 
    var widthViewport,heightViewport,xScroll,yScroll,widthTotal,heightTotal; 
    
    if (typeof window.innerWidth != 'undefined'){ 
        widthViewport= window.innerWidth-17; 
        heightViewport= window.innerHeight-17; 
    }else if(typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth !='undefined' && document.documentElement.clientWidth != 0){ 
        widthViewport=document.documentElement.clientWidth; 
        heightViewport=document.documentElement.clientHeight; 
    }else{ 
        widthViewport= document.getElementsByTagName('body')[0].clientWidth; 
        heightViewport=document.getElementsByTagName('body')[0].clientHeight; 
    } 
    
    xScroll=self.pageXOffset || (document.documentElement.scrollLeft+document.body.scrollLeft);
    yScroll=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
    
    widthTotal=Math.max(document.documentElement.scrollWidth,document.body.scrollWidth,widthViewport);
    heightTotal=Math.max(document.documentElement.scrollHeight,document.body.scrollHeight,heightViewport);
    
    return [widthViewport,heightViewport,xScroll,yScroll,widthTotal,heightTotal];
} 