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
	public $pageTitle="Facturación";
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
				'actions'=>array('index', 'create', 'admin', 'generarFactura', 'agregarConcepto'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionCreate()
	{
		$this->generarCFD(1);
		return;
		$this->subSection = "Nuevo";
		$model = new FacturacionForm;
		$conceptosConError = null;
		$conceptos = array();

		if(isset($_POST['FacturacionForm']))
		{
			$model->attributes=$_POST['FacturacionForm'];
			$conceptos = array();
			if(isset($_POST['conceptos'])){
				foreach ($_POST['conceptos'] as $key => $value) {
					$concepto = new ConceptoForm;
					$concepto->id = $key;
					$concepto->clave = $_POST["clave_$value"];
					$concepto->concepto = $_POST["concepto_$value"];
					$concepto->precio = $_POST["precio_$value"];
					if (!$concepto->validate()) {
						$conceptosConError = '';
						foreach ($concepto->getErrors() as $value) {
							$conceptosConError = $value[0].'<br>';
						}
					}
					array_push($conceptos, $concepto);
				}
				$model->conceptos = $conceptos;
			}
			else{
				$conceptosConError = "No es posible generar una factura sin conceptos";
			}
			if($model->validate() && $conceptosConError == null){
				$mensaje="Listo para imprimir la factura correspondiente";
				$titulo="Aviso";
			}
			// $model->attributes=$_POST['Examenes'];
			// if($model->save())
			// 	$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('_form', array(
			'model' => $model,
			'conceptos' => $conceptos,
			'conceptosConError' => $conceptosConError,
			));
		$this->renderPartial('/comunes/mensaje',array('mensaje'=>isset($mensaje)?$mensaje:"",'titulo'=>isset($titulo)?$titulo:""));
	}

	public function actionAdmin(){
		$this->subSection = "Admin";
		$model=new Ordenes('searchRequiereFactura');

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordenes']))
			$model->attributes=$_GET['Ordenes'];

		$this->render('admin',array(
			'model'=>$model,
			'filtroFactura'=>1,
			));
	}

	public function actionGenerarFactura($id){
		$this->subSection = "Nuevo";
		$orden = Ordenes::model()->findByPk($id);
		$model = new FacturacionForm;
		$conceptosConError = null;
		if($orden == null){
			$conceptos = new ConceptoForm;
		}
		else{
			if ($orden->requiere_factura == 1) {
				$model->razon_social = $orden->ordenFacturacion->datosFacturacion->razon_social;
				$model->rfc = $orden->ordenFacturacion->datosFacturacion->RFC;
				$model->calle = $orden->ordenFacturacion->datosFacturacion->direccion->calle;
				$model->numero = $orden->ordenFacturacion->datosFacturacion->direccion->numero_ext;
				$model->colonia = $orden->ordenFacturacion->datosFacturacion->direccion->colonia;
				$model->codigo_postal = $orden->ordenFacturacion->datosFacturacion->direccion->codigo_postal;
				$model->localidad = $orden->ordenFacturacion->datosFacturacion->direccion->municipio->nombre;
				$model->municipio = $orden->ordenFacturacion->datosFacturacion->direccion->municipio->nombre;
				$model->estado = $orden->ordenFacturacion->datosFacturacion->direccion->estado->nombre;
				$model->fecha = $orden->fecha_captura;
			}
			$model->descuento = $orden->descuento;
			$model->costo_extra = $orden->costo_emergencia;
			$conceptos = array();
			$idExamen = 0;
			foreach ($orden->ordenTieneExamenes as $index => $ordenExamen) {
				$examen = $ordenExamen->detalleExamen->examenes;
            	if($examen->id!=$idExamen){
					$concepto = new ConceptoForm;
					$concepto->id = $index;
					$concepto->clave = $examen->clave;
					$concepto->concepto = $examen->nombre;
					$precio = OrdenPrecioExamen::model()->findByAttributes(array('id_ordenes'=>$orden->id, 'id_examenes'=>$examen->id));
					$concepto->precio = $precio->precio;
					array_push($conceptos, $concepto);
				}
				$idExamen = $examen->id;
			}
			$model->conceptos = $conceptos;
		}

		if(isset($_POST['FacturacionForm']))
		{
			$model->attributes=$_POST['FacturacionForm'];
			$conceptos = array();
			if (isset($_POST['conceptos'])) {
				foreach ($_POST['conceptos'] as $key => $value) {
					$concepto = new ConceptoForm;
					$concepto->id = $key;
					$concepto->clave = $_POST["clave_$value"];
					$concepto->concepto = $_POST["concepto_$value"];
					$concepto->precio = $_POST["precio_$value"];
					if (!$concepto->validate()) {
						$conceptosConError = '';
						foreach ($concepto->getErrors() as $value) {
							$conceptosConError = $value[0].'<br>';
						}
					}
					array_push($conceptos, $concepto);
				}
				$model->conceptos = $conceptos;
			}else{
				$conceptosConError = "No es posible generar una factura sin conceptos";
				$mensaje="No es posible generar una factura sin conceptos";
				$titulo="Error";
			}
			if($model->validate() && $conceptosConError == null){
				$result = $this->imprimirFactura($model);
				if (isset($result['titulo']) && isset($result['mensaje'])) {
					$titulo = $result['titulo'];
					$mensaje = $result['mensaje'];
				}
			}
		}

		$this->render('_form', array(
			'model' => $model,
			'conceptos' => $conceptos,
			'conceptosConError' => $conceptosConError,
			));
		$this->renderPartial('/comunes/mensaje',array('mensaje'=>isset($mensaje)?$mensaje:"",'titulo'=>isset($titulo)?$titulo:""));
	}

	public function imprimirFactura($facturacionModel){
		$fullAnswer = $this->conectarConWS();
		if ($fullAnswer['errorCode'] != 0) {
			$mensaje="";

			switch ($fullAnswer['errorCode']) {
				case '5102':
					$mensaje ='Caracteres inválidos en campo token (fuera del rango UTF8)';
					break;

				case '5103':
					$mensaje = 'Caracteres inválidos en campo xml (fuera del rango UTF8)';
					break;

				case '5201':
					$mensaje = 'Token de sesión inválido';
					break;

				case '5300':
					$mensaje = 'No más timbres disponibles';
					break;

				case '5400':
					$mensaje = 'RFC de CFD no autorizado para timbrar';
					break;

				case '301':
					$mensaje = 'Error en la estructura del XML con respecto al ANEXO 20 de la Resolución Miscelánea Fiscal 2010';
					break;

				case '302':
					$mensaje = 'Sello mal formado o inválido';
					break;

				case '303':
					$mensaje = 'Sello de firma no corresponde a CSD del emisor';
					break;

				case '304':
					$mensaje = 'CSD del contribuyente vencido o inválido';
					break;

				case '305':
					$mensaje = 'La fecha de emisión no esta dentro de la vigencia del CSD del Emisor';
					break;

				case '306':
					$mensaje = 'El certificado no es de tipo CSD';
					break;

				case '307':
					$mensaje = 'El CFDI contiene un timbre previo';
					break;

				case '308':
					$mensaje = 'Certificado no expedido por el SAT';
					break;

				case '401':
					$mensaje = 'CFD fuera de fecha (emitido hace más de 72 horas)';
					break;

				case '402':
					$mensaje = 'RFC del emisor no se encuentra en el régimen de contribuyentes';
					break;

				case '403':
					$mensaje = 'La fecha de emisión no es posterior al 01 de enero 2012';
					break;

				case '404':
					$mensaje = 'La fecha de emisión está en el futuro';
					break;
			}

			$titulo="Error al generar factura";
			return array('titulo'=>$titulo, 'mensaje'=>$mensaje);
		}

		$pdf = new ImprimirFactura('P','cm','letter');
		$pdf->AddPage();
		$pdf->cabeceraHorizontal($facturacionModel, $fullAnswer);
		$pdf->contenido($facturacionModel, $fullAnswer);
		$pdf->Output();
	}

	# Función para sellar la cadena original
	public function selloCFD($stringResult,$pemPath){
		#cargar archivo pem
		$sat_key = fopen(sprintf('%s', strval($pemPath)),'r');
		$sat_key = fread($sat_key, filesize($pemPath));
		$pkeyid = openssl_get_privatekey($priv_key);
		echo $pkeyid;
		if (openssl_open($sealed, $open, $env_key, $pkeyid)) {
			echo "aquí está la información abierta: ", $open;
		} else {
			echo "fallo al abrir la información";
		}
		// $key=EVP.load_key_string(sat_key)
		// $key=openssl_get_privatekey();
		// #sha1
		// key.reset_context(md='sha1')
		// key.sign_init()
		// #pongo la cadena
		// key.sign_update(stringResult)
		// signature=key.sign_final()
		// #regreso el selloDigital en base64
		// return base64.b64encode(signature)
	}

	public function generarCFD($id){
		$xslt = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/xslt/cadenaoriginal_3_2.xslt';
		$xsltXmlOut = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/xml/xsltXmlOut.xml';
		$cerFile = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/cert_key/AAQM610917QJA.cer';
		$cerOutFile = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/cert_key/AAQM610917QJAOut.txt';
		$keyPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/cert_key/AAQM610917QJA_s.key';
		$keyPwd = '12345678a';
		$pemPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/tmp/AAQM610917QJA_key.pem';
		$pemCert = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/tmp/AAQM610917QJA_cer.pem';
		$xmlPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/cfd.xml';
		$xmlResultPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/xml/cfdi.xml';

		# Valida contraseña de llave y genera el formato PEM
		$errorCode = $this->validateKeyPass($keyPath,$keyPwd,$pemPath);
		# Obtén número de certificado
		$NO_CERTIFICADO = $this->getSerial($cerFile);
		
		# Obtén certificado en PEM para insertar en CFD
		$CERTIFICADO =  $this->certificadoF($cerFile, $cerOutFile);
		# Obtén rfc a partir del certificado
		$RFC_EMISOR = $this->getRFC($cerFile);
		# Fecha y hora actuales
		$datetime = new DateTime();
		$datetime = $datetime->format(DateTime::ISO8601);
		$FECHA = substr($datetime, 0, 19);

		if ($errorCode == 0){
			# Determina sistema operativo
			$os = PHP_OS;
			# Lee XML de CFD base
			$cfd_xml_handler = fopen($xmlPath,'r');
			$cfd_xml = fread($cfd_xml_handler, filesize($xmlPath));
			fclose($cfd_xml_handler);

			# Establece datos de emisor
			$cfd_xml = str_replace('@CERTIFICADO',$CERTIFICADO,$cfd_xml);
			$cfd_xml = str_replace('@NO_CERTIFICADO',$NO_CERTIFICADO,$cfd_xml);
			$cfd_xml = str_replace('@RFC_EMISOR',$RFC_EMISOR,$cfd_xml);
			# Establece fecha de CFD
			$cfd_xml = str_replace('@FECHA',$FECHA,$cfd_xml);
			# Establece RFC de receptor aleatoriamente
			$cfd_xml = str_replace('@RFC_RECEPTOR','RUCC9009253A6', $cfd_xml);

			# Elimina saltods de línea
			$cfd_xml = preg_replace('/\n\r/',' ',$cfd_xml);
			$cfd_xml = preg_replace('/\r\n/',' ',$cfd_xml);
			$cfd_xml = preg_replace('/\n/',' ',$cfd_xml);
			$cfd_xml = preg_replace('/\r/',' ',$cfd_xml);
			$cfd_xml = str_replace('> <','><',$cfd_xml);

			# Guarda XML
			$xmlResult = fopen($xmlResultPath,'w');
			fwrite($xmlResult,$cfd_xml);
			fclose($xmlResult);

			# Obtén cadena original
			//if (strpos($os,'WIN') !== false) {
			 	# Windows
			// 	$command = 'msxsl.exe %s %s -o %s';
			// 	$command = sprintf($command, $xmlResultPath, $xslt, $xsltXmlOut);
			// 	echo $command ."<br />";
			// 	$string_result_handler = popen($command, 'r');
			// 	$stringResult = fread($string_result_handler, filesize($xslt));
			// 	fclose($string_result_handler);
			//}
			// else{
			// 	# Unix like
			// 	$command = 'xsltproc %s %s -o %s 2>/dev/null';
			// 	$command = sprintf($command, $xslt, $xmlResultPath, $xsltXmlOut);
			// 	echo $command;
			// 	$stringResult_handler = popen($command, 'r');
			// 	$stringResult = fread($stringResult_handler, filesize($xsltXmlOut));
			// 	fclose($stringResult_handler);
			// }
			$xsltDoc = new DOMDocument();
	        $xsltDoc->load($xslt);
	        $xmlDoc = new DOMDocument();
	        $xmlDoc->load($xmlResultPath);
	        $proc = new XSLTProcessor();
	        $proc->importStylesheet($xsltDoc);
	        $datos = $proc->transformToXML($xmlDoc);

			echo $datos;
			// var_dump($stringResult);
			
			# Crea sello
			$SELLO = $this->selloCFD($datos,$pemPath);
			// # Incluye sello
			// $cfd_xml = cfd_xml.replace('@SELLO',SELLO)
			// # Guarda XML con sello
			// open('%s' % xmlResult,'w').write('%s' % cfd_xml)
		}
	}

	public function validateKeyPass($keyPath, $keyPwd, $pemPath){
		$os = PHP_OS;
		if (strpos($os,'WIN') !== false) {
			$command = 'set OPENSSL_CONF=C:\\OpenSSL-Win32\\bin\\openssl.cfg && C:\\OpenSSL-Win32\\bin\\openssl.exe';
		}
		else if (strpos($os,'Linux') !== false) {
			$command = 'openssl';
		}

		$command .= ' pkcs8 -inform der -in "%s" -passin pass:%s -out "%s"';
		$command = sprintf($command, strval($keyPath),strval($keyPwd),strval($pemPath));
		$f = popen(strval($command), 'r');

		try{
			$f = fopen($pemPath,'r');
			$key = fread($f, filesize($pemPath));
			fclose($f);
		}
		catch(Exception $ex){
			$key = '';
		}
		if ($key != ''){
			$errorCode = 0;
		}
		else{
			$errorCode = 0;
		}
		return $errorCode;
	}

	public function getSerial($cerFile){
		$os = PHP_OS;
		if (strpos($os,'WIN') !== false) {
			$command = 'set OPENSSL_CONF=C:\\OpenSSL-Win32\\bin\\openssl.cfg && C:\\OpenSSL-Win32\\bin\\openssl.exe';
		}
		else if (strpos($os,'Linux') !== false) {
			$command = 'openssl';
		}

		$command .= ' x509 -inform DER -in "%s" -noout -serial';
		$command = sprintf($command, $cerFile);
		$f = popen($command, 'r');
		$num_cert = fread($f, filesize($cerFile));
		fclose($f);
		$num_cert = split("=", $num_cert);
		$num_cert = str_replace('\n','',$num_cert[1]);
		$num_cert = str_replace('\r','',$num_cert);
		$num_cert = trim($num_cert);
		$num_cert = pack("H*", $num_cert);
		return $num_cert;
	}

	# Función para obtener el certificado en formato PEM para insertarlo en el CFD
	public function certificadoF($cerFile, $outFile){
		$os = PHP_OS;
		if (strpos($os,'WIN') !== false) {
			$command = 'set OPENSSL_CONF=C:\\OpenSSL-Win32\\bin\\openssl.cfg && C:\\OpenSSL-Win32\\bin\\openssl.exe';
		}
		else if (strpos($os,'Linux') !== false) {
			$command = 'openssl';
		}

		$command .= ' x509 -inform DER -outform PEM -in "%s" -out "%s"';
		$command = sprintf($command, $cerFile, $outFile);
		$codificacion_handler = popen($command, 'r');
		$codificacion_handler = fopen($outFile, 'r');
		$codificacion = fread($codificacion_handler, filesize($outFile));
		fclose($codificacion_handler);
		$codificacion = str_replace('-----BEGIN CERTIFICATE-----','',$codificacion);
		$codificacion = str_replace('-----END CERTIFICATE-----','',$codificacion);
		// $codificacion = str_replace('\n\r','',$codificacion);
		// $codificacion = str_replace('\r\n','',$codificacion);
		// $codificacion = str_replace('\n','**1',$codificacion);
		// $codificacion = str_replace('\r','**2',$codificacion);
		$codificacion = preg_replace('/\s/','',$codificacion);
		$codificacion = trim($codificacion);
		return $codificacion;
	}

	# Función para obtener el RFC a partir del certificado
	public function getRFC($cerFile){
		$os = PHP_OS;
		if (strpos($os,'WIN') !== false) {
			$command = 'set OPENSSL_CONF=C:\\OpenSSL-Win32\\bin\\openssl.cfg && C:\\OpenSSL-Win32\\bin\\openssl.exe';
		}
		else if (strpos($os,'Linux') !== false) {
			$command = 'openssl';
		}
		$command .= ' x509 -inform DER -in "%s" -noout -subject -nameopt RFC2253';
		$command = sprintf($command, $cerFile);
		$f = popen($command, 'r');
		$subject = fread($f, filesize($cerFile));
		fclose($f);
		$subject = str_replace('\n','', $subject);
		$subject = str_replace('\r','', $subject);
		$subject = split(',', $subject);
		$rfc = $subject[2];
		$rfc = split('=', $rfc);
		$rfc = split(' /', $rfc[1]);
		$rfc = $rfc[0];
		return $rfc;
	}

	public function obtenerPaciente($data, $row){
		$paciente = $data->ordenFacturacion->paciente;
		$completo = $paciente->obtenerNombreCompleto();
		return $completo;
	}

	public function datosFacturacionCliente($data, $row){
		$datosFacturacion = $data->ordenFacturacion->datosFacturacion;
		$datos = $datosFacturacion->razon_social.' - '.$datosFacturacion->RFC;
		return $datos;
	}

	public function actionAgregarConcepto(){
		$numeroConcepto = $_POST['id'];
		echo "
		<tr class='row_$numeroConcepto' data-id='$numeroConcepto'>
			<td>
				<input type='hidden' name='conceptos[$numeroConcepto]' value='$numeroConcepto' />
				<input type='text' class='form-control' id='clave_$numeroConcepto' name='clave_$numeroConcepto' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;'/>
			</td>
			<td>
				<input type='text' class='form-control' id='concepto_$numeroConcepto' name='concepto_$numeroConcepto' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />
			</td>
			<td class='precioConcepto'>
				<input type='text' class='form-control' id='precio_$numeroConcepto' name='precio_$numeroConcepto' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />
			</td>
			<td>
				<a href='javascript:void(0)' data-id='$numeroConcepto' class='eliminarConcepto'><span class='fa fa-trash'></span></a>
			</td>
		</tr>";
	}

	public function conectarConWS(){
		$url = 'http://www.bpimorelia.com/wstech/api.php';
		$data = array('xmlfile' => '<?xml version="1.0" encoding="UTF-8"?><cfdi:Comprobante LugarExpedicion="BOCA DEL RIO, VERACRUZ" certificado="MIIELTCCAxWgAwIBAgIUMjAwMDEwMDAwMDAyMDAwMDAxNzkwDQYJKoZIhvcNAQEFBQAwggFcMRowGAYDVQQDDBFBLkMuIDIgZGUgcHJ1ZWJhczEvMC0GA1UECgwmU2VydmljaW8gZGUgQWRtaW5pc3RyYWNpw7NuIFRyaWJ1dGFyaWExODA2BgNVBAsML0FkbWluaXN0cmFjacOzbiBkZSBTZWd1cmlkYWQgZGUgbGEgSW5mb3JtYWNpw7NuMSkwJwYJKoZIhvcNAQkBFhphc2lzbmV0QHBydWViYXMuc2F0LmdvYi5teDEmMCQGA1UECQwdQXYuIEhpZGFsZ28gNzcsIENvbC4gR3VlcnJlcm8xDjAMBgNVBBEMBTA2MzAwMQswCQYDVQQGEwJNWDEZMBcGA1UECAwQRGlzdHJpdG8gRmVkZXJhbDESMBAGA1UEBwwJQ295b2Fjw6FuMTQwMgYJKoZIhvcNAQkCDCVSZXNwb25zYWJsZTogQXJhY2VsaSBHYW5kYXJhIEJhdXRpc3RhMB4XDTEyMTAyMjIwMDcwMloXDTE2MTAyMjIwMDcwMlowgacxHjAcBgNVBAMTFU1BUlRJTiBBUkJBSVpBIFFVSVJPWjEeMBwGA1UEKRMVTUFSVElOIEFSQkFJWkEgUVVJUk9aMR4wHAYDVQQKExVNQVJUSU4gQVJCQUlaQSBRVUlST1oxFjAUBgNVBC0TDUFBUU02MTA5MTdRSkExGzAZBgNVBAUTEkFBUU02MTA5MTdNREZSTk4wOTEQMA4GA1UECxMHTU9SRUxJQTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAuf5O30micrZtUGDgHlfQBPF9lyutJQJckUuMp+qpBZYYIpPTG2HlSWUgTnvWXpOajDTXF2pAJA2m1Y/lAIlyvVu6I6DwaVKm7n8mPCFVNnun0U5drlk5Xmu4cAG/OfF/KSgT8+u1R1auu1DPm1vUqzdRxP7mnmY9Y0eEc+qalfcCAwEAAaMdMBswDAYDVR0TAQH/BAIwADALBgNVHQ8EBAMCBsAwDQYJKoZIhvcNAQEFBQADggEBAGdO8y+w0XytPTU2j/2WwJ4nQEtuw3GF09ZUFrVfHeyvTY9oaPL9uRnJ1PcCJd/d/GaXiCSUj1zzcycw/lu1OY/bMlwl9sM9/EfYasCUTOtApZL1+e4fr5tWKS3T4ZXjsXWafd8qu6kA7/sNwEgqpgKQguKQPSogTIYsPTTlqwDWYoEBoliKZU195Nl5t+YIcOfwm0RBCrqkGLlk5IO7Pq0FANHONBcFg5vQM5d/MDSYpwMXGXVuxaK6jIutsvwg6tyayVwl5LO9H1v2TIRZw9BRYTgTMLbxPjKx1Cgf5n8VgUj40oGoDBLOeyYDr/341gC+bXfqgTfbR2ESupooN04=" fecha="2015-07-29T08:58:25" formaDePago="PAGO EN UNA SOLA EXHIBICION" metodoDePago="EFECTIVO" noCertificado="20001000000200000179" sello="lEkR1Alib4tmjoG0gqXf1oyfOsOkXpUlkEnH3/Z1mS7UN+9nliozQnSQh8s1BRAWVcLBrmJuk+L+JvGecJH3iCdtxHKtj0V6rWX1fD4QwEeOUjIVogL5OtqWCg0t6HN8slUbSPy0+thjDHhV8VkbDLyzClUxbHWCVgZ2yEgAA40=" subTotal="1480.00" tipoDeComprobante="ingreso" total="1716.80" version="3.2" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd"><cfdi:Emisor nombre="EMPRESA AAQM610917QJA" rfc="AAQM610917QJA"><cfdi:DomicilioFiscal calle="JUAN PABLO II" codigoPostal="94294" colonia="FRACC. REFORMA" estado="VERACRUZ" municipio="BOCA DEL RIO" noExterior="258" pais="MEXICO"/><cfdi:RegimenFiscal Regimen="Regimen Simplificado"/></cfdi:Emisor><cfdi:Receptor nombre="EMPRESA CPA060516BG5" rfc="CPA060516BG5"><cfdi:Domicilio calle="EJERCITO MEXICANO" codigoPostal="91900" colonia="CARRANZA" estado="VERACRUZ" localidad="BOCA DEL RIO" municipio="BOCA DEL RIO" noExterior="234" pais="MEXICO"/></cfdi:Receptor><cfdi:Conceptos><cfdi:Concepto cantidad="15.0" descripcion="PERA" importe="25.25" noIdentificacion="PROD02" unidad="PIEZAS" valorUnitario="150.00"/><cfdi:Concepto cantidad="15.0" descripcion="SILLA" importe="750.00" noIdentificacion="PROD02" unidad="REMESA" valorUnitario="75.00"/><cfdi:Concepto cantidad="10.0" descripcion="MANZANA" importe="12.50" noIdentificacion="PROD02" unidad="PIEZAS" valorUnitario="3000.00"/></cfdi:Conceptos><cfdi:Impuestos><cfdi:Traslados><cfdi:Traslado importe="25.25" impuesto="IVA" tasa="16.00"/><cfdi:Traslado importe="750.00" impuesto="IVA" tasa="16.00"/><cfdi:Traslado importe="12.50" impuesto="IVA" tasa="16.00"/></cfdi:Traslados></cfdi:Impuestos></cfdi:Comprobante>', 'action' => 'upload');

		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data),
				),
			);
		$context  = stream_context_create($options);
		$user_info = file_get_contents($url, false, $context);
		$user_info = json_decode($user_info, true);
		return $user_info;
	}
}
