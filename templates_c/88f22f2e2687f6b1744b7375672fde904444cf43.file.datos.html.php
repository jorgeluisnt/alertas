<?php /* Smarty version 3.0rc1, created on 2014-06-26 20:07:14
         compiled from "./templates/plantilla_mensajes/datos.html" */ ?>
<?php /*%%SmartyHeaderCode:190757514253acc3c26d5992-14587739%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '88f22f2e2687f6b1744b7375672fde904444cf43' => 
    array (
      0 => './templates/plantilla_mensajes/datos.html',
      1 => 1403824736,
    ),
  ),
  'nocache_hash' => '190757514253acc3c26d5992-14587739',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form action="/index.php/plantilla_mensajes/guardar" title="Administra Municipalidades" method="post" id="frm_plantilla_mensajes" class="formulario ">
            <table style="width: 100%">
                <tr>
                    <td>
                        <label class="required" for="descripcion">Descripcion</label>
                        <br/>
                        <input type="text" name="descripcion" id="descripcion" class="text ui-widget-content ui-corner-all" style="width: 100%" onkeypress="return validarLetras(event);"/>                        
                        </br>
                    </td>
                </tr>
            </table>
            
            <input type="hidden" name="id_plantilla_mensajes" id="id_plantilla_mensajes" value ="-1"/>
</form>