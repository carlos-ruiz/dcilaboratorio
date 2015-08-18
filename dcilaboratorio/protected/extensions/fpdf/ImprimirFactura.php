<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirFactura extends FPDF{

	function Header(){
        $y = 0.5;
		$this->SetFont('Arial','B',14);
        $this->Image(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../css/layout/img/logoNuevo.png',16,1.7,4.3,3.3);
	}

	function cabeceraHorizontal($model, $datosFactura)
	{
        // $fecha = explode('-', $model->fecha);
        $fecha = $model->fecha;
        // $dia= substr($fecha[2], 0, 2);
        // $hora = explode(' ', $fecha[2]);
        // $hora = explode(':', $hora[1]);


        // $fecha = $dia.'/'.$fecha[1].'/'.$fecha[0].'   '. $hora[0].':'.$hora[1];

        $y = 0.5;
        $this->SetXY(1, .75);
        $this->Cell(0,2.54,'SILVIA GUERRA LAUCHINO',0,0,'C');
        $this->ln(0.5);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,2.54,'RFC. GULS720801NY4',0,0,'C');
        $this->ln(0.75);
        $this->SetFont('Times','B',14);
        $this->SetXY(1.8, 2.75);
        $this->Cell(1.3, $y, 'Factura', 0, 0, 'C');
        $this->SetFont('Times','B',10);
        $this->Cell(.9, 2, 'Domicilio y Expendido en:', 0, 0, 'C');
        $this->SetX(2);
        $this->SetFont('Times','',8);
        $this->Cell(1, 3, 'Gnl.Bravo #170', 0, 0, 'C');
        $this->Cell(1, 3.7, 'Col. Chapultepec Nte. C.P. 58260', 0, 0, 'C');
        $this->Cell(-2.4, 4.4, 'Morelia, Michoacán', 0, 0, 'C');

        $this->SetXY(2.4, 3.7);
        $this->SetFont('Times','B',8);
        $this->Cell(1, 3.7, 'Lugar de expedición:', 0, 0, 'C');
        $this->SetFont('Times','',8);
        $this->Cell(3.9, 3.7, ' Morelia, Michoacán', 0, 0, 'C');
        $this->SetFont('Times','B',8);
        $this->SetXY(2.4, 4);
        $this->Cell(.6, 3.8, 'Datos del Receptor', 0, 0, 'C');
        $this->SetXY(1, 4);
        $this->Cell(2, 4.6, 'Cliente:', 0, 0, 'C');
        $this->SetXY(2, 4);
        $this->Cell(-0.2, 5.3, 'RFC:', 0, 0, 'C');
        $this->Cell(0, 5.5, 'Folio Fiscal: '.$datosFactura['uuid'], 0, 0, 'R');
        $this->ln(1.5);

        $y = 0.5;
        $this->ln(.75);
        $this->SetFont('Times','B',9);
        $this->setX(2.5);
        $this->Cell(0,0.1,$model->razon_social, 0, 1, 'L');
        $this->Cell(0,0.1,'Comprobante Digital por Internet', 0, 1, 'R');
        $this->SetFont('Times','',8);
        $this->setX(2.5);
        $this->Cell(5,0.6,$model->rfc, 0, 1, 'L');
        $this->ln(.2);
        $this->SetFont('Times','B',8);
        $this->setX(1.5);
        $this->Cell(0,0.1,'Domicilio', 0, 1, 'L');
        $this->Cell(0,0.1,'Número de comprobante: '.$model->numeroFactura, 0, 1, 'R');
        $this->SetFont('Times','',8);
        $this->setX(1.5);
        $this->Cell(2,0.6,'Calle '.$model->calle.' N° '.$model->numero, 0, 1, 'L');
        $this->Cell(0,0.1,'Forma de pago: Pago en Una sola exibición', 0, 1, 'R');
        $this->setX(1.5);
        $this->Cell(2,0.1,'Col. '.$model->colonia.' CP. '.$model->codigo_postal, 0, 1, 'L');
        $this->Cell(0,0.4,'Fecha de comprobante '.$fecha, 0, 1, 'R');
        $this->setX(1.5);
        $this->Cell(2,-0.1,$model->municipio.', '.$model->estado, 0, 1, 'L');
        $this->setX(1.5);
        $this->Cell(2,0.8,'Moneda: PESOS   Tipo de cambio: 1.00', 0, 1, 'L');
        $this->Cell(0,-1,'Fecha de certificación del CFDI '.$datosFactura['date'], 0, 1, 'R');

        $this->setX(-8.5);
        $this->SetXY(-7.5,9.5);
        $this->Cell(0,0,'Método de pago y cuenta: TARJETA', 0, 1, 'R');
        $this->setX(-7.5);

        $this->setX(-7.5);
        $this->Cell(0,.7,'Regimen Fiscal: Reg. de la PF con Act. Emp. y Prof.', 0, 1, 'R');



        $this->ln(0.5);
        $this->SetFont('Arial','B',12);
        $this->SetTextColor(75, 141, 248);
        $this->Cell(3,$y,'Estudios Solicitados', 0, 1);
        $this->SetTextColor(0, 0, 0);

        $this->ln(.5);
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(75, 141, 248);//Fondo azul de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco

        $this->Cell(2,$y, 'Cantidad',1, 0 , 'C', true);
        $this->Cell(2,$y, 'Unidad',1, 0 , 'C', true);
        $this->Cell(9.5,$y, 'Descripción',1, 0 , 'C', true);
        $this->Cell(3,$y, 'Precio unitario',1, 0 , 'C', true);
        $this->Cell(3,$y, 'Importe',1, 1 , 'C', true);
    }

    function contenido($model, $datosFactura){
    	$this->SetTextColor(0, 0, 0); //Letra color blanco
    	$this->SetFont('Arial','',8);
    	$posYOriginal = 7;
    	$posYIncremento = 1.5;
    	// $this->setXY(1,8.5);
    	$y = 0.5;
        $conceptos = $model->conceptos;
        $idExamen = 0;
        $totalOrden = 0;
        $subtotal = 0;
        $duracion = 0;
        $descuento = isset($model->descuento)?$model->descuento:0;
        foreach ($conceptos as $concepto) {
            $this->Cell(2,$y, '1.00',1, 0);
            $this->Cell(2,$y, 'N/A',1, 0);
            $this->Cell(9.5,$y, $concepto->concepto,1, 0 );
            $this->Cell(3,$y, '$ '.round(($concepto->precio*(1-($descuento/100))/1.16), 2),1, 0, 'R');
            $this->Cell(3,$y, '$ '.round(($concepto->precio*(1-($descuento/100))/1.16), 2),1, 1, 'R');
            $totalOrden += ($concepto->precio*(1-($descuento/100)));
            $subtotal += round(($concepto->precio*(1-($descuento/100))/1.16), 2);
        }
        $this->setX(14.5);
        $this->SetFont('Arial','B',8);
        $this->Cell(3,$y,'Subtotal:', 0, 0, 'R');
        $this->Cell(3,$y,'$ '.$subtotal, 0, 1, 'R');
        $this->setX(14.5);
        $this->Cell(3,$y,'I.V.A. 16.00%:', 0, 0, 'R');
        $this->Cell(3,$y,'$ '.($totalOrden-$subtotal), 0, 1, 'R');
        $this->setX(14.5);
        // $this->Cell(3,$y,'Descuento:', 1, 0, 'R');
        // $this->Cell(4,$y,isset($model->descuento)?$model->descuento:'0'.'%', 1, 1, 'R');
        // $this->setX(13.5);
        // $this->Cell(3,$y,'Total con descuento:', 1, 0, 'R');
        // $this->Cell(4,$y,'$ '.$totalOrden*(1-($model->descuento/100)), 1, 1, 'R');
        // $this->setX(13.5);
        $total = $totalOrden*(1-($model->descuento/100)) + $model->costo_extra;
        $this->Cell(3,$y,'Total:', 0, 0, 'R');
        $this->Cell(3,$y,'$ '.$totalOrden, 0, 1, 'R');

        $this->ln(2);
        $this->setX(1);

        $this->Cell(0, $y, '"Este documento es una representación impresa de un CFDI"', 0, 1, 'L');
        $this->ln();
        $this->Cell(10, $y, 'Número de serie del certificado de sello digital:', 0, 0, 'L');
        $this->Cell(10, $y, 'Número de serie del certificado de sello digital del SAT:', 0, 1, 'L');
        $this->SetFont('Arial','',8);
        $this->Cell(10, $y, $datosFactura['certNumber'], 0, 0, 'L');
        $this->Cell(10, $y, $datosFactura['certNumber'], 0, 1, 'L');
        $this->ln();
        $this->SetFont('Arial','B',8);
        $this->Cell(10, $y, 'Cadena original del complemento de certificación digital del SAT: ', 0, 1, 'L');
        $this->SetFont('Arial','',8);
        $this->MultiCell(0, $y, $datosFactura['string'], 0, 'L', false);
        $this->setX(1);
        $this->SetFont('Arial','B',8);
        $this->Cell(0, $y, 'Sello Digital del Emisor:', 0, 1, 'L');
        $this->SetFont('Arial','',8);
        $this->MultiCell(15, $y,$datosFactura['cfdStamp'], 0, 'L', false);
        $this->SetFont('Arial','B',8);
        $this->Cell(0, $y, 'Sello digital del SAT:', 0, 1, 'L');
        $this->SetFont('Arial','',8);
        $this->MultiCell(15, $y, $datosFactura['satStamp'], 0, 'L', false);
        $this->Image(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../assets/qrcodes/qr.png',16,22,4,4);
    }

    function Footer()
	{
	//Position at 1.5 cm from bottom
    $this->SetY(-6);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Página '.$this->PageNo(),0,0,'C');
	}
}