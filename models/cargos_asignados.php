<?php
    include_once('phpORM/ORMBase.php');

    class Cargos_Asignados extends ORMBase{
       protected $tablename = 'alertas.cargos_asignados';

       public static function getCargos($id_programacion){
           $sql= "select ca.id_cargos_asignados,c.descripcion as cargo,o.descripcion as oficina
            from alertas.cargos_asignados ca
            inner join alertas.cargo c on ca.id_cargo = c.id_cargo
            inner join alertas.oficina o on c.id_oficina = o.id_oficina
            where ca.estado = 'A' and ca.id_programacion = $id_programacion
            order by ca.id_cargos_asignados ";
           
           return ORMConnection::Execute($sql);
           
       }
    }
?>
