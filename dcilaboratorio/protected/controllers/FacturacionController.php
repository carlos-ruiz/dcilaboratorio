<?php

class FacturacionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $section = "Facturacion";
	public $subSection;
	public $pageTitle="Facturacion";
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */

	public function actions()
    {
        return array(
            'quote'=>array(
                'class'=>'CWebServiceAction',
            ),
        );
    }

	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$answer=null;
		if(isset($_POST['xmlfile'])){
			$wsUser = 'VE223.test_ws';   //usuario de ws
			$wsPassword = 'Test-WS+092013';   //password de ws
			//
			///////////////////////////////////////////////////////////////////////////
			//lib
			//indicamos el archivo wspac.wsdl
	
			$client = new soapclient('C:\xampp\htdocs\techinc\dcilaboratorio\css/wspac.wsdl');
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
					return;
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
						return;
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
						return;
					}else {
						$params = array($token); /*token de sesion a cerrar*/
						$answer = $client->call('closeSession', $params );
						$err = $client->getError();
						if ($err) {
							//     Muestra error
							echo 'Error: ' . $err;
							print_r($client->response);
							print_r($client->getDebug());
							return;
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
						return;
					}else {
						$params = array($token); /*token de sesion a cerrar*/
						$answer = $client->call('closeSession', $params );
						$err = $client->getError();
						if ($err) {
							//     Muestra error
							echo 'Error: ' . $err;
							print_r($client->response);
							print_r($client->getDebug());
							return;
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
		}
		$this->render('index',array('respuesta'=>$answer));
	}

	public function timbrar(){
		///////////////////////////////////////////////////////////////////////////
		//Configuracion de usuario y password para generar el Timbre.
		///////////////////////////////////////////////////////////////////////////
		//

		$this->render('index');
	}




}
