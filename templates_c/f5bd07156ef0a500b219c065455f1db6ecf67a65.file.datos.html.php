<?php /* Smarty version 3.0rc1, created on 2014-07-04 13:49:22
         compiled from "./templates/tipo_oficina/datos.html" */ ?>
<?php /*%%SmartyHeaderCode:174013397453b6f732031816-39300949%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f5bd07156ef0a500b219c065455f1db6ecf67a65' => 
    array (
      0 => './templates/tipo_oficina/datos.html',
      1 => 1403824736,
    ),
  ),
  'nocache_hash' => '174013397453b6f732031816-39300949',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form action="/index.php/tipo_oficina/guardar" title="Administra Municipalidades" method="post" id="frm_tipo_oficina" class="formulario ">
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
            
            <input type="hidden" name="id_tipo_oficina" id="id_tipo_oficina" value ="-1"/>
</form>