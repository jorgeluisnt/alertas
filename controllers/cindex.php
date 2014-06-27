<?php
include_once('ControllerBase.php');

class cIndex extends ControllerBase{
    
    protected $defaultaction = 'index';

    protected $autoRoute = true;

    protected $route = array(
        
        "modulos" => "cModulos",
        "municipalidad" => "cMunicipalidad",
        "cargo"=>"cCargo",
        "tipo_oficina"=>"cTipo_Oficina",
        "funcionario"=>"cFuncionario",
        "oficina"=>"cOficina",
        "perfil"=>"cPerfil",
        "plantilla_mensajes"=>"cPlantilla_Mensajes",
        "programacion"=>"cProgramacion"
         );

    protected function init(){
                
        date_default_timezone_set('America/Lima');

        global $smarty;

        $smarty->assign('login', @$_SESSION['vales.funcionario']);
        $smarty->assign('menu', 'menu.tpl');

    }

    public function rights(){
        
        //// Procesa el Login
        if ($this->actionName == 'loginAction')
            return true;
        // Muestra la pantalla de login
        if ($this->actionName == 'indexAction')
            return true;
        if ($this->actionName == 'logoutAction')
            return true;

        // Si se ha logueado
        if (array_key_exists('vales.funcionario', $_SESSION))
            return true;

        return false;
    }
    
    public function getPermisoModulos($obj){
        
        $index = $obj->index;
        $URLBase = $obj->URLBase;
        $fType = $obj->ftype;
        $actionName = $obj->actionName;
        
        $accion = $obj->args['params'];
        
        if (count($accion) > 0)
            $accion = '/'.$accion[0];
        else{
            $accion = '';
        }
        
        $actionName = str_replace($fType,'',$actionName);
        
        $url = $URLBase.$index.'/'.$actionName.$accion;
        
//        print_r($url.array_search($url, $_SESSION['permisos']));
        
        if ( array_key_exists('permisos',$_SESSION) ){
            $res = array_search($url, $_SESSION['permisos']);

            debug($url);
            
            if ($res >= 1)
                return true;
            else
                return false;
        }else
            return false;
        
    }


    public static function _403() {
        $url_script = $_SERVER['SCRIPT_NAME'];
        header('Location: '.$url_script);
    }
    
    public  function _404(){
        global $smarty;
        $mensaje=$this->mensaje('error', 'Mensaje de Error del Sistema', 'Esta Sitio no Existe<br/>Ah Ocurrido algun Error<br/>'.
                "<b>Si el Error persiste Consulte con El Administrador del Sistema.<br/><span style='font-size:12px;'>Web Master:Descubre innova.<br/>942052518</span></b>");        
        $smarty->assign('links', 'links.html');
        $smarty->assign('mensaje',$mensaje);
        $smarty->display('error.html');
    }
    
    public function loginAction(){
        
        include_once('models/funcionario.php');
        
        $usuario = '';
        $clave = '';
        
        if(isset($_REQUEST['usuario']) && $_REQUEST['clave']){
            $usuario = $_REQUEST['usuario'];
            $clave = ($_REQUEST['clave']);        
        }else{
            if(isset($_COOKIE['alertas_usu']) && isset($_COOKIE['alertas_pass']) && $_COOKIE['alertas_usu'] != '' && $_COOKIE['alertas_pass']!=''){
                $usuario = $_COOKIE['alertas_usu'];
                $clave = $_COOKIE['alertas_pass']; 
            }
        }
        
        $obj = new funcionario();
  
        $obj = $obj->getAll()
                ->whereAnd('usuario =', $usuario)
                ->whereAnd('clave =', $clave);
        
        $url_script = $_SERVER['SCRIPT_NAME'];
        
        if ( $obj->count() == 0 ){
            header("Location: $url_script?error=NOT_VALID");
            die();
        }
        
        $_SESSION['vales.funcionario'] = $obj->get(0)->getFields();
        $_SESSION['vales.perfil'] = $obj->get(0)->Cargo->Perfil->getFields();
        
        if(isset($_REQUEST['recordar']) && $_REQUEST['recordar']=='on'){
            setcookie('alertas_usu',$usuario,time()+30*24*60*60,'/');
            setcookie('alertas_pass',$clave,time()+30*24*60*60,'/');
        }
        
        header("Location: $url_script");

        
    }

