<?php /* Smarty version 3.0rc1, created on 2014-07-03 17:50:40
         compiled from "./templates/alertas/graficos.html" */ ?>
<?php /*%%SmartyHeaderCode:105350966753b5de40c21577-40247348%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '70f2696a889f86378d0995ecd57f0b6f1e800b9e' => 
    array (
      0 => './templates/alertas/graficos.html',
      1 => 1404427029,
    ),
  ),
  'nocache_hash' => '105350966753b5de40c21577-40247348',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Highcharts Example</title>

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <style type="text/css">
            
        </style>
        <script type="text/javascript">
            $(function() {

                $('#grafico_1').highcharts({
                    chart: {
                        type: 'gauge',
                        plotBackgroundColor: null,
                        plotBackgroundImage: null,
                        plotBorderWidth: 0,
                        plotShadow: false
                    },
                    title: {
                        text: 'Avance General'
                    },
                    pane: {
                        startAngle: -150,
                        endAngle: 150,
                        background: [{
                                backgroundColor: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                                    stops: [
                                        [0, '#FFF'],
                                        [1, '#333']
                                    ]
                                },
                                borderWidth: 0,
                                outerRadius: '109%'
                            }, {
                                backgroundColor: {
                                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                                    stops: [
                                        [0, '#333'],
                                        [1, '#FFF']
                                    ]
                                },
                                borderWidth: 1,
                                outerRadius: '107%'
                            }, {
                                // default background
                            }, {
                                backgroundColor: '#DDD',
                                borderWidth: 0,
                                outerRadius: '105%',
                                innerRadius: '103%'
                            }]
                    },
                    // the value axis
                    yAxis: {
                        min: 0,
                        max: <?php echo $_smarty_tpl->getVariable('resumen')->value['total'];?>
,
                        minorTickInterval: 'auto',
                        minorTickWidth: 1,
                        minorTickLength: 10,
                        minorTickPosition: 'inside',
                        minorTickColor: '#666',
                        tickPixelInterval: 30,
                        tickWidth: 2,
                        tickPosition: 'inside',
                        tickLength: 10,
                        tickColor: '#666',
                        labels: {
                            step: 2,
                            rotation: 'auto'
                        },
                        title: {
                            text: 'pts'
                        },
                        plotBands: [{
                                from: 0,
                                to: <?php echo $_smarty_tpl->getVariable('resumen')->value['tramo_1'];?>
,
                                color: '#DF5353' // green
                            }, {
                                from: <?php echo $_smarty_tpl->getVariable('resumen')->value['tramo_1'];?>
,
                                to: <?php echo $_smarty_tpl->getVariable('resumen')->value['tramo_2'];?>
,
                                color: '#DDDF0D' // yellow
                            }, {
                                from: <?php echo $_smarty_tpl->getVariable('resumen')->value['tramo_2'];?>
,
                                to: <?php echo $_smarty_tpl->getVariable('resumen')->value['total'];?>
,
                                color: '#55BF3B' // red
                            }]
                    },
                    series: [{
                            name: 'Avance',
                            data: [ <?php echo $_smarty_tpl->getVariable('resumen')->value['recepcionado'];?>
 ],
                            tooltip: {
                                valueSuffix: ' pts'
                            }
                        }]

                });
            
    $('#grafico_2').highcharts({
	
	    chart: {
	        type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
	    },
	    
	    title: {
	        text: 'Mensajes Pendientes'
	    },
	    
	    pane: {
	        startAngle: -150,
	        endAngle: 150,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: <?php echo $_smarty_tpl->getVariable('resumen')->value['total'];?>
,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#666',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	        },
	        title: {
	            text: 'pts'
	        },
	        plotBands: [{
	            from: 0,
	            to: <?php echo $_smarty_tpl->getVariable('resumen')->value['tramo_1'];?>
,
	            color: '#55BF3B' // green
	        }, {
	            from: <?php echo $_smarty_tpl->getVariable('resumen')->value['tramo_1'];?>
,
	            to: <?php echo $_smarty_tpl->getVariable('resumen')->value['tramo_2'];?>
,
	            color: '#DDDF0D' // yellow
	        }, {
	            from: <?php echo $_smarty_tpl->getVariable('resumen')->value['tramo_2'];?>
,
	            to: <?php echo $_smarty_tpl->getVariable('resumen')->value['total'];?>
,
	            color: '#DF5353' // red
	        }]        
	    },
	
	    series: [{
	        name: 'Pendientes',
	        data: [<?php echo $_smarty_tpl->getVariable('resumen')->value['pendiente'];?>
],
	        tooltip: {
	            valueSuffix: ' pts'
	        }
	    }]
	
	});
});

        </script>
    </head>
    <body>
        <script src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/highcharts/highcharts.js"></script>
        <script src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/highcharts/highcharts-more.js"></script>
        <script src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/highcharts/modules/exporting.js"></script>

        <span id="grafico_1" style="min-width: 310px; max-width: 400px; height: 300px; float: left;"></span>
        <span id="grafico_2" style="min-width: 310px; max-width: 400px; height: 300px; float: left;"></span>

    </body>
</html>
