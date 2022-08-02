<?php
ini_set('display_errors', 1);
class ModelModulos
{
    public static function buscarModulos()
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');

        $consulta = "SELECT
        M.id_modulo,
        M.descripcion,
        M.id_estado,
        M.icono,
        M.modulo
        FROM modulos M";

        $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            $arrayrespuesta['status'] = "1";
            require_once(rutaBase . 'php/libraries/fechas.php');
            //$formatoFecha = new fechas();
            while ($data = mysqli_fetch_array($resultado)) {
                $id_modulo = $data['id_modulo'];
                $descripcion = $data['descripcion'];
                $estado = $data['id_estado'];
                $icono = $data['icono'];
                $modulo = $data['modulo'];

                if ($estado == 1) {
                    $estado = '<span class="badge badge-success">ACTIVO</span>';
                } else {
                    $estado = '<span class="badge badge-danger">INACTIVO</span>';
                }


                if (!empty($icono)) {
                    $icono = '<i class="' . $icono . ' fa-lg"></i>';
                }

                $acciones = '<i class="ik ik-eye fa-lg" style="cursor: pointer;" onclick="datos_registro(' . $id_modulo . ');"  title="Ver"></i>';
                $acciones .= '<i class="ik ik-edit-2 fa-lg" style="cursor: pointer;margin-left:5px;" title="Editar" onclick="editar_registro(' . $id_modulo . ');"></i>';
                $acciones .= '<i class="ik ik-repeat fa-lg" style="cursor: pointer;margin-left:5px;" title="Activar/Desactivar" onclick="cambiar_estado(' . $id_modulo . ',' . $data['id_estado'] . ');"></i>';

                $respuesta = array($id_modulo, $modulo, $descripcion, $icono,  $estado,  $acciones);
                $arrayrespuesta['datos'][] = $respuesta;
            }
        } else {
            $arrayrespuesta['status'] = "0";
        }
        mysqli_close($mysqli);
        return json_encode($arrayrespuesta);
    }

    public static function crearModulo($descripcion, $icono, $modulo)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $usuario = Sesion::GetParametro('id');

        $descripcion = $mysqli->real_escape_string($descripcion);
        $icono = $mysqli->real_escape_string($icono);

        date_default_timezone_set('America/Bogota');
        $fechaHoraActual = date('Y-m-d H:i:s');

        $consultaValidarDescripcion = "SELECT * FROM modulos where (descripcion like '%$descripcion%' or modulo like '%$modulo%')";
        $resultadoValidarDescripcion = mysqli_query($mysqli, $consultaValidarDescripcion) or die("Error en la Consulta SQL: " . $consultaValidarDescripcion);

        if (mysqli_num_rows($resultadoValidarDescripcion) > 0) {
            $respuesta['status'] = "2";
        } else {
            $consulta = "INSERT INTO modulos(descripcion,icono,id_estado,usuario_creacion,fecha_creacion,modulo)
				VALUES('$descripcion','$icono',1,$usuario,'$fechaHoraActual','$modulo')";
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

    public static function cambiarEstado($id_modulo, $estado)
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

        $consulta = "UPDATE modulos SET
                    id_estado = $estado
                    where id_modulo = $id_modulo";

        $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

        if ($resultado) {
            $respuesta['status'] = "1";
        } else {
            $respuesta['status'] = "0";
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function datosModulo($id_modulo)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');

        $consulta = "SELECT * FROM modulos where id_modulo = $id_modulo";

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

    public static function editarModulo($id_modulo, $descripcion, $icono, $modulo)
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
        FROM modulos 
        where (descripcion like '%$descripcion%' or modulo like '%$modulo%')
        and id_modulo != $id_modulo";
        $resultadoValidarDescripcion = mysqli_query($mysqli, $consultaValidarDescripcion) or die("Error en la Consulta SQL: " . $consultaValidarDescripcion);

        if (mysqli_num_rows($resultadoValidarDescripcion) > 0) {
            $respuesta['status'] = "2";
        } else {

            $consulta = "UPDATE modulos
            SET
            descripcion = '$descripcion',
            icono = '$icono',
            usuario_actualizacion = '$usuario',
            fecha_actualizacion = '$fechaHoraActual',
            modulo = '$modulo'
            WHERE
            id_modulo = $id_modulo";
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
