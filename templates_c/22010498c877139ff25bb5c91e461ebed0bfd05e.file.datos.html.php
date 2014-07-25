<?php /* Smarty version 3.0rc1, created on 2014-07-04 03:10:30
         compiled from "./templates/programacion/datos.html" */ ?>
<?php /*%%SmartyHeaderCode:25091801953b6617646ac44-76091457%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22010498c877139ff25bb5c91e461ebed0bfd05e' => 
    array (
      0 => './templates/programacion/datos.html',
      1 => 1404410488,
    ),
  ),
  'nocache_hash' => '25091801953b6617646ac44-76091457',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form action="/index.php/programacion/guardar" title="Administra Municipalidades" method="post" id="frm_programacion" class="formulario ">
    <table>
        <tr>
            <td style="vertical-align: top;" colspan="2">
                <label class="required" for="descripcion">Descripcion</label><br/>
                <input type="text" name="descripcion" id="descripcion" class="text ui-widget-content ui-corner-all" style="width: 400px" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>Plantilla mensaje:</label><br/>
                <select name="id_plantilla_mensajes" id="id_plantilla_mensajes" class="full"  title="Seleccione una plantilla para mensajes" style="width: 400px">
                    <?php  $_smarty_tpl->tpl_vars["m"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('plantilla_mensajes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["m"]->key => $_smarty_tpl->tpl_vars["m"]->value){
?>
                        <option value="<?php echo $_smarty_tpl->getVariable('m')->value->id_plantilla_mensajes;?>
" ><?php echo $_smarty_tpl->getVariable('m')->value->descripcion;?>
</option>
                    <?php }} ?>
                </select>
            </td>           
        </tr>
        <tr>
            <td colspan="2">
                <label>Puntaje:</label><br/>
                <input type="text" name="puntaje" id="puntaje" class="text ui-widget-content ui-corner-all" style="width: 100px" onkeypress="return validarNumeros(event);"/>
            </td>           
        </tr>
        <tr>
            <td colspan="2">
                <label>Periodicidad</label><br/>
                <select name="tipo_periodo" id="tipo_periodo" style="width: 150px" title="Seleccione periodo de inicio">
                    <option value="DIARIO">DIARIO</option>
                    <option value="MENSUAL">MENSUAL</option>
                    <option value="TRIMESTRAL">TRIMESTRAL</option>
                    <option value="SEMESTRAL">SEMESTRAL</option>
                    <option value="ANUAL">ANUAL</option>
                    <option value="VARIABLE">VARIABLE</option>
                </select>
            </td>           
        </tr>
        <!--<tr>
            <td>
                <label>Dias entre mensaje:</label><br/>
                <input type="text" name="num_dias_entre_mensaje" id="num_dias_entre_mensaje" class="text ui-widget-content ui-corner-all" style="width: 150px" onkeypress="return validarNumeros(event);"/>
            </td>
            <td>
                <label>Num. Max. Mensajes:</label><br/>
                <input type="text" name="num_max_mensajes" id="num_max_mensajes" class="text ui-widget-content ui-corner-all" style="width: 150px" onkeypress="return validarNumeros(event);" title="0 para indeterminado solo dejara de publicar si esta publicado o vencido"/>
            </td>
        </tr>
        <tr>
            <td>
                <label>Periodo Inicio:</label><br/>
                <select name="tipo_periodo" id="tipo_periodo" style="width: 150px" title="Seleccione periodo de inicio">
                    <option value="POR DIA">POR DIA</option>
                    <option value="POR MES">POR MES</option>
                </select>
            </td>
            <td>
                <label>Numero de periodo</label><br/>
                <input type="text" name="num_unidades_periodo" id="num_unidades_periodo" class="text ui-widget-content ui-corner-all" style="width: 150px" onkeypress="return validarNumeros(event);"/>
            </td>        
        </tr>-->
    </table>

    <input type="hidden" name="id_programacion" id="id_programacion" value ="-1"/>
</form>