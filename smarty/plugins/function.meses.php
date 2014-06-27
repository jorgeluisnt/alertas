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
function smarty_function_meses($string)
{
    $return = null;

    $cad = $string['mes'];

    switch ($cad) {
        case 1:
            $return = 'Enero';
            break;
        case 2:
            $return = 'Febrero';
            break;
        case 3:
            $return = 'Marzo';
            break;
        case 4:
            $return = 'Abril';
            break;
        case 5:
            $return = 'Mayo';
            break;
        case 6:
            $return = 'Junio';
            break;
        case 7:
            $return = 'Julio';
            break;
        case 8:
            $return = 'Agosto';
            break;
        case 9:
            $return = 'Setiembre';
            break;
        case 10:
            $return = 'Octubre';
            break;
        case 11:
            $return = 'Noviembre';
            break;
        case 12:
            $return = 'Diciembre';
            break;
        
        default:
            $return = $string;
            break;
    }

    return $return;
} 

?>
