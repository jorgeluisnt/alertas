<?php /* Smarty version 3.0rc1, created on 2014-07-04 13:49:21
         compiled from "./templates/tipo_oficina/form.html" */ ?>
<?php /*%%SmartyHeaderCode:77471257753b6f731f1dd85-72349138%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '136914678a1b4ee6f2d3d56ca6729de27459b418' => 
    array (
      0 => './templates/tipo_oficina/form.html',
      1 => 1403824736,
    ),
  ),
  'nocache_hash' => '77471257753b6f731f1dd85-72349138',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

 <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('links')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/modulos/tipo_oficina.js"></script>

<script type="text/javascript">

<?php echo $_smarty_tpl->getVariable('grilla')->value;?>


</script>


<div style="width: 100%">
    
    <div style="width: 451px;float: left">
        
        <table id="lstipo_oficina"></table>
        <div id="pgtipo_oficina"></div>
        
        
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Operaciones</legend>
            
            <button id="nuevo_tipo_oficina">Nuevo</button>
            <button id="modificar_tipo_oficina">Modificar</button>
            <button id="anular_tipo_oficina">Anular</button>
        </fieldset>
        
    </div>
    
    <div style="width: 400px;float: left;" >
        
    <fieldset class="ui-widget ui-widget-content"> 
      <legend class="ui-widget-header ui-corner-all">Datos</legend>
        
        <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('datos')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

      
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Confirmar</legend>

            <button id="guardar_tipo_oficina">Guardar</button>
            <button id="cancelar_tipo_oficina">Cancelar</button>
        </fieldset>
        
    </fieldset>
    
    </div>
    
</div>



