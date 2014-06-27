<?php
include_once('phpORM/ORMBase.php');

class Modulos extends ORMBase{
    protected $tablename = 'alertas.modulos';

    public static function ModulosPadres($car_id){
            $sql = "
                    select  dm.id_detalle_modulos,m.descripcion,dm.estado,m.id_modulos,m.url
                    from alertas.detalle_modulos dm
                    inner join alertas.modulos m on m.id_modulos = dm.id_modulos
                    where m.id_padre = 0 and m.estado = 'A' and dm.estado = 'A' and dm.id_perfil = ?
                    order by m.orden
	       ";

            return ORMConnection::Execute($sql,array($car_id));

    }

    public static function ModulosHijo($car_id,$idpadre){
            $sql = "
                    select dm.id_detalle_modulos,m.descripcion,dm.estado,m.id_modulos,m.url
                    from alertas.detalle_modulos dm
                    inner join alertas.modulos m on m.id_modulos = dm.id_modulos
                    where m.id_padre = ? and m.estado = 'A' and dm.estado = 'A' and dm.id_perfil = ?
                    order by m.orden
	       ";

            return ORMConnection::Execute($sql,array($idpadre,$car_id));

    }

    public static function modulosPadrescargo($car_id){
            $sql = "
                select  dm.id_detalle_modulos,m.descripcion,dm.estado,m.id_modulos,m.url
                from alertas.detalle_modulos dm
                inner join alertas.modulos m on m.id_modulos = dm.id_modulos
                where m.id_padre = 0 and m.estado = 'A' and dm.id_perfil = ?
                order by m.orden
	       ";

            return ORMConnection::Execute($sql,array($car_id));
    }
    
    public static function modulosHijosCargo($car_id,$id_padre){
            $sql = "
                select dm.id_detalle_modulos,m.descripcion,dm.estado,m.id_modulos,m.url
                from alertas.detalle_modulos dm
                inner join alertas.modulos m on m.id_modulos = dm.id_modulos
                where m.id_padre = ? and m.estado = 'A' and dm.id_perfil = ?
                order by m.orden
	       ";

            return ORMConnection::Execute($sql,array($id_padre,$car_id));
    }
    
    public static function getModulos($car_id){
                    
        $ul  = "<ul class='clearfix'>";
        
        $padres = Modulos::ModulosPadres($car_id);
        for ($index = 0; $index < count($padres); $index++) {
            $ul  = $ul."<li><a href='#'>";
            $ul  = $ul."        <img src='images/icons/running_man.png'>";
            $ul  = $ul."        <span>".$padres[$index]['descripcion']."</span>";
            $ul  = $ul."        <span class='icon'>&nbsp;</span></a>";
            $ul  = $ul."        <div class='accordion'>";
            
            $hijos = Modulos::ModulosHijo($car_id,$padres[$index]['id_modulos']);
            for ($indey = 0; $indey < count($hijos); $indey++) {
                $ul  = $ul.'        <a class="btnop" id="'.$hijos[$indey]['id_detalle_modulos'].'" link="'.$hijos[$indey]['url'].'" href="javascript:abrir('.$hijos[$indey]['id_detalle_modulos'].')">'.$hijos[$indey]['descripcion'].'</a>';
            }
            $ul  = $ul."        </div>";
            $ul  = $ul."</li>";
        }
        
        $ul  = $ul."</ul>";
        
        return $ul;
        
    }
    
}

?>
