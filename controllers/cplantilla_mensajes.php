<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cplantilla_mensajes
 *
 * @author Ericson
 */
include_once 'ControllerBase.php';
include_once 'models/plantilla_mensajes.php';

class cPlantilla_Mensajes extends ControllerBase{
    
    protected $defaultaction = 'index';
    protected $model = 'plantilla_mensajes';
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

        $grilla->setCaption("Plantillas Mensajes");
        $grilla->setPager("pgplantilla_mensajes");
        $grilla->setTabla("lsplantilla_mensajes");
        $grilla->setSortname("descripcion");
        $grilla->setUrl($_SESSION['URL_INDEX']."/plantilla_mensajes/lista");
        $grilla->setWidth(400);
        $grilla->setAlto(300);

        $grilla->addColumnas("descripcion", "Descripcion");

        global $smarty;
        
        $smarty->assign('links', 'links.html');
        $smarty->assign('grilla', $grilla->buildJsGrid());
        $smarty->assign('datos','plantilla_mensajes/datos.html');
        $smarty->display('plantilla_mensajes/form.html');

    }
       
    public function listaAction(){

        $db = new jsGridBdORM();

        $db->setTabla('plantilla_mensajes');
        $db->setParametros($_REQUEST);

        $db->setColumnaId('id_plantilla_mensajes');

        $db->addColumna('descripcion');

        $db->addWhereAnd("estado=","A");

        echo $db->to_json();

    }
    public function guardarAjax(){

        $obj = new Plantilla_Mensajes();
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
            $obj->create(true);
            
        }
            
        return $obj->getFields();

    }

    public function anularAjax(){

        $obj = new Plantilla_Mensajes();
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
        
        $smarty->display('plantilla_mensajes/datos.html');
    }
    
    public function getDatosAjax(){
        $obj = new Plantilla_Mensajes();
        $obj = $obj->getAll()->WhereAnd('estado=', 'A');
        return $obj->getArray();
    }
    
    public function getAjax(){

        $obj = new Plantilla_Mensajes();
        try{
            $obj = $obj->getAll()->WhereAnd('id_plantilla_mensajes'.'=', $_REQUEST['id_plantilla_mensajes']);
            if ($obj->count() > 0)
                return $obj->get (0);
            else
                return null;
            
        }catch(ORMException $e){
            return null;
        }

    }
}
?>
