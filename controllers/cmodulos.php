<?php
include_once('ControllerBase.php');
include_once 'models/modulos.php';

class cModulos extends ControllerBase{
    
    protected $defaultaction = 'index';
    protected $model = 'modulos';
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

        $obj = new Modulos();
        $obj->setFields($_REQUEST);
        $obj->estado = 'A';
        try{
            $obj->find($_REQUEST);
            $obj->setFields($_REQUEST);
            $obj->update();
        }catch(ORMException $e){
            $obj->create(true);
            
            include_once 'models/perfil.php';
            include_once 'models/detalle_modulos.php';
            
            $perfil = new Perfil();
            $perfil = $perfil->getAll();
            
            $dm = new Detalle_Modulos();
            foreach ($perfil as $value) {
                $dm->estado = 'I';
                $dm->id_modulos = $obj->id_modulos;
                $dm->id_perfil = $value->id_perfil;
                $dm->create(true);
            }
        }
            
        return $obj->getFields();

    }

    public function anularAjax(){

        $obj = new Modulos();
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

        $obj = new Modulos();
        try{
            $obj->find($_REQUEST);
        }catch(ORMException $e){
            $obj = null;
        }

        return $obj->getFields();

    }
    
    public function getDatosAjax(){
        $obj = new Modulos();
        $obj = $obj->getAll()->WhereAnd('estado=', 'A');
        return $obj->getArray();
    }

    public function formAction(){

        $grilla = new jsGrid();

        $grilla->setCaption("Modulos");
        $grilla->setPager("pgmodulos");
        $grilla->setTabla("lsmodulos");
        $grilla->setSortname("descripcion");
        $grilla->setUrl("modulos/lista");
        $grilla->setWidth(400);
        $grilla->setAlto(350);

        $grilla->addColumnas("descripcion", "Descripcion");
        $grilla->addColumnas("url", "URL");
        $grilla->addColumnas("orden", "Orden");

        global $smarty;

        $smarty->assign('dependencias', $this->getModulosAjax());
        $smarty->assign('grilla', $grilla->buildJsGrid());
        $smarty->assign('links', 'links.html');
        $smarty->assign('datos', 'modulos/datos.tpl'); 
        $smarty->display('modulos/form.tpl');

    }

    public function getModulosAjax(){
        $obj = new Modulos();
        $obj = $obj->getAll()->WhereAnd('estado=', 'A')->WhereAnd('id_padre=','0');
        return $obj->getArray();
    }
    
    public function datosAction(){
        global $smarty;

        $smarty->display('modulos/datos.tpl');
    }
    
    public function listaAction(){

        $db = new jsGridBdORM();

        $db->setTabla('modulos');
        $db->setParametros($_REQUEST);

        $db->setColumnaId('id_modulos');

        $db->addColumna('descripcion');
        $db->addColumna("url");
        $db->addColumna("orden");

        $db->addWhereAnd("estado=","A");

        echo $db->to_json();

    }

    public function modulosAction(){
        
        $url_script = $_SERVER['SCRIPT_NAME'];
        
        $url_script = '';
        
        $id_cargo = 0;
        
        if (isset ($_SESSION['funcionario'])){
            $usuario = $_SESSION['funcionario'];
            $id_cargo = $usuario['id_cargo'];
        }
        
        $padres = Modulos::ModulosPadres($id_cargo);

        //$xml  = "<?xml version='1.0' encoding=\"utf-8\"";
        $xml  = "";
        $xml .= "<rows>\n";
        $xml .= "   <page>1</page>\n";
        $xml .= "   <total>1</total>\n";
        $xml .= "   <records>1</records>\n";

        $hasta = 0;
        $lista = 1;

        for ($index = 0; $index < count($padres); $index++) {

            $hijos = Modulos::ModulosHijo($id_cargo,$padres[$index]['id_modulos']);

            $numHijos = count($hijos);

            $count = $hasta;;

            $count++;
            
            $hasta = ($numHijos*2) + $count + 1;

            $xml .= "       <row>\n";
            $xml .= "           <cell>$lista</cell>\n";
            $xml .= "           <cell>".$padres[$index]['descripcion']."</cell>\n";
            $xml .= "           <cell></cell>\n";
            $xml .= "           <cell>0</cell>\n";
            $xml .= "           <cell>$count</cell>\n";
            $xml .= "           <cell>". $hasta ."</cell>\n";
            $xml .= "           <cell>false</cell>\n";
            $xml .= "           <cell>false</cell>\n";
            $xml .= "       </row>\n";

            $lista++;
            
            for ($indey = 0; $indey < $numHijos; $indey++) {

                $count++;

                $xml .= "       <row>\n";
                $xml .= "           <cell>$lista</cell>\n";
                $xml .= "           <cell>".$hijos[$indey]['descripcion']."</cell>\n";
                $xml .= "           <cell>".$url_script.$hijos[$indey]['url']."</cell>\n";
                $xml .= "           <cell>1</cell>\n";
                $xml .= "           <cell>$count</cell>\n";
                $xml .= "           <cell>". ($count + 1) ."</cell>\n";
                $xml .= "           <cell>true</cell>\n";
                $xml .= "           <cell>true</cell>\n";
                $xml .= "       </row>\n";
                
                $lista++;
                $count++;
                
            }

            
        }

        $xml .= "</rows>";

        header("Content-type: text/xml");
        echo $xml;
    }
    
    public function permisosAction(){
        
        global $smarty;
        
        $smarty->assign('links', 'links.tpl');
        $smarty->display('permisos/form.tpl');   
    }
    
    public function getPermisosAction(){
        
        include_once 'models/modulos.php';
        include_once 'lib/tree.php';
        include_once 'lib/chil.php';
        
        $id_cargo = $_REQUEST['id_cargo'];
        
        $padres = Modulos::modulosPadrescargo($id_cargo);
        
        $datos = array();
        
        for ($index = 0; $index < count($padres); $index++) {
            
            $hijos = Modulos::modulosHijosCargo($id_cargo,$padres[$index]['id_modulos']);
            $numHijos = count($hijos);
            
            $value = new tree();
            
            $value->data = $padres[$index]['descripcion'];
            $value->attr = new chil();
            $value->attr->id = $padres[$index]['id_detalle_modulos'];
            
            if ($numHijos > 0){
                
                $value->state = "closed";
                
                $datoshijos = array();
                for ($indey = 0; $indey < $numHijos; $indey++) {
                    
                    $valueh = new tree();
                    $valueh->data = $hijos[$indey]['descripcion'];
                    $valueh->attr = new chil();
                    $valueh->attr->id = $hijos[$indey]['id_detalle_modulos'];
                    
                    if ($hijos[$indey]['estado'] == 'A')
                        $valueh->attr->class = "jstree-checked";
                    else
                        $valueh->attr->class = "jstree-unchecked";
                    
                    $datoshijos[] = $valueh;
                    
                    $valueh= null;
                    
                }
                
                $value->children = $datoshijos;
                
            }
            
            $datos[] = $value;
            $value= null;
            
        }
        echo json_encode($datos);
    }
    
    public function actualizarPermisosAjax(){
        
        include_once 'models/detalle_modulos.php';
        
        if (isset ($_REQUEST['permisos'])){
            
            $permisos = $_REQUEST['permisos'];
            
            foreach ($permisos as $value) {
                
                $dm = new Detalle_Modulos();
                
                try{
                    $dm->find(array('id_detalle_modulos'=>$value['id']));
                    $dm->estado = $value['val'];
                    $dm->update();
                }catch(ORMException $e){
                    
                }
            }
            
        }
        
    }
}
?>
