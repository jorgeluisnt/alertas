<?php /* Smarty version 3.0rc1, created on 2014-07-04 12:18:24
         compiled from "./templates/oficina/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:89770816553b6e1e03430b9-72316539%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e09740901d38a16a2bbcc434c5d30a2a0bb53883' => 
    array (
      0 => './templates/oficina/form.tpl',
      1 => 1403824735,
    ),
  ),
  'nocache_hash' => '89770816553b6e1e03430b9-72316539',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
 <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('links')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

 
 <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/modulos/oficina.js"></script>
 
<script type="text/javascript">

<?php echo $_smarty_tpl->getVariable('grilla')->value;?>



</script>

<div style="width: 100%">
    
    <div style="width: 410px;float: left">
        
        <table id="TTabla"></table>
        <div id="DTabla"></div>
        
        
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Operaciones</legend>
            
            <button id="nuevo">Nuevo</button>
            <button id="modificar" >Modificar</button>
            <button id="eliminar" >Eliminar</button>
            <span id="load"></span>
        </fieldset>
        
    </div>
    
    <div style="width: 400px;float: left" >
        
    <fieldset class="ui-widget ui-widget-content"> 
      <legend class="ui-widget-header ui-corner-all">Datos</legend>
        
        <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('datos')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

      
        <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
            <legend class="ui-widget-header ui-corner-all">Confirmar</legend>

            <button id="guardar" >Guardar</button>
            <button id="cancelar" >Cancelar</button>
        </fieldset>
        
    </fieldset>
    
    </div>
    
</div>
