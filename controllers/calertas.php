<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of calertas
 *
 * @author Ericson
 */
include_once 'ControllerBase.php';
include_once 'models/alertas.php';

class cAlertas extends ControllerBase{
    
    protected $defaultaction = 'index';
    protected $model = 'alertas';
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

        $grilla->setCaption("Mensajes Enviados");
        $grilla->setPager("pgalertas");
        $grilla->setTabla("lsalertas");
        $grilla->setSortname("p.descripcion");
        $grilla->setUrl($_SESSION['URL_INDEX']."/alertas/lista");
        $grilla->setWidth(400);
        $grilla->setAlto(300);
        $grilla->setMultiselect(TRUE);

        $grilla->addColumnas("p.descripcion", "Item",250);
        $grilla->addColumnas("f.nombres", "Nombre Funcionario",250);
        $grilla->addColumnas("f.apellidos", "Apellidos Funcionario",250);
        $grilla->addColumnas("a.fecha_inicio", "Fecha Incio");
        $grilla->addColumnas("a.fecha_fin", "Fecha Fin");
        $grilla->addColumnas("a.fecha_recepcion", "Fecha Recepcion");
        $grilla->addColumnas("a.num_envios", "Numero Envios");
        $grilla->addColumnas("a.estado_alerta", "Estado Alerta");

        global $smarty;
        
        $smarty->assign('links', 'links.html');
        $smarty->assign('grilla', $grilla->buildJsGrid());
        $smarty->display('alertas/form.html');

    }
       
    public function listaAction(){
        
        $db = new jsGridBd();

        $db->setParametros($_REQUEST);
        
        $db->setFrom(' alertas.alertas a
            inner join alertas.funcionario f on a.id_funcionario = f.id_funcionario
            inner join alertas.programacion p on a.id_programacion = p.id_programacion ');

        $db->setSelect(" 
        a.id_alertas, 
        p.descripcion as item, 
	f.nombres,
	f.apellidos,
	to_char(a.fecha_inicio,'dd/MM/yyyy') as fecha_inicio,
	to_char(a.fecha_fin,'dd/MM/yyyy') as fecha_fin,
        to_char(a.fecha_recepcion,'dd/MM/yyyy') as fecha_recepcion,
	a.num_envios,
	a.estado_alerta ");
        
        $db->setColumnaId('id_alertas');
            
        $estado = " and a.estado_alerta = 'PENDIENTE' ";
        if (isset($_REQUEST['estado_alerta'])){
            
            if ($_REQUEST['estado_alerta'] == '-'){
                $estado = '';
            }else{
                $estado = " and a.estado_alerta = '".$_REQUEST['estado_alerta']."' ";
            }
            
        }
        
        $db->setWhere(" a.estado = 'A' $estado ");
        
        echo $db->to_json();

    }
//    public function guardarAjax(){
//
//        $obj = new Alertas();
//        foreach ($_REQUEST as $key => $value) {
//           $_REQUEST[$key]=  strtoupper($value); 
//        }
//        $obj->setFields($_REQUEST);
//        $obj->estado = 'A';
//        try{
//            $obj->find($_REQUEST);
//            $obj->setFields($_REQUEST);
//            $obj->update();
//        }catch(ORMException $e){
//            $obj->fecha_registro = date('Y-m-d');
//            if($obj->fecha_inicia_alerta == ''){
//                $obj->fecha_inicia_alerta = null;
//            }else{
//                $obj->fecha_inicia_alerta = $obj->getFecha($obj->fecha_inicia_alerta);
//            }
//            $obj->create(true);
//        }
//            
//        return $obj->getFields();
//
//    }
//
//    public function anularAjax(){
//
//        $obj = new Alertas();
//        try{
//            $obj->find($_REQUEST);
//
//            if ($obj->estado == 'I')
//                $obj->estado = 'A';
//            else
//                $obj->estado = 'I';
//
//            $obj->update();
//        }catch(ORMException $e){
//            
//        }
//
//        return $obj->getFields();
//
//    }
//    
//    public function datosAction(){
//        global $smarty;
//        
//        $smarty->display('alertas/datos.html');
//    }
//    
//    public function getDatosAjax(){
//        $obj = new Alertas();
//        $obj = $obj->getAll()->WhereAnd('estado=', 'A');
//        return $obj->getArray();
//    }
//    
//    public function getAjax(){
//
//        $obj = new Alertas();
//        try{
//            $obj->find($_REQUEST);
//            
//            return $obj->getFields();
//            
//        }catch(ORMException $e){
//            return null;
//        }
//
//    }
    

    public function recepcionarAjax(){

        $obj = new Alertas();
        try{
            $obj->find($_REQUEST);

            $obj->fecha_recepcion = $obj->getFecha($_REQUEST['fecha_fin']);
            $obj->observaciones_fin = $_REQUEST['observaciones'];
            $obj->link_archivo_subido = $_REQUEST['link_archivo_subido'];
            $obj->estado_alerta = 'RECEPCIONADO';

            $obj->update();
        }catch(ORMException $e){
            
        }

        return $obj->getFields();

    }
    
    public function mensajesAction(){

        $grilla = new jsGrid();

        $grilla->setCaption("Mensajes Enviados");
        $grilla->setPager("pgalertas");
        $grilla->setTabla("lsalertas");
        $grilla->setSortname("p.descripcion");
        $grilla->setUrl($_SESSION['URL_INDEX']."/alertas/lista?estado_alerta=-");
        $grilla->setWidth(400);
        $grilla->setAlto(250);
        $grilla->setFnCargaCompleta('resumen');

        $grilla->addColumnas("p.descripcion", "Item",250);
        $grilla->addColumnas("f.nombres", "Nombre Funcionario",250);
        $grilla->addColumnas("f.apellidos", "Apellidos Funcionario",250);
        $grilla->addColumnas("a.fecha_inicio", "Fecha Incio");
        $grilla->addColumnas("a.fecha_fin", "Fecha Fin");
        $grilla->addColumnas("a.fecha_recepcion", "Fecha Recepcion");
        $grilla->addColumnas("a.num_envios", "Numero Envios");
        $grilla->addColumnas("a.estado_alerta", "Estado Alerta");

        global $smarty;
        
        $smarty->assign('links', 'links.html');
        $smarty->assign('grilla', $grilla->buildJsGrid());
        $smarty->display('alertas/lista.html');

    }
    
    public function graficosAction(){

        
        $resumen = Alertas::getResumen();
        
        $max_1 = round($resumen['total'] * 30 / 100,2);
        $max_2 = round($resumen['total'] * 70 / 100,2);
        
        $resumen['tramo_1'] = $max_1;
        $resumen['tramo_2'] = $max_2;
        
        global $smarty;
        
        $smarty->assign('resumen', $resumen);
        $smarty->assign('links', 'links.html');
        $smarty->display('alertas/graficos.html');

    }
    
    public function resumenAjax(){

        return Alertas::getResumen();

    }
    
    public function getListaMensajesAjax(){
        include_once 'models/mensajes_enviados.php';
        
        $lsMensajes = new Mensajes_Enviados();
        $lsMensajes = $lsMensajes->getAll()->WhereAnd('id_alertas=', $_REQUEST['id_alertas']);

        return $lsMensajes->getArrayAll();
    }
    
    public function getMensajeAjax(){

        include_once 'models/mensajes_enviados.php';
        
        $obj = new Mensajes_Enviados();
        try{
            $obj->find($_REQUEST);
            
            return $obj->getFields();
            
        }catch(ORMException $e){
            return null;
        }

    }
    
}
?>
