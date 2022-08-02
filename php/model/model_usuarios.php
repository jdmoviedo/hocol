<?php
ini_set('display_errors', 1);
class ModelUsuarios
{
    public static function buscarUsuarios()
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');

        $consulta = "SELECT
        US.id_usuario,
        US.documento ,
        US.primer_nombre, 
        US.segundo_nombre , 
        US.primer_apellido ,
        US.segundo_apellido,       
        US.correo,
        US.telefono,
        US.id_estado
        FROM usuario US
        order by US.id_usuario";

        $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            $arrayrespuesta['status'] = "1";
            require_once(rutaBase . 'php/libraries/fechas.php');
            //$formatoFecha = new fechas();
            while ($data = mysqli_fetch_array($resultado)) {
                $idUsuario = $data['id_usuario'];
                $nombrecompleto = $data['primer_apellido'] . ' ' . $data['segundo_apellido'] . ' ' . $data['primer_nombre'] . ' ' . $data['segundo_nombre'];
                $documento = $data['documento'];
                $correo = $data['correo'];
                $telefono = $data['telefono'];
                $estado = $data['id_estado'];

                if ($estado == 1) {
                    $estado = '<span class="badge badge-success">ACTIVO</span>';
                } else {
                    $estado = '<span class="badge badge-danger">INACTIVO</span>';
                }

                $acciones = '<i class="ik ik-eye fa-lg cursor-pointer" onclick="datos_registro(' . $idUsuario . ');"  title="Ver"></i>';
                $acciones .= '<i class="ik ik-edit-2 fa-lg cursor-pointer ml-1" title="Editar" onclick="editar_registro(' . $idUsuario . ');"></i>';
                $acciones .= '<i class="ik ik-repeat fa-lg cursor-pointer ml-1" title="Activar/Desactivar" onclick="cambiar_estado(' . $idUsuario . ',' . $data['id_estado'] . ');"></i>';
                $acciones .= '<i class="fas fa-cubes fa-lg cursor-pointer ml-1" onclick="showModalAsignarSubmodulo(' . $idUsuario . ');"  title="Asignar Submodulo"></i>';
                $acciones .= '<i class="fas fa-user-gear fa-lg cursor-pointer ml-1" onclick="showModalAsignarPermiso(' . $idUsuario . ');"  title="Asignar Permisos"></i>';

                $respuesta = array($idUsuario, $documento, $nombrecompleto, $correo, $telefono, $estado, $acciones);
                $arrayrespuesta['datos'][] = $respuesta;
            }
        } else {
            $arrayrespuesta['status'] = "0";
        }
        mysqli_close($mysqli);
        return json_encode($arrayrespuesta);
    }

    public static function crearUsuario($primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $documento, $correo, $telefono, $contrasenia)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $usuario = Sesion::GetParametro('id');

        date_default_timezone_set('America/Bogota');
        $fechaHoraActual = date('Y-m-d H:i:s');

        $primer_nombre = $mysqli->real_escape_string($primer_nombre);
        $segundo_nombre = $mysqli->real_escape_string($segundo_nombre);
        $primer_apellido = $mysqli->real_escape_string($primer_apellido);
        $segundo_apellido = $mysqli->real_escape_string($segundo_apellido);
        $correo = $mysqli->real_escape_string($correo);


        $consultaValidarDocumento = "SELECT * FROM usuario where documento = '$documento'";
        $resultadoValidarDocumento = mysqli_query($mysqli, $consultaValidarDocumento) or die("Error en la Consulta SQL: " . $consultaValidarDocumento);

        if (mysqli_num_rows($resultadoValidarDocumento) > 0) {
            $respuesta['status'] = "2";
        } else {
            $consultaValidarCorreo = "SELECT * FROM usuario where correo = '$correo'";
            $resultadoValidarCorreo = mysqli_query($mysqli, $consultaValidarCorreo) or die("Error en la Consulta SQL: " . $consultaValidarCorreo);

            if (mysqli_num_rows($resultadoValidarCorreo) > 0) {
                $respuesta['status'] = "3";
            } else {
                $hash = password_hash($contrasenia, PASSWORD_DEFAULT);
                $consulta = "INSERT INTO usuario(primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,documento,correo,telefono,contraseña,id_estado,usuario_creacion,fecha_creacion)
				VALUES('$primer_nombre','$segundo_nombre','$primer_apellido','$segundo_apellido','$documento','$correo','$telefono','$hash',1,$usuario,'$fechaHoraActual')";
                $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

                if ($resultado) {
                    $respuesta['status'] = "1";
                } else {
                    $respuesta['status'] = "0";
                }
            }
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function cambiarEstado($id_usuario, $estado)
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

        $consulta = "UPDATE usuario SET
                    id_estado = $estado
                    where id_usuario = $id_usuario";

        $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

        if ($resultado) {
            $respuesta['status'] = "1";
        } else {
            $respuesta['status'] = "0";
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function datosUsuario($id_usuario)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');

        $consulta = "SELECT * FROM usuario where id_usuario = $id_usuario";

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

    public static function editarUsuario($id_usuario, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $documento, $correo, $telefono)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $usuario = Sesion::GetParametro('id');

        date_default_timezone_set('America/Bogota');
        $fechaHoraActual = date('Y-m-d H:i:s');

        $primer_nombre = $mysqli->real_escape_string($primer_nombre);
        $segundo_nombre = $mysqli->real_escape_string($segundo_nombre);
        $primer_apellido = $mysqli->real_escape_string($primer_apellido);
        $segundo_apellido = $mysqli->real_escape_string($segundo_apellido);
        $correo = $mysqli->real_escape_string($correo);

        $consultaValidarDocumento = "SELECT * FROM usuario where documento = '$documento' and id_usuario != $id_usuario";
        $resultadoValidarDocumento = mysqli_query($mysqli, $consultaValidarDocumento) or die("Error en la Consulta SQL: " . $consultaValidarDocumento);

        if (mysqli_num_rows($resultadoValidarDocumento) > 0) {
            $respuesta['status'] = "2";
        } else {
            $consultaValidarCorreo = "SELECT * FROM usuario where correo = '$correo' and id_usuario != $id_usuario";
            $resultadoValidarCorreo = mysqli_query($mysqli, $consultaValidarCorreo) or die("Error en la Consulta SQL: " . $consultaValidarCorreo);

            if (mysqli_num_rows($resultadoValidarCorreo) > 0) {
                $respuesta['status'] = "3";
            } else {

                $consulta = "UPDATE usuario 
                SET
                primer_nombre = '$primer_nombre',
                segundo_nombre = '$segundo_nombre',
                primer_apellido = '$primer_apellido',
                segundo_apellido = '$segundo_apellido',
                documento = '$documento',
                correo = '$correo',
                telefono = '$telefono',                
                usuario_actualizacion = $usuario,
                fecha_actualizacion = '$fechaHoraActual'
                WHERE
                id_usuario = $id_usuario";
                $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

                if ($resultado) {
                    $respuesta['status'] = "1";
                } else {
                    $respuesta['status'] = "0";
                }
            }
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function asignarSubmodulo($id_usuario, $home, $submodulos)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $usuario = Sesion::GetParametro('id');

        date_default_timezone_set('America/Bogota');
        $fechaHoraActual = date('Y-m-d H:i:s');


        $consulta = "DELETE FROM usuarios_has_submodulos where id_usuario = $id_usuario";
        $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

        if ($resultado) {
            $respuesta['status'] = "1";

            for ($i = 0; $i < count($submodulos); $i++) {
                $consultaSubmodulos = "INSERT INTO usuarios_has_submodulos(id_usuario,id_submodulo,usuario_creacion,fecha_creacion)
                VALUES($id_usuario,$submodulos[$i],$usuario,'$fechaHoraActual')";
                $resultadoSubmodulos = mysqli_query($mysqli, $consultaSubmodulos) or die("Error en la Consulta SQL: " . $consultaSubmodulos);
            }

            $consultaUsuario = "UPDATE usuario SET
            home = $home
            where id_usuario = $id_usuario";

            $resultadoUsuario = mysqli_query($mysqli, $consultaUsuario) or die("Error en la Consulta SQL: " . $consultaUsuario);
        } else {
            $respuesta['status'] = "0";
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function cargarAsignacion($id_usuario)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');

        $consultaModulos = "SELECT * FROM modulos";

        $resultadoModulos = mysqli_query($mysqli, $consultaModulos) or die("Error en la Consulta SQL: " . $consultaModulos);

        if ($resultadoModulos) {
            if (mysqli_num_rows($resultadoModulos) > 0) {

                $html = '<div class="col-md-4 form-group text-center"><b>MODULOS</b></div>';
                $html .= '<div class="col-md-8 form-group text-center"><b>SUBMODULOS</b></div>';

                while ($dataModulos = mysqli_fetch_array($resultadoModulos)) {
                    $id_modulo = $dataModulos["id_modulo"];
                    $modulo = $dataModulos["descripcion"];
                    $html .= '<div class="col-md-4 form-group text-capitalize"><input class="chkModulos" value="' . $id_modulo . '" type="checkbox" id="modulo' . $id_modulo . '"> ' . $modulo . '</div>';
                    $html .= '<div class="col-md-8 form-group"><select class="form-control" name="selectSubModulos[]" id="selectModulo' . $id_modulo . '" style="width: 100%;" disabled onchange="todos(this.id)"></select></div>';
                }

                $arrayAsignados = [];

                $consultaAsignados = "SELECT 
                SM.id_modulo,
                SM.id_submodulo,
                U.home
                FROM usuarios_has_submodulos UHS 
                join submodulos SM on SM.id_submodulo = UHS.id_submodulo
                join usuario U on U.id_usuario = UHS.id_usuario
                where UHS.id_usuario = $id_usuario";
                $resultadoAsignados = mysqli_query($mysqli, $consultaAsignados) or die("Error en la Consulta SQL: " . $consultaAsignados);

                while ($datosAsignados = mysqli_fetch_array($resultadoAsignados)) {
                    $id_modulo = $datosAsignados["id_modulo"];
                    $id_submodulo = $datosAsignados["id_submodulo"];
                    $respuesta['home'] = $datosAsignados["home"];
                    $arrayAsignados[$id_modulo][] = $id_submodulo;
                }
                $respuesta['asignados'] = $arrayAsignados;
                $respuesta['status'] = "1";
                $respuesta['html'] = $html;
            } else {
                $respuesta['status'] = "2";
            }
        } else {
            $respuesta['status'] = "0";
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function asignarPermiso($id_usuario, $permisos)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        $usuario = Sesion::GetParametro('id');

        date_default_timezone_set('America/Bogota');
        $fechaHoraActual = date('Y-m-d H:i:s');


        $consulta = "DELETE FROM usuarios_has_permiso where id_usuario = $id_usuario";
        $resultado = mysqli_query($mysqli, $consulta) or die("Error en la Consulta SQL: " . $consulta);

        if ($resultado) {
            $respuesta['status'] = "1";

            foreach ($permisos as $key => $value) {
                $consultaPermisos = "INSERT INTO usuarios_has_permiso(id_usuario,id_proceso,id_permiso,usuario_creacion,fecha_creacion)
                VALUES($id_usuario,$key,$value,$usuario,'$fechaHoraActual')";
                $resultadoPermisos = mysqli_query($mysqli, $consultaPermisos) or die("Error en la Consulta SQL: " . $consultaPermisos);
            }
        } else {
            $respuesta['status'] = "0";
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }

    public static function cargarPermisos($id_usuario)
    {
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');

        $consultaProcesos = "SELECT * FROM proceso";

        $resultadoProcesos = mysqli_query($mysqli, $consultaProcesos) or die("Error en la Consulta SQL: " . $consultaProcesos);

        if ($resultadoProcesos) {
            if (mysqli_num_rows($resultadoProcesos) > 0) {

                $html = '<div class="col-md-4 form-group text-center"><b>PROCESOS</b></div>';
                $html .= '<div class="col-md-8 form-group text-center"><b>PERMISOS</b></div>';

                while ($dataProcesos = mysqli_fetch_array($resultadoProcesos)) {
                    $id_proceso = $dataProcesos["id_proceso"];
                    $proceso = $dataProcesos["descripcion"];
                    $html .= '<div class="col-md-4 form-group text-capitalize"><input class="chkProcesos" value="' . $id_proceso . '" type="checkbox" id="proceso' . $id_proceso . '"> ' . $proceso . '</div>';
                    $html .= '<div class="col-md-8 form-group">
                    <a class="tooltips">
                        <select class="form-control" name="selectPermisos[' . $id_proceso . ']" id="selectPermiso' . $id_proceso . '" style="width: 100%;" disabled onchange="todos(this.id)" title="Permiso">
                        <option value="">Seleccione...</option>
                        <option value="1">Ver</option>
                        <option value="2">Editar</option>
                        </select>
                        <span class="spanValidacion"></span>
                    </a>
                    </div>';
                }

                $arrayAsignados = [];

                $consultaAsignados = "SELECT 
                UHP.id_permiso,
                UHP.id_proceso
                FROM usuarios_has_permiso UHP
                where UHP.id_usuario = $id_usuario";
                $resultadoAsignados = mysqli_query($mysqli, $consultaAsignados) or die("Error en la Consulta SQL: " . $consultaAsignados);

                while ($datosAsignados = mysqli_fetch_array($resultadoAsignados)) {
                    $id_proceso = $datosAsignados["id_proceso"];
                    $id_permiso = $datosAsignados["id_permiso"];
                    $arrayAsignados[$id_proceso][] = $id_permiso;
                }
                $respuesta['asignados'] = $arrayAsignados;
                $respuesta['status'] = "1";
                $respuesta['html'] = $html;
            } else {
                $respuesta['status'] = "2";
            }
        } else {
            $respuesta['status'] = "0";
        }

        mysqli_close($mysqli);
        return json_encode($respuesta);
    }
}
