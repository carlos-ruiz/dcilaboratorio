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

	//pruebas para ambiente de prueba
	//produccion para ambiente de produccion
	public $modo = "pruebas";
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
				'actions'=>array('index', 'create', 'admin', 'mostrarExpedidas', 'reimprimirFactura', 'generarFactura', 'cancelarCfdi', 'agregarConcepto'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionCreate(){
		$this->subSection = "Nuevo";
		$model = new FacturacionForm;
		$model->fecha = date('Y-m-d');
		$conceptosConError = null;
		$conceptos = array();

		if(isset($_POST['FacturacionForm']))
		{
			$model->attributes=$_POST['FacturacionForm'];

			$date1 = date('H:i:s');
			$time = split(":", $date1);
			$date = date('Y-m-d H:i:s', strtotime($model->fecha.' + '.$time[0].' hours'));
			$date = date('Y-m-d H:i:s', strtotime($date.' + '.$time[1].' minutes'));
			$date = date('Y-m-d H:i:s', strtotime($date.' + '.$time[2].' seconds'));
			$date = split(" ", $date);
			$date = $date[0].'T'.$date[1];
			$model->fecha = $date;

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
				$this->prepararCFD($model);
				$model->csd_emisor = $this->generarCFD();
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

	public function actionIndex(){
		$this->redirect(array('admin'));
	}

	public function actionMostrarExpedidas(){
		$this->subSection = "Expedidas";
		if (isset($_GET['mensaje'])) {
			$mensaje = $_GET['mensaje'];
			$titulo = $_GET['titulo'];
		}
		$model=new FacturasExpedidas('search');
		$mes = date('m');
		$anio = date('Y');
		$periodo = $mes.'/'.$anio;
		$contador = ConteoTimbresUsados::model()->find("anio=? AND mes=?", array($anio, $mes));
		if(isset($contador)){
			$contador = $contador->cantidad;
		}
		else{
			$contador = 0;
		}
		$importe = number_format($contador*3, 2);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FacturasExpedidas']))
			$model->attributes=$_GET['FacturasExpedidas'];

		$this->render('reimprimir',array(
			'model'=>$model,
			'periodo'=> $periodo,
			'importe'=>$importe,
			'contador'=>$contador,
			));
		$this->renderPartial('/comunes/mensaje',array('mensaje'=>isset($mensaje)?$mensaje:"",'titulo'=>isset($titulo)?$titulo:""));
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
			$model->correo_electronico = $orden->ordenFacturacion->paciente->email;
			$model->descuento = $orden->descuento;
			$model->costo_extra = $orden->costo_emergencia;
			$model->id_orden = $orden->id;
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
			if(isset($model->costo_extra) && $model->costo_extra > 0){
				$conceptoExtra = new ConceptoForm;
				$conceptoExtra->id = count($conceptos);
				$conceptoExtra->clave = "EMRGNC";
				$conceptoExtra->concepto = "Costo de emergencia";
				$conceptoExtra->precio = $model->costo_extra;
				array_push($conceptos, $conceptoExtra);
			}
			$model->conceptos = $conceptos;
		}

		if(isset($_POST['FacturacionForm']))
		{
			$model->attributes=$_POST['FacturacionForm'];
			if(strlen($model->fecha)<12){
				$date1 = date('H:i:s');
				$time = split(":", $date1);
				$date = date('Y-m-d H:i:s', strtotime($model->fecha.' + '.$time[0].' hours'));
				$date = date('Y-m-d H:i:s', strtotime($date.' + '.$time[1].' minutes'));
				$date = date('Y-m-d H:i:s', strtotime($date.' + '.$time[2].' seconds'));
				$date = split(" ", $date);
				$date = $date[0].'T'.$date[1];
				$model->fecha = $date;
			}
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
				if(isset($model->id_orden)){
					$facturaExpedida = $this->facturaGeneradaAnteriormente($model->id_orden);
					if (isset($facturaExpedida->id)) {
						$this->redirect(array('reimprimirFactura', 'id'=>$facturaExpedida->id));
					}
					else{
						$this->prepararCFD($model);
						$model->csd_emisor = $this->generarCFD();
						$result = $this->imprimirFactura($model);

						if (isset($result['titulo']) && isset($result['mensaje'])) {
							$titulo = $result['titulo'];
							$mensaje = $result['mensaje'];
						}
					}
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

	function facturaGeneradaAnteriormente($id){
		$facturacionModel = FacturasExpedidas::model()->find("id_ordenes=?", array($id));
		return $facturacionModel;
	}

	public function imprimirFactura($facturacionModel){
		$currentDate = date('Y-m-d H:i:s');
		$current = new DateTime($currentDate);
		$emision = new DateTime($facturacionModel->fecha);
		if($emision > $current){
			$titulo = "Error revise fecha de emisión";
			$mensaje = 'La fecha de emisión no debe ser mayor a la fecha actual<BR/>Actual: '.print_r($current).'emision<br/>'.print_r($emision);
			return array('titulo'=>$titulo, 'mensaje'=>$mensaje);
		}

		$fullAnswer = $this->conectarConWS();
		$anio = substr($currentDate, 0, 4);
		$mes = substr($currentDate, 5, 2);
		$conteo = ConteoTimbresUsados::model()->find('mes=? AND anio=?', array($mes, $anio));
		if(isset($conteo)){
			$conteo->cantidad = $conteo->cantidad + 1;
		}
		else{
			$conteo = new ConteoTimbresUsados;
			$conteo->cantidad = 1;
			$conteo->anio = $anio;
			$conteo->mes = $mes;
		}
		$conteo->save();

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

		$facturaExpedida = new FacturasExpedidas;
		$facturaExpedida->razon_social = $facturacionModel->razon_social;
		$facturaExpedida->rfc = $facturacionModel->rfc;
		$facturaExpedida->calle = $facturacionModel->calle;
		$facturaExpedida->numero = $facturacionModel->numero;
		$facturaExpedida->colonia = $facturacionModel->colonia;
		$facturaExpedida->codigo_postal = $facturacionModel->codigo_postal;
		$facturaExpedida->localidad = $facturacionModel->localidad;
		$facturaExpedida->municipio = $facturacionModel->municipio;
		$facturaExpedida->estado = $facturacionModel->estado;
		$facturaExpedida->fecha_emision = $facturacionModel->fecha;
		$facturaExpedida->descuento = $facturacionModel->descuento;
		$facturaExpedida->fecha_certificacion = $fullAnswer['date'];
		$facturaExpedida->uuid = $fullAnswer['uuid'];
		$facturaExpedida->numero_comprobante = $fullAnswer['certNumber'];
		$facturaExpedida->numero_certificado_emisor = $facturacionModel->csd_emisor;
		$facturaExpedida->cadena_original = $fullAnswer['string'];
		$facturaExpedida->sello_cfdi = $fullAnswer['cfdStamp'];
		$facturaExpedida->sello_sat = $fullAnswer['satStamp'];
		$facturaExpedida->id_ordenes = $facturacionModel->id_orden;
		$facturaExpedida->correo_electronico = $facturacionModel->correo_electronico;

		$response = $this->obtenerQr($facturaExpedida->uuid);
		$png = base64_decode($response['b64cbb']);
		$pngPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../../assets/qrcodes/qr.png';
		file_put_contents($pngPath, $png);
		$facturaExpedida->qr_png = $response['b64cbb'];


		if($facturaExpedida->validate()){

			if($facturaExpedida->save()){
				$conceptos = $facturacionModel->conceptos;
				$facturacionModel->numeroFactura = $facturaExpedida->id;

				foreach ($conceptos as $value) {
					$concepto = new ConceptosFactura;
					$concepto->clave = $value->clave;
					$concepto->descripcion = $value->concepto;
					$concepto->precio = $value->precio;
					$concepto->id_facturas_expedidas = $facturaExpedida->id;
					$concepto->save();
				}
			}
			$this->redirect(array('reimprimirFactura', 'id' => $facturaExpedida->id));
		}


	}

	public function actionReimprimirFactura($id){
		$facturaExpedida = FacturasExpedidas::model()->findByPk($id);
		$factura = new FacturacionForm;
		$factura->numeroFactura = $facturaExpedida->id;
		$factura->razon_social = $facturaExpedida->razon_social;
		$factura->rfc = $facturaExpedida->rfc;
		$factura->calle = $facturaExpedida->calle;
		$factura->numero = $facturaExpedida->numero;
		$factura->colonia = $facturaExpedida->colonia;
		$factura->codigo_postal = $facturaExpedida->codigo_postal;
		$factura->localidad = $facturaExpedida->localidad;
		$factura->municipio = $facturaExpedida->municipio;
		$factura->estado = $facturaExpedida->estado;
		$factura->fecha = $facturaExpedida->fecha_emision;
		$factura->id_orden = $facturaExpedida->id_ordenes;
		$factura->descuento = $facturaExpedida->descuento;
		$factura->csd_emisor = $facturaExpedida->numero_certificado_emisor;
		$factura->correo_electronico = $facturaExpedida->correo_electronico;

		$fullAnswer = array(
			'date' => $facturaExpedida->fecha_certificacion,
			'uuid' => $facturaExpedida->uuid,
			'certNumber' => $facturaExpedida->numero_comprobante,
			'string' => $facturaExpedida->cadena_original,
			'cfdStamp' => $facturaExpedida->sello_cfdi,
			'satStamp' => $facturaExpedida->sello_sat,
			);

		$response = $this->obtenerQr($facturaExpedida->uuid);
		$png = base64_decode($response['b64cbb']);
		$pngPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../../assets/qrcodes/qr.png';
		file_put_contents($pngPath, $png);

		$conceptosExpedidos = $facturaExpedida->conceptos;

		$conceptos = array();

		foreach ($conceptosExpedidos as $concepto) {
			$conceptoForm = new ConceptoForm;
			$conceptoForm->clave = $concepto->clave;
			$conceptoForm->concepto = $concepto->descripcion;
			$conceptoForm->precio = $concepto->precio;
			array_push($conceptos, $conceptoForm);
		}

		$factura->conceptos = $conceptos;

		$this->exportarPDF($factura, $fullAnswer);
	}

	public function exportarPDF($facturacionModel, $fullAnswer){
		$user = Usuarios::model()->findByPk(Yii::app()->user->id);
		$pdf = new ImprimirFactura('P','cm','letter');
		$pdf->AddPage();
		$pdf->cabeceraHorizontal($facturacionModel, $fullAnswer, $user->sucursal);
		$pdf->contenido($facturacionModel, $fullAnswer);
		$respuesta = array();
		if(isset($facturacionModel->correo_electronico) && strlen($facturacionModel->correo_electronico)>0){
			$pdf->Output(dirname(__FILE__).DIRECTORY_SEPARATOR."../../assets/facturas/factura".$facturacionModel->numeroFactura.'.pdf', "F");
			$respuesta = $this->enviarArchivosPorCorreo($facturacionModel);
			$pdf->Output();
		}
		else{
			$pdf->Output();
		}
		if (isset($respuesta['titulo']) && isset($respuesta['mensaje'])) {
			$titulo = $respuesta['titulo'];
			$mensaje = $respuesta['mensaje'];
		}
		$this->redirect(array('mostrarExpedidas', 'mensaje'=>$mensaje, 'titulo'=>$titulo));
	}

	public function enviarArchivosPorCorreo($facturacionModel){
		$mail = new YiiMailer();
		$mail->setView('enviarFactura');
		$mail->setFrom('clientes@dcilaboratorio.com', 'DCI Laboratorio');
		$mail->setTo($facturacionModel->correo_electronico);
		$mail->setSubject('Envío de Factura Electrónica');
		$mail->setAttachment(array(dirname(__FILE__).DIRECTORY_SEPARATOR."../../assets/facturas/factura".$facturacionModel->numeroFactura.'.pdf'=>'PDF', dirname(__FILE__).DIRECTORY_SEPARATOR."../extensions/TimbradoCFD/generador_xml_cfdi/xml/cfdi.xml"=>"XML"));
		if ($mail->send()) {
			$titulo = 'Correo enviado exitosamente';
			$mensaje = 'Su factura fue enviada exitosamente al correo electrónico proporcionado.';
		} else {
			$titulo = 'Error al enviar correo';
			$mensaje = 'Hubo un error al enviar el correo electrónico';
		}
		return array('titulo'=>$titulo, 'mensaje'=>$mensaje);
	}

	public function prepararCFD($model){
		$conceptos = $model->conceptos;
		$descuento = $model->descuento;
		$xmlPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/cfd.xml';
		$xmlTempPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/tmp/cfd.xml';
		# Lee XML de CFD base
		$cfd_xml_handler = fopen($xmlPath,'r');
		$cfd_xml = fread($cfd_xml_handler, filesize($xmlPath));
		fclose($cfd_xml_handler);

		# Fecha y hora de la orden
		$fechaModel = $model->fecha;
		$datetime = new DateTime($fechaModel);
		$datetime = $datetime->format(DateTime::ISO8601);
		$FECHA = substr($datetime, 0, 19);
		# Establece fecha de CFD
		$cfd_xml = str_replace('@FECHA',$FECHA,$cfd_xml);

		# Agregar datos del receptor
		$cfd_xml = str_replace('@NOMBRE_RECEPTOR',strtoupper($model->razon_social),$cfd_xml);
		$cfd_xml = str_replace('@RFC_RECEPTOR',strtoupper($model->rfc),$cfd_xml);
		$cfd_xml = str_replace('@CALLE_RECEPTOR',strtoupper($model->calle),$cfd_xml);
		$cfd_xml = str_replace('@CP_RECEPTOR',strtoupper($model->codigo_postal),$cfd_xml);
		$cfd_xml = str_replace('@COLONIA_RECEPTOR',strtoupper($model->colonia),$cfd_xml);
		$cfd_xml = str_replace('@NO_RECEPTOR',strtoupper($model->numero),$cfd_xml);
		$cfd_xml = str_replace('@LOCALIDAD_RECEPTOR',strtoupper($model->localidad),$cfd_xml);
		$cfd_xml = str_replace('@MUNICIPIO_RECEPTOR',strtoupper($model->municipio),$cfd_xml);
		$cfd_xml = str_replace('@ESTADO_RECEPTOR',strtoupper($model->estado),$cfd_xml);

		$stringConceptos = "";
		$stringTrasladados = "";
		# Agregar conceptos al XML
		$subTotal = 0;
		$total = 0;
		foreach ($conceptos as $concepto) {
			$precio = $concepto->precio;
			$precio = $precio*(1-($descuento/100));
			$subTotal += ($precio / 1.16);
			$total += $precio;
			$stringConceptos .= '<cfdi:Concepto cantidad="1" descripcion="'.$concepto->concepto.'" importe="'.str_replace(",","",number_format($precio/1.16, 2)).'" noIdentificacion="'.$concepto->clave.'" unidad="EXAMEN" valorUnitario="'.str_replace(",","",number_format($precio/1.16, 2)).'"/>';
			$stringTrasladados .= '<cfdi:Traslado importe="'.str_replace(",","",number_format($precio/1.16*0.16, 2)).'" impuesto="IVA" tasa="16.00"/>';
		}
		$cfd_xml = str_replace('@CONCEPTOS',$stringConceptos,$cfd_xml);
		$cfd_xml = str_replace('@TRASLADADOS',$stringTrasladados,$cfd_xml);
		$cfd_xml = str_replace("@SUBTOTAL", str_replace(",","",number_format($subTotal, 2)), $cfd_xml);
		$cfd_xml = str_replace("@TOTAL", str_replace(",","",number_format($total, 2)), $cfd_xml);

		# Guarda XML
		$xmlResult = fopen($xmlTempPath,'w');
		fwrite($xmlResult,$cfd_xml);
		fclose($xmlResult);
	}


	public function generarCFD(){
		$xslt = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/xslt/cadenaoriginal_3_2.xslt';
		$xsltXmlOut = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/xml/xsltXmlOut.xml';
		if($this->modo == "produccion"){
			$cerFile = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/cert_key/guls720801ny4.cer';
			$cerOutFile = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/cert_key/guls720801ny4Out.txt';
			$keyPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/cert_key/guls720801ny4.key';
			$keyPwd = '12345678a';
			$pemPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/tmp/guls720801ny4_key.pem';
			$pemCert = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/tmp/guls720801ny4_cer.pem';
		}
		else{
			$cerFile = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/cert_key/AAQM610917QJA.cer';
			$cerOutFile = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/cert_key/AAQM610917QJAOut.txt';
			$keyPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/cert_key/AAQM610917QJA_s.key';
			$keyPwd = '12345678a';
			$pemPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/tmp/AAQM610917QJA_key.pem';
			$pemCert = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/tmp/AAQM610917QJA_cer.pem';
		}
		$xmlPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/tmp/cfd.xml';
		$xmlResultPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/xml/cfdi.xml';
		$cadenaOriginalPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/xml/cadenaOriginalOut.txt';
		$signBinPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/xml/sign.bin';
		$selloPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/xml/selloOut.txt';

		# Valida contraseña de llave y genera el formato PEM
		$errorCode = $this->validateKeyPass($keyPath,$keyPwd,$pemPath);
		# Obtén número de certificado
		$NO_CERTIFICADO = $this->getSerial($cerFile);

		# Obtén certificado en PEM para insertar en CFD
		$CERTIFICADO =  $this->certificadoF($cerFile, $cerOutFile);
		# Obtén rfc a partir del certificado
		$RFC_EMISOR = $this->getRFC($cerFile);

		if ($errorCode == 0){

			# Lee XML de CFD base
			$cfd_xml_handler = fopen($xmlPath,'r');
			$cfd_xml = fread($cfd_xml_handler, filesize($xmlPath));
			fclose($cfd_xml_handler);

			# Establece datos de emisor
			$cfd_xml = str_replace('@CERTIFICADO',$CERTIFICADO,$cfd_xml);
			$cfd_xml = str_replace('@NO_CERTIFICADO',$NO_CERTIFICADO,$cfd_xml);
			$cfd_xml = str_replace('@RFC_EMISOR',$RFC_EMISOR,$cfd_xml);

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

			#generamos la cadena original
			$xsltDoc = new DOMDocument();
	        $xsltDoc->load($xslt);
	        $xmlDoc = new DOMDocument();
	        $xmlDoc->load($xmlResultPath);
	        $proc = new XSLTProcessor();
	        $proc->importStylesheet($xsltDoc);
	        $datos = $proc->transformToXML($xmlDoc);

			#guardamos la cadena en un archivo
			$cadenaOriginal = fopen($cadenaOriginalPath,'w');
			fwrite($cadenaOriginal,$datos);
			fclose($cadenaOriginal);

			# generamos el sello
			$SELLO = $this->selloCFD($datos,$pemPath,$cadenaOriginalPath,$selloPath,$signBinPath);

			# Incluye sello
			$cfd_xml = str_replace('@SELLO',$SELLO, $cfd_xml);

			# Guarda XML
			$xmlResult = fopen($xmlResultPath,'w');
			fwrite($xmlResult,$cfd_xml);
			fclose($xmlResult);
			return $NO_CERTIFICADO;
		}
		else{
			return null;
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

	# Función para sellar la cadena original
	public function selloCFD($stringResult,$pemPath,$cadenaOriginalPath,$selloPath,$signBinPath){

		$os = PHP_OS;
		if (strpos($os,'WIN') !== false) {
			$command = 'set OPENSSL_CONF=C:\\OpenSSL-Win32\\bin\\openssl.cfg && C:\\OpenSSL-Win32\\bin\\openssl.exe';
		}
		else if (strpos($os,'Linux') !== false) {
			$command = 'openssl';
		}
		$commandBase = $command;

		$command .= ' dgst -sha1 -out %s -sign %s %s';
		$command = sprintf($command, strval($signBinPath), strval($pemPath), strval($cadenaOriginalPath));
		$f = popen($command, 'r');

		sleep(1);

		$command = $commandBase.' enc -in %s -a -A -out %s';
		$command = sprintf($command, strval($signBinPath), strval($selloPath));
		$f = popen($command, 'r');

		sleep(1);

		$sello_handler = fopen($selloPath,'r');
		$sellotemp = fread($sello_handler, filesize($selloPath));
		fclose($sello_handler);
		return $sellotemp;
	}

	public function actionCancelarCfdi($uuid){
		if($this->modo == "pruebas"){
			$url = 'http://www.bpimorelia.com/wstech/api_test.php';
		}
		else{
			$url = 'http://www.bpimorelia.com/wstech/api.php';
		}
		$data = array('uuidCancel' => $uuid);

		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data),
				),
			);
		$context  = stream_context_create($options);
		$ws_response = file_get_contents($url, false, $context);
		$ws_response = json_decode($ws_response, true);
		if($ws_response['ok'] == true && $ws_response['errorCode'] == 0){
			$facturaExpedida = FacturasExpedidas::model()->find("uuid=?", array($uuid));
			$facturaExpedida->activa = 0;
			if($facturaExpedida->save()){
				$mensaje = "Factura cancelada correctamente";
				$titulo = "Cancelación exitosa";
			}
		}
		else{
			$titulo = "Error";
			$response = $ws_response['uuid'];
			$error = split("\|", $response);
			$errorCode = split(':', $error[0]);
			$errorCode = $errorCode[1];

			switch ($errorCode) {
				case '200':
					$mensaje = "UUID en proceso de cancelación";
					break;
				case "202":
					$mensaje = "UUID previamente cancelado";
					break;
				case "203":
					$mensaje = "UUID consultado no pertenece a contribuyente";
					break;
				case "205":
					$mensaje = "UUID consultado desconocido";
					break;
				case "206":
					$mensaje = "UUID no solicitado para cancelación";
					break;
			}
		}
		$this->actionMostrarExpedidas();
		$this->renderPartial('/comunes/mensaje',array('mensaje'=>isset($mensaje)?$mensaje:"",'titulo'=>isset($titulo)?$titulo:""));
	}

	public function obtenerQr($uuid){
		if($this->modo == "pruebas"){
			$url = 'http://www.bpimorelia.com/wstech/api_test.php';
		}
		else{
			$url = 'http://www.bpimorelia.com/wstech/api.php';
		}

		$data = array('uuidCBB' => $uuid);

		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data),
				),
			);
		$context  = stream_context_create($options);
		$ws_response = file_get_contents($url, false, $context);
		$ws_response = json_decode($ws_response, true);
		return $ws_response;
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
				<input type='text' class='form-control' data-row='$numeroConcepto' id='precio_$numeroConcepto' name='precio_$numeroConcepto' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />
			</td>
			<td>
				<span id='total_desc_$numeroConcepto'></span>
			</td>
			<td class='importeSinIva'>
				<span id='importe_sin_iva_$numeroConcepto'></span>
			</td>
			<td class='iva'>
				<span id='iva_$numeroConcepto'></span>
			</td>
			<td>
				<a href='javascript:void(0)' data-id='$numeroConcepto' class='eliminarConcepto'><span class='fa fa-trash'></span></a>
			</td>
		</tr>";
	}

	public function conectarConWS(){
		if($this->modo == "pruebas"){
			$url = 'http://www.bpimorelia.com/wstech/api_test.php';
		}
		else{
			$url = 'http://www.bpimorelia.com/wstech/api.php';
		}
		$xmlResultPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'../extensions/TimbradoCFD/generador_xml_cfdi/xml/cfdi.xml';
		$cfdi_handler = fopen($xmlResultPath,'r');
		$xml_file = fread($cfdi_handler, filesize($xmlResultPath));
		fclose($cfdi_handler);
		$data = array('xmlfile' => $xml_file, 'action' => 'upload');

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

	public function obtenerEstatus($data, $row){
		$estatus = $data->activa == 1 ? 'Activa':'Cancelada';
		return $estatus;
	}
}
