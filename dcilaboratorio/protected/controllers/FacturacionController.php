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
				'actions'=>array('index', 'create', 'admin' ,'imprimirFactura', 'agregarConcepto'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionCreate()
	{
		$this->subSection = "Nuevo";
		$model = new FacturacionForm;
		$examenes = new ConceptoForm;

		if(isset($_POST['FacturacionForm']))
		{
		print_r($_POST);
		return;
			$model->attributes=$_POST['FacturacionForm'];
			$model->validate();
			// $model->attributes=$_POST['Examenes'];
			// if($model->save())
			// 	$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('_form', array(
			'model' => $model,
			'conceptos' => $examenes,
			));
	}

	public function actionAdmin()
	{
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

	public function actionImprimirFactura($id){
		$model = Ordenes::model()->findByPk($id);
		$fullAnswer = $this->conectarConWS();
		$pdf = new ImprimirFactura('P','cm','letter');
		$pdf->AddPage();
		$pdf->cabeceraHorizontal($model, $fullAnswer);
		$pdf->contenido($model, $fullAnswer);
		$pdf->Output();
	}

	public function generarCFD($id){
		$orden = Ordenes::model()->findByPk($id);
		$listaConceptos = $orden->ordenTieneExamenes;
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
		$regimenFiscal = 'Regimen Simplificado';

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
		$xmlGenerado = '<?xml version="1.0" encoding="UTF-8"?>
<cfdi:Comprobante LugarExpedicion="'.$lugarExpedicion.'" certificado="@CERTIFICADO" fecha="@FECHA" formaDePago="'.$formaDePago.'" metodoDePago="'.$modoDePago.'" noCertificado="@NO_CERTIFICADO" sello="@SELLO" subTotal="'.$subTotal.'" tipoDeComprobante="'.$tipoDeComprobante.'" total="'.$total.'" version="3.2" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd"><cfdi:Emisor nombre="DCI LABORATORIO" rfc="@RFC_EMISOR"><cfdi:DomicilioFiscal calle="'.$calleEmisor.'" codigoPostal="'.$codigoPostalEmisor.'" colonia="'.$coloniaEmisor.'" estado="'.$estadoEmisor.'" municipio="'.$municipioEmisor.'" noExterior="'.$noExteriorEmisor.'" pais="MÉXICO"/><cfdi:RegimenFiscal Regimen="'.$regimenFiscal.'"/></cfdi:Emisor><cfdi:Receptor nombre="'.$nombreReceptor.'" rfc="'.$rfcReceptor.'"><cfdi:Domicilio calle="'.$calleReceptor.'" codigoPostal="'.$codigoPostalReceptor.'" colonia="'.$coloniaReceptor.'" estado="'.$estadoReceptor.'" localidad="'.$localidadReceptor.'" municipio="'.$municipioReceptor.'" noExterior="'.$noExteriorReceptor.'" pais="MEXICO"/></cfdi:Receptor><cfdi:Conceptos>';

	foreach ($listaConceptos as $concepto) {
		$xmlGenerado .= '<cfdi:Concepto cantidad="1.0" descripcion="'.$concepto->detalleExamen->examenes->nombre.'" importe="'.$concepto->detalleExamen->examenes->nombre.'" noIdentificacion="'.$concepto->detalleExamen->examenes->clave.'" unidad="'.$concepto->detalleExamen->unidadesMedida->abreviatura.'" valorUnitario="'.$concepto->detalleExamen->examenes->nombre.'"/>';
	}

	$xmlGenerado .= '</cfdi:Conceptos><cfdi:Impuestos><cfdi:Traslados><cfdi:Traslado importe="1500.00" impuesto="IVA" tasa="16.00"/><cfdi:Traslado importe="1850.00" impuesto="IVA" tasa="16.00"/><cfdi:Traslado importe="154.51" impuesto="IVA" tasa="16.00"/></cfdi:Traslados></cfdi:Impuestos></cfdi:Comprobante>';
echo $xmlGenerado;
return;

$cfdi = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<cfdi:Comprobante LugarExpedicion="BOCA DEL RIO, VERACRUZ" certificado="MIIELTCCAxWgAwIBAgIUMjAwMDEwMDAwMDAyMDAwMDAxNzkwDQYJKoZIhvcNAQEFBQAwggFcMRowGAYDVQQDDBFBLkMuIDIgZGUgcHJ1ZWJhczEvMC0GA1UECgwmU2VydmljaW8gZGUgQWRtaW5pc3RyYWNpw7NuIFRyaWJ1dGFyaWExODA2BgNVBAsML0FkbWluaXN0cmFjacOzbiBkZSBTZWd1cmlkYWQgZGUgbGEgSW5mb3JtYWNpw7NuMSkwJwYJKoZIhvcNAQkBFhphc2lzbmV0QHBydWViYXMuc2F0LmdvYi5teDEmMCQGA1UECQwdQXYuIEhpZGFsZ28gNzcsIENvbC4gR3VlcnJlcm8xDjAMBgNVBBEMBTA2MzAwMQswCQYDVQQGEwJNWDEZMBcGA1UECAwQRGlzdHJpdG8gRmVkZXJhbDESMBAGA1UEBwwJQ295b2Fjw6FuMTQwMgYJKoZIhvcNAQkCDCVSZXNwb25zYWJsZTogQXJhY2VsaSBHYW5kYXJhIEJhdXRpc3RhMB4XDTEyMTAyMjIwMDcwMloXDTE2MTAyMjIwMDcwMlowgacxHjAcBgNVBAMTFU1BUlRJTiBBUkJBSVpBIFFVSVJPWjEeMBwGA1UEKRMVTUFSVElOIEFSQkFJWkEgUVVJUk9aMR4wHAYDVQQKExVNQVJUSU4gQVJCQUlaQSBRVUlST1oxFjAUBgNVBC0TDUFBUU02MTA5MTdRSkExGzAZBgNVBAUTEkFBUU02MTA5MTdNREZSTk4wOTEQMA4GA1UECxMHTU9SRUxJQTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAuf5O30micrZtUGDgHlfQBPF9lyutJQJckUuMp+qpBZYYIpPTG2HlSWUgTnvWXpOajDTXF2pAJA2m1Y/lAIlyvVu6I6DwaVKm7n8mPCFVNnun0U5drlk5Xmu4cAG/OfF/KSgT8+u1R1auu1DPm1vUqzdRxP7mnmY9Y0eEc+qalfcCAwEAAaMdMBswDAYDVR0TAQH/BAIwADALBgNVHQ8EBAMCBsAwDQYJKoZIhvcNAQEFBQADggEBAGdO8y+w0XytPTU2j/2WwJ4nQEtuw3GF09ZUFrVfHeyvTY9oaPL9uRnJ1PcCJd/d/GaXiCSUj1zzcycw/lu1OY/bMlwl9sM9/EfYasCUTOtApZL1+e4fr5tWKS3T4ZXjsXWafd8qu6kA7/sNwEgqpgKQguKQPSogTIYsPTTlqwDWYoEBoliKZU195Nl5t+YIcOfwm0RBCrqkGLlk5IO7Pq0FANHONBcFg5vQM5d/MDSYpwMXGXVuxaK6jIutsvwg6tyayVwl5LO9H1v2TIRZw9BRYTgTMLbxPjKx1Cgf5n8VgUj40oGoDBLOeyYDr/341gC+bXfqgTfbR2ESupooN04=" fecha="2015-07-19T09:18:23" formaDePago="PAGO EN UNA SOLA EXHIBICION" metodoDePago="EFECTIVO" noCertificado="20001000000200000179" sello="PjV68LHu22EJXUNrGXb+vcqieBTwaNAPtBqWgCLVTnpXDvNeww7BeQYtJfH74zxhw+E0okSsyMqB5GUQAiFxcvb0VTGDouBtruZ+QwW5hN5uHR0EM3UlSpsVMQstnVSe/npZ8vBvI1NorzuymwSOT4vmHE3ai/pugcWKoczL894=" subTotal="1480.00" tipoDeComprobante="ingreso" total="1716.80" version="3.2" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd"><cfdi:Emisor nombre="EMPRESA AAQM610917QJA" rfc="AAQM610917QJA"><cfdi:DomicilioFiscal calle="JUAN PABLO II" codigoPostal="94294" colonia="FRACC. REFORMA" estado="VERACRUZ" municipio="BOCA DEL RIO" noExterior="258" pais="MEXICO"/><cfdi:RegimenFiscal Regimen="Regimen Simplificado"/></cfdi:Emisor><cfdi:Receptor nombre="EMPRESA CHO1006237R4" rfc="CHO1006237R4"><cfdi:Domicilio calle="EJERCITO MEXICANO" codigoPostal="91900" colonia="CARRANZA" estado="VERACRUZ" localidad="BOCA DEL RIO" municipio="BOCA DEL RIO" noExterior="234" pais="MEXICO"/></cfdi:Receptor><cfdi:Conceptos><cfdi:Concepto cantidad="10.0" descripcion="MOCHILA" importe="1500.00" noIdentificacion="PROD04" unidad="MENSAJE" valorUnitario="2150.50"/><cfdi:Concepto cantidad="25.0" descripcion="TICKET" importe="1850.00" noIdentificacion="PROD05" unidad="PKG" valorUnitario="3000.00"/><cfdi:Concepto cantidad="15.0" descripcion="SILLA" importe="154.51" noIdentificacion="PROD01" unidad="MENSAJE" valorUnitario="225.20"/></cfdi:Conceptos><cfdi:Impuestos><cfdi:Traslados><cfdi:Traslado importe="1500.00" impuesto="IVA" tasa="16.00"/><cfdi:Traslado importe="1850.00" impuesto="IVA" tasa="16.00"/><cfdi:Traslado importe="154.51" impuesto="IVA" tasa="16.00"/></cfdi:Traslados></cfdi:Impuestos></cfdi:Comprobante>
XML;

		return $cfdi;
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
				<input type='text' class='form-control' id='clave_$numeroConcepto' name='clave_$numeroConcepto' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;'/>
			</td>
			<td>
				<input type='text' class='form-control' id='concepto_$numeroConcepto' name='concepto_$numeroConcepto' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />
			</td>
			<td class='precioConcepto'>
				<input type='text' class='form-control' id='precio_$numeroConcepto' name='precio_$numeroConcepto' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />
			</td>
			<td>
				<a href='javascript:void(0)' data-id='numeroConcepto' class='eliminarConcepto'><span class='fa fa-trash'></span></a>
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
