<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cprogramacion
 *
 * @author Ericson
 */
include_once 'ControllerBase.php';
include_once 'models/programacion.php';

class cProgramacion extends ControllerBase{
    
    protected $defaultaction = 'index';
    protected $model = 'programacion';
    /**
     *  listAjax
     *  saveAjax
     *  selectAjax
     *  deleteAjax
     */
    public function indexAction(){
        $this->formAction();
    }
    public function formAction(){

        $grilla = new jsGrid();

        $grilla->setCaption("Programacion de alertas");
        $grilla->setPager("pgprogramacion");
        $grilla->setTabla("lsprogramacion");
        $grilla->setSortname("p.descripcion");
        $grilla->setUrl($_SESSION['URL_INDEX']."/programacion/lista");
        $grilla->setWidth(400);
        $grilla->setAlto(300);

        $grilla->addColumnas("p.descripcion", "Descripcion",250);
        $grilla->addColumnas("p.fecha_inicia_alerta", "Fecha Incio");
//        $grilla->addColumnas("p.num_dias_entre_mensaje", "Num. Dias Entre Mensaje");
//        $grilla->addColumnas("p.num_max_mensajes", "Num. Maximo Mensajes");
//        $grilla->addColumnas("p.tipo_periodo", "Tipo Periodo");
//        $grilla->addColumnas("p.num_unidades_periodo", "Unidades Periodo");
        $grilla->addColumnas("pm.descripcion", "Plantilla");
        $grilla->addColumnas("siguiente_ejecucion", "Siguiente Ejecucion", 150, 'false', 'false');

        global $smarty;
        
        include_once 'models/plantilla_mensajes.php';
        $plantilla_mensajes = new Plantilla_Mensajes();
        $plantilla_mensajes = $plantilla_mensajes->getAll()->WhereAnd('estado=', 'A')->Orderby('descripcion',true);
        
        include_once 'models/oficina.php';
        $oficina = Oficina::getOficinasDependencia(0, 0);
        
        $date = array();
        
        for ($index = date('Y'); $index < date('Y') + 5; $index++) {
            $date[] = $index;
        }
        
        $smarty->assign('oficina', $oficina);
        $smarty->assign('date', $date);
        $smarty->assign('plantilla_mensajes', $plantilla_mensajes);
        $smarty->assign('links', 'links.html');
        $smarty->assign('grilla', $grilla->buildJsGrid());
        $smarty->assign('datos','programacion/datos.html');
        $smarty->display('programacion/form.html');

    }
       
