<?php
    include_once('phpORM/ORMBase.php');
    include_once('config_db.php');

    class Funcionario extends ORMBase{
        
       protected $tablename = 'alertas.funcionario';

       protected $hasone = array(
           'Oficina' => 'Oficina',
           'Cargo' => 'Cargo'
        );
       
        public static function getFuncionarios($texto,$limit){
                $sql = "
                        select  f.nombres || ' ' || f.apellidos as funcionario
                        from alertas.funcionario f
                        where f.estado = 'A' and (upper(f.nombres) like upper('%".$texto."%') or upper(f.apellidos) like upper('%".$texto."%'))
                        order by f.nombres offset 0 limit ? 
                   ";

                $rest = ORMConnection::Execute($sql,array($limit));
                
                if (count($rest) > 0){
                    $arr = array();
                    
                    foreach ($rest as $value) {
                        $arr[] = $value['funcionario'];
                    }                    
                    return $arr;
                }else{
                    return array();
                }

        }
        
        public static function getFuncionariosAll(){
                $sql = "
                        select  f.id_funcionario,f.apellidos || ', ' || f.nombres as funcionario
                        from alertas.funcionario f
                        where f.estado = 'A' 
                        order by f.apellidos,f.nombres
                   ";

                $rest = ORMConnection::Execute($sql);
                return $rest;
        }
        
    }
?>