<?php /* Smarty version 3.0rc1, created on 2014-07-25 00:36:47
         compiled from "./templates/alertas/lista.html" */ ?>
<?php /*%%SmartyHeaderCode:127446054253d1ecef75cbc9-05537467%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d8e556327d7625dbcc169704b3d8a331cf68c97' => 
    array (
      0 => './templates/alertas/lista.html',
      1 => 1406264602,
    ),
  ),
  'nocache_hash' => '127446054253d1ecef75cbc9-05537467',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('links')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/modulos/alertas.lista.js"></script>

<script type="text/javascript">

    <?php echo $_smarty_tpl->getVariable('grilla')->value;?>


</script>

<fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;width: 97%"> 
    <legend class="ui-widget-header ui-corner-all">Filtro</legend>
    
    <table>
        <tr>
            <td>
                <label>Estado</label>
            </td>
            <td>
                <select name="estado_alerta" id="estado_alerta" style="width: 150px;">
                    <option value='-'>TODOS</option>
                    <option value='PENDIENTE'>PENDIENTE</option>
                    <option value='RECEPCIONADO'>RECEPCIONADO</option>
                    <option value='VENCIDO'>VENCIDO</option>
                </select>
            </td>
        </tr>
    </table>
</fieldset>

<div style="width: 97%">

        <table id="lsalertas"></table>
        <div id="pgalertas"></div>

        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Detalle</legend>
            
            <table>
                <tr>
                    <td>
                        <label>TOTAL PUNTOS</label>
                    </td>
                    <td>
                        <label style="color: #000099;" id="total_puntos">0.00</label>
                    </td>
                    <td>
                        <label>&nbsp;&nbsp;TOTAL RECEPCIONADOS</label>
                    </td>
                    <td>
                        <label style="color: #000099;" id="total_recepcionados">0.00</label>
                    </td>
                    <td>
                        <label>&nbsp;&nbsp;TOTAL PENDIENTES</label>
                    </td>
                    <td>
                        <label style="color: #000099;" id="total_pendoentes">0.00</label>
                    </td>
                    <td>
                        <label>&nbsp;&nbsp;AVANCE</label>
                    </td>
                    <td>
                        <label style="color: #000099;" id="total_avance">0.00 %</label>
                    </td>
                </tr>
            </table>
        </fieldset>

</div>