<?php
/**
* Smarty plugin
* 
* @package Smarty
* @subpackage PluginsModifier
*/

/**
* Smarty upper modifier plugin
* 
* Type:     modifier<br>
* Name:     upper<br>
* Purpose:  convert string to uppercase
* 
* @link http://smarty.php.net/manual/en/language.modifier.upper.php upper (Smarty online manual)
* @author Monte Ohrt <monte at ohrt dot com> 
* @param string $ 
* @return string 
*/
function smarty_function_fecha_format($string)
{
    $return = null;

    $cad = $string['fecha'];

    if (stripos($cad, '-')){
        $f = explode("-",$cad);
        $return = $f[2] . '/' . $f[1] . '/' . $f[0];
    }else{
        $return = $cad;
    }

    return $return;
} 

?>
