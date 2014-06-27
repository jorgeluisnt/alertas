<?php
include_once('phpORM/ORMBase.php');

class Municipalidad extends ORMBase{
    protected $tablename = 'alertas.municipalidad';

    protected $hasone = array(
        'Ubigeo' => 'Ubigeo'
    );
    
    protected $hasmany = array(
        'Sectores' => 'Sectores'
    );
}

?>
