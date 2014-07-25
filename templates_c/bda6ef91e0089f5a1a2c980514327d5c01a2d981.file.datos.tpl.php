<?php /* Smarty version 3.0rc1, created on 2014-07-03 11:11:16
         compiled from "./templates/modulos/datos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:120709529553b580a4766aa8-21413087%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bda6ef91e0089f5a1a2c980514327d5c01a2d981' => 
    array (
      0 => './templates/modulos/datos.tpl',
      1 => 1403824734,
    ),
  ),
  'nocache_hash' => '120709529553b580a4766aa8-21413087',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form action="index.php/Modulos/guardar" title="Administrar Modulos" method="post" id="frm_Modulos" class="formulario ">

            <table style="width: 100%">
                <tr>
                    <td>
                        <label class="required" for="descripcion">Descripcion</label>
                        <br/>
                        <input type="text" name="descripcion" id="descripcion" class="text ui-widget-content ui-corner-all" style="text-transform: none;width: 100%"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label  class="required"  for="url">Url</label>
                        <br/>
                        <input type="text" name="url" id="url" class="text ui-widget-content ui-corner-all" style="text-transform: none;width: 100%" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label  class="required"  for="url">Orden</label>
                        <br/>
                        <input type="text" name="orden" id="orden" class="text ui-widget-content ui-corner-all" style="text-transform: none;width: 100%" onkeypress="return validarNumeros(event);" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label  class="required" for="descripcion">Dependencia</label>
                        <br/>
                        <select name="id_padre" id="id_padre" style="width: 100%" title="Seleccione dependencia">
                            <option value="0" >Ninguno</option>
                            <?php  $_smarty_tpl->tpl_vars["d"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('dependencias')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["d"]->key => $_smarty_tpl->tpl_vars["d"]->value){
?>
                                <option value="<?php echo $_smarty_tpl->getVariable('d')->value->id_modulos;?>
" ><?php echo $_smarty_tpl->getVariable('d')->value->descripcion;?>
</option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>
            </table>
            
            <input type="hidden" name="id_modulos" id="id_modulos" value ="-1"/>
</form>


