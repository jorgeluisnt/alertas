$(document).ready(function(){
   
    $( "#estado_alerta" ).change(function(){
        jQuery("#lsalertas").jqGrid('setGridParam', {url: URLINDEX + "/alertas/lista?estado_alerta=" + $('#estado_alerta').val(), page: 1});
        jQuery("#lsalertas").trigger('reloadGrid');
    });
    
});

function resumen(){
    $.post(
        URLINDEX + '/alertas/resumen',
        {
            ajax: 'ajax'
        }, //parametros

        function(response) { //funcion para procesar los datos
            
            var total = parseFloat(response.response.total);
            var pendiente = parseFloat(response.response.pendiente);
            var recepcionado = parseFloat(response.response.recepcionado);
            var porcentaje = decimales(recepcionado * 100 / total,2);
            
            $('#total_puntos').text(total);
            $('#total_recepcionados').text(recepcionado);
            $('#total_pendoentes').text(pendiente);
            $('#total_avance').text(porcentaje + ' %');
        },
        'json'//tipo de dato devuelto
    );
}