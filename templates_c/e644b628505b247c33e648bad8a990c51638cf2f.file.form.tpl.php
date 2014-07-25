<?php /* Smarty version 3.0rc1, created on 2014-07-03 11:11:16
         compiled from "./templates/modulos/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:162540334553b580a4623006-53392586%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e644b628505b247c33e648bad8a990c51638cf2f' => 
    array (
      0 => './templates/modulos/form.tpl',
      1 => 1403824735,
    ),
  ),
  'nocache_hash' => '162540334553b580a4623006-53392586',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

 <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('links')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/modulos/modulos.js"></script>

<script type="text/javascript">

<?php echo $_smarty_tpl->getVariable('grilla')->value;?>


</script>


<div style="width: 100%">
    
    <div style="width: 410px;float: left">
        
        <table id="lsmodulos"></table>
        <div id="pgmodulos"></div>
        
        
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Operaciones</legend>
            
            <button id="nuevo_modulos">Nuevo</button>
            <button id="modificar_modulos">Modificar</button>
            <button id="anular_modulos">Anular</button>
        </fieldset>
        
    </div>
    
    <div style="width: 400px;float: left" >
        
    <fieldset class="ui-widget ui-widget-content"> 
      <legend class="ui-widget-header ui-corner-all">Datos</legend>
        
        <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('datos')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

      
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Confirmar</legend>

            <button id="guardar_modulos" />Guardar</button>
            <button id="cancelar_modulos" />Cancelar</button>
        </fieldset>
        
    </fieldset>
    
    </div>
    
</div>



