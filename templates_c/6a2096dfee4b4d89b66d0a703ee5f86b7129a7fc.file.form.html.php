<?php /* Smarty version 3.0rc1, created on 2014-07-03 03:28:35
         compiled from "./templates/plantilla_mensajes/form.html" */ ?>
<?php /*%%SmartyHeaderCode:194464768253b514333bd934-75627294%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a2096dfee4b4d89b66d0a703ee5f86b7129a7fc' => 
    array (
      0 => './templates/plantilla_mensajes/form.html',
      1 => 1404376107,
    ),
  ),
  'nocache_hash' => '194464768253b514333bd934-75627294',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

 <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('links')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


 <link type="text/css" rel="stylesheet" media="screen" href="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
css/jquery-te-1.4.0.css"/>
 
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/jquery-te-1.4.0.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/modulos/plantilla_mensajes.js"></script>

<script type="text/javascript">

<?php echo $_smarty_tpl->getVariable('grilla')->value;?>


</script>


<div style="width: 100%">
    
    <div style="width: 451px;float: left">
        
        <table id="lsplantilla_mensajes"></table>
        <div id="pgplantilla_mensajes"></div>
        
        
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Operaciones</legend>
            
            <button id="nuevo_plantilla_mensajes">Nuevo</button>
            <button id="modificar_plantilla_mensajes">Modificar</button>
            <button id="anular_plantilla_mensajes">Anular</button>
            
            ||
            
            <button id="plantilla">Definir Plantilla</button>
        </fieldset>
        
    </div>
    
    <div style="width: 400px;float: left;" >
        
    <fieldset class="ui-widget ui-widget-content"> 
      <legend class="ui-widget-header ui-corner-all">Datos</legend>
        
        <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('datos')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

      
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Confirmar</legend>

            <button id="guardar_plantilla_mensajes">Guardar</button>
            <button id="cancelar_plantilla_mensajes">Cancelar</button>
        </fieldset>
        
    </fieldset>
    
    </div>
    
</div>

<div id="dlgPlantilla" title="Definir Plantillas">
    
    <div style="border: solid 1px #CCC; margin-top: 10px">
        <table class="detalle_header" style="margin-right:16px; border-spacing:0; margin-top:0; width:100%;">
            <thead>
                <tr>
                    <th width="10%">N° Mensaje</th>
                    <th width="80%">Plantilla</th>
                    <th width="10%"><a href="#" title="Agregar Detalle Plantilla" class="addDetalle"><img src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/add.png"/></a></th>
                </tr>
            </thead>
        </table>
    </div>
    <div style="overflow-y: scroll; overflow-x: hidden; height: 180px; border: solid 1px #CCC;">
        <table class="table-details detalle_body" style="border: 0; width: 100%;" id="lsDetalles">
            <thead>
                <tr>
                    <th width="10%"></th>
                    <th width="80%"></th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    
</div>


<div id="dlgFormato" title="Definicion de la plantilla">
    <table style="width: 720px;">
        <tr>
            <td  style="width: 130px;">
                <label>Numero de Mensaje</label>
            </td>
            <td>
                <input type="text" name="numero" id="numero" value="" style="width: 100px;" onkeypress="return validarNumeros(event);"/>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label>Mensaje</label>
            </td>
            <td valign="top">
                <textarea name="mensaje" id="mensaje" rows="15" cols="20" style="width: 500px;"></textarea>
            </td>
        </tr>
    </table>
</div>