<?php
include_once('ControllerBase.php');
include_once('models/cargo.php');

class cCargo extends ControllerBase{
    protected $defaultaction = 'index';
    protected $model = 'cargo';
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

        $obj = new Cargo();
        $obj->setFields($_REQUEST);
        $obj->estado = 'A';
        try{
            $obj->find($_REQUEST);
            $obj->setFields($_REQUEST);
            $obj->update();
            
//            include_once 'models/modulos.php';
//            include_once 'models/detalle_modulos.php';
//            
//            $modulos = new Modulos();
//            $modulos = $modulos->getAll();
//            
//            $dm = new Detalle_Modulos();
//            foreach ($modulos as $value) {
//                $dm->estado = 'I';
//                $dm->id_modulos = $value->id_modulos;
//                $dm->id_cargo = $obj->id_cargo;
//                $dm->create(true);
//            }
            
        }catch(ORMException $e){
            $obj->create(true);
            
//            include_once 'models/modulos.php';
//            include_once 'models/detalle_modulos.php';
//            
//            $modulos = new Modulos();
//            $modulos = $modulos->getAll();
//            
//            $dm = new Detalle_Modulos();
//            foreach ($modulos as $value) {
//                $dm->estado = 'I';
//                $dm->id_modulos = $value->id_modulos;
//                $dm->id_cargo = $obj->id_cargo;
//                $dm->create(true);
//            }
            
        }

        return $obj->getFields();

    }

    public function anularAjax(){

        $obj = new Cargo();
        try{
            $obj->find($_REQUEST);

            $obj->estado = 'I';

            $obj->update();
        }catch(ORMException $e){

        }

        return $obj->getFields();

    }

    public function getAjax(){

        $obj = new Cargo();
        try{
            $obj->find($_REQUEST);
        }catch(ORMException $e){
            $obj = null;
        }

        return $obj->getFields();

    }

    public function formAction(){

        $grilla = new jsGrid();

        $grilla->setCaption("Cargo");
        $grilla->setPager("DTabla");
        $grilla->setTabla("TTabla");
        $grilla->setSortname("descripcion");
        $grilla->setUrl("cargo/lista");
        $grilla->setWidth(400);
        $grilla->setAlto(350);

        $grilla->addColumnas("descripcion", "Descripcion");
        $grilla->addColumnas("Oficina", "Oficina");
        $grilla->addColumnas("estado", "Estado");

        global $smarty;

        include_once 'models/oficina.php';

        $oficina = Oficina::getOficinasDependencia(0, 0);
        
        include_once 'models/perfil.php';
        $perfil = new Perfil();
        $perfil = $perfil->getAll()->WhereAnd('estado=', 'A');
        
        $smarty->assign('grilla',$grilla->buildJsGrid());
        $smarty->assign('oficina',$oficina);
        $smarty->assign('perfil',$perfil);
        $smarty->assign('links', 'links.html');
        $smarty->assign('datos', 'cargo/datos.tpl');
        $smarty->display('cargo/form.tpl');    
    }

    public function listaAction(){

        $db = new jsGridBdORM();

        $db->setTabla('cargo');
        $db->setParametros($_REQUEST);

        $db->setColumnaId('id_cargo');

        $db->addColumna("descripcion");
        $db->addColumna("Oficina->nombre");
        $db->addColumna("estado");

        $db->addWhereAnd('estado=', 'A');

        echo $db->to_json();

    }
    
    public function getDatosAjax(){
        $obj = new Accion_Tramite();
        $obj = $obj->getAll()->WhereAnd('estado=', 'A');
        return $obj->getArray();
    }
    
    public function datosAction(){
        global $smarty;

        include_once 'models/oficina.php';

        $oficina = Oficina::getOficinasDependencia(0, 0);
        
        $smarty->assign('oficina',$oficina);
        $smarty->display('cargo/datos.tpl');
    }
    
}
?>