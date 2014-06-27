<?php
include_once('ControllerBase.php');
include_once('models/oficina.php');

class cOficina extends ControllerBase{
    protected $defaultaction = 'index';
    protected $model = 'oficina';
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

        $obj = new Oficina();
        $obj->setFields($_REQUEST);
        $obj->estado = 'A';
        try{
            $obj->find($_REQUEST);
            $obj->setFields($_REQUEST);
            $obj->update();
        }catch(ORMException $e){

//            $obj->id_tipo_oficina = 1;
//            $obj->id_localizacion = 1;
            $obj->tipo = 'O';

            $obj->create(true);
        }

        return $obj->getFields();

    }

    public function anularAjax(){

        $obj = new Oficina();
        try{
            $obj->find($_REQUEST);

            $obj->estado = 'I';

            $obj->update();
        }catch(ORMException $e){

        }

        return $obj->getFields();

    }

    public function getAjax(){

        $obj = new Oficina();
        try{
            $obj->find($_REQUEST);
        }catch(ORMException $e){
            $obj = null;
        }

        return $obj->getFields();

    }

    public function getCargosAjax(){

        include_once 'models/cargo.php';
        $cargos = new Cargo();
        $cargos = $cargos->getAll()->WhereAnd('id_oficina=', $_REQUEST['id_oficina'])->WhereAnd('estado=', 'A');
        
        return $cargos->getArray();

    }
    
    public function formAction(){

        $grilla = new jsGrid();

        $grilla->setCaption("Oficina");
        $grilla->setPager("DTabla");
        $grilla->setTabla("TTabla");
        $grilla->setSortname("nombre");
        $grilla->setUrl("oficina/lista");
        $grilla->setWidth(400);
        $grilla->setAlto(350);

        $grilla->addColumnas("nombre", "Nombre");
        $grilla->addColumnas("telefono", "Telefono");
        $grilla->addColumnas("estado", "Estado");

        global $smarty;

        $padre = Oficina::getOficinasDependencia(0, 0);

        include_once 'models/tipo_oficina.php';
        include_once 'models/municipalidad.php';
        
        $tipo = new Tipo_Oficina();
        $tipo = $tipo->getAll()->WhereAnd('estado=', 'A');
        
        $entidad = new Municipalidad();
        $entidad = $entidad->getAll()->WhereAnd('estado=', 'A');
        
        $smarty->assign('grilla', $grilla->buildJsGrid());
        $smarty->assign('padre',$padre);
        $smarty->assign('links', 'links.html');
        $smarty->assign('datos', 'oficina/datos.tpl');
        $smarty->assign('tipo',$tipo);
        $smarty->assign('entidad',$entidad);
        $smarty->display('oficina/form.tpl');
        
    }

    public function datosAction(){
        
        global $smarty;

        $padre = Oficina::getOficinasDependencia(0, 0);

        include_once 'models/tipo_oficina.php';
        include_once 'models/municipalidad.php';
        
        $tipo = new Tipo_Oficina();
        $tipo = $tipo->getAll()->WhereAnd('estado=', 'A');
        $entidad = new Municipalidad();
        $entidad = $entidad->getAll()->WhereAnd('estado=', 'A');
        
        $smarty->assign('padre',$padre);
        $smarty->assign('links', 'links.html');
        $smarty->assign('tipo',$tipo);
        $smarty->assign('entidad',$entidad);
        $smarty->display('oficina/datos.tpl');
    }


    public function getOficinasAjax(){
        $condi = "";
        if (isset ($_REQUEST['tipo']))
            $condi = " and tipo = '" . $_REQUEST['tipo']."' ";
        
        return Oficina::getOficinasDependencia(0, 0,$condi);
    }


    public function listaAction(){

        $db = new jsGridBdORM();

        $db->setTabla('oficina');
        $db->setParametros($_REQUEST);

        $db->setColumnaId('id_oficina');

        $db->addColumna("nombre");
        $db->addColumna("telefono");
        $db->addColumna("estado");

        $db->addWhereAnd('estado=', 'A');

        echo $db->to_json();

    }
}
?>