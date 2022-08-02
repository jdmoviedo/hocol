<?php

/**
 * clase para conectar con api icosalud
 */
class model_peticion
{
	public static function enviarPeticion($arrayDatos)
	{
        require_once(rutaBase . 'php' . DS . 'conexion' . DS . 'conexion.php');
        $conexion = new Conexion();
        $mysqli = $conexion->Conectar();

        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');

		$sql = "SELECT
        url_conexion_principal,
        url_conexion_secundaria,
        llave
        FROM peticiones_api
        WHERE id_peticiones_api = 1;";
        // echo $sql;exit;
        $rtdo = mysqli_query($mysqli, $sql);
        if( mysqli_num_rows($rtdo) == 1 ){
            $data = mysqli_fetch_object($rtdo);
            
            $banderaLlamada = 0;
            $url = $data->url_conexion_principal;
            while ($banderaLlamada < 2) {
                $urlCompleta = $url.'api/icoweb/';
    
                $arrayjson = json_encode($arrayDatos, 5000);
    
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $urlCompleta);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 1500); // si falla usar la siguiente linea
                // curl_setopt($ch, 156, 1500); // por si el anterior da error
                curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayjson);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //no verificar certificado ssl
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                //no verificar nombre de dominio asociado al hosting
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: '.strlen($arrayjson),
                    'llave: '.$data->llave
                ));
                //ejecutamos la peticion al server externo
                $rtaPeticion = curl_exec($ch);
                $rtaPeticionDecode = json_decode($rtaPeticion);
                //o el error, por si falla
                $errorPeticion = curl_error($ch);
                curl_close($ch);
    
                // print_r($rtaPeticion);exit;
                // $statusResponse = $errorPeticion;
                if ( is_object($rtaPeticionDecode) && isset($rtaPeticionDecode->status) ) {
                    $response['response'] = $rtaPeticionDecode;
                    //establezco la bandera en 2 para salir del while
                    $banderaLlamada = 2;
                } else {
                    $url = $data->url_conexion_secundaria;
                    $response['response'] = '505';
                    //incremento la llamada para hacer otro intento
                    $banderaLlamada++;
                }
            }
        }else{
            $response['response'] = '404';
        }

		return json_encode($response);
	}
}
