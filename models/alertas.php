<?php
    include_once('phpORM/ORMBase.php');

    class Alertas extends ORMBase{
       protected $tablename = 'alertas.alertas';

       public static function getResumen(){
            $sql = "
                select 
                        (select coalesce(sum(p.puntaje),0) from alertas.programacion p where p.estado = 'A' ) as total,
                        coalesce((select coalesce(sum(pp.puntaje),0) from alertas.alertas a 
                        inner join alertas.programacion pp on a.id_programacion = pp.id_programacion 
                        where a.estado = 'A' and a.estado_alerta = 'PENDIENTE'),0) as pendiente,
                        coalesce((select coalesce(sum(pp.puntaje),0) from alertas.alertas a 
                        inner join alertas.programacion pp on a.id_programacion = pp.id_programacion 
                        where a.estado = 'A' and a.estado_alerta = 'RECEPCIONADO'),0) as recepcionado 
	       ";

            return ORMConnection::Execute($sql)[0];
       }
    }
?>
