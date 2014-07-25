<?php /* Smarty version 3.0rc1, created on 2014-07-21 18:51:19
         compiled from "./templates/alertas/form.html" */ ?>
<?php /*%%SmartyHeaderCode:87443700153cda7774da691-57924001%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1cfa4a2d16709a548329b76bb9fde5ba4eab01c5' => 
    array (
      0 => './templates/alertas/form.html',
      1 => 1405986634,
    ),
  ),
  'nocache_hash' => '87443700153cda7774da691-57924001',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('links')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/modulos/alertas.js"></script>

<script type="text/javascript">

    <?php echo $_smarty_tpl->getVariable('grilla')->value;?>


</script>


<div style="width: 97%">

        <table id="lsalertas"></table>
        <div id="pgalertas"></div>

        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Operaciones</legend>

            <button id="nuevo_alertas">Ver Mensajes</button>
            <button id="recepcionar_alertas">Recepcionar Informacion</button>
            <button id="reenviar_alertas">Reenviar Mensajes</button>
            
        </fieldset>

</div>

<div id="dlgRecepcionar" title="Recepcionar Informacion" style="display: none;">
    
    <table>
        <tr>
            <td>
                <label>Fecha Recepcion</label>
            </td>
            <td>
                <input type="text" id="fecha_fin" value="" class="text ui-widget-content ui-corner-all" style="width: 100px" name="fecha_fin" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Link Archivo</label>
            </td>
            <td>
                <input type="text" id="link_archivo_subido" value="" class="text ui-widget-content ui-corner-all" style="width: 300px" name="link_archivo_subido" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Observaciones</label>
            </td>
            <td>
                <textarea name="observaciones" id="observaciones" rows="4" cols="20" style="width: 300px;"></textarea>
            </td>
        </tr>
    </table>
    
</div>

<div id="dlgMensajesEnviados" title="Lista de Mensajes Enviados">
    <div style="border: solid 1px #CCC; margin-top: 10px">
        <table class="detalle_header" style="margin-right:16px; border-spacing:0; margin-top:0; width:100%;">
            <thead>
                <tr>
                    <th width="10%">Fecha Envio</th>
                    <th width="85%">Funcionario</th>
                    <th width="5%">Ver</th>
                </tr>
            </thead>
        </table>
    </div>
    <div style="overflow-y: scroll; overflow-x: hidden; height: 180px; border: solid 1px #CCC;">
        <table class="table-details detalle_body" style="border: 0; width: 100%;" id="lsMensajesEnviados">
            <thead>
                <tr>
                    <th width="10%"></th>
                    <th width="85%"></th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div id="dlgVerMensaje" title="Mensaje Enviado">
    <div id="valMsg"></div>
</div>