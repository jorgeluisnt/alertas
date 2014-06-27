<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ctipo_oficina
 *
 * @author Ericson
 */
include_once 'ControllerBase.php';
include_once 'models/tipo_oficina.php';

class cTipo_Oficina extends ControllerBase{
    
    protected $defaultaction = 'index';
    protected $model = 'tipo_oficina';
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

        $grilla->setCaption("tipos de oficinas");
        $grilla->setPager("pgtipo_oficina");
        $grilla->setTabla("lstipo_oficina");
        $grilla->setSortname("descripcion");
        $grilla->setUrl($_SESSION['URL_INDEX']."/tipo_oficina/lista");
        $grilla->setWidth(400);
        $grilla->setAlto(300);

        $grilla->addColumnas("descripcion", "Descripcion");

        global $smarty;
        
        $smarty->assign('links', 'links.html');
        $smarty->assign('grilla', $grilla->buildJsGrid());
        $smarty->assign('datos','tipo_oficina/datos.html');
        $smarty->display('tipo_oficina/form.html');

    }
       
    public function listaAction(){

        $db = new jsGridBdORM();

        $db->setTabla('tipo_oficina');
        $db->setParametros($_REQUEST);

        $db->setColumnaId('id_tipo_oficina');

        $db->addColumna('descripcion');

        $db->addWhereAnd("estado=","A");

        echo $db->to_json();

    }
    public function guardarAjax(){

        $obj = new Tipo_Oficina();
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

        $obj = new Tipo_Oficina();
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
        
        $smarty->display('tipo_oficina/datos.html');
    }
    
    public function getDatosAjax(){
        $obj = new Tipo_Oficina();
        $obj = $obj->getAll()->WhereAnd('estado=', 'A');
        return $obj->getArray();
    }
    
    public function getAjax(){

        $obj = new Tipo_Oficina();
        try{
            $obj = $obj->getAll()->WhereAnd('id_tipo_oficina'.'=', $_REQUEST['id_tipo_oficina']);
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
