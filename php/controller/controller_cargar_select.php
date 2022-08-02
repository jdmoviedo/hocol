<?php
ini_set('display_errors', 1);
require_once(dirname(__DIR__) . '/libraries/rutas.php');
require_once(rutaBase . 'php/libraries/sesion.php');
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    if (isset($_POST['select'])) {
        require_once(rutaBase . 'php/libraries/validaciones.php');
        $select = $_POST['select'];
        switch ($select) {
            case 'cargarSubModulos':
                $valores = isset($_POST['valores']) ? json_decode($_POST['valores']) : (object)[];
                if ($valores) {
                    $id_modulo = $valores->modulo;
                    if (Validar::numeros($id_modulo)) {
                        require_once(rutaBase . 'php/model/model_cargar_select.php');
                        echo model_cargar_select::cargarSubModulos($id_modulo);
                    } else {
                        $respuesta['status'] = "0";
                        echo json_encode($respuesta);
                    }
                } else {
                    require_once(rutaBase . 'php/model/model_cargar_select.php');
                    echo model_cargar_select::cargarSubModulos();
                }
                break;
            case 'cargarModulos':
                require_once(rutaBase . 'php/model/model_cargar_select.php');
                echo model_cargar_select::cargarModulos();
                break;
            case 'cargarDepartamentos':
                require_once(rutaBase . 'php/model/model_cargar_select.php');
                echo model_cargar_select::cargarDepartamentos();
                break;
            case 'cargarMunicipios':
                require_once(rutaBase . 'php/model/model_cargar_select.php');
                echo model_cargar_select::cargarMunicipios();
                break;
            case 'cargarCargos':
                require_once(rutaBase . 'php/model/model_cargar_select.php');
                echo model_cargar_select::cargarCargos();
                break;
            case 'cargarTipoDocumento':
                require_once(rutaBase . 'php/model/model_cargar_select.php');
                echo model_cargar_select::cargarTipoDocumento();
                break;
            case 'cargarODS':
                require_once(rutaBase . 'php/model/model_cargar_select.php');
                echo model_cargar_select::cargarODS();
                break;
            default:
                echo "0_o";
                break;
        }
    } else {
        echo "0_o";
    }
} else {
}
