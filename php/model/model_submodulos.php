<?php
ini_set('display_errors', 1);
class ModelSubmodulos
{
    public static function buscarSubmodulos()
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');

        $consulta = "SELECT
        SM.id_submodulo,
        M.descripcion as modulo,
        SM.descripcion as descripcion,
        SM.id_estado,
        SM.submodulo,
        SM.url
        FROM submodulos SM
        join modulos M on M.id_modulo = SM.id_modulo";

        $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            $arrayrespuesta['status'] = "1";
            require_once(rutaBase . 'php/libraries/fechas.php');
            //$formatoFecha = new fechas();
            while ($data = mysqli_fetch_array($resultado)) {
                $id_submodulo = $data['id_submodulo'];
                $modulo = $data['modulo'];
                $submodulo = $data['submodulo'];
                $estado = $data['id_estado'];
                $descripcion = $data['descripcion'];
                $url = $data['url'];

                if ($estado == 1) {
                    $estado = '<span class="badge badge-success">ACTIVO</span>';
                } else {
                    $estado = '<span class="badge badge-danger">INACTIVO</span>';
                }


                $acciones = '<i class="ik ik-eye fa-lg" style="cursor: pointer;" onclick="datos_registro(' . $id_submodulo . ');"  title="Ver"></i>';
                $acciones .= '<i class="ik ik-edit-2 fa-lg" style="cursor: pointer;margin-left:5px;" title="Editar" onclick="editar_registro(' . $id_submodulo . ');"></i>';
                $acciones .= '<i class="ik ik-repeat fa-lg" style="cursor: pointer;margin-left:5px;" title="Activar/Desactivar" onclick="cambiar_estado(' . $id_submodulo . ',' . $data['id_estado'] . ');"></i>';

                $respuesta = array($id_submodulo, $modulo, $submodulo, $descripcion, $url, $estado, $acciones);
                $arrayrespuesta['datos'][] = $respuesta;
            }
        } else {
            $arrayrespuesta['status'] = "0";
        }
        mysqli_close($mysqli);
        return json_encode($arrayrespuesta);
    }

    public static function crearSubmodulo($id_modulo, $descripcion, $submodulo, $url)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $usuario = Sesion::GetParametro('id');

        $descripcion = $mysqli->real_escape_string($descripcion);

        date_default_timezone_set('America/Bogota');
        $fechaHoraActual = date('Y-m-d H:i:s');

        $consultaValidarDescripcion = "SELECT * FROM submodulos where (submodulo like '%$submodulo%' or url like '%$url%')";
        $resultadoValidarDescripcion = mysqli_query($mysqli, $consultaValidarDescripcion) or die("Error en la Consulta SQL: " . $consultaValidarDescripcion);

        if (mysqli_num_rows($resultadoValidarDescripcion) > 0) {
            $respuesta['status'] = "2";
        } else {

            $consulta = "INSERT INTO submodulos(id_modulo,descripcion,id_estado,usuario_creacion,fecha_creacion,submodulo,url)
				VALUES($id_modulo,'$descripcion',1,$usuario,'$fechaHoraActual','$submodulo','$url')";
            $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

            if ($resultado) {
                $respuesta['status'] = "1";
            } else {
                $respuesta['status'] = "0";
            }
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function cambiarEstado($id_submodulo, $estado)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');

        if ($estado == 1) {
            $estado = 2;
        } else {
            $estado = 1;
        }

        $consulta = "UPDATE submodulos SET
                    id_estado = $estado
                    where id_submodulo = $id_submodulo";

        $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

        if ($resultado) {
            $respuesta['status'] = "1";
        } else {
            $respuesta['status'] = "0";
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function datosSubmodulo($id_submodulo)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');

        $consulta = "SELECT * FROM submodulos where id_submodulo = $id_submodulo";

        $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

        if ($resultado) {
            if (mysqli_num_rows($resultado) > 0) {
                $row = mysqli_fetch_assoc($resultado);
                foreach ($row as $key => $value) {
                    $respuesta[$key] = $value;
                }
                $respuesta['status'] = "1";
            } else {
                $respuesta['status'] = "2";
            }
        } else {
            $respuesta['status'] = "0";
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function editarSubmodulo($id_submodulo, $id_modulo, $descripcion, $submodulo, $url)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $usuario = Sesion::GetParametro('id');

        date_default_timezone_set('America/Bogota');
        $fechaHoraActual = date('Y-m-d H:i:s');

        $descripcion = $mysqli->real_escape_string($descripcion);

        $consultaValidarDescripcion = "SELECT 
        * 
        FROM submodulos 
        where (submodulo like '%$submodulo%' or url like '%$url%') and id_submodulo != $id_submodulo";
        $resultadoValidarDescripcion = mysqli_query($mysqli, $consultaValidarDescripcion) or die("Error en la Consulta SQL: " . $consultaValidarDescripcion);

        if (mysqli_num_rows($resultadoValidarDescripcion) > 0) {
            $respuesta['status'] = "2";
        } else {

            $consulta = "UPDATE submodulos 
            SET
            id_modulo = $id_modulo,
            descripcion = '$descripcion',
            usuario_actualizacion = '$usuario',
            fecha_actualizacion = '$fechaHoraActual',
            submodulo ='$submodulo',
            url = '$url'
            WHERE
            id_submodulo = $id_submodulo";

            $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

            if ($resultado) {
                $respuesta['status'] = "1";
            } else {
                $respuesta['status'] = "0";
            }
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }
}
