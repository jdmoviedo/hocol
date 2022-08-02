<?php
ini_set('display_errors', 1);
/**
 *
 */
class model_cargar_select
{
    public static function cargarModulos()
    {
        require_once(rutaBase . 'php/conexion/conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $sql = "SELECT * FROM modulos where id_estado = 1";
        $html = "";
        $resultado = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);
        if (mysqli_num_rows($resultado) > 0) {
            while ($data = mysqli_fetch_array($resultado)) {
                $id_modulo = $data['id_modulo'];
                $descripcion = $data['descripcion'];
                $html .= '<option value="' . $id_modulo . '">' . $descripcion . '</option>';
            }
            $respuesta = array(
                'status' => '1',
                'html' => $html
            );
        } else {
            $respuesta['status'] = "0";
        }
        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function cargarSubModulos($id_modulo = null)
    {
        require_once(rutaBase . 'php/conexion/conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $AndModulo = "";

        if ($id_modulo != "") {
            $AndModulo = "AND id_modulo = $id_modulo";
        }

        $sql = "SELECT * FROM submodulos where id_estado = 1 $AndModulo";
        $html = "";
        $resultado = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);
        if (mysqli_num_rows($resultado) > 0) {
            while ($data = mysqli_fetch_array($resultado)) {
                $id_submodulo = $data['id_submodulo'];
                $descripcion = $data['descripcion'];
                $html .= '<option value="' . $id_submodulo . '">' . $descripcion . '</option>';
            }
            $respuesta = array(
                'status' => '1',
                'html' => $html
            );
        } else {
            $respuesta['status'] = "0";
        }
        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function cargarDepartamentos()
    {
        require_once(rutaBase . 'php/conexion/conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $sql = "SELECT * FROM departamentos order by nombre";
        $html = "";
        $resultado = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);
        if (mysqli_num_rows($resultado) > 0) {
            while ($data = mysqli_fetch_array($resultado)) {
                $codigo = $data['codigo'];
                $nombre = $data['nombre'];
                $html .= '<option value="' . $codigo . '">' . $nombre . '</option>';
            }
            $respuesta = array(
                'status' => '1',
                'html' => $html
            );
        } else {
            $respuesta['status'] = "0";
        }
        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function cargarMunicipios()
    {
        require_once(rutaBase . 'php/conexion/conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $sql = "SELECT * FROM municipios order by nombre";
        $html = "";
        $resultado = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);
        if (mysqli_num_rows($resultado) > 0) {
            while ($data = mysqli_fetch_array($resultado)) {
                $id_municipio = $data['id_municipio'];
                $nombre = $data['nombre'];
                $html .= '<option value="' . $id_municipio . '">' . $nombre . '</option>';
            }
            $respuesta = array(
                'status' => '1',
                'html' => $html
            );
        } else {
            $respuesta['status'] = "0";
        }
        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function cargarCargos()
    {
        require_once(rutaBase . 'php/conexion/conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $sql = "SELECT * FROM cargos WHERE id_estado = 1 order by descripcion";
        $html = "";
        $resultado = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);
        if (mysqli_num_rows($resultado) > 0) {
            while ($data = mysqli_fetch_array($resultado)) {
                $id_cargo = $data['id_cargo'];
                $descripcion = $data['descripcion'];
                $html .= '<option value="' . $id_cargo . '">' . $descripcion . '</option>';
            }
            $respuesta = array(
                'status' => '1',
                'html' => $html
            );
        } else {
            $respuesta['status'] = "0";
        }
        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function cargarTipoDocumento()
    {
        require_once(rutaBase . 'php/conexion/conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $sql = "SELECT * FROM tipo_documento";
        $html = "";
        $resultado = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);
        if (mysqli_num_rows($resultado) > 0) {
            while ($data = mysqli_fetch_array($resultado)) {
                $id_tipo_documento = $data['id_tipo_documento'];
                $descripcion = $data['descripcion'];
                $html .= '<option value="' . $id_tipo_documento . '">' . $descripcion . '</option>';
            }
            $respuesta = array(
                'status' => '1',
                'html' => $html
            );
        } else {
            $respuesta['status'] = "0";
        }
        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function cargarODS()
    {
        require_once(rutaBase . 'php/conexion/conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $sql = "SELECT * FROM ods WHERE id_estado = 1 order by descripcion";
        $html = "";
        $resultado = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);
        if (mysqli_num_rows($resultado) > 0) {
            while ($data = mysqli_fetch_array($resultado)) {
                $id_ods = $data['id_ods'];
                $descripcion = $data['descripcion'];
                $html .= '<option value="' . $id_ods . '">' . $descripcion . '</option>';
            }
            $respuesta = array(
                'status' => '1',
                'html' => $html
            );
        } else {
            $respuesta['status'] = "0";
        }
        mysqli_close($mysqli);
        return json_encode($respuesta);
    }
}
