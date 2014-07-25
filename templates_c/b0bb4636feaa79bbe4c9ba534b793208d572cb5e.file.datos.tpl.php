<?php /* Smarty version 3.0rc1, created on 2014-07-04 12:18:24
         compiled from "./templates/oficina/datos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9235424653b6e1e041bd07-64216091%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0bb4636feaa79bbe4c9ba534b793208d572cb5e' => 
    array (
      0 => './templates/oficina/datos.tpl',
      1 => 1403824735,
    ),
  ),
  'nocache_hash' => '9235424653b6e1e041bd07-64216091',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/mnt/Datos/Proyectos/php/alertas/smarty/plugins/modifier.replace.php';
?><form action="/index.php/Modulos/guardar" title="Administrar Oficinas" method="post" id="oform" class="formulario ">

    <table style="width: 100%">
        <tr>
            <td>
                <label class="required" for="nombre">Nombre</label>
                <br/>
                <input type="text" name="nombre" id="nombre" class="text ui-widget-content ui-corner-all" style="width: 100%"/>
            </td>
        </tr>
        <tr>
            <td>
                <label class="required" for="telefono">Telefono</label>
                <br/>
                <input type="text" name="telefono" id="telefono" class="text ui-widget-content ui-corner-all" style="width: 100%" onkeypress="return validarNumeros(event);"/>
            </td>
        </tr>
        <tr>
            <td>
                <label class="required" for="abreviatura">Abreviatura</label>
                <br/>
                <input type="text" name="abreviatura" id="abreviatura" class="text ui-widget-content ui-corner-all" style="width: 100%"/>
            </td>
        </tr>
        <tr>
            <td>
                <label class="required" for="id_tipo_oficina">Tipo Oficina:</label><br/>
                <select name="id_tipo_oficina" id="id_tipo_oficina" class="full"  title="Seleccione un tipo oficina" style="width: 100%">
                    <?php  $_smarty_tpl->tpl_vars["to"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('tipo')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["to"]->key => $_smarty_tpl->tpl_vars["to"]->value){
?>
                        <option value="<?php echo $_smarty_tpl->getVariable('to')->value->id_tipo_oficina;?>
" ><?php echo $_smarty_tpl->getVariable('to')->value->descripcion;?>
</option>
                    <?php }} ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label class="required" for="id_municipalidad">Entidad::</label><br/>
                <select name="id_municipalidad" id="id_municipalidad" class="full"  title="Seleccione una municipalidad" style="width: 100%">
                    <?php  $_smarty_tpl->tpl_vars["m"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('entidad')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["m"]->key => $_smarty_tpl->tpl_vars["m"]->value){
?>
                        <option value="<?php echo $_smarty_tpl->getVariable('m')->value->id_municipalidad;?>
" ><?php echo $_smarty_tpl->getVariable('m')->value->razon_social;?>
</option>
                    <?php }} ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label class="required" for="padre">Dependencia:</label><br/>
                <select name="padre" id="padre" class="full"  title="Seleccione una dependencia" style="width: 100%">
                    <option value="0">NINGUNA</option>
                    <?php  $_smarty_tpl->tpl_vars["p"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('padre')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["p"]->key => $_smarty_tpl->tpl_vars["p"]->value){
?>
                        <option value="<?php echo $_smarty_tpl->getVariable('p')->value['id_oficina'];?>
" ><?php echo smarty_modifier_replace($_smarty_tpl->getVariable('p')->value['nombre'],"=","&nbsp;");?>
</option>
                    <?php }} ?>
                </select>
            </td>
        </tr>
    </table>

    <input type="hidden" name="id_oficina" id="id_oficina" value ="-1"/>

</form>