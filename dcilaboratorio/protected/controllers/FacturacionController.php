<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'/../extensions/Facturacion/conf/nusoap.php');
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
				'actions'=>array('index','imprimirFactura'),
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
		$answer = null;
		$token = null;
		$cfdi = null;
		$fullAnswer = null;
		$msgError = null;
		if(isset($_POST['xmlfile'])){
			$wsUser = 'VE223.test_ws';   //usuario de ws
			$wsPassword = 'Test-WS+092013';   //password de ws
			//
			///////////////////////////////////////////////////////////////////////////
			//lib
			//indicamos el archivo wspac.wsdl

			$client = new soapclient('C:\xampp\htdocs\dcilaboratorio\dcilaboratorio\protected\extensions\Facturacion/php/wspac.wsdl', 'wsdl');
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
					$params = array('token' => $token, 'xml' => $xml); /*('token','xml')*/
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
						$fullAnswer = $answer;
						$ok = $answer['ok'];
						$errorCode = $answer['errorCode'];
						$cfdi = $answer['xml'];
						$uuid = $answer['uuid'];
						$msgError = 'ok';
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
		$this->render('index',array('respuestaCompleta'=>$fullAnswer, 'resultado'=>$msgError));
	}

	public function actionImprimirFactura($id){
		$model = Ordenes::model()->findByPk($id);
		$xml = null;
		$answer = null;
		$token = null;
		$cfdi = null;
		$fullAnswer = null;
		$msgError = null;
		$xml = $this->generarCFD($id);

		if(isset($xml)){
			$wsUser = 'VE223.test_ws';   //usuario de ws
			$wsPassword = 'Test-WS+092013';   //password de ws
			//
			///////////////////////////////////////////////////////////////////////////
			//lib
			//indicamos el archivo wspac.wsdl

			$client = new soapclient('C:\xampp\htdocs\dcilaboratorio\dcilaboratorio\protected\extensions\Facturacion/php/wspac.wsdl', 'wsdl');
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
					// $xml = $_POST["xmlfile"];
					//
					$params = array('token' => $token, 'xml' => $xml); /*('token','xml')*/
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
						$fullAnswer = $answer;
						$ok = $answer['ok'];
						$errorCode = $answer['errorCode'];
						$cfdi = $answer['xml'];
						$uuid = $answer['uuid'];
						$msgError = 'ok';
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
		if ($fullAnswer['ok']) {
			// print_r($fullAnswer);
			// return;
			$pdf = new ImprimirFactura('P','cm','letter');
			$pdf->AddPage();
			$pdf->cabeceraHorizontal($model, $fullAnswer);
			$pdf->contenido($model, $fullAnswer);
			$pdf->Output();
		}
	}

	public function generarCFD($id){
		$orden = Ordenes::model()->findByPk($id);

		$fecha_actual = substr( date('c'), 0, 19);
		$regimenFiscal = 'RÉGIMEN SIMPLIFICADO';
		$rfc_emisor = 'AAQM610917QJA';
		$lugarExpedicion = 'MORELIA, MICHOACÁN';
		$formaDePago = 'PAGO EN UNA SOLA EXHIBICIÓN';
		$modoDePago = 'EFECTIVO';
		$subTotal = 0;
		$tipoDeComprobante = 'INGRESO';
		$total = 0;

		//DATOS DEL EMISOR
		$nombreEmisor = 'EMPRESA DE PRUEBAS';
		$rfcEmisor = 'AAQM610917QJA';
		$calleEmisor = 'JUAN PABLO II';
		$codigoPostalEmisor="94294";
		$coloniaEmisor='FRACC. REFORMA';
		$estadoEmisor='VERACRUZ';
		$municipioEmisor='BOCA DEL RIO';
		$noExteriorEmisor='258';
		$paisEmisor='MEXICO';

		//DATOS DEL RECEPTOR
		$nombreReceptor = 'CARLOS ALFREDO RUIZ CALDERON';
		$rfcReceptor = 'RUCC900925123';
		$calleReceptor = 'JUAN PABLO II';
		$codigoPostalReceptor="94294";
		$coloniaReceptor='FRACC. REFORMA';
		$estadoReceptor='VERACRUZ';
		$localidadReceptor = 'HUANIYORK';
		$municipioReceptor='BOCA DEL RIO';
		$noExteriorReceptor='258';
		$paisReceptor='MEXICO';

$cfdi = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<cfdi:Comprobante LugarExpedicion="BOCA DEL RIO, VERACRUZ" certificado="MIIELTCCAxWgAwIBAgIUMjAwMDEwMDAwMDAyMDAwMDAxNzkwDQYJKoZIhvcNAQEFBQAwggFcMRowGAYDVQQDDBFBLkMuIDIgZGUgcHJ1ZWJhczEvMC0GA1UECgwmU2VydmljaW8gZGUgQWRtaW5pc3RyYWNpw7NuIFRyaWJ1dGFyaWExODA2BgNVBAsML0FkbWluaXN0cmFjacOzbiBkZSBTZWd1cmlkYWQgZGUgbGEgSW5mb3JtYWNpw7NuMSkwJwYJKoZIhvcNAQkBFhphc2lzbmV0QHBydWViYXMuc2F0LmdvYi5teDEmMCQGA1UECQwdQXYuIEhpZGFsZ28gNzcsIENvbC4gR3VlcnJlcm8xDjAMBgNVBBEMBTA2MzAwMQswCQYDVQQGEwJNWDEZMBcGA1UECAwQRGlzdHJpdG8gRmVkZXJhbDESMBAGA1UEBwwJQ295b2Fjw6FuMTQwMgYJKoZIhvcNAQkCDCVSZXNwb25zYWJsZTogQXJhY2VsaSBHYW5kYXJhIEJhdXRpc3RhMB4XDTEyMTAyMjIwMDcwMloXDTE2MTAyMjIwMDcwMlowgacxHjAcBgNVBAMTFU1BUlRJTiBBUkJBSVpBIFFVSVJPWjEeMBwGA1UEKRMVTUFSVElOIEFSQkFJWkEgUVVJUk9aMR4wHAYDVQQKExVNQVJUSU4gQVJCQUlaQSBRVUlST1oxFjAUBgNVBC0TDUFBUU02MTA5MTdRSkExGzAZBgNVBAUTEkFBUU02MTA5MTdNREZSTk4wOTEQMA4GA1UECxMHTU9SRUxJQTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAuf5O30micrZtUGDgHlfQBPF9lyutJQJckUuMp+qpBZYYIpPTG2HlSWUgTnvWXpOajDTXF2pAJA2m1Y/lAIlyvVu6I6DwaVKm7n8mPCFVNnun0U5drlk5Xmu4cAG/OfF/KSgT8+u1R1auu1DPm1vUqzdRxP7mnmY9Y0eEc+qalfcCAwEAAaMdMBswDAYDVR0TAQH/BAIwADALBgNVHQ8EBAMCBsAwDQYJKoZIhvcNAQEFBQADggEBAGdO8y+w0XytPTU2j/2WwJ4nQEtuw3GF09ZUFrVfHeyvTY9oaPL9uRnJ1PcCJd/d/GaXiCSUj1zzcycw/lu1OY/bMlwl9sM9/EfYasCUTOtApZL1+e4fr5tWKS3T4ZXjsXWafd8qu6kA7/sNwEgqpgKQguKQPSogTIYsPTTlqwDWYoEBoliKZU195Nl5t+YIcOfwm0RBCrqkGLlk5IO7Pq0FANHONBcFg5vQM5d/MDSYpwMXGXVuxaK6jIutsvwg6tyayVwl5LO9H1v2TIRZw9BRYTgTMLbxPjKx1Cgf5n8VgUj40oGoDBLOeyYDr/341gC+bXfqgTfbR2ESupooN04=" fecha="2015-07-19T09:18:23" formaDePago="PAGO EN UNA SOLA EXHIBICION" metodoDePago="EFECTIVO" noCertificado="20001000000200000179" sello="PjV68LHu22EJXUNrGXb+vcqieBTwaNAPtBqWgCLVTnpXDvNeww7BeQYtJfH74zxhw+E0okSsyMqB5GUQAiFxcvb0VTGDouBtruZ+QwW5hN5uHR0EM3UlSpsVMQstnVSe/npZ8vBvI1NorzuymwSOT4vmHE3ai/pugcWKoczL894=" subTotal="1480.00" tipoDeComprobante="ingreso" total="1716.80" version="3.2" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd"><cfdi:Emisor nombre="EMPRESA AAQM610917QJA" rfc="AAQM610917QJA"><cfdi:DomicilioFiscal calle="JUAN PABLO II" codigoPostal="94294" colonia="FRACC. REFORMA" estado="VERACRUZ" municipio="BOCA DEL RIO" noExterior="258" pais="MEXICO"/><cfdi:RegimenFiscal Regimen="Regimen Simplificado"/></cfdi:Emisor><cfdi:Receptor nombre="EMPRESA CHO1006237R4" rfc="CHO1006237R4"><cfdi:Domicilio calle="EJERCITO MEXICANO" codigoPostal="91900" colonia="CARRANZA" estado="VERACRUZ" localidad="BOCA DEL RIO" municipio="BOCA DEL RIO" noExterior="234" pais="MEXICO"/></cfdi:Receptor><cfdi:Conceptos><cfdi:Concepto cantidad="10.0" descripcion="MOCHILA" importe="1500.00" noIdentificacion="PROD04" unidad="MENSAJE" valorUnitario="2150.50"/><cfdi:Concepto cantidad="25.0" descripcion="TICKET" importe="1850.00" noIdentificacion="PROD05" unidad="PKG" valorUnitario="3000.00"/><cfdi:Concepto cantidad="15.0" descripcion="SILLA" importe="154.51" noIdentificacion="PROD01" unidad="MENSAJE" valorUnitario="225.20"/></cfdi:Conceptos><cfdi:Impuestos><cfdi:Traslados><cfdi:Traslado importe="1500.00" impuesto="IVA" tasa="16.00"/><cfdi:Traslado importe="1850.00" impuesto="IVA" tasa="16.00"/><cfdi:Traslado importe="154.51" impuesto="IVA" tasa="16.00"/></cfdi:Traslados></cfdi:Impuestos></cfdi:Comprobante>
XML;

		return $cfdi;
	}
}
