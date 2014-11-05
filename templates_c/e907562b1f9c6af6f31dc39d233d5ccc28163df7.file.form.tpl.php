<?php /* Smarty version 3.0rc1, created on 2014-08-07 16:25:10
         compiled from "./templates/funcionario/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:75580179353e3eeb69b0a49-60216343%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e907562b1f9c6af6f31dc39d233d5ccc28163df7' => 
    array (
      0 => './templates/funcionario/form.tpl',
      1 => 1403824734,
    ),
  ),
  'nocache_hash' => '75580179353e3eeb69b0a49-60216343',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('links')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('HOST')->value;?>
js/modulos/funcionario.js"></script>
<script type="text/javascript">

        <?php echo $_smarty_tpl->getVariable('grilla')->value;?>


</script>

    <fieldset class="ui-widget ui-widget-content" style="width: 80%;float: left;">
        <legend class="ui-widget-content ui-widget-header">Administraci&oacute;n de Funcionarios</legend>
        <table id="TTabla"></table>
        <div id="DTabla"></div>
    </fieldset>

        <div id="botones" style="width: 15%;float:left;">
            <?php if ($_smarty_tpl->getVariable('activo')->value=='A'){?>
            <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
                <legend class="ui-widget-header ui-corner-all">Operaciones</legend>

                <button id="nuevo" >Nuevo Personal</button>
                <button id="modificar" >Modificar Personal</button>
                <button id="eliminar" >Eliminar Personal</button>


            </fieldset>
            <?php }?>
             <fieldset class="ui-widget ui-widget-content" style="margin-top: 5px;"> 
                  <legend class="ui-widget-header ui-corner-all">Habilitar</legend>
             <?php if ($_smarty_tpl->getVariable('activo')->value=='A'){?>
                <button id="inactivo_btn">Inactivos</button>
            <?php }else{ ?>
                <button id="habilitar_btn">Habilitar</button>
                <button id="atras">Atras</button>

            <?php }?>
             </fieldset>
        </div>

        
<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('datos')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


