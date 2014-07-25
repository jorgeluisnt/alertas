<?php /* Smarty version 3.0rc1, created on 2014-07-04 12:17:48
         compiled from "./templates/cargo/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:77622758253b6e1bc242c14-93168985%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f97a5be71cf383b0375fa482936b3081c6bd92f' => 
    array (
      0 => './templates/cargo/form.tpl',
      1 => 1403824734,
    ),
  ),
  'nocache_hash' => '77622758253b6e1bc242c14-93168985',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
 <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('links')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

 
 
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/modulos/cargo.js"></script>
 
<script type="text/javascript">

        <?php echo $_smarty_tpl->getVariable('grilla')->value;?>



</script>


<div style="width: 100%">
    
    <div style="width: 410px;float: left">
        
        <table id="TTabla"></table>
        <div id="DTabla"></div>
        
        
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Operaciones</legend>
            
            <button id="nuevo" >Nuevo</button>
            <button id="modificar" >Modificar</button>
            <button id="eliminar" >Eliminar</button>

        </fieldset>
        
    </div>
    
    <div style="width: 400px;float: left" >
        
    <fieldset class="ui-widget ui-widget-content"> 
      <legend class="ui-widget-header ui-corner-all">Datos</legend>
        
      <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('datos')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

      
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Confirmar</legend>

            <button id="guardar_modulos" >Guardar</button>
            <button id="cancelar_modulos" >Cancelar</button>
        </fieldset>
        
    </fieldset>
    
    </div>
    
</div>