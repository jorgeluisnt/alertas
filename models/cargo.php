<?php
    include_once('phpORM/ORMBase.php');

    class Cargo extends ORMBase{
       protected $tablename = 'alertas.cargo';

       protected $hasone = array(
           'Oficina' => 'Oficina',
           'Perfil' => 'Perfil'
        );

    }
?>
