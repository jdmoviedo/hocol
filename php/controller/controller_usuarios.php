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
            if (controller_login::verificarLogin("Usuarios")) {
                $peticion = $_POST['peticion'];
                switch ($peticion) {
                    case "crearUsuario":
                        $primer_nombre = isset($_POST['primer_nombre']) ? strtoupper(trim($_POST['primer_nombre'])) : NULL;
                        $segundo_nombre = isset($_POST['segundo_nombre']) ? strtoupper(trim($_POST['segundo_nombre'])) : NULL;
                        $primer_apellido = isset($_POST['primer_apellido']) ? strtoupper(trim($_POST['primer_apellido'])) : NULL;
                        $segundo_apellido = isset($_POST['segundo_apellido']) ? strtoupper(trim($_POST['segundo_apellido'])) : NULL;
                        $documento = isset($_POST['documento']) ? trim($_POST['documento']) : NULL;
                        $correo = isset($_POST['correo']) ? strtoupper(trim($_POST['correo'])) : NULL;
                        $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : NULL;
                        $contrasenia = isset($_POST['password']) ? trim($_POST['password']) : NULL;
                        $contrasenia1 = isset($_POST['password1']) ? trim($_POST['password1']) : NULL;

                        if (
                            Validar::letras($primer_nombre) && Validar::letras($primer_apellido) && Validar::numeros($telefono)
                            && Validar::numeros($documento) && $contrasenia === $contrasenia1 && Validar::correo($correo)
                        ) {
                            require_once(rutaBase . 'php' . DS . 'model' . DS . 'model_usuarios.php');
                            echo ModelUsuarios::crearUsuario(
                                $primer_nombre,
                                $segundo_nombre,
                                $primer_apellido,
                                $segundo_apellido,
                                $documento,
                                $correo,
                                $telefono,
                                $contrasenia,
                            );
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "buscarUsuarios":
                        require_once(rutaBase . 'php/model/model_usuarios.php');
                        echo ModelUsuarios::buscarUsuarios();
                        break;
                    case "cambiarEstado":
                        $id_usuario = isset($_POST['id_usuario']) ? trim($_POST['id_usuario']) : null;
                        $estado = isset($_POST['estado']) ? trim($_POST['estado']) : null;
                        if (
                            validar::patronnumeros($id_usuario) && validar::patronnumeros($estado)
                        ) {
                            require_once(rutaBase . 'php/model/model_usuarios.php');

                            echo ModelUsuarios::cambiarEstado($id_usuario, $estado);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "datosUsuario":
                        $id_usuario = isset($_POST['id_usuario']) ? trim($_POST['id_usuario']) : null;
                        if (
                            validar::patronnumeros($id_usuario)
                        ) {
                            require_once(rutaBase . 'php/model/model_usuarios.php');
                            echo ModelUsuarios::datosUsuario($id_usuario);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "editarUsuario":
                        $id_usuario = isset($_POST['id_usuario']) ? trim($_POST['id_usuario']) : NULL;
                        $primer_nombre = isset($_POST['primer_nombre']) ? strtoupper(trim($_POST['primer_nombre'])) : NULL;
                        $segundo_nombre = isset($_POST['segundo_nombre']) ? strtoupper(trim($_POST['segundo_nombre'])) : NULL;
                        $primer_apellido = isset($_POST['primer_apellido']) ? strtoupper(trim($_POST['primer_apellido'])) : NULL;
                        $segundo_apellido = isset($_POST['segundo_apellido']) ? strtoupper(trim($_POST['segundo_apellido'])) : NULL;
                        $documento = isset($_POST['documento']) ? trim($_POST['documento']) : NULL;
                        $correo = isset($_POST['correo']) ? strtoupper(trim($_POST['correo'])) : NULL;
                        $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : NULL;

                        if (
                            Validar::numeros($id_usuario) && Validar::letras($primer_nombre) && Validar::letras($primer_apellido) && Validar::numeros($telefono)
                            && Validar::numeros($documento) && Validar::correo($correo)
                        ) {
                            require_once(rutaBase . 'php' . DS . 'model' . DS . 'model_usuarios.php');
                            echo ModelUsuarios::editarUsuario(
                                $id_usuario,
                                $primer_nombre,
                                $segundo_nombre,
                                $primer_apellido,
                                $segundo_apellido,
                                $documento,
                                $correo,
                                $telefono
                            );
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "asignarSubmodulo":
                        $id_usuario = isset($_POST['id_usuario']) ? trim($_POST['id_usuario']) : null;
                        $home = isset($_POST['selectHome']) ? trim($_POST['selectHome']) : NULL;
                        $submodulos = isset($_POST['selectSubModulos']) ? $_POST['selectSubModulos'] : [];

                        if (
                            validar::numeros($id_usuario) && validar::numeros($home) && validar::array_requerido($submodulos)
                        ) {
                            require_once(rutaBase . 'php/model/model_usuarios.php');

                            echo ModelUsuarios::asignarSubmodulo($id_usuario, $home, $submodulos);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "cargarAsignacion":
                        $id_usuario = isset($_POST['id_usuario']) ? trim($_POST['id_usuario']) : null;

                        if (
                            validar::numeros($id_usuario)
                        ) {
                            require_once(rutaBase . 'php/model/model_usuarios.php');
                            echo ModelUsuarios::cargarAsignacion($id_usuario);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "cargarPermisos":
                        $id_usuario = isset($_POST['id_usuario']) ? trim($_POST['id_usuario']) : null;

                        if (
                            validar::numeros($id_usuario)
                        ) {
                            require_once(rutaBase . 'php/model/model_usuarios.php');
                            echo ModelUsuarios::cargarPermisos($id_usuario);
                        } else {
                            $respuesta['status'] = "0";
                            echo json_encode($respuesta);
                        }
                        break;
                    case "asignarPermiso":
                        $id_usuario = isset($_POST['id_usuario']) ? trim($_POST['id_usuario']) : null;
                        $permisos = isset($_POST['selectPermisos']) ? $_POST['selectPermisos'] : [];

                        if (
                            validar::numeros($id_usuario) && validar::array_requerido($permisos)
                        ) {
                            require_once(rutaBase . 'php/model/model_usuarios.php');

                            echo ModelUsuarios::asignarPermiso($id_usuario, $permisos);
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
