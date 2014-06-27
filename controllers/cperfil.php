<?php
include_once('ControllerBase.php');
include_once('models/perfil.php');

class cPerfil extends ControllerBase{
    protected $defaultaction = 'index';
    protected $model = 'perfil';
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

        $obj = new Perfil();
        $obj->setFields($_REQUEST);
        $obj->estado = 'A';
        try{
            $obj->find($_REQUEST);
            $obj->setFields($_REQUEST);
            $obj->update();
        }catch(ORMException $e){
            $obj->create(true);
            
            include_once 'models/modulos.php';
            include_once 'models/detalle_modulos.php';
            
            $modulos = new Modulos();
            $modulos = $modulos->getAll();
            
            $dm = new Detalle_Modulos();
            foreach ($modulos as $value) {
                $dm->estado = 'I';
                $dm->id_modulos = $value->id_modulos;
                $dm->id_perfil = $obj->id_perfil;
                $dm->create(true);
            }
        }

        return $obj->getFields();

    }

    public function anularAjax(){

        $obj = new Perfil();
        try{
            $obj->find($_REQUEST);

            $obj->estado = 'I';

            $obj->update();
        }catch(ORMException $e){

        }

        return $obj->getFields();

    }

    public function getAjax(){

        $obj = new Perfil();
        try{
            $obj->find($_REQUEST);
        }catch(ORMException $e){
            $obj = null;
        }

        return $obj->getFields();

    }
    
    public function formAction(){

        $grilla = new jsGrid();

        $grilla->setCaption("Perfil");
        $grilla->setPager("DTabla");
        $grilla->setTabla("TTabla");
        $grilla->setSortname("descripcion");
        $grilla->setUrl("perfil/lista");
//        $grilla->setWidth(730);
        $grilla->setAlto(300);

        $grilla->addColumnas("descripcion", "Descripcion del Perfil");

        
        global $smarty;
        
        $smarty->assign('grilla', $grilla->buildJsGrid());
        $smarty->assign('links', 'links.html');
        $smarty->assign('datos', 'perfil/datos.tpl');
        $smarty->display('perfil/form.tpl');

    }
    
    public function listaAction(){

        $db = new jsGridBdORM();

        $db->setTabla('perfil');
        $db->setParametros($_REQUEST);

        $db->setColumnaId('id_perfil');

        $db->addColumna("descripcion");

        $db->addWhereAnd('estado=', 'A');

        echo $db->to_json();

    }
    
    public function datosAction(){
        global $smarty;
        
        $smarty->display('perfil/datos.html');
    }
    
    public function getDatosAjax(){
        $obj = new Perfil();
        $obj = $obj->getAll()->WhereAnd('estado=', 'A');
        return $obj->getArray();
    }

}
?>