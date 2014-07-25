<?php /* Smarty version 3.0rc1, created on 2014-07-24 19:30:46
         compiled from "./templates/programacion/form.html" */ ?>
<?php /*%%SmartyHeaderCode:73992257753d1a536a96e05-25372223%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ed3e28feeacb234d135c134fee4beb2c30cf0ad' => 
    array (
      0 => './templates/programacion/form.html',
      1 => 1406246809,
    ),
  ),
  'nocache_hash' => '73992257753d1a536a96e05-25372223',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/mnt/Datos/Proyectos/php/alertas/smarty/plugins/modifier.replace.php';
?>
<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('links')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/modulos/programacion.js"></script>

<script type="text/javascript">

    <?php echo $_smarty_tpl->getVariable('grilla')->value;?>


</script>


<div style="width: 97%">

        <table id="lsprogramacion"></table>
        <div id="pgprogramacion"></div>

        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Operaciones</legend>

            <button id="nuevo_programacion">Nuevo</button>
            <button id="modificar_programacion">Modificar</button>
            <button id="anular_programacion">Anular</button>
            
            <button id="asignar_cargos">Asignar Cargos</button>
            <button id="fechas_alertas">Fechas Alertas</button>
            <button id="fechas_masivas">Fechas Masivas</button>
        </fieldset>

</div>

<div id="dlgProgramacion" title="Programacion de alertas" >

    <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('datos')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


</div>

<div id="dlgCargos" title="Asignacion de cargos">
    
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Datos</legend>

            <table>
                <tr>
                    <td><label>Oficina</label></td>
                    <td colspan="2">
                        <select name="id_oficina" id="id_oficina" style="width: 300px;" title="Seleccione una oficina" onchange="cargarCargos();">
                            <option value="0" >.: SELECCIONE :.</option>
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
                    <td><label>Cargo</label></td>
                    <td>
                        <select name="id_cargo" id="id_cargo" style="width: 200px;" title="Seleccione un cargo">
                        </select>
                    </td>
                    <td>
                        <button id="agregar">Agregar</button>
                    </td>
                </tr>
            </table>
            
        </fieldset>
    
        <div style="border: solid 1px #CCC; margin-top: 10px">
            <table class="detalle_header" style="margin-right:16px; border-spacing:0; margin-top:0; width:100%;">
                <thead>
                    <tr>
                        <th width="45%">Oficina</th>
                        <th width="45%">Cargo</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="overflow-y: scroll; overflow-x: hidden; height: 180px; border: solid 1px #CCC;">
            <table class="table-details detalle_body" style="border: 0; width: 100%;" id="detalle">
                <thead>
                    <tr>
                        <th width="45%"></th>
                        <th width="45%"></th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
</div>

<div id="dlgDetalle" title="Detalle de programacion">
    <table style="width: 100%;">
        <tr>
            <td colspan="2">
                <label>Programacion:</label>
                <input type="text" name="nProgramacion" id="nProgramacion" value="" readonly="readonly" style="width: 500px;"/>
            </td>
        </tr>
        <tr>
            <td style="width: 50%">
                <div style="border: solid 1px #CCC; margin-top: 10px">
                    <table class="detalle_header" style="margin-right:16px; border-spacing:0; margin-top:0; width:100%;">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="95%">Periodos</th>
                                <th width="5%"><a href="#" title="Agregar Periodo" class="addPeriodo"><img src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/add.png"/></a></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div style="overflow-y: scroll; overflow-x: hidden; height: 180px; border: solid 1px #CCC;">
                    <table class="table-details detalle_body" style="border: 0; width: 100%;" id="lsPeriodos">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="90%"></th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </td>
            <td style="width: 50%">
                <div style="border: solid 1px #CCC; margin-top: 10px">
                    <table class="detalle_header" style="margin-right:16px; border-spacing:0; margin-top:0; width:100%;">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="45%">Fecha Alerta</th>
                                <th width="45%">Fecha Final</th>
                                <th width="5%"><a href="#" title="Agregar Fechas" class="addFechas"><img src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/add.png"/></a></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div style="overflow-y: scroll; overflow-x: hidden; height: 180px; border: solid 1px #CCC;">
                    <table class="table-details detalle_body" style="border: 0; width: 100%;" id="lsFechas">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="45%"></th>
                                <th width="45%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>

<div id="dlgAddPeriodo" title="Agregar Periodo">
    <table>
        <tr>
            <td>
                <label>Mes:</label>
            </td>
            <td>
                <select name="mes" id="mes" style="width: 100px;">
                    <option value="1">ENERO</option>
                    <option value="2">FEBRERO</option>
                    <option value="3">MARZO</option>
                    <option value="4">ABRIL</option>
                    <option value="5">MAYO</option>
                    <option value="6">JUNIO</option>
                    <option value="7">JULIO</option>
                    <option value="8">AGOSTO</option>
                    <option value="9">SEPTIEMBRE</option>
                    <option value="10">OCTUBRE</option>
                    <option value="11">NOVIEMBRE</option>
                    <option value="12">DICIEMBRE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label>Año:</label>
            </td>
            <td>
                <select name="anio" id="anio" style="width: 100px;">
                    <?php  $_smarty_tpl->tpl_vars["p"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('date')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["p"]->key => $_smarty_tpl->tpl_vars["p"]->value){
?>
                        <option value="<?php echo $_smarty_tpl->getVariable('p')->value;?>
" ><?php echo $_smarty_tpl->getVariable('p')->value;?>
</option>
                    <?php }} ?>
                </select>
            </td>
        </tr>
    </table>
</div>

<div id="dlgFechas" title="Fechas de publicacion">
    <table>
        <tr>
            <td>
                <label>Fecha Envio:</label>
            </td>
            <td>
                <input type="text" name="f_fecha_mensaje" id="f_fecha_mensaje" value="" readonly="readonly" style="width: 100px;"/>
            </td>
        </tr>
        <tr>
            <td>
                <label>Fecha Fin Tarea:</label>
            </td>
            <td>
                <input type="text" name="f_fecha_final" id="f_fecha_final" value="" readonly="readonly" style="width: 100px;"/>
            </td>
        </tr>
    </table>
</div>

<div id="DlgMasivo" title="Agregar Fechas Masivas">
    <table>
        <tr>
            <td>Periodicidad</td>
            <td>
                <select name="tipo_pe" id="tipo_pe" style="width: 150px" title="Seleccione periodo">
                    <option value="DIARIO">DIARIO</option>
                    <option value="MENSUAL">MENSUAL</option>
                    <option value="TRIMESTRAL">TRIMESTRAL</option>
                    <option value="SEMESTRAL">SEMESTRAL</option>
                    <option value="ANUAL">ANUAL</option>
                    <option value="VARIABLE">VARIABLE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Periodo</td>
            <td>
                <select name="anio_per" id="anio_per" style="width: 100px;">
                    <?php  $_smarty_tpl->tpl_vars["p"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('date')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["p"]->key => $_smarty_tpl->tpl_vars["p"]->value){
?>
                        <option value="<?php echo $_smarty_tpl->getVariable('p')->value;?>
" ><?php echo $_smarty_tpl->getVariable('p')->value;?>
</option>
                    <?php }} ?>
                </select>
                <select name="mes_per" id="mes_per" style="width: 100px;">
                    <option value="1">ENERO</option>
                    <option value="2">FEBRERO</option>
                    <option value="3">MARZO</option>
                    <option value="4">ABRIL</option>
                    <option value="5">MAYO</option>
                    <option value="6">JUNIO</option>
                    <option value="7">JULIO</option>
                    <option value="8">AGOSTO</option>
                    <option value="9">SEPTIEMBRE</option>
                    <option value="10">OCTUBRE</option>
                    <option value="11">NOVIEMBRE</option>
                    <option value="12">DICIEMBRE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;background-color: #ffffcc;">
                <label>.: FECHAS :.</label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="border: solid 1px #CCC; margin-top: 10px">
                    <table class="detalle_header" style="margin-right:16px; border-spacing:0; margin-top:0; width:100%;">
                        <thead>
                            <tr>
                                <th width="45%">Fecha Alerta</th>
                                <th width="45%">Fecha Final</th>
                                <th width="5%"><a href="#" title="Agregar Fechas" class="addFechasAdd"><img src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
images/add.png"/></a></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div style="overflow-y: scroll; overflow-x: hidden; height: 180px; border: solid 1px #CCC;">
                    <table class="table-details detalle_body" style="border: 0; width: 100%;" id="lsFechasAdd">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="45%"></th>
                                <th width="45%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>

<div id="dlgFechasAdd" title="Fechas de publicacion">
    <table>
        <tr>
            <td>
                <label>Fecha Envio:</label>
            </td>
            <td>
                <input type="text" name="f_fecha_mensaje_add" id="f_fecha_mensaje_add" value="" readonly="readonly" style="width: 100px;"/>
            </td>
        </tr>
        <tr>
            <td>
                <label>Fecha Fin Tarea:</label>
            </td>
            <td>
                <input type="text" name="f_fecha_final_add" id="f_fecha_final_add" value="" readonly="readonly" style="width: 100px;"/>
            </td>
        </tr>
    </table>
</div>