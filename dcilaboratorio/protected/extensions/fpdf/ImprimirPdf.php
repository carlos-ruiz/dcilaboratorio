<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirPdf extends FPDF{
	var $model;

	function Header(){
		$this->SetFont('Arial','B',18);
		$this->Image('/../../../css/layout/img/avatar7.jpg',1,2,10,10);
    // Move to the right
    //$this->Cell(8);
    // Title
		$this->Cell(0,2.54,'DIAGNOSTICO CLÍNICO INTEGRAL',0,0,'C');
		$this->ln(0.75);
		$this->Cell(0,2.54,'KANTOR PERTANAHAN KOTA PEKANBARU',0,0,'C');
		$this->ln(0.75);
		$this->Cell(0,2.54,'PROVINSI RIAU',0,0,'C');
		$this->ln(0.75);
		$this->SetFont('Times','',13);
		$this->Cell(0,2.54,'JALAN PEPAYA NO.47 TELP.(0761)23106-PEKANBARU',0,0,'C');
		$this->ln(0.75);
		$this->Cell(0,2.54,$this->model->fecha_captura,0,0,'C');
		$this->ln(0.75);
		$this->SetLineWidth(0.07);
		$this->line(0.54,5,21,5);       
	}
}