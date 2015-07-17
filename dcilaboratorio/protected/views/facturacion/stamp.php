<?php
	///////////////////////////////////////////////////////////////////////////
	//Configuracion de usuario y password para generar el Timbre.
	///////////////////////////////////////////////////////////////////////////
	//
	$wsUser = 'VE223.test_ws';   //usuario de ws
	$wsPassword = 'Test-WS+092013';   //password de ws
	//
	///////////////////////////////////////////////////////////////////////////
	//lib
	require_once('C:\xampp\htdocs\dcilaboratorio\dcilaboratorio\protected\extensions\Facturacion\conf/nusoap.php');
	//indicamos el archivo wspac.wsdl
	$client = new soapclient('wspac.wsdl', 'wsdl');
	//
	$err = $client->getError();
	if ($err) {
	//   Muestra error
		echo 'Error al construir el cliente: ' . $err ;
	}else {
		$params = array($wsUser,$wsPassword); /*('usuario','contrasena')*/
		$answer = $client->call('openSession', $params );
		$err = $client->getError();
		if ($err) {
			//     Muestra error
			echo 'Error: ' . $err;
			print_r($client->response);
			print_r($client->getDebug());
		} else {
			//     Respuesta ws
			$token = $answer['token'];
			$errorCode = $answer['errorCode'];
			$ok = $answer['ok'];
		}
	}
	if (($ok == true) && ($errorCode == 0)){
		$err = $client->getError();
		if ($err) {
			//   Muestra error
			echo 'Error al construir el cliente: ' . $err ;
		}else {
			//   token para inicio de sesion
			$token = $token;
			// xml a Timbrar
			$xml = $_POST["xmlfile"];
			//
			$params = array(token => $token, xml => $xml); /*('token','xml')*/
			$answer = $client->call('createCFDI', array($params) );
			//
			$err = $client->getError();
			//
			if ($err) {
				//     Muestra error
				echo 'Error: ' . $err;
				print_r($client->response);
				print_r($client->getDebug());
			} else {
				//     Respuesta ws
				$ok = $answer['ok'];
				$errorCode = $answer['errorCode'];
				$cfdi = $answer['xml'];
				$uuid = $answer['uuid'];
				$msgError = 'cfdi';
			}
		}
		//
		if (($ok == true) && ($errorCode == 0)){
			$err = $client->getError();
			if ($err) {
				//   Muestra error
				echo 'Error al construir el cliente: ' . $err ;
			}else {
				$params = array($token); /*token de sesion a cerrar*/
				$answer = $client->call('closeSession', $params );
				$err = $client->getError();
				if ($err) {
					//     Muestra error
					echo 'Error: ' . $err;
					print_r($client->response);
					print_r($client->getDebug());
				} else {
					//     Respuesta ws
					$ok = $answer['ok'];
					$errorCode = $answer['errorCode'];
				}
			}
		} else{
			$err = $client->getError();
			if ($err) {
				//   Muestra error
				echo 'Error al construir el cliente: ' . $err ;
			}else {
				$params = array($token); /*token de sesion a cerrar*/
				$answer = $client->call('closeSession', $params );
				$err = $client->getError();
				if ($err) {
					//     Muestra error
					echo 'Error: ' . $err;
					print_r($client->response);
					print_r($client->getDebug());
				} else {
					//     Respuesta ws
					$msgError = '';
				}
			}
			$msgError = 'Codigo de error = '.$errorCode;
		}
	//Error al iniciar sesion
	} else{
		$msgError = $token;
	}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>KIT DESARROLLO - 4G FACTOR</title>
	</head>
	<body>
		<center>
			<br><br><br><br>
			<label><font color="BLUE" size="+3"><b>XML TIMBRADO</b></font></label><br>
			<textarea name="cfdi" cols="100" rows="20">
 			<?php if ($_POST["action"] == "upload"){
				if ($msgError == 'cfdi'){
					printf($cfdi);
					printf('<input type="text" name="nombre" value="'.$uuid.'" />');
				} else{
					printf($msgError);
				}
			} ?>
			</textarea>
			<br><br><br><br>


 			<?php if ($_POST["action"] == "upload"){
				if ($msgError == 'cfdi'){
					printf('<b>UUID</b><br> <input type="text" size="38" name="nombre" value="'.$uuid.'" readonly=yes />');
					printf('<br><br><a href="javascript:history.back()"> Volver Atrás</a> ');
				} else{
					printf($msgError);
					printf('<br><br><a href="javascript:history.back()"> Volver Atrás</a> ');
				}
			} ?>

			<br><br><br><br>

			<b><font color="BLUE" size="-1">4G Factor, S.A. de C.V.</font></b>
		</center>
	</body>
</html>