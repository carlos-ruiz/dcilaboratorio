<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirFactura extends FPDF{

	function Header(){
        $y = 0.5;
		$this->SetFont('Arial','B',14);
        $this->Image(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../css/layout/img/gvia_logo22.png',16,1.7,4.3,3.3);
		
    // Move to the right
    //$this->Cell(8);
    // Title
		
		
        
	}

	function cabeceraHorizontal($model, $datosFactura)
	{
        $fecha = explode('-', $model->fecha_captura);
        $dia= substr($fecha[2], 0, 2);
        $hora = explode(' ', $fecha[2]);
        $hora = explode(':', $hora[1]);


        $fecha = $dia.'/'.$fecha[1].'/'.$fecha[0].'   '. $hora[0].':'.$hora[1];

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
        $this->Cell(-2.4, 4.4, 'Morelia Michoacán', 0, 0, 'C');

        $this->SetXY(2.4, 3.7);
        $this->SetFont('Times','B',8);
        $this->Cell(1, 3.7, 'Lugar de expedición:', 0, 0, 'C');
        $this->SetFont('Times','',8);
        $this->Cell(3.9, 3.7, 'Morelia, Michoacán', 0, 0, 'C');
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
        $this->Cell(0,0.1,$model->ordenFacturacion->datosFacturacion->razon_social, 0, 1, 'L');
        $this->Cell(0,0.1,'Comprobante Digital por Internet', 0, 1, 'R');
        $this->SetFont('Times','',8);
        $this->setX(2.5);
        $this->Cell(5,0.6,$model->ordenFacturacion->datosFacturacion->RFC, 0, 1, 'L');
        $this->ln(.2);
        $this->SetFont('Times','B',8);
        $this->setX(1.5);
        $this->Cell(0,0.1,'Domicilio', 0, 1, 'L');
        $this->Cell(0,0.1,'Número de comprobante: '.$datosFactura['certNumber'], 0, 1, 'R');
        $this->SetFont('Times','',8);
        $this->setX(1.5);
        $this->Cell(2,0.6,'Calle '.$model->ordenFacturacion->datosFacturacion->direccion->calle.' N° '.$model->ordenFacturacion->datosFacturacion->direccion->numero_ext, 0, 1, 'L');
        $this->Cell(0,0.1,'Forma de pago: Pago en Una sola exibición', 0, 1, 'R');
        $this->setX(1.5);
        $this->Cell(2,0.1,'Col. '.$model->ordenFacturacion->datosFacturacion->direccion->colonia.' CP. '.$model->ordenFacturacion->datosFacturacion->direccion->codigo_postal, 0, 1, 'L');
        $this->Cell(0,0.4,'Fecha de comprobante '.$fecha, 0, 1, 'R');
        $this->setX(1.5);
        $this->Cell(2,-0.1,$model->ordenFacturacion->datosFacturacion->direccion->municipio->nombre.', '.$model->ordenFacturacion->datosFacturacion->direccion->estado->nombre, 0, 1, 'L');
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

        $this->Cell(3.5,$y, 'Clave',1, 0 , 'C', true);
        $this->Cell(12,$y, 'Descripción',1, 0 , 'C', true);
        $this->Cell(4,$y, 'Costo',1, 1 , 'C', true);
    }

    function contenido($model, $datosFactura){
    	$this->SetTextColor(0, 0, 0); //Letra color blanco
    	$this->SetFont('Arial','',8);
    	$posYOriginal = 7;
    	$posYIncremento = 1.5;
    	// $this->setXY(1,8.5);
    	$y = 0.5;
        $ordenTieneExamenes = $model->ordenTieneExamenes;
        $idExamen = 0;
        $totalOrden = 0;
        $duracion = 0;
        foreach ($ordenTieneExamenes as $ordenExamen) {
            $examen = $ordenExamen->detalleExamen->examenes;
            if($examen->id!=$idExamen){
                $this->Cell(3.5,$y, $examen->clave,1, 0);
                $this->Cell(12,$y, $examen->nombre,1, 0 );
                $precio = OrdenPrecioExamen::model()->findByAttributes(array('id_ordenes'=>$model->id, 'id_examenes'=>$examen->id));
                $this->Cell(4,$y, '$ '.$precio->precio,1, 1, 'R');
                $totalOrden += $precio->precio;
                if ($examen->duracion_dias > $duracion) {
                    $duracion = $examen->duracion_dias;
                }
            }
            $idExamen = $examen->id;
        }
        $this->setX(13.5);
        $this->SetFont('Arial','B',8);
        $this->Cell(3,$y,'Total orden:', 1, 0, 'R');
        $this->Cell(4,$y,'$ '.$totalOrden, 1, 1, 'R');
        $this->setX(13.5);
        $this->Cell(3,$y,'Descuento:', 1, 0, 'R');
        $this->Cell(4,$y,isset($model->descuento)?$model->descuento:'0'.'%', 1, 1, 'R');
        $this->setX(13.5);
        $this->Cell(3,$y,'Total con descuento:', 1, 0, 'R');
        $this->Cell(4,$y,'$ '.$totalOrden*(1-($model->descuento/100)), 1, 1, 'R');
        $this->setX(13.5);
        $this->Cell(3,$y,'Costo emergencia:', 1, 0, 'R');
        $this->Cell(4,$y,'$ '.$model->costo_emergencia, 1, 1, 'R');
        $this->setX(13.5);
        $total = $totalOrden*(1-($model->descuento/100)) + $model->costo_emergencia;
        $this->Cell(3,$y,'Total:', 1, 0, 'R');
        $this->Cell(4,$y,'$ '.$total, 1, 1, 'R');
        $pagos = $model->pagos;
        $totalPagado = 0;
        foreach ($pagos as $pago) {
            $totalPagado +=  $pago->efectivo + $pago->cheque + $pago->tarjeta;
        }
        $this->setX(13.5);
        $this->Cell(3,$y,'Pago:', 1, 0, 'R');
        $this->Cell(4,$y,'$ '.$totalPagado, 1, 1, 'R');
        $this->setX(13.5);
        $this->Cell(3,$y,'Saldo:', 1, 0, 'R');
        $this->Cell(4,$y,'$ '.($total-$totalPagado), 1, 1, 'R');

        $this->ln(2);
        $this->setX(1);

        $this->MultiCell(0, $y, 'Este documento es una representación impresa de un CFDI - '.$datosFactura['string'], 0, 'L', false);
        $this->MultiCell(0, $y, 'cfdStamp - '.$datosFactura['cfdStamp'], 0, 'L', false);
        $this->MultiCell(0, $y, 'Sello digital del emisor (certNumber) - '.$datosFactura['certNumber'], 0, 'L', false);
        $this->MultiCell(0, $y, 'Sello digital del SAT(satStamp) - '.$datosFactura['satStamp'], 0, 'L', false);
         $this->Image(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../css/layout/img/qr.png',16,22,4,4);
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