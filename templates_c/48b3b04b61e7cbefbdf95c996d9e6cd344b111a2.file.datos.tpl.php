<?php /* Smarty version 3.0rc1, created on 2014-08-07 16:25:10
         compiled from "./templates/funcionario/datos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:114118503253e3eeb6a15473-78367630%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48b3b04b61e7cbefbdf95c996d9e6cd344b111a2' => 
    array (
      0 => './templates/funcionario/datos.tpl',
      1 => 1405986868,
    ),
  ),
  'nocache_hash' => '114118503253e3eeb6a15473-78367630',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/mnt/Datos/Proyectos/php/alertas/smarty/plugins/modifier.replace.php';
?><div id="frm_funcionario" title="Administrar Funcionario">
    

    <form id="oform" method="post" action="#" >


                    <table width="100%">
                        <tr>
                            <td>
                                <label class="required" for="nombres">Nombres:</label><br/>
                                <input type="text" id="nombres" class="text ui-widget-content ui-corner-all" style="width: 250px" value="" name="nombres"/>
                                <input type="hidden" id="id_funcionario" class="full" value="-1" name="id_funcionario"/>
                            </td>
                            <td>
                                <label class="required" for="apellidos">Apellidos:</label><br/>
                                <input type="text" id="apellidos" class="text ui-widget-content ui-corner-all" style="width: 250px" value="" name="apellidos"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="required" for="direccion">Direccion:</label><br/>
                                <input type="text" id="direccion" class="text ui-widget-content ui-corner-all" style="width: 100%" value="" name="direccion"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="required" for="dni">Dni:</label><br/>
                                <input type="text" id="dni" value="" class="text ui-widget-content ui-corner-all" style="width: 250px" name="dni" onkeypress="return validarNumeros(event);" maxlength="8"/>
                            </td>
                            <td>
                                <label for="email">Email:</label><br/>
                                <input type="text" id="email" class="text ui-widget-content ui-corner-all" value="" style="width: 250px;text-transform: lowercase;" name="email" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="email_2">Email 2:</label><br/>
                                <input type="text" id="email_2" class="text ui-widget-content ui-corner-all" value="" style="width: 250px;text-transform: lowercase;" name="email_2" />
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="required" for="id_oficina">Dependencia:</label><br/>
                                <select name="id_oficina" id="id_oficina" style="width: 500px;" title="Seleccione una oficina" onchange="cargarCargos();">
                                    <?php  $_smarty_tpl->tpl_vars["p"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('oficina')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                        <tr>
                            <td colspan="2">
                                <label class="required" for="id_cargo">Cargo:</label><br/>
                                <select name="id_cargo" id="id_cargo" style="width: 500px;" title="Seleccione un cargo">
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label class="required" for="id_funcionario_jefe">Jefe:</label><br/>
                                <select name="id_funcionario_jefe" id="id_funcionario_jefe" style="width: 500px;" title="Seleccione una jefe">
                                    <option value="0" >NINGUNO</option>
                                    <?php  $_smarty_tpl->tpl_vars["p"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('funcionarios')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["p"]->key => $_smarty_tpl->tpl_vars["p"]->value){
?>
                                        <option value="<?php echo $_smarty_tpl->getVariable('p')->value['id_funcionario'];?>
" ><?php echo $_smarty_tpl->getVariable('p')->value['funcionario'];?>
</option>
                                    <?php }} ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" name="es_usuario" id="es_usuario" value="ON" /><label class="required" for="usuario">¿Es Usuario del sistema?</label><br/>
                            </td>
                        </tr>
                         <?php if ($_smarty_tpl->getVariable('perfil')->value==1){?>
                             <tr id="trUsuario" style="display: none;">
                                <td>

                                    <label class="required" for="usuario">Usuario:</label><br/>
                                    <input type="text" id="usuario" class="text ui-widget-content ui-corner-all" value="" style="width: 250px;text-transform: lowercase;" name="usuario"/>
                                </td>
                                <td>
                                    <label class="required" for="clave">Clave:</label><br/>
                                    <input type="password" id="clave" class="text ui-widget-content ui-corner-all" value="" style="width: 250px" name="clave"/>
                                </td>
                            </tr>
                        <?php }?>
                    </table>

        </form>
    </div>