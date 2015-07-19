<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirFactura extends FPDF{

	function Header(){
        $y = 0.5;
		$this->SetFont('Arial','B',18);
		$this->Image(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../css/layout/img/gvia_logo22.png',1,1.7,2.3,2.3);
    // Move to the right
    //$this->Cell(8);
    // Title
		$this->SetXY(4, .75);
		$this->Cell(0,2.54,'DIAGNOSTICO CLÍNICO INTEGRAL',0,0,'C');
		$this->ln(0.75);
		$this->SetFont('Times','B',8);
        $this->SetXY(3, 2.75);
        $this->Cell(4.3, $y, 'UNIDAD CENTRAL', 0, 0, 'C');
        $this->Cell(4.3, $y, 'UNIDAD FÉLIX IRETA', 0, 0, 'C');
        $this->Cell(4.3, $y, 'UNIDAD AMADO NERVO', 0, 0, 'C');
        $this->Cell(4.5, $y, 'UNIDAD DE CANCEROLOGÍA', 0, 1, 'C');
        $this->SetX(3);
        $this->SetFont('Times','',8);
        $y = 0.4;
        $this->Cell(4.3, $y, 'Gnl.Bravo #170', 0, 0, 'C');
        $this->Cell(4.3, $y, 'Tucurán #230', 0, 0, 'C');
        $this->Cell(4.3, $y, 'Amado Nervo #392-A', 0, 0, 'C');
        $this->Cell(4.5, $y, 'Francisco Madero #145', 0, 1, 'C');
        $this->SetX(3);
        $this->Cell(4.3, $y, 'Col. Chapultepec Nte.', 0, 0, 'C');
        $this->Cell(4.3, $y, 'Col. Félix Ireta', 0, 0, 'C');
        $this->Cell(4.3, $y, 'Col. Centro', 0, 0, 'C');
        $this->Cell(4.5, $y, 'Fracc. Ex Gob. Gildardo Magaña', 0, 1, 'C');
        $this->SetX(3);
        $this->Cell(4.3, $y, 'C.P. 58260', 0, 0, 'C');
        $this->Cell(4.3, $y, 'C.P. 58070', 0, 0, 'C');
        $this->Cell(4.3, $y, 'C.P. 58000', 0, 0, 'C');
        $this->Cell(4.5, $y, 'C.P. 58149', 0, 1, 'C');
        $this->SetX(3);
        $this->Cell(4.3, $y, 'Tel.(443)232-0166', 0, 0, 'C');
        $this->Cell(4.3, $y, 'Tel.(443)326-9891', 0, 0, 'C');
        $this->Cell(4.3, $y, 'Tel.(443)312-3490', 0, 0, 'C');
        $this->Cell(4.5, $y, 'Tel.(443)232-0165', 0, 1, 'C');
	}

	function cabeceraHorizontal($model, $datosFactura)
	{
        $y = 0.5;
        $this->ln(1);
        $this->setX(-7.5);
        $this->SetFont('Arial','B',8);
        $this->Cell(0,$y,'Fecha:', 0, 1, 'R');
        $fecha = explode('-', $model->fecha_captura);
        $dia= substr($fecha[2], 0, 2);
        $hora = explode(' ', $fecha[2]);
        $hora = explode(':', $hora[1]);


        $fecha = $dia.'/'.$fecha[1].'/'.$fecha[0].'   '. $hora[0].':'.$hora[1];
        $this->setX(-7.5);
        $this->Cell(0,$y,$fecha, 0, 1, 'R');
        $this->setX(-7.5);
        $this->Cell(0,$y,'Factura:', 0, 1, 'R');
        $this->setX(-7.5);
        $this->Cell(0,$y,'XXXXXX', 0, 1, 'R');
        $this->setX(-7.5);
        $this->Cell(0,$y,'Folio fiscal:', 0, 1, 'R');
        $this->setX(-7.5);
        $this->Cell(0,$y,$datosFactura['uuid'], 0, 1, 'R');
        $this->setX(-7.5);
        $this->Cell(0,$y,'No de serie del certificado:', 0, 1, 'R');
        $this->setX(-7.5);
        $this->Cell(0,$y, $datosFactura['certNumber'], 0, 1, 'R');
        $this->setX(-7.5);
        $this->Cell(0,$y,'Fecha y hora de emisión:', 0, 1, 'R');
        $this->setX(-7.5);
        $this->Cell(0,$y, $datosFactura['date'], 0, 1, 'R');


        $this->ln(0.5);
        $this->SetFont('Arial','B',12);
        $this->SetTextColor(75, 141, 248);
        $this->Cell(3,$y,'Estudios Solicitados', 0, 1);
        $this->SetTextColor(0, 0, 0);

        $this->ln(1);
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
        $this->MultiCell(0, $y, 'string - '.$datosFactura['string'], 0, 'L', false);
        $this->MultiCell(0, $y, 'cfdStamp - '.$datosFactura['cfdStamp'], 0, 'L', false);
        $this->MultiCell(0, $y, 'certNumber - '.$datosFactura['certNumber'], 0, 'L', false);
        $this->MultiCell(0, $y, 'satStamp - '.$datosFactura['satStamp'], 0, 'L', false);
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