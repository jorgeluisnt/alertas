<?php
    include_once('phpORM/ORMBase.php');
    
    include_once('models/alertas.php');
    include_once('models/mensajes_enviados.php');
    include_once('models/detalle_plantilla.php');
    include_once('models/funcionario.php');

    class Programacion extends ORMBase{
       protected $tablename = 'alertas.programacion';
       
       private $email_desde = 'jorgeluisntqgmail.com';
       private $email_responsable = 'jorgeluisntqgmail.com';
       
       
       public static function ejecutaProgramacion($fecha=null,$programacion='0',$id_cargo=0){
           
           if ($fecha == null){
               $fecha = date('Y-m-d');
           }else{
               $fecha = $this->getFecha($fecha);
           }
           
           if ($programacion != '0'){
               $programacion = " and p.id_programacion = ".$programacion;
           }else{
               $programacion = "";
           }
           
           if ($id_cargo != '0'){
               $id_cargo = " and ca.id_cargo = ".$id_cargo;
           }else{
               $id_cargo = "";
           }
           
           //OPTENEMOS LAS PROGRAMACION DE LA FECHA DE EJECUCION
           $sql = "select 
                    dp.fecha_mensaje,
                    dp.fecha_final,
                    pg.mes,
                    pg.anio,
                    p.descripcion,
                    p.id_plantilla_mensajes,
                    p.id_programacion
            from alertas.detalle_periodo dp
            inner join alertas.periodo_programacion pg on dp.id_periodo_programacion = pg.id_periodo_programacion
            inner join alertas.programacion p on pg.id_programacion = p.id_programacion
            where dp.fecha_mensaje = ? and dp.estado = 'A' and pg.estado = 'A' and p.estado = 'A' ".$programacion;
           
           $lsProgramacion = ORMConnection::Execute($sql,array($fecha));
           
           foreach ($lsProgramacion as $programacion) {
               //OPTENEMOS LOS CARGOS Y FUNCIONARIOS DENTRO DE LA PROGRAMACION
                $sql = "select 
                                ca.id_cargo,
                                c.descripcion as cargo,
                                f.id_funcionario,
                                f.nombres,
                                f.apellidos,
                                f.direccion,
                                f.dni,
                                f.email,
                                f.email_2,
                                f.id_funcionario_jefe
                        from alertas.cargos_asignados ca
                        inner join alertas.funcionario f on ca.id_cargo = f.id_cargo
                        inner join alertas.cargo c on ca.id_cargo = c.id_cargo
                        where ca.estado = 'A' and ca.id_programacion = ? and f.estado = 'A' and 
                            f.email is not null and trim(f.email) != '' ".$id_cargo;

                $lsFuncionarios = ORMConnection::Execute($sql,array($programacion['id_programacion']));
                
                foreach ($lsFuncionarios as $funcionarios) {
                    //OPTENEMOS LAS ALERTAS SI TIENES SI NO SE CREARA UNO NUEVO
                    $lsAlertas = new Alertas();
                    $lsAlertas = $lsAlertas->getAll()
                            ->WhereAnd('estado=', 'A')
                            ->WhereAnd('id_programacion=', $programacion['id_programacion'])
                            ->WhereAnd('id_funcionario=', $funcionarios['id_funcionario'])
                            ->WhereAnd('mes_periodo=', $programacion['mes'])
                            ->WhereAnd('anio_periodo=', $programacion['anio']);

                    if ($lsAlertas->count() == 0){
                        // SI NO EXISTEN ALERTAS SE CREA UNO NUEVO
                        $alerta = new Alertas();
                        $alerta->descripcion = $programacion['descripcion'];
                        $alerta->fecha_inicio = $programacion['fecha_mensaje'];
                        $alerta->fecha_fin = $programacion['fecha_final'];
                        $alerta->fecha_recepcion = null;
                        $alerta->num_envios = 1;
                        $alerta->estado_alerta = 'PENDIENTE';
                        $alerta->observaciones_fin = '';
                        $alerta->estado = 'A';
                        $alerta->id_programacion = $programacion['id_programacion'];
                        $alerta->id_funcionario = $funcionarios['id_funcionario'];
                        $alerta->mes_periodo = $programacion['mes'];
                        $alerta->anio_periodo = $programacion['anio'];
                        $alerta->create();                        
                        
                        Programacion::enviarMensaje(null,$alerta,$programacion,$funcionarios,$alerta->num_envios);
                        
                    }else{
                        $alerta = $lsAlertas->get(0);
                        
                        // SE VERIFICA SI LA ALERTA SIGE PENDIENTE
                        if ($alerta->estado_alerta == 'PENDIENTE'){
                            //BUSCO SI YA SE ENVIO MENSAJE EN LA FECHA
                            $lsMensajes = new Mensajes_Enviados();
                            $lsMensajes = $lsMensajes->getAll()
                                    ->WhereAnd('id_alertas=',$alerta->id_alertas)
                                    ->WhereAnd('fecha_envio=',$programacion['fecha_mensaje']);
                            
                            if ($lsMensajes->count() == 0){
                                //SE CREA EL MENSAJE NUEVO Y SE AUMENTA EL NUMERO DE ENVIO EN ALERTAS
                                $alerta->num_envios = $alerta->num_envios + 1;
                                $alerta->update();
                                
                                Programacion::enviarMensaje(null,$alerta,$programacion,$funcionarios,$alerta->num_envios);
                            }else{
                                $mensaje = $lsMensajes->get(0);
                                //SE ENVIA EL MENSAJE Y SE AHUMENTA SU CONTADOR
                                Programacion::enviarMensaje($mensaje,$alerta,$programacion,$funcionarios,$alerta->num_envios);
                            }
                            
                        }
                        
                    }
                    
                }
                
           }
           
       }
       
       public static function enviarMensaje($mensaje,$alerta,$programacion,$funcionario,$num_mensaje){
           
           $cuerpo_mensaje = '';
           
           if ($mensaje != null){
               //ACTUALIZAMOS EL MENSAJE
              $mensaje->veces_enviado = $mensaje->veces_enviado + 1; 
              $mensaje->update();
              
              $cuerpo_mensaje = $mensaje->mensaje;
           }else{
                //CARGAMOS LA PLANTILLA
                $plantilla = new Detalle_Plantilla();
                $plantilla = $plantilla->getAll()
                       ->WhereAnd('estado=', 'A')
                       ->WhereAnd('id_plantilla_mensajes=', $programacion['id_plantilla_mensajes'])
                       ->WhereAnd('numero<=', $num_mensaje)->Orderby('numero',false);
               
                if ($plantilla->count() > 0){
                    $cuerpo_mensaje = $plantilla->get(0)->mensaje;
                   
                    //REEMPLAZAMOS LOS VALORES DE PLANTILLA
                    
                    $cuerpo_mensaje = str_replace('@FECHA@', date('d/m/Y'), $cuerpo_mensaje);
                    $cuerpo_mensaje = str_replace('@FUNCIONARIO@', $funcionario['nombres'] . ' ' .$funcionario['apellidos'], $cuerpo_mensaje);
                    $cuerpo_mensaje = str_replace('@CARGO@', $funcionario['cargo'], $cuerpo_mensaje);
                    $cuerpo_mensaje = str_replace('@CARGO@', $funcionario['cargo'], $cuerpo_mensaje);
                    $cuerpo_mensaje = str_replace('@ITEM@', $programacion['descripcion'], $cuerpo_mensaje);
                    $cuerpo_mensaje = str_replace('@FECHA_FIN@', getFechaLarga($programacion['fecha_final']), $cuerpo_mensaje);
                }else{
                    $cuerpo_mensaje = "<b>Usted tiene PENDIENTE el envio de informacion para la publicacion en el portal de transparencia correspondiente a ".$programacion['descripcion']."</b>";
                }
               
                //CREAMOS EL MENSAJE
                $mensaje = new Mensajes_Enviados();
                $mensaje->fecha_envio = $programacion['fecha_mensaje'];
                $mensaje->destinatario = $funcionario['nombres'] . ' ' .$funcionario['apellidos'];
                $mensaje->id_funcionario = $funcionario['id_funcionario'];
                $mensaje->estado_mensaje = 'NO SE PUDO ENVIAR';
                $mensaje->mensaje = $cuerpo_mensaje;
                $mensaje->id_alertas = $alerta->id_alertas;
                $mensaje->veces_enviado = 1;
                $mensaje->num_mensaje = $num_mensaje;
                $mensaje->create();
           }
           
           $lista_envio = array();
           $lista_email[] = array('email'=>$funcionario['email'],'email_2'=>$funcionario['email_2'],'funcionario'=>$funcionario['nombres'] . ' ' .$funcionario['apellidos']);
           
           //VERIFICAMOS SI ES MAS DEL PRIMER MENSAJE PARA ENVIAR A LOS JEFES
           if ($num_mensaje > 1 && $funcionario['id_funcionario_jefe'] != '0'){
               
                $jefe = null;
                if ( $num_mensaje >= 2){
                    try {
                        $jefe = new Funcionario(array('id_funcionario'=>$funcionario['id_funcionario_jefe']));
                        $lista_email[] = array('email'=>$jefe->email,'email_2'=>$jefe->email_2,'funcionario'=>$jefe->nombres . ' ' .$jefe->apellidos);
                    } catch (Exception $exc) {
                        $jefe = null;
                    }
                }
                if ( $num_mensaje >= 3 && $jefe != null){
                    try {
                        $jefe = new Funcionario(array('id_funcionario'=>$jefe->id_funcionario_jefe));
                        $lista_email[] = array('email'=>$jefe->email,'email_2'=>$jefe->email_2,'funcionario'=>$jefe->nombres . ' ' .$jefe->apellidos);
                    } catch (Exception $exc) {
                        $jefe = null;
                    }
                }
               
           }
           
            //ENVIAR EMAIL
            $asunto = 'Recordatorio de informacion de transparencia';
            $cuerpo = $cuerpo_mensaje;
            $header = 'From: '.$this->email_desde.' \r\n';
            $header .= "Mime-Version: 1.0 \r\n";
            $header .= "Content-Type: text/html";
            
            foreach ($lista_email as $email) {
                 mail($email['email'], $asunto, utf8_decode($cuerpo), $header);
                 if ($email['email_2'] != null & $email['email_2'] != ''){
                    mail($email['email_2'], $asunto, utf8_decode($cuerpo), $header);
                 }
            }           
           
            print_r("EJECUTADO");
       }
       
       public static function reenviarMensaje($id_alerta){
            $lsMensajes = new Mensajes_Enviados();
            $lsMensajes = $lsMensajes->getAll()
                    ->WhereAnd('id_alertas=',$id_alerta)->Orderby('id_mensajes_enviados', false);
            
            if ($lsMensajes->count() > 0){
                $mensaje = $lsMensajes->get(0);
                $mensaje->veces_enviado = $mensaje->veces_enviado + 1; 
                $mensaje->update();

                $cuerpo_mensaje = $mensaje->mensaje;
                $funcionario = new Funcionario(array('id_funcionario'=>$mensaje->id_funcionario));
                
                
                $lista_envio = array();
                $lista_email[] = array('email'=>$funcionario->email,'email_2'=>$funcionario->email_2,'funcionario'=>$funcionario->nombres . ' ' .$funcionario->apellidos);

                //VERIFICAMOS SI ES MAS DEL PRIMER MENSAJE PARA ENVIAR A LOS JEFES
                if ($mensaje->num_mensaje > 1 && $funcionario->id_funcionario_jefe != '0'){

                     $jefe = null;
                     if ( $num_mensaje >= 2){
                         try {
                             $jefe = new Funcionario(array('id_funcionario'=>$funcionario->id_funcionario_jefe));
                             $lista_email[] = array('email'=>$jefe->email,'email_2'=>$jefe->email_2,'funcionario'=>$jefe->nombres . ' ' .$jefe->apellidos);
                         } catch (Exception $exc) {
                             $jefe = null;
                         }
                     }
                     if ( $num_mensaje >= 3 && $jefe != null){
                         try {
                             $jefe = new Funcionario(array('id_funcionario'=>$jefe->id_funcionario_jefe));
                             $lista_email[] = array('email'=>$jefe->email,'email_2'=>$jefe->email_2,'funcionario'=>$jefe->nombres . ' ' .$jefe->apellidos);
                         } catch (Exception $exc) {
                             $jefe = null;
                         }
                     }

                }

                 //ENVIAR EMAIL
                 $asunto = 'Recordatorio de informacion de transparencia';
                 $cuerpo = $cuerpo_mensaje;
                 $header = 'From: '.$this->email_desde.' \r\n';
                 $header .= "Mime-Version: 1.0 \r\n";
                 $header .= "Content-Type: text/html";

                 foreach ($lista_email as $email) {
                    mail($email['email'], $asunto, utf8_decode($cuerpo), $header);
                    if ($email['email_2'] != null & $email['email_2'] != ''){
                       mail($email['email_2'], $asunto, utf8_decode($cuerpo), $header);
                    }
                 }     
            
            }
            
            return array('ok');
       }
       
       public static function ejecutaResultados(){
            $hoy = date( "Y-m-d" );
            $ayer = date( "Y-m-d", strtotime( "-1 day", strtotime( $hoy ) ) );  
            
           $sql = "select 
                        p.descripcion as programacion,
                        count(a.id_alertas) as total,
                        (select count(aa.id_alertas) from alertas.alertas aa 
                                where aa.id_programacion = p.id_programacion 
                                and aa.estado = 'A' and aa.fecha_fin = '$ayer' 
                                and aa.estado_alerta = 'PENDIENTE' ) as pendiente,	
                        (select count(aa.id_alertas) from alertas.alertas aa 
                                where aa.id_programacion = p.id_programacion 
                                and aa.estado = 'A' and aa.fecha_fin = '$ayer' 
                                and aa.estado_alerta = 'RECEPCIONADO' ) as recepcionados
                from alertas.alertas a
                inner join alertas.programacion p on a.id_programacion = p.id_programacion
                where a.estado = 'A' and a.fecha_fin = '$ayer'
                group by p.descripcion,p.id_programacion ";
           
           $datos = ORMConnection::Execute($sql);
            
           $sql = "update alertas.alertas set estado_alerta = 'VENCIDO' where estado = 'A' and fecha_fin = '$ayer' and estado_alerta = 'PENDIENTE'";
           ORMConnection::Execute($sql);
           
           $html = "<b>El dia $ayer se vencio el plazo de unas alertas:</b>";
           
           $html = $html."<table>";
           $html = $html."<tr><td>Descripcion</td><td>Total Mensajes</td><td>Mensajes Recepcionados</td><td>Mensajes Pendientes</td></tr>";
           foreach ($datos as $value) {
               $html = $html."<tr><td>".$value['programacion']."</td><td>".$value['total']."</td><td>".$value['recepcionados']."</td><td>".$value['pendiente']."</td></tr>";
           }
           $html = $html."</table>";
           
            //ENVIAR EMAIL
            $asunto = 'Resumen de alertas';
            $header = 'From: '.$this->email_desde.' \r\n';
            $header .= "Mime-Version: 1.0 \r\n";
            $header .= "Content-Type: text/html";
             mail($this->email_responsable, $asunto, utf8_decode($html), $header);
           return array('ok');
       }
    }
?>
