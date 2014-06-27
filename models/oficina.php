<?php
    include_once('phpORM/ORMBase.php');

    class Oficina extends ORMBase{
        
       protected $hasone = array(
           'Tipo_Oficina' => 'Tipo_Oficina'
        );
       
        protected $tablename = 'alertas.oficina';
        
        public static function getOficinasDependencia($iddependencia,$numespacios,$condicion = ''){

                $string = '';

                $idoficina ='';

                if ($numespacios > 0)
                    $string = str_repeat('====', $numespacios).'ʟ_ ';

                $sql = "
                        SELECT id_oficina,?||nombre as nombre
                        FROM alertas.oficina
                        where estado = 'A' and padre = ? $condicion $idoficina
                        order by nombre;
                   ";

                $rst= ORMConnection::Execute($sql,array($string,$iddependencia));

                $resultado = array();

                if (count($rst) > 0){

                    foreach( $rst as $item){
                             $resultado [] = $item;

                             $rs = Oficina::getOficinasDependencia($item['id_oficina'], $numespacios + 1,$condicion);

                             if ($rs != null){
                                foreach( $rs as $items){
                                         $resultado [] = $items;
                                 }
                             }

                     }

                }  else {
                    return null;
                }

                return $resultado;

        }
    }
?>
