<?php
ini_set('display_errors', 1);
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (isset($_POST['peticion'])) {
        require_once(dirname(__DIR__) . '/libraries/rutas.php');
        require_once(rutaBase . 'php' . DS . 'libraries' . DS . 'sesion.php');
        require_once(rutaBase . 'php' . DS . 'libraries' . DS . 'validaciones.php');
        require_once(rutaBase . 'php' . DS . 'controller' . DS . 'controller_login.php');
        $permisos = Sesion::GetParametro('permisos');

        if ($permisos) {
            if (controller_login::verificarLogin("Modulos")) {
                $peticion = $_POST['peticion'];
                switch ($peticion) {
                    case "crearModulo":
                        $modulo = isset($_POST['modulo']) ? trim($_POST['modulo']) : NULL;
                        $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : NULL;
                        $icono = isset($_POST['icono']) ? trim($_POST['icono']) : NULL;

                        if (
                            Validar::letras($descripcion) && Validar::requerido($icono) && Validar::letras($modulo)
                        ) {
                            require_once(rutaBase . 'php' . DS . 'model' . DS . 'model_modulos.php');
                            echo ModelModulos::crearModulo($descripcion, $icono, $modulo);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "buscarModulos":
                        require_once(rutaBase . 'php/model/model_modulos.php');
                        echo ModelModulos::buscarModulos();
                        break;
                    case "datosModulo":
                        $id_modulo = isset($_POST['id_modulo']) ? trim($_POST['id_modulo']) : null;
                        if (
                            validar::patronnumeros($id_modulo)
                        ) {
                            require_once(rutaBase . 'php/model/model_modulos.php');
                            echo ModelModulos::datosModulo($id_modulo);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "editarModulo":
                        $id_modulo = isset($_POST['id_modulo']) ? trim($_POST['id_modulo']) : NULL;
                        $modulo = isset($_POST['modulo']) ? trim($_POST['modulo']) : NULL;
                        $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : NULL;
                        $icono = isset($_POST['icono']) ? trim($_POST['icono']) : NULL;

                        if (
                            Validar::numeros($id_modulo) && Validar::letras($descripcion) && Validar::requerido($icono) && Validar::letras($modulo)
                        ) {
                            require_once(rutaBase . 'php' . DS . 'model' . DS . 'model_modulos.php');
                            echo ModelModulos::editarModulo($id_modulo, $descripcion, $icono, $modulo);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "cambiarEstado":
                        $id_modulo = isset($_POST['id_modulo']) ? trim($_POST['id_modulo']) : null;
                        $estado = isset($_POST['estado']) ? trim($_POST['estado']) : null;
                        if (
                            validar::patronnumeros($id_modulo) && validar::patronnumeros($estado)
                        ) {
                            require_once(rutaBase . 'php/model/model_modulos.php');

                            echo ModelModulos::cambiarEstado($id_modulo, $estado);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                }
            }
        }
    } else {
        echo json_encode('Sin peticion 0_o');
    }
}
