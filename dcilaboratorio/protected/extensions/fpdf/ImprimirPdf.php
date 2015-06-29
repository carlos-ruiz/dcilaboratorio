<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirPdf extends FPDF{

	function Header(){
		$this->SetFont('Arial','B',18);
		$this->Image(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../css\layout\img/gvia_logo22.png',1.5,1.5,3,3);
    // Move to the right
    //$this->Cell(8);
    // Title
		$this->SetXY(4, 1);
		$this->Cell(0,2.54,'DIAGNOSTICO CLÍNICO INTEGRAL',0,0,'C');
		$this->ln(0.75);
		$this->SetFont('Times','',8);
		$this->SetXY(4, 1.75);
		$this->Cell(0,2.54,'UNIDAD CENTRAL                    UNIDAD FELIX IRETA                     UNIDAD AMADO NERVO                     UNIDAD DE CANCEROLOGIA',0,0,'C');
		$this->SetXY(7, 2.30);
		$this->Cell(0,2.54,'Gnl.Bravo #170                                      Tucurán #230                                   Amado Nervo $392-A                                 Francisco Madero #145',0,0,'L');
		$this->SetXY(6.8, 2.65);
		$this->Cell(0,2.54,'Col. Chapultepec Nte.                              Col. Félix Ireta                                          Col. Centro                                   Fracc. Ex Gob. Gildardo Magaña',0,0,'L');
		$this->SetXY(7.35, 3);
		$this->Cell(0,2.54,'C.P. 58260                                           C.P. 58070                                              C.P. 58000                                                     C.P. 58149',0,0,'L');
		$this->SetXY(6.9, 3.35);
		$this->Cell(0,2.54,'Tel.(443)232-0166                                Tel.(443)326-9891                                  Tel.(443)312-3490                                        Tel.(443)232-0165',0,0,'L');
		$this->Cell(0,2.54,'',0,0,'C');
	//	$this->SetLineWidth(0.07);
	//	$this->line(0.54,5,27,5);       
	}

	function cabeceraHorizontal($cabecera)
	{
		$this->SetXY(1, 6);
		$this->SetFont('Arial','B',8);
        $this->SetFillColor(75, 141, 248);//Fondo azul de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco
        $x = 2;
        $y = 1;
        foreach ($cabecera as $i=>$columna) {
        	$this->Cell($cabecera[$i]['size'],$y, utf8_decode($cabecera[$i]['nombre']),1, 0 , 'C', true);
        }
        //Atención!! el parámetro true rellena la celda con el color elegido
		//$this->Cell(120,7, utf8_decode("hola mundo"),1, 0 , 'C', true);
		//$this->Cell(20,7, utf8_decode($cabecera[2]),1, 0 , 'C', true);
    }

    function contenido($coleccion, $cabecera){
    	$this->SetTextColor(0, 0, 0); //Letra color blanco
    	$this->SetFont('Arial','',8);
    	$posYOriginal = 7;
    	$posYIncremento = 1.5;
    	$posX = 1;
    	$posY = $posYOriginal;
    	$this->setXY($posX,$posYOriginal);
    	$y = 0.5;
    	foreach ($cabecera as $i => $columna) {
    		if ($columna['id']=='day') {
    			foreach ($coleccion as $i => $value) {
    				$orden = Ordenes::model()->findByPk($value);
    				$fecha = explode('-', $orden->fecha_captura);
    				$fecha = explode(' ', $fecha[2]);
    				$this->Cell($columna['size'],($y*$posYIncremento),$fecha[0], 1, 1);
    			}
    			$posX += $columna['size']; 
    		}
    		if ($columna['id']=='month') {
    			foreach ($coleccion as $i => $value) {
    				$this->setXY($posX,$posY);
    				$posY+=$y*$posYIncremento;
    				$orden = Ordenes::model()->findByPk($value);
    				$fecha = explode('-', $orden->fecha_captura);
    				$fecha = $fecha[1];
    				$this->Cell($columna['size'],($y*$posYIncremento),$fecha, 1, 1);
    			}
    			$posX += $columna['size'];
    			$posY = $posYOriginal;
    		}
    		if ($columna['id']=='year') {
    			foreach ($coleccion as $i => $value) {
    				$this->setXY($posX,$posY);
    				$posY+=$y*$posYIncremento;
    				$orden = Ordenes::model()->findByPk($value);
    				$fecha = explode('-', $orden->fecha_captura);
    				$fecha = $fecha[0];
    				$this->Cell($columna['size'],($y*$posYIncremento),$fecha, 1, 1);
    			}
    			$posX += $columna['size'];
    			$posY = $posYOriginal;
    		}
    		if ($columna['id']=='week') {
    			foreach ($coleccion as $i => $value) {
    				$this->setXY($posX,$posY);
    				$posY+=$y*$posYIncremento;
    				$orden = Ordenes::model()->findByPk($value);
    				$fecha = new DateTime($orden->fecha_captura);
    				$week = $fecha->format("W");
    				$this->Cell($columna['size'],($y*$posYIncremento),$week, 1, 1);
    			}
    			$posX += $columna['size'];
    			$posY = $posYOriginal;
    		}
    		if ($columna['id']=='hr') {
    			foreach ($coleccion as $i => $value) {
    				$this->setXY($posX,$posY);
    				$posY+=$y*$posYIncremento;
    				$orden = Ordenes::model()->findByPk($value);
    				$fecha = explode('-', $orden->fecha_captura);
    				$fecha = explode(' ', $fecha[2]);
    				$fecha = explode(':', $fecha[1]);
    				$fecha = $fecha[0].':'.$fecha[1];
    				$this->Cell($columna['size'],($y*$posYIncremento),$fecha, 1, 1);
    			}
    			$posX += $columna['size'];
    			$posY = $posYOriginal;
    		}
    		if ($columna['id']=='folio') {
    			foreach ($coleccion as $i => $value) {
    				$this->setXY($posX,$posY);
    				$posY+=$y*$posYIncremento;
    				$orden = Ordenes::model()->findByPk($value);
    				$this->Cell($columna['size'],($y*$posYIncremento),$orden->id, 1, 1);
    			}
    			$posX += $columna['size'];
    			$posY = $posYOriginal;
    		}
    		if ($columna['id']=='idp') {
    			foreach ($coleccion as $i => $value) {
    				$this->setXY($posX,$posY);
    				$posY+=$y*$posYIncremento;
    				$orden = Ordenes::model()->findByPk($value);
    				$paciente = $orden->ordenFacturacion->id_pacientes;
    				$this->Cell($columna['size'],($y*$posYIncremento),$paciente, 1, 1);
    			}
    			$posX += $columna['size'];
    			$posY = $posYOriginal;
    		}
    		if ($columna['id']=='namep') {
    			foreach ($coleccion as $i => $value) {
    				$this->setXY($posX,$posY);
    				$posY+=$y*$posYIncremento;
    				$orden = Ordenes::model()->findByPk($value);
    				$paciente = $orden->ordenFacturacion->paciente;
    				$nombre = $paciente->nombre.' '.$paciente->a_paterno.' '.$paciente->a_materno;
    				$nombre = substr($nombre, 0, 29);
    				$this->Cell($columna['size'],($y*$posYIncremento),$nombre, 1, 1);
    			}
    			$posX += $columna['size'];
    			$posY = $posYOriginal;
    		}
    		if ($columna['id']=='ur') {
    			foreach ($coleccion as $i => $value) {
    				$this->setXY($posX,$posY);
    				$posY+=$y*$posYIncremento;
    				$orden = Ordenes::model()->findByPk($value);
    				$ur = $orden->idUnidadesResponsables;
    				$ur = isset($ur)?$ur->nombre:'';
    				$ur = substr($ur, 0, 19);
    				$this->Cell($columna['size'],($y*$posYIncremento),$ur, 1, 1);
    			}
    			$posX += $columna['size'];
    			$posY = $posYOriginal;
    		}
    		if ($columna['id']=='dr') {
    			foreach ($coleccion as $i => $value) {
    				$this->setXY($posX,$posY);
    				$posY+=$y*$posYIncremento;
    				$orden = Ordenes::model()->findByPk($value);
    				$dr = $orden->doctor;
    				$dr = isset($dr)?$dr->titulo->nombre.' '.$dr->nombre.' '.$dr->a_paterno:'';
    				$dr = substr($dr, 0, 29);
    				$this->Cell($columna['size'],($y*$posYIncremento),$dr, 1, 1);
    			}
    			$posX += $columna['size'];
    			$posY = $posYOriginal;
    		}
			if ($columna['id']=='exam') {
				foreach ($coleccion as $i => $value) {
					$this->setXY($posX,$posY);
					$posY+=$y*$posYIncremento;
					$orden = Ordenes::model()->findByPk($value);
					$ordenTieneExamenes = $orden->ordenTieneExamenes;
					$examenes = '';
					$idExamen = 0;
					foreach ($ordenTieneExamenes as $ordenExamen) {
						if($ordenExamen->detalleExamen->examenes->id!=$idExamen){
							$examenes .= ', '.$ordenExamen->detalleExamen->examenes->clave;
						}
						$idExamen = $ordenExamen->detalleExamen->examenes->id;
					}
					$examenes = substr($examenes, 1);
					if (strlen($examenes)>20) {
						$examenes = substr($examenes, 0, 19);
						$examenes.='...';
					}
						$this->Cell($columna['size'],($y*$posYIncremento),$examenes, 1, 1);
				}
				$posX += $columna['size'];
				$posY = $posYOriginal;
			}
			if ($columna['id']=='cost') {
				foreach ($coleccion as $i => $value) {
					$this->setXY($posX,$posY);
					$posY+=$y*$posYIncremento;
					$orden = Ordenes::model()->findByPk($value);
					$ordenPreciosExamen = $orden->precios;
					$costoTotal = 0;
					foreach ($ordenPreciosExamen as $precioExamen) {
						$costoTotal += $precioExamen->precio;
					}
					$this->Cell($columna['size'],($y*$posYIncremento),'$ '.$costoTotal, 1, 1);
				}
				$posX += $columna['size'];
				$posY = $posYOriginal;
			}

    		//descuento porcentaje

    		if ($columna['id']=='discp') {
    			foreach ($coleccion as $i => $value) {
    				$this->setXY($posX,$posY);
    				$posY+=$y*$posYIncremento;
    				$orden = Ordenes::model()->findByPk($value);
    				$this->Cell($columna['size'],($y*$posYIncremento),$orden->descuento, 1, 1);
    			}
    			$posX += $columna['size'];
    			$posY = $posYOriginal;
    		}
    		if ($columna['id']=='disa') {
				foreach ($coleccion as $i => $value) {
					$this->setXY($posX,$posY);
					$posY+=$y*$posYIncremento;
					$orden = Ordenes::model()->findByPk($value);
					$ordenPreciosExamen = $orden->precios;
					$costoTotal = 0;
					foreach ($ordenPreciosExamen as $precioExamen) {
						$costoTotal += $precioExamen->precio;
					}
					$costoTotal = $costoTotal*$orden->descuento/100;
					$this->Cell($columna['size'],($y*$posYIncremento),'$ '.$costoTotal, 1, 1);
				}
				$posX += $columna['size'];
				$posY = $posYOriginal;
			}
    		
    		//Tarifa
    			if ($columna['id']=='tarifa') {
    			foreach ($coleccion as $i => $value) {
    				$this->setXY($posX,$posY);
    				$posY+=$y*$posYIncremento;
    				$orden = Ordenes::model()->findByPk($value);
    				$multitarifario = $orden->multitarifarios;
    				$nombre = $multitarifario->nombre;
    				$nombre = substr($nombre, 0, 9);
    				$this->Cell($columna['size'],($y*$posYIncremento),$nombre, 1, 1);
    			}
    			$posX += $columna['size'];
    			$posY = $posYOriginal;
    		}
    	}
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