    private function getIpPc(){
        
        if ($_SERVER) {
           if ( isset ($_SERVER["HTTP_X_FORWARDED_FOR"]) ) {
               $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
           } elseif ( isset ($_SERVER["HTTP_CLIENT_IP"]) ) {
               $realip = $_SERVER["HTTP_CLIENT_IP"];
           } else {
               $realip = $_SERVER["REMOTE_ADDR"];
           }
        } else {
            if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
               $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
            } elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
               $realip = getenv( 'HTTP_CLIENT_IP' );
            } else {
               $realip = getenv( 'REMOTE_ADDR' );
            }
        }

        return $realip;
    }
    
    public function logoutAction(){
        
        unset($_SESSION['vales.funcionario']);
        unset($_SESSION['vales.perfil']);
        
        session_unset();
        session_destroy();
        setcookie ('alertas_usu', '', time()-604800,'/');
        setcookie ('alertas_pass', '', time()-604800,'/');
        $url_script = $_SERVER['SCRIPT_NAME'];
        
        header('Location: '.$url_script);
        
    }

    public function indexAction(){

        if ( array_key_exists('error', $_REQUEST) ){
                $errors = array(
                                        'NOT_VALID'=>'Usuario Ingresado o Contraseña no validos'
                                        );
                $errorMessage = @$errors[$_REQUEST['error']];
                
                global $smarty;
                
                $smarty->assign('mensaje',$errorMessage);
                
                $smarty->assign('url','');

                $smarty->assign('info', 'N');
                $smarty->display('login.html');
                
        }else{
        
            if (!isset ($_SESSION['vales.funcionario'])){

                if(isset($_COOKIE['alertas_usu']) && isset($_COOKIE['alertas_pass']) && $_COOKIE['alertas_usu'] != '' && $_COOKIE['alertas_pass']!=''){
                    
                    $this->loginAction();
                }
                
                global $smarty;
                $smarty->assign('url','');

                $smarty->assign('info', 'N');
                $smarty->display('login.html');

            }else{

                include_once 'models/modulos.php';

                $perfil = $_SESSION['vales.perfil'];
                $funcionario = $_SESSION['vales.funcionario'];

                if (isset ($_SESSION['vales.perfil'])){
                    $car_id = $perfil['id_perfil'];
                }else
                     $car_id = 0;
                
                global $smarty;
                
                $smarty->assign('opciones', Modulos::getModulos($car_id));

                $smarty->assign('contenido','bienvenido.html');
                $smarty->assign('nombre_funcionario', $funcionario['nombres'].' '.$funcionario['apellidos']);
                $smarty->assign('ip', $this->getIpPc());
                $smarty->display('index.html');
            }
        }

    }
 
    public function getUbigeoAjax(){
        include_once 'models/ubigeo.php';

        $ubigeo = new Ubigeo();

        $cod_dpto  = @$_REQUEST['coddpto'];
        $cod_prov  = @$_REQUEST['codprov'];
        $cod_dist  = @$_REQUEST['coddist'];
        $idtipo  = $_REQUEST['tipo'];

        if ($idtipo == 1){
            $ubigeo = $ubigeo->getAll()
                    ->Orderby('nombre',true)
                    ->WhereAnd('cod_dpto<>', '00')
                    ->WhereAnd('cod_prov=', '00')
                    ->WhereAnd('cod_dist=', '00');
        }

        if ($idtipo == 2){
            $ubigeo = $ubigeo->getAll()
                    ->Orderby('nombre',true)
                    ->WhereAnd('cod_dpto=', $cod_dpto)
                    ->WhereAnd('cod_prov<>', '00')
                    ->WhereAnd('cod_dist=', '00');
        }

        if ($idtipo == 3){

            $ubigeo = $ubigeo->getAll()
                    ->Orderby('nombre',true)
                    ->WhereAnd('cod_dpto=', $cod_dpto)
                    ->WhereAnd('cod_prov=', $cod_prov)
                    ->WhereAnd('cod_dist<>', '00');

        }

        if ($idtipo == 4){
           $ubigeo = $ubigeo->getAll()
                   ->Orderby('nombre',true)
                    ->WhereAnd('cod_dpto=', $cod_dpto)
                   ->WhereAnd('cod_prov=', $cod_prov)
                   ->WhereAnd('cod_dist=', $cod_dist)
                   ->WhereAnd('codccpp<>', '00');
        }
        return $ubigeo->getArray();
    }

    public function searchUbigeoAjax(){
        include_once 'models/ubigeo.php';

        $ubigeo = new Ubigeo();
        
        $nombre = strtoupper($_REQUEST['nombre']);
        
        return $ubigeo->getAll()->WhereAnd('upper(nombre) like ', $nombre.'%')->getDatos(10);
    }
    
    public function getNameUbigeoAjax(){
        include_once 'models/ubigeo.php';
        $obj=new ubigeo();
        $obj=$obj->getAll()->WhereAnd('id_ubigeo=',$_REQUEST['id_ubigeo']);
        return $obj->get(0);
    }
     
    public function UbigeoAjax(){
        include_once 'models/ubigeo.php';

        $obj=new ubigeo();
        $obj=$obj->getAll()->WhereAnd('id_ubigeo=',$_REQUEST['id_ubigeo']);
        return $obj->get(0);
        
    }
    public  function saveubigeoAjax()
       {
        $cod_dpto  = $_REQUEST['coddpto'];
        $cod_prov  = $_REQUEST['codprov'];
        $cod_dist  = $_REQUEST['coddist']; 
        include_once 'models/ubigeo.php';
        // $sql="SELECT MAX (ubigeo.id_ubigeo)as id_ubigeo from ubigeo";
        // $sql=  ORMConnection::Execute($sql);
        // $id_ubigeo=$sql[0]['id_ubigeo'];
        // $id_ubigeo=$id_ubigeo+1;
         $ubigeo= new Ubigeo();
         $ubigeo = $ubigeo->getAll()
                   ->Orderby('nombre',true)
                    ->WhereAnd('cod_dpto=', $cod_dpto)
                   ->WhereAnd('cod_prov=', $cod_prov)
                   ->WhereAnd('cod_dist=', $cod_dist)
                   ->WhereAnd('codccpp<>', '00');
         if($ubigeo->count()==0)
            {
             $codccpp=1; 
            }else
             {
               $r=  ORMConnection::Execute("SELECT max(codccpp)  as codccpp from ubigeo
                where cod_dpto='{$cod_dpto}'
                and cod_prov='{$cod_prov}'
                and cod_dist='{$cod_dist}'");
               $codccpp=$r[0]['codccpp'];
               $codccpp=$codccpp+1;
             }
            $codccpp = str_pad($codccpp,2,'0',STR_PAD_LEFT);
          $obj=new Ubigeo();
         // $obj->id_ubigeo=$id_ubigeo;
          $obj->cod_dpto=$cod_dpto;
          $obj->cod_prov=$cod_prov;
          $obj->cod_dist=$cod_dist;
          $obj->nombre=strtoupper($_REQUEST['nombre']);
          $obj->codccpp=$codccpp;
          $obj->create(true);
         return $obj->getFields();
       }
}

?>

