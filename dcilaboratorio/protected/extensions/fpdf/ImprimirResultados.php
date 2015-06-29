<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirOrden extends FPDF{

	function Header(){
		$this->SetFont('Arial','B',18);
		$this->Image(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../css/layout/img/gvia_logo22.png',1,1.7,2.3,2.3);
    // Move to the right
    //$this->Cell(8);
    // Title
		$this->SetXY(4, .75);
		$this->Cell(0,2.54,'DIAGNOSTICO CLÍNICO INTEGRAL',0,0,'C');
		$this->ln(0.75);
		$this->SetFont('Times','B',8);
		$this->SetXY(4, 1.75);
		$this->Cell(0,2.54,'UNIDAD CENTRAL                    UNIDAD FELIX IRETA                     UNIDAD AMADO NERVO                     UNIDAD DE CANCEROLOGIA',0,0,'C');
		$this->SetXY(4, 2.30);
        $this->SetFont('Times','',8);
		$this->Cell(0,2.54,'Gnl.Bravo #170                                      Tucurán #230                                   Amado Nervo $392-A                                 Francisco Madero #145',0,0,'L');
		$this->SetXY(3.8, 2.65);
		$this->Cell(0,2.54,'Col. Chapultepec Nte.                              Col. Félix Ireta                                          Col. Centro                                   Fracc. Ex Gob. Gildardo Magaña',0,0,'L');
		$this->SetXY(4.35, 3);
		$this->Cell(0,2.54,'C.P. 58260                                           C.P. 58070                                              C.P. 58000                                                     C.P. 58149',0,0,'L');
		$this->SetXY(3.9, 3.35);
		$this->Cell(0,2.54,'Tel.(443)232-0166                                Tel.(443)326-9891                                  Tel.(443)312-3490                                        Tel.(443)232-0165',0,0,'L');
		$this->Cell(0,2.54,'',0,0,'C');
	//	$this->SetLineWidth(0.07);
	//	$this->line(0.54,5,27,5);       
	}

	function cabeceraHorizontal($model)
	{
        $y = 0.5;
        $this->SetXY(-5, 6);
        $this->SetFont('Arial','',8);
        $this->Cell(1,$y,'Fecha:', 0, 0);
        $this->SetFont('Arial','B',8);
        $fecha = explode('-', $model->fecha_captura);
        $dia= substr($fecha[2], 0, 2);
        $hora = explode(' ', $fecha[2]);
        $hora = explode(':', $hora[1]);
        

        $fecha = $dia.'/'.$fecha[1].'/'.$fecha[0].'   '. $hora[0].':'.$hora[1];
        $this->Cell(2,$y,$fecha, 0, 1);
        $this->setX(1);
        $this->SetFont('Arial','B',12);
        $this->SetTextColor(75, 141, 248);
        $this->Cell(10,$y,'Orden de Trabajo', 0, 1);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0, 0, 0); 
        $this->Cell(3,$y,'Folio:', 0, 0);
        $this->SetFont('Arial','B',8);
        $this->Cell(3,$y,$model->id, 0, 1);
        $this->SetFont('Arial','',8);
        $this->Cell(3,$y,'Paciente', 0, 0);
        $this->SetFont('Arial','B',8);
        $this->Cell(10,$y,$model->ordenFacturacion->paciente->obtenerNombreCompleto(), 0, 0);
        $this->setX(-5);
        $this->SetFont('Arial','',8);
        $this->Cell(1,$y,'Sexo:', 0, 0);
        $this->SetFont('Arial','B',8);
        $this->Cell(2,$y,$model->ordenFacturacion->paciente->sexo==0?'Masculino':'Femenino', 0, 1);
        $this->setX(1);
        $this->SetFont('Arial','',8);
        $this->Cell(3,$y,'Médico:', 0, 0);
        $this->SetFont('Arial','B',8);
        if($model->doctor)
            $this->Cell(10,$y,$model->doctor->obtenerNombreCompleto(), 0, 1);
        else
            $this->Cell(10,$y,'Sin Dr. asignado', 0, 1);
        $this->ln(0.5);
        $this->SetFont('Arial','B',12);
        $this->SetTextColor(75, 141, 248);
        $this->Cell(3,$y,'Estudios Solicitados', 0, 1);
        $this->SetTextColor(0, 0, 0); 
        
        
        $this->SetXY(1, 10);
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(75, 141, 248);//Fondo azul de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco
        $x = 2;
        $this->Cell(9,$y, 'Prueba',1, 0 , 'C', true);
        $this->Cell(3.5,$y, 'Resultado',1, 0 , 'C', true);
        $this->Cell(2,$y, 'Unidad',1, 0 , 'C', true);
        $this->Cell(5,$y, 'Rango (Bajo-Prom-Alto)',1, 0 , 'C', true);
         $this->SetFillColor(219,239,253);
        //Atención!! el parámetro true rellena la celda con el color elegido
		//$this->Cell(120,7, utf8_decode("hola mundo"),1, 0 , 'C', true);
		//$this->Cell(20,7, utf8_decode($cabecera[2]),1, 0 , 'C', true);
    }

    function contenido($model){
    	$this->SetTextColor(0, 0, 0); //Letra color blanco
    	$this->SetFont('Arial','',8);
    	$posYOriginal = 7;
    	$posYIncremento = 1.5;
    	$this->setXY(1,10.5);
    	$y = 0.5;
        $ordenTieneExamenes = $model->ordenTieneExamenes;
        $idExamen = 0;
        $totalOrden = 0;
        $duracion = 0;
        foreach ($ordenTieneExamenes as $ordenExamen) {
            $examen = $ordenExamen->detalleExamen->examenes;
            if($examen->id!=$idExamen){
            $this->SetFont('Arial','B',8);


            $this->Cell(19.5,$y, $examen->nombre,1, 1 ,'C', true);                  
            }

        $this->Cell(9,$y,$ordenExamen->detalleExamen->descripcion ,1, 0 , 'C');
        $this->Cell(3.5,$y,$ordenExamen->resultado,1, 0 , 'C');
        $this->Cell(2,$y, $ordenExamen->detalleExamen->unidadesMedida->abreviatura,1, 0 , 'C');
        $rango=$ordenExamen->detalleExamen->rango_inferior.'-'.$ordenExamen->detalleExamen->rango_promedio.'-'.$ordenExamen->detalleExamen->rango_superior;
        $this->Cell(5,$y, $rango,1, 1 , 'C');
            $idExamen = $examen->id;


        }
        
        //Observaciones
        $this->ln(1);
        $this->ln(1);
        $this->SetFont('Arial','B',8);
        $this->Cell(19.5,$y,'RESPONSABLE:', 0, 1, 'C');
        $this->Cell(19.5,$y,'QFB. MARCO ANTONIO URTIS GARCÍA', 0, 1, 'C');
        $this->Cell(19.5,$y,'CED. PROF. 1269174', 0, 1, 'C'); 
        $this->ln(1);
        $this->SetFont('Arial','B',8);
        $fecha = date("d/m/y  H:i");
        $this->Cell(10,$y,'Impresión en Morelia, Mich. a '.$fecha, 0, 1);

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