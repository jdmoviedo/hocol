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
            if (controller_login::verificarLogin("Submodulos")) {
                $peticion = $_POST['peticion'];
                switch ($peticion) {
                    case "crearSubmodulo":
                        $id_modulo = isset($_POST['selectModulo']) ? $_POST['selectModulo'] : NULL;
                        $submodulo = isset($_POST['submodulo']) ? trim($_POST['submodulo']) : NULL;
                        $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : NULL;
                        $url = isset($_POST['url']) ? trim($_POST['url']) : NULL;

                        if (
                            Validar::numeros($id_modulo) && Validar::letras($descripcion) && Validar::letras($submodulo) && Validar::letras($descripcion)
                            && Validar::letras($url)
                        ) {
                            require_once(rutaBase . 'php' . DS . 'model' . DS . 'model_submodulos.php');
                            echo ModelSubmodulos::crearSubmodulo($id_modulo, $descripcion, $submodulo, $url);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "buscarSubmodulos":
                        require_once(rutaBase . 'php/model/model_submodulos.php');
                        echo ModelSubmodulos::buscarSubmodulos();
                        break;
                    case "datosSubmodulo":
                        $id_submodulo = isset($_POST['id_submodulo']) ? trim($_POST['id_submodulo']) : null;
                        if (
                            validar::patronnumeros($id_submodulo)
                        ) {
                            require_once(rutaBase . 'php/model/model_submodulos.php');
                            echo ModelSubmodulos::datosSubmodulo($id_submodulo);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "editarSubmodulo":
                        $id_submodulo = isset($_POST['id_submodulo']) ? trim($_POST['id_submodulo']) : NULL;
                        $id_modulo = isset($_POST['selectModulo']) ? $_POST['selectModulo'] : NULL;
                        $submodulo = isset($_POST['submodulo']) ? trim($_POST['submodulo']) : NULL;
                        $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : NULL;
                        $url = isset($_POST['url']) ? trim($_POST['url']) : NULL;

                        if (
                            Validar::numeros($id_submodulo) && Validar::numeros($id_modulo) && Validar::letras($descripcion)
                            && Validar::letras($submodulo) && Validar::letras($url)
                        ) {
                            require_once(rutaBase . 'php' . DS . 'model' . DS . 'model_submodulos.php');
                            echo ModelSubmodulos::editarSubmodulo($id_submodulo,  $id_modulo, $descripcion, $submodulo, $url);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "cambiarEstado":
                        $id_submodulo = isset($_POST['id_submodulo']) ? trim($_POST['id_submodulo']) : null;
                        $estado = isset($_POST['estado']) ? trim($_POST['estado']) : null;
                        if (
                            validar::numeros($id_submodulo) && validar::numeros($estado)
                        ) {
                            require_once(rutaBase . 'php/model/model_submodulos.php');

                            echo ModelSubmodulos::cambiarEstado($id_submodulo, $estado);
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
