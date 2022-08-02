<?php

class modellogin
{
	public static function login($usuario, $contrasenia)
	{
		require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');

		$conexion = new Conexion();
		$mysqli = $conexion->Conectar();

		$usuario = mysqli_real_escape_string($mysqli, $usuario);

		$sql = "SELECT
		id_usuario,
		CONCAT(primer_nombre,' ',primer_apellido) AS nombre,
		contraseña,
		id_estado,
		correo,
		foto,
		home
		FROM usuario
		WHERE correo = '$usuario' or documento = '$usuario';";

		$rtdo = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);

		if (mysqli_num_rows($rtdo) == 1) {
			require_once(rutaBase . 'php' . DS . 'libraries' . DS . 'sesion.php');
			require_once(rutaBase . 'php' . DS . 'libraries' . DS . 'utilidades.php');

			$data = mysqli_fetch_object($rtdo);

			$estado = $data->id_estado;
			if ($estado == 1) {
				$contraseniaBD = $data->contraseña;
				$verificarContrasenia = Utilidades::VerificarHash($contrasenia, $contraseniaBD);
				if ($verificarContrasenia) {

					$respuesta['status'] = "1";
					$idUsuario = $data->id_usuario;
					$respuesta['idUsuario'] = $idUsuario;
					$usuario = $data->nombre;
					$correo = $data->correo;
					$foto = $data->foto;
					$home = $data->home;
					$permisos =  self::PermisosUsuario($idUsuario);
					if ($permisos) {
						$datosSesion = array(
							'id' => $idUsuario,
							'usuario' => $usuario,
							'correo' => $correo,
							'permisos' => $permisos,
							'foto' => $foto,
							'timeout' => time(),
							'token' => "dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9",
						);
						Sesion::CrearSesion($datosSesion);

						$sql = "SELECT
						url
						FROM submodulos sw
						WHERE sw.id_submodulo = $home";
						$resultado = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);
						if (mysqli_num_rows($resultado) == 1) {
							$respuesta['url'] = mysqli_fetch_array($resultado)['url'];
						}
					}
				} else {
					$respuesta['status'] = "4"; //contraseña erronea
				}
			} else {
				$respuesta['status'] = "3"; // usuario no activo
			}
		} else {
			$respuesta['status'] = "2"; //usuario no existe
		}
		return json_encode($respuesta);
		mysqli_close($mysqli);
	}

	public static function PermisosUsuario($idUsuario)
	{
		//funcion para obtener los modulos y submodulos
		$conexion = new Conexion();
		$mysqli = $conexion->Conectar();

		$idUsuario = mysqli_real_escape_string($mysqli, $idUsuario);

		$arrayPermisos = array();

		$sqlpermisos = "SELECT 
		MW.descripcion as modulo,
		MW.icono as icono,
		group_concat(CONCAT(SMW.descripcion,'|JUAN|',SMW.url,'|JUAN|',SMW.submodulo) SEPARATOR '|SEPARATOR|') as submodulos
		from 
		usuarios_has_submodulos USW
		JOIN submodulos SMW ON SMW.id_submodulo  = USW.id_submodulo
		JOIN modulos MW ON MW.id_modulo = SMW.id_modulo 
		WHERE USW.id_usuario = $idUsuario
		group by MW.id_modulo,MW.icono
		order by USW.id_submodulo";

		$rtopermisos = mysqli_query($mysqli, $sqlpermisos) or die("Error en la Consulta SQL: " . $sqlpermisos);

		//submodulos
		if (mysqli_num_rows($rtopermisos) > 0) {
			while ($data_permisos = mysqli_fetch_array($rtopermisos)) {
				$modulo = $data_permisos['modulo'];
				$icono = $data_permisos['icono'];
				$submodulos = explode('|SEPARATOR|', $data_permisos['submodulos']);
				$arrayPermisos[] = array("modulo" => $modulo, "icono" => $icono, "submodulos" => $submodulos);
			}
		}

		if (count($arrayPermisos) > 0) {
			$permisos = $arrayPermisos;
		} else {
			$permisos = false;
		}
		//retorno los permisos encontrados
		return $permisos;
	}

	public static function 	Recuperar($correo)
	{
		require_once(rutaBase . 'php' . DS . 'libraries' . DS . 'fechas.php');
		require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
		require_once(rutaBase . 'php' . DS . 'model' . DS . 'model_correo.php');
		$conexion = new Conexion();
		$mysqli = $conexion->Conectar();

		$formatoFecha = new fechas();

		date_default_timezone_set('America/Bogota');
		$horaActual = date('H:i:s');
		$fechaActual = $formatoFecha->formato4(date('Y-m-d'));

		$correo = mysqli_real_escape_string($mysqli, $correo);

		$sql = "SELECT * FROM usuario WHERE correo = '$correo'";

		$rtdo = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);

		if (mysqli_num_rows($rtdo) == 1) {
			require_once(rutaBase . 'php' . DS . 'libraries' . DS . 'sesion.php');
			require_once(rutaBase . 'php' . DS . 'libraries' . DS . 'utilidades.php');

			$data = mysqli_fetch_array($rtdo);

			$estado = $data['id_estado'];
			$mensaje = "";

			if ($estado == 1) {
				$cadena = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 40);

				$sql = "UPDATE usuario SET recuperar =  '$cadena' WHERE correo = '$correo'";

				$rtdo = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);

				// Consultamos los datos de usuario del correo para enviar la recuperacion
				$arrayRemitentes[0]['correo'] = "pqrshs@gmail.com";
				$arrayRemitentes[0]['contrasenia'] = "shs12345";

				$arrayDestinatarios[] = $correo;

				$mensaje .= "<br>Ingrese al siguiente enlace para recuperar su contraseña - SHS: ";
				$mensaje .= " <a href='http://localhost/utitalco/recuperar.php?recuperar=" . $cadena . "'>Da Click Aqui!<a>";

				$asunto = "Recuperar contraseña - SHS";
				ModelCorreo::Enviar($arrayRemitentes, $arrayDestinatarios, $asunto, $mensaje);
				$respuesta['status'] = "1"; // recuperacion satisfactoria
			} else {
				$respuesta['status'] = "3"; // usuario no activo
			}
		} else {
			$respuesta['status'] = "2"; //usuario no existe
		}
		return json_encode($respuesta);
		mysqli_close($mysqli);
	}

	public static function UpdatePassword($password)
	{
		require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
		require_once(rutaBase . 'php' . DS . 'libraries' . DS . 'utilidades.php');
		require_once(rutaBase . 'php' . DS . 'libraries' . DS . 'sesion.php');

		$conexion = new Conexion();
		$mysqli = $conexion->Conectar();

		$usuario = Sesion::GetParametro('id');

		date_default_timezone_set('America/Bogota');
		$fechaHoraActual = date('Y-m-d H:i:s');

		$password = $mysqli->real_escape_string($password);
		$password = Utilidades::Hash($password);

		$sql = "UPDATE usuario 
        SET contraseña = '$password'
        WHERE id_usuario = $usuario;";

		$resultado = mysqli_query($mysqli, $sql) or die("Error en la Consulta SQL: " . $sql);

		if ($resultado) {
			$respuesta['status'] = "1";
		} else {
			$respuesta['status'] = "0";
		}

		mysqli_close($mysqli);
		return json_encode($respuesta);
	}
}
