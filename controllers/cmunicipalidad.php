<?php
include_once('ControllerBase.php');
include_once 'models/municipalidad.php';

class cMunicipalidad extends ControllerBase{
    
    protected $defaultaction = 'index';
    protected $model = 'municipalidad';
    /**
     *  listAjax
     *  saveAjax
     *  selectAjax
     *  deleteAjax
     */
    public function indexAction(){
        $this->formAction();
    }

    public function guardarAjax(){

        $obj = new Municipalidad();
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

        $obj = new Municipalidad();
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
    
    public function getAjax(){

        $obj = new Municipalidad();
        try{
            $obj->find($_REQUEST);
        }catch(ORMException $e){
            $obj = null;
        }

        return $obj->getFields();

    }
    
    public function getDatosAjax(){
        $obj = new Municipalidad();
        $obj = $obj->getAll()->WhereAnd('estado=', 'A');
        return $obj->getArray();
    }

    public function formAction(){

        $grilla = new jsGrid();

        $grilla->setCaption("Municipalidad");
        $grilla->setPager("pgmunicipalidad");
        $grilla->setTabla("lsmunicipalidad");
        $grilla->setSortname("razon_social");
        $grilla->setUrl("municipalidad/lista");
        $grilla->setWidth(450);
        $grilla->setAlto(350);
        
        $grilla->addColumnas("razon_social", "Razon Social");
        $grilla->addColumnas("direccion", "Direccion");
        $grilla->addColumnas("ruc", "RUC");

        global $smarty;

        $smarty->assign('links', 'links.html');
        $smarty->assign('grilla', $grilla->buildJsGrid());
        $smarty->assign('datos', 'municipalidad/datos.html');
        $smarty->display('municipalidad/form.html');

    }
    
    public function datosAction(){
        global $smarty;

        $smarty->display('municipalidad/datos.html');
    }

    public function listaAction(){

        $db = new jsGridBdORM();

        $db->setTabla('municipalidad');
        $db->setParametros($_REQUEST);

        $db->setColumnaId('id_municipalidad');

        $db->addColumna('razon_social');
        $db->addColumna('direccion');
        $db->addColumna('ruc');

        $db->addWhereAnd("estado=","A");

        echo $db->to_json();

    }

}
?>
