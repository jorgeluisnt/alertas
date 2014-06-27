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
function smarty_modifier_file_ext($string,$col = '',$exts=array('jpg','jpeg','gif','png'))
{
    $return = null;

        if (is_a($string, 'ORMCollection')){

            foreach ($string as $value) {

               $fichero = strtolower($value->$col) ;
               $extension = split("[/\\.]", $fichero) ;
               $n = count($extension)-1;
               $extension = $extension[$n];

               if (array_search($extension, $exts) != false){
                   $return = $value->$col;
                   break;
               }

            }
        }else{
            if (is_array($string)){

                foreach ($string as $value) {
                    if (is_array($value)){
                        $valor = $value->$col;
                    }else{
                        $valor = $value->$col;
                    }
                   $fichero = strtolower($valor) ;
                   $extension = split("[/\\.]", $fichero) ;
                   $n = count($extension)-1;
                   $extension = $extension[$n];
                   foreach ($exts as $key => $val) {
                       if ($val == $extension){
                           $return = $valor;
                           break;
                       }
                   }

                }
            }else{
               $fichero = strtolower($string) ;
               $extension = split("[/\\.]", $fichero) ;
               $n = count($extension)-1;
               $extension = $extension[$n];
               $return = $extension;
            }
        }

        return $return;
} 

?>
