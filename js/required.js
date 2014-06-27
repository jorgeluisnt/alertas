/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var _msg_error="<div class='ui-widget'><div class='ui-state-error ui-corner-all' style='padding: 0 .7em;height: 15px;width: 150px;'><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>Mensaje de Error</div></div>";
(function( $ ){
  $.fn.required = function() {
      var valor=$.trim($(this).val());
    if ( valor.length <1) {
        $(this).addClass('ui-state-error ui-icon-alert');
        $(this).focus();
        return false;
    }else {
        $(this).removeClass('ui-state-error ui-icon-alert')
        return true;
    }
  };
})( jQuery );
(function( $ ){
	  $.fn.combo = function() {
	    if ( $(this).val() == null ) {
	        $(this).addClass('ui-state-error ui-icon-alert');
	        $(this).focus();
	        return false;
	    }else {
                if ( $(this).val() == 0 ) {
                    $(this).addClass('ui-state-error ui-icon-alert');
                    $(this).focus();
                    return false;
                }else{
                    $(this).removeClass('ui-state-error ui-icon-alert')
                    return true;
                }
	    }
	  };
	})( jQuery );
(function( $ ){
	  $.fn.size = function(tam) {
	    if ( $(this).val().length<tam ||$(this).val().length>tam ) {
	        $(this).addClass('ui-state-error ui-icon-alert');
	        $(this).focus();
	        return false;
	    }else {
	        $(this).removeClass('ui-state-error ui-icon-alert')
	        return true;
	    }
	  };
	})( jQuery );
(function( $ ){
	$.fn.numerico = function() {
		var az = "abcdefghijklmn�opqrstuvwxyz";
		az += az.toUpperCase();
		az += "!@#$%^&*()+=[]\\\';,/{}|\":<>?~`- ";	
		  	
		return this.each (function() {
			$(this).keypress(function (e){
				if (!e.charCode) k = String.fromCharCode(e.which);
				else k = String.fromCharCode(e.charCode);
										
				if (az.indexOf(k) != -1) e.preventDefault();
				if (e.ctrlKey&&k=='v') e.preventDefault();
									
			});
						
			/*$(this).bind('contextmenu',function () {return false});*/
		});	 
	};
})( jQuery );
(function( $ ){
	  $.fn.setEnabled = function(estado) {
              
            $(this).attr("disabled",estado);
            return true;
	  };
	})( jQuery );
decimales=function(numero,num){
    var pot = Math.pow(10,num); 
    return parseInt(parseFloat(numero) * pot) / pot;
}

$('.cajaFecha').live('keyup',function(e){
//    e.preventDefault();
    
    var tecla = (document.all) ? e.keyCode : e.which; // 2
    
    if (tecla==13){
        var fec = new Date();
        var dia = fec.getDay();
        var mes = fec.getMonth() + 1;
        var anio = fec.getFullYear();
        
        if (dia < 10)
            dia = '0' + dia;
        
        if (mes < 10)
            mes = '0' + mes;
        
        $(this).val(dia + '/' + mes + '/' + anio);
        
        return true;
    }
    
    if (tecla==8 || tecla==13 || tecla==0 || tecla==46) return true; // 3
    
    var patron =/\d/; // 4
    var te = String.fromCharCode(tecla); // 5
    
    if(patron.test(te)){
        
        var tex = $.trim($(this).val());
        
        if (tex.length == 2 || tex.length == 5){
            $(this).val($.trim($(this).val()) + '/');
        }
        
    }
    
});

$('.cajaFecha').live('blur',function(e){
    e.preventDefault();
    
    if ($(this).val() != '')
        if (ValidarFecha( $(this).val() , 'fecha' ) != true ) {
            alert('Fecha esta mal ingresada (Ej: 27/05/2000)');
            $(this).val('');
            $(this).focus();
        }
    
});