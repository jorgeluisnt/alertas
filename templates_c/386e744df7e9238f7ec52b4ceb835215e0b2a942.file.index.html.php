<?php /* Smarty version 3.0rc1, created on 2014-08-07 16:24:03
         compiled from "./templates/index.html" */ ?>
<?php /*%%SmartyHeaderCode:83644053453e3ee730cb7f1-72858344%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '386e744df7e9238f7ec52b4ceb835215e0b2a942' => 
    array (
      0 => './templates/index.html',
      1 => 1403824737,
    ),
  ),
  'nocache_hash' => '83644053453e3ee730cb7f1-72858344',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/mnt/Datos/Proyectos/php/alertas/smarty/plugins/modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <title>Sistema de control de alertas</title>

        <link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/reset.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/text.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/960_fluid.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/main.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/style.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/bar_nav.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/side_nav.css" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/theme/jquery-ui.custom.css" />

        <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/config.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery-ui.min.js"></script>

        <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery.cookie.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery.hoverIntent.minified.js"></script>

        <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/sherpa_ui.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/util.js"></script>

        <style type="text/css">
            .mensaje {  
                font-size: 11px;
                border-bottom: 1px solid #DDD;
                border-top: 1px solid white;
                cursor: pointer;
            }
            .mensaje:hover {  
                background-color: #E3E8F0;
            }
            .codigo {  
                float: left;
                color: #000099;
                font-weight: bold;
                padding: 5px 5px 2px 5px;
            }
            .fecha { 
                float: right;
                color: #cc0000;
                font-weight: bold;
                padding: 5px 5px 2px 5px;
            }
            .destino { 
                padding-left: 5px;
            }.responsable { 
                padding-left: 5px;
                font-style: italic;
            }
        </style>

        <script type="text/javascript">

            var maintab;

            jQuery(document).ready(function() {

                maintab = jQuery('#tabs').tabs({
                    add: function(e, ui) {
                        // append close thingy
                        $(ui.tab).parents('li:first').css('font-size', '12px')
                                .append('<span class="ui-tabs-close ui-icon ui-icon-close" title="Cerra Tab"></span>')
                                .find('span.ui-tabs-close')
                                .click(function() {
                                    maintab.tabs('remove', $('li', maintab).index($(this).parents('li:first')[0]));
                                });
                        // select just added tab
                        maintab.tabs('select', '#' + ui.panel.id);

                    }
                });

            });

            function abrir(a) {

                var href = $('#' + a + '.btnop').attr('link');
                var id = $('#' + a + '.btnop').attr('id');
                var nombre = $('#' + a + '.btnop').text();

                var st = "#t" + id;

                if ($(st).html() != null) {
                    maintab.tabs('select', st);
                } else {

                    var h = getWindowData()[1] - 80;

                    maintab.tabs('add', st, nombre);

                    $(st).css("overflow", "hidden").css("height", " 100%").css("position:", "relative");
                    $(st, "#tabs").append("<iframe frameborder='0' width='99%' height='" + h + "px' id='if_" + id + "' src='" + href + "' ></iframe>");

                }

            }
            ;

            function ShowNotificacion(id_servicios) {

                $('#loader').css('display', '');

                $.ajax({
                    url: URLHOST + 'templates/Frame.php',
                    async: true,
                    data: {
                        url: URLINDEX + '/servicios/detalle?id_servicios=' + id_servicios,
                        height: '400px',
                        width: '440px'
                    },
                    type: 'post',
                    success: function(data) {
                        $('#loader').css('display', 'none');
                        $("#fmas").empty().append(data);
                        $("#fmas").dialog({
                            title: 'Detalle Servicio',
                            modal: true,
                            position: "top",
                            height: 460,
                            width: 480,
                            show: 'slide'
                        });
                    }
                });

            }
            ;

            function finalizar() {
                $("#fmas").dialog('close');
                $("#fmas").empty();
            }
        </script>

    </head>

    <body>
        <div id="wrapper" class="container_16">
            <div id="top_nav" class="nav_down bar_nav grid_16 round_all">
                <ul class="round_all clearfix">				
                    <li><a class="round_left" href="javascript:;">
                            <img src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/user.png" >
                                <?php echo $_smarty_tpl->getVariable('nombre_funcionario')->value;?>

                        </a>
                    </li>
                    <li><a class="round_left" href="javascript:;">
                            <img src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/monitor.png">
                                <?php echo $_smarty_tpl->getVariable('ip')->value;?>

                        </a>
                    </li>
                    <li><a class="round_left" href="javascript:;">
                            <img src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/clock.png" >
                                <?php echo smarty_modifier_date_format(time(),"%d/%m/%Y");?>

                        </a>
                    </li>
                    <li class="send_right"><a class="round_right" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
index.php/logout">
                            <img src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/delete.png" >
                                Salir
                        </a>
                    </li>
                    <li class="send_right"><a class="round_right" href="javascript:frmclave();">
                            <img src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/clave.png" >
                                Cambia Clave
                        </a>
                    </li>
                    <li class="send_right" >
                        <span id="loader" style="display: none;">
                            <img src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/ajax-loader.gif" />
                        </span>
                    </li>
                </ul>
            </div>

            <div id="side_nav" class="side_nav grid_3 push_down">
                <?php echo $_smarty_tpl->getVariable('opciones')->value;?>

                <a href="#" class="minimize round_bottom"><span>minimize</span></a>
            </div>

            <div id="main" class="grid_13 omega">
                <div class="content round_all clearfix">

                    <div id="tabs" style="overflow: hidden; position: relative; height: 99%;" class="jqgtabs">

                        <ul>
                            <li><a href="#tabs-1">Bienvenido</a></li>
                        </ul>

                        <div id="tabs-1">

                            <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('contenido')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


                        </div>

                    </div>

                </div>
            </div>
            <div class="clear"></div>
        </div>

        <div id="fmas"></div>
    </body>
    <style type="text/css">
        .cell-wrapperleaf{
            cursor: pointer !important;
        }
    </style>
</html>
