<?php

include_once('ControllerBase.php');
include_once('models/funcionario.php');

class cFuncionario extends ControllerBase {

    protected $defaultaction = 'index';
    protected $model = 'funcionario';

    /**
     *  listAjax
     *  saveAjax
     *  selectAjax
     *  deleteAjax
     */
    public function indexAction() {
        $this->formAction();
    }

    public function guardarAjax() {
        $perfil = $_SESSION['vales.perfil'];
        $obj = new Funcionario();
        $obj->setFields($_REQUEST);
        $obj->estado = 'A';
        if ($perfil['id_perfil'] == 1) {
            try {
                $obj->find($_REQUEST);
                $clave = $obj->clave;
                $obj->setFields($_REQUEST);
                if ($clave != $obj->clave)
                    $obj->clave = md5($obj->clave);

                $obj->update();
                $res['tipo'] = 'OK';
            } catch (ORMException $e) {

                $lsFuncionario = new Funcionario();
                $lsFuncionario = $lsFuncionario->getAll()->WhereAnd('usuario=', $_REQUEST['usuario'])->WhereAnd('estado=', 'A');

                if ($lsFuncionario->count() == 0) {

                    $obj->clave = $obj->clave;

                    $obj->create(true);
                    $res['tipo'] = 'OK';
                } else {
                    $res['tipo'] = 'ERROR';
                    $res['mensaje'] = 'El usuario [' . $obj->usuario . '] ya existe';
                }
            }
            return $res;
        } else {
            try {
                $obj->find($_REQUEST);
                $obj->clave = null;
                $obj->usuario = null;

                $obj->update();
                $res['tipo'] = 'OK';
            } catch (ORMException $e) {
                $obj->clave = md5($obj->clave);

                $obj->create(true);
                $res['tipo'] = 'OK';
            }
            return $res;
        }
    }

    public function anularAjax() {

        $obj = new Funcionario();
        try {
            $obj->find($_REQUEST);

            if ($obj->estado == 'I')
                $obj->estado = 'A';
            else
                $obj->estado = 'I';

            $obj->update();
        } catch (ORMException $e) {
            
        }

        return $obj->getFields();
    }

    public function getAjax() {

        $obj = new Funcionario();
        try {
            $obj->find($_REQUEST);
        } catch (ORMException $e) {
            $obj = null;
        }

        return $obj->getFields();
    }

    public function getOnLineAjax() {

        $obj = new Funcionario();

        $fun = $_SESSION['login'];

        $obj = $obj->getAll()->WhereAnd('on_line=', 'S')->WhereAnd('usuario<>', $fun['usuario']);

        return $obj->getArray();
    }

    public function getFuncionariosAjax() {

        $obj = new Funcionario();

        $obj = $obj->getAll();

        if (isset($_REQUEST['id_oficina']))
            $obj = $obj->WhereAnd('estado=', 'A')->WhereAnd('id_oficina=', $_REQUEST['id_oficina']);

        return $obj->getArrayAll();
    }

    public function listaFuncionarioAjax() {
        return Funcionario::getFuncionarios($_REQUEST['q'], 3);
    }

    public function formAction() {

        $grilla = new jsGrid();
        $grilla->setCaption("Personal");
        $grilla->setPager("DTabla");
        $grilla->setTabla("TTabla");
        $grilla->setSortname("nombres");
        $activo = 'A';
        if (isset($_REQUEST['inactivo'])) {
            $activo = 'I';
            $grilla->setUrl("funcionario/lista?inactivo=I");
        } else {
            $grilla->setUrl("funcionario/lista");
        }
        $perfil = $_SESSION['vales.perfil'];
        $grilla->setAlto(350);

        $grilla->addColumnas("nombres", "Nombre");
        $grilla->addColumnas("apellidos", "Apellidos");
        $grilla->addColumnas("estado", "Direccion");
        $grilla->addColumnas("dni", "Dni");
        $grilla->addColumnas("email", "Email");
        $grilla->addColumnas("cargo", "Cargo");
        $grilla->addColumnas("oficina", "Oficina");

        global $smarty;

        include_once 'models/oficina.php';
        $oficina = Oficina::getOficinasDependencia(0, 0);
        
        $funcionarios = Funcionario::getFuncionariosAll();
        
        $smarty->assign('grilla', $grilla->buildJsGrid());
        $smarty->assign('oficina', $oficina);
        $smarty->assign('funcionarios', $funcionarios);
        $smarty->assign('links', 'links.html');
        $smarty->assign('activo', $activo);
        $smarty->assign('perfil', $perfil['id_perfil']);
        $smarty->assign('datos', 'funcionario/datos.tpl');
        $smarty->display('funcionario/form.tpl');
    }

    public function getFuncionarioAllAjax(){
        return Funcionario::getFuncionariosAll();
    }


    public function misDatosAction() {

        global $smarty;

        $funcionario = $_SESSION['login'];

        $funcionario = new Funcionario($funcionario);

        $oficina = $funcionario->Oficina->nombre;
        $cargo = $funcionario->Cargo->descripcion;

        $smarty->assign('current', '0');
        $smarty->assign('funcionario', $funcionario);
        $smarty->assign('cargo', $cargo);
        $smarty->assign('oficina', $oficina);
        $smarty->assign('contenido', 'funcionario/mis_datos.tpl');
        $smarty->assign('camino', 'Mis Datos');

        $smarty->display('index.tpl');
    }

    public function listaAction() {

        $est = 'A';
        if (isset($_REQUEST['inactivo'])) {
            $est = 'I';
        }
        $db = new jsGridBdORM();

        $db->setTabla('funcionario');
        $db->setParametros($_REQUEST);

        $db->setColumnaId('id_funcionario');

        $db->addColumna("nombres");
        $db->addColumna("apellidos");
        $db->addColumna("direccion");
        $db->addColumna("dni");
        $db->addColumna("email");
        $db->addColumna("Cargo->descripcion");
        $db->addColumna("Oficina->nombre");
        $db->addColumna("estado");

        $db->addWhereAnd('estado=', $est);

        if (isset($_REQUEST['req'])) {

            $func = $_SESSION['funcionario'];

            $db->addWhereAnd('id_funcionario=', $func['id_funcionario']);
        }

        echo $db->to_json();
    }

    public function cambiarclaveAjax() {
        $funcionario = $_SESSION['funcionario'];

        $Objfuncionario = new Funcionario();

        try {

            $Objfuncionario->find(array('id_funcionario' => $funcionario['id_funcionario']));

            if ($Objfuncionario->clave == md5($_REQUEST['claveactual'])) {

                $Objfuncionario->clave = md5($_REQUEST['nuevaclave']);
                $Objfuncionario->update();

                $Objfuncionario->clave = '---';

                return $Objfuncionario->getFields();
            } else {
                return array('error' => 'Clave actual incorrecta.');
            }
        } catch (ORMException $e) {
            return array('error' => 'Error en la autenticacion del usuario.');
        }
    }

    public function verificarUsuarioAjax() {

        $obj = new Funcionario();
        $usuario = $_SESSION['funcionario'];
        $obj = $obj->getAll()
                ->whereAnd('estado =', 'A')
                ->whereAnd('usuario =', $usuario['usuario'])
                ->whereAnd('clave =', md5($_REQUEST['clave']));

        if ($obj->count() == 1) {

            return $obj->get(0)->getFields();
        } else
            return null;
    }

}

?>