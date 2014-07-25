<?php /* Smarty version 3.0rc1, created on 2014-07-04 12:17:48
         compiled from "./templates/cargo/datos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:55252568953b6e1bc3b5721-25951766%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9b95c44598f02a06006f01ce55f827f6d00207a5' => 
    array (
      0 => './templates/cargo/datos.tpl',
      1 => 1403824734,
    ),
  ),
  'nocache_hash' => '55252568953b6e1bc3b5721-25951766',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/mnt/Datos/Proyectos/php/alertas/smarty/plugins/modifier.replace.php';
?>        <form action="/index.php/Modulos/guardar" title="Administrar Cargos" method="post" id="cargosform" class="formulario ">

            <table style="width: 100%">
                <tr>
                    <td>
                        <label class="required" for="descripcion">Descripcion</label>
                        <br/>
                        <input type="text" name="descripcion" id="descripcion" class="text ui-widget-content ui-corner-all" style="width: 100%"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="required" for="id_oficina">Dependencia:</label><br/>
                        <select name="id_oficina" id="id_oficina" title="Seleccione una dependencia" style="width: 100%">
                            <?php  $_smarty_tpl->tpl_vars["o"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('oficina')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["o"]->key => $_smarty_tpl->tpl_vars["o"]->value){
?>
                                <option value="<?php echo $_smarty_tpl->getVariable('o')->value['id_oficina'];?>
" ><?php echo smarty_modifier_replace($_smarty_tpl->getVariable('o')->value['nombre'],"=","&nbsp;");?>
</option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="required" for="id_perfil">Perfil:</label><br/>
                        <select name="id_perfil" id="id_perfil" title="Seleccione un perfil" style="width: 100%">
                            <?php  $_smarty_tpl->tpl_vars["p"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('perfil')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["p"]->key => $_smarty_tpl->tpl_vars["p"]->value){
?>
                                <option value="<?php echo $_smarty_tpl->getVariable('p')->value->id_perfil;?>
" ><?php echo $_smarty_tpl->getVariable('p')->value->descripcion;?>
</option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>
            </table>
            
            <input type="hidden" name="id_cargo" id="id_cargo" value ="-1"/>
            
        </form>