    public function listaAction(){

        $db = new jsGridBd();

        $db->setParametros($_REQUEST);
        
        $db->setFrom(' alertas.programacion p
            inner join alertas.plantilla_mensajes pm on p.id_plantilla_mensajes = pm.id_plantilla_mensajes ');
        
        $db->setSelect(" 
            p.id_programacion,p.descripcion,to_char(p.fecha_inicia_alerta,'dd/MM/yyyy') as fecha_inicia_alerta,
            pm.descripcion as plantilla,

            to_char(case when 
            coalesce((select aa.fecha_inicio from alertas.alertas aa 
            where aa.id_programacion = p.id_programacion order by aa.fecha_inicio desc limit 1),p.fecha_inicia_alerta)
            > current_date then 
            coalesce((select aa.fecha_inicio from alertas.alertas aa 
            where aa.id_programacion = p.id_programacion order by aa.fecha_inicio desc limit 1),p.fecha_inicia_alerta)
            else

                    coalesce((select aa.fecha_inicio from alertas.alertas aa 
                    where aa.id_programacion = p.id_programacion order by aa.fecha_inicio desc limit 1),p.fecha_inicia_alerta) + 
                    (p.num_unidades_periodo::character varying || replace(replace(p.tipo_periodo,'POR MES',' month'),'POR DIA',' day'))::interval

            end,'dd/MM/yyyy') siguiente_ejecucion ");

        $db->setColumnaId('id_programacion');
            
        $db->setWhere(" p.estado = 'A' ");
        
        echo $db->to_json();

    }
    public function guardarAjax(){

        $obj = new Programacion();
        foreach ($_REQUEST as $key => $value) {
           $_REQUEST[$key]=  strtoupper($value); 
        }
        $obj->setFields($_REQUEST);
        $obj->estado = 'A';
        try{
            $obj->find($_REQUEST);
            $obj->setFields($_REQUEST);
            $obj->update();
        }catch(ORMException $e){
            $obj->fecha_registro = date('Y-m-d');
            if($obj->fecha_inicia_alerta == ''){
                $obj->fecha_inicia_alerta = null;
            }else{
                $obj->fecha_inicia_alerta = $obj->getFecha($obj->fecha_inicia_alerta);
            }
            $obj->create(true);
        }
            
        return $obj->getFields();

    }
    
    public function agregarCargosAjax(){
        include_once 'models/cargos_asignados.php';
        $obj = new Cargos_Asignados();
        $obj->estado = 'A';
        $obj->id_cargo = $_REQUEST['id_cargo'];
        $obj->id_programacion = $_REQUEST['id_programacion'];
        $obj->create();
        return $obj->getFields();

    }

    public function getCargosAjax(){
        include_once 'models/cargos_asignados.php';
        return Cargos_Asignados::getCargos($_REQUEST['id_programacion']);
    }
    
    public function quitarCargosAjax(){
        include_once 'models/cargos_asignados.php';
        $cargo = new Cargos_Asignados($_REQUEST);
        $cargo->delete();
        return $cargo->getFields();
    }

        public function anularAjax(){

        $obj = new Programacion();
        try{
            $obj->find($_REQUEST);

            if ($obj->estado == 'I')
                $obj->estado = 'A';
            else
                $obj->estado = 'I';

            $obj->update();
        }catch(ORMException $e){
            
        }

        return $obj->getFields();

    }
    
    public function datosAction(){
        global $smarty;
        
        $smarty->display('programacion/datos.html');
    }
    
    public function getDatosAjax(){
        $obj = new Programacion();
        $obj = $obj->getAll()->WhereAnd('estado=', 'A');
        return $obj->getArray();
    }
    
    public function getAjax(){

        $obj = new Programacion();
        try{
            $obj->find($_REQUEST);
            
            return $obj->getFields();
            
        }catch(ORMException $e){
            return null;
        }

    }
    
    public function getPeriodoAjax(){

        include_once 'models/periodo_programacion.php';
        $pp = new Periodo_Programacion();
        $pp = $pp->getAll()->WhereAnd('id_programacion=', $_REQUEST['id_programacion'])->WhereAnd('estado=', 'A')
                ->Orderby('anio', true)->Orderby('mes', true);
        
        return $pp->getArrayAll();

    }
    
    public function guardarPeriodoAjax(){
        include_once 'models/periodo_programacion.php';
        
        $objLs = new Periodo_Programacion();
        $objLs = $objLs->getAll()->WhereAnd('id_programacion=', $_REQUEST['id_programacion'])
                ->WhereAnd('mes=', $_REQUEST['mes'])
                ->WhereAnd('anio=', $_REQUEST['anio'])
                ->WhereAnd('estado=', 'A');
        
        if ($objLs->count() > 0){
            throw new Exception("El periodo ya esta registrado");
        }
        
        $obj = new Periodo_Programacion();
        $obj->estado = 'A';
        $obj->mes = $_REQUEST['mes'];
        $obj->anio = $_REQUEST['anio'];
        $obj->id_programacion = $_REQUEST['id_programacion'];
        $obj->create();
        return $obj->getFields();

    }
    
    public function quitarPeriodoAjax(){
        include_once 'models/periodo_programacion.php';

        $obj = new Periodo_Programacion(array('id_periodo_programacion'=>$_REQUEST['id_periodo_programacion']));
        $obj->estado = 'I';
        $obj->update();
        return $obj->getFields();

    }
    
    public function getFechasPeriodoAjax(){

        include_once 'models/detalle_periodo.php';
        $pp = new Detalle_Periodo();
        $pp = $pp->getAll()->WhereAnd('id_periodo_programacion=', $_REQUEST['id_periodo_programacion'])->WhereAnd('estado=', 'A')
                ->Orderby('fecha_mensaje', true);
        
        return $pp->getArrayAll();

    }
    
    public function guardarFechaAjax(){
        include_once 'models/detalle_periodo.php';
        
        $fecha_mensaje = explode('/',$_REQUEST['fecha_mensaje']);
        $fecha_mensaje = array_reverse($fecha_mensaje);
        $fecha_mensaje = implode('-',$fecha_mensaje);
        
        $fecha_final = explode('/',$_REQUEST['fecha_final']);
        $fecha_final = array_reverse($fecha_final);
        $fecha_final = implode('-',$fecha_final);
        
        
        $objLs = new Detalle_Periodo();
        $objLs = $objLs->getAll()->WhereAnd('id_periodo_programacion=', $_REQUEST['id_periodo_programacion'])
                ->WhereAnd('fecha_mensaje=', $fecha_mensaje)->WhereAnd('estado=', 'A');
        
        if ($objLs->count() > 0){
            throw new Exception("La fecha ya esta registrado");
        }
        
        $obj = new Detalle_Periodo();
        $obj->estado = 'A';
        $obj->fecha_mensaje = $fecha_mensaje;
        $obj->fecha_final = $fecha_final;
        $obj->id_periodo_programacion = $_REQUEST['id_periodo_programacion'];
        $obj->create();
        return $obj->getFields();

    }
    
    public function quitarFechaAjax(){
        include_once 'models/detalle_periodo.php';

        $obj = new Detalle_Periodo(array('id_detalle_periodo'=>$_REQUEST['id_detalle_periodo']));
        $obj->estado = 'I';
        $obj->update();
        return $obj->getFields();

    }
}
?>
