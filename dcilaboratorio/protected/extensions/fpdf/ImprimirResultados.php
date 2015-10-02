<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirResultados extends FPDF{

	function Header(){
        $this->ln(4);
	}

	function cabeceraHorizontal($model)
	{
        $y = 0.5;
        $this->SetXY(-5, 5.1);
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
        $this->setXY(1.5, 4.1);
        // $this->Cell(10,$y,'Resultados de Laboratorio', 0, 1);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(3,$y,'Folio:', 0, 0);
        $this->SetFont('Arial','B',8);
        $this->Cell(3,$y,$model->id, 0, 1);
        $this->setX(1.5);
        $this->SetFont('Arial','',8);
        $this->Cell(3,$y,'Paciente', 0, 0);
        $this->SetFont('Arial','B',8);
        $this->Cell(10,$y,$model->ordenFacturacion->paciente->obtenerNombreCompleto(), 0, 0);
        $this->setX(-5);
        $this->SetFont('Arial','',8);
        $this->Cell(1,$y,'Sexo:', 0, 0);
        $this->SetFont('Arial','B',8);
        $this->Cell(2,$y,$model->ordenFacturacion->paciente->sexo==0?'Masculino':'Femenino', 0, 1);
        $this->setX(1.5);
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
       // $this->Cell(3,$y,'Estudios Solicitados', 0, 1);
        $this->SetTextColor(0, 0, 0);


        $this->SetXY(1, 6.5);
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(75, 141, 248);//Fondo azul de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco
        $x = 2;
        $this->Cell(9,$y, 'Determinación Análitica',1, 0 , 'C', true);
        $this->Cell(3.5,$y, 'Resultado',1, 0 , 'C', true);
        $this->Cell(2,$y, 'Unidad',1, 0 , 'C', true);
        $this->Cell(5,$y, 'Intervalo de Referencia',1, 0 , 'C', true);
        // $this->SetFillColor(219,239,253);
        //Atención!! el parámetro true rellena la celda con el color elegido
		//$this->Cell(120,7, utf8_decode("hola mundo"),1, 0 , 'C', true);
		//$this->Cell(20,7, utf8_decode($cabecera[2]),1, 0 , 'C', true);
    }

    function contenido($model){
        $this->cabeceraHorizontal($model);
    	$this->SetTextColor(0, 0, 0); //Letra color blanco
    	$this->SetFont('Arial','',8);
    	$this->setXY(1,7);
    	$y = 0.5;
        $ordenTieneExamenes = $model->ordenTieneExamenes;
        $idExamen = 0;
        $totalOrden = 0;
        $duracion = 0;
        //examenes de la orden
        $idsExamenes=array();
        foreach ($ordenTieneExamenes as $ordenExamen) {
            array_push($idsExamenes, $ordenExamen->detalleExamen->id_examenes);
        }

        //grupos de la orden
        $grupos = Grupos::model()->findAll();
        $gruposExistentesEnOrden=array();

        $gruposOrdenados=array();
        for($i=0;$i<sizeof($grupos);$i++){
            $cuantosExamenesTiene=sizeof($grupos[$i]->grupoTiene)*100;
            if(!array_key_exists($cuantosExamenesTiene, $gruposOrdenados))
                $gruposOrdenados[$cuantosExamenesTiene]=$grupos[$i];
            else{
                $j=1;
                while(array_key_exists($cuantosExamenesTiene+$j, $gruposOrdenados)){
                    $j++;
                }
                $gruposOrdenados[$cuantosExamenesTiene+$j]=$grupos[$i];
            }

        }
        krsort($gruposOrdenados);
        $grupos=$gruposOrdenados;
        //return;
        //Obtener grupos incluidos en la orden
        foreach ($grupos as $grupo) {
            $examenes=GrupoExamenes::model()->findAll("id_grupos_examenes=?",array($grupo->id));

            $tiene=true;
            // print_r($examenes);return;
            foreach($examenes as $grupoExamen){
                if(!in_array($grupoExamen->id_examenes, $idsExamenes)){
                    $tiene=false;
                    break;
                }
            }
            if($tiene){
             array_push($gruposExistentesEnOrden,$grupo->id);
            }
        }

        $examenesImpresos=array();
        // krsort($gruposExistentesEnOrden);
        // $gruposMayores = array();
        // foreach ($gruposExistentesEnOrden as $grupo) {
        //         foreach ($gruposMayores as $grupoMayor) {
        //             if(Grupos::model()->perfilEsHijoDe($grupo, $grupoMayor) != 1){

        //             }
        //         }
        //     }
        // }
        foreach ($gruposExistentesEnOrden as $grupo) {

            $grupo = Grupos::model()->findByPk($grupo);
            $examenesEnGrupo=GrupoExamenes::model()->findAll('id_grupos_examenes=?',array($grupo->id));
            $examenesIds=array();

            foreach ($examenesEnGrupo as $grupoExamen) {
                array_push($examenesIds, $grupoExamen->id_examenes);
            }
            if(sizeof($idsExamenes)!=sizeof($examenesImpresos)){
                $this->SetFillColor(117, 163, 240);
                $this->Cell(19.5,$y, $grupo->nombre ,1, 1, 'C', true);
            }
            foreach($gruposExistentesEnOrden as $grupoY){
                if($grupoY!=$grupo->id){
                    $examenesEnGrupoY=GrupoExamenes::model()->findAll('id_grupos_examenes=?',array($grupoY));
                    $examenesIdsY=array();
                    foreach ($examenesEnGrupoY as $grupoExamenY) {
                        array_push($examenesIdsY, $grupoExamenY->id_examenes);
                    }
                    if(count(array_intersect($examenesIdsY, $examenesIds)) == count($examenesIdsY)&&sizeof($idsExamenes)!=sizeof($examenesImpresos)){
                        $grupoY=Grupos::model()->findByPk($grupoY);
                        $this->SetFillColor(117, 163, 240);
                        $this->Cell(19.5,$y, $grupoY->nombre ,1, 1, 'C', true);
                    }
                }
            }


            foreach ($ordenTieneExamenes as $ordenExamen) {
                $examen = $ordenExamen->detalleExamen->examenes;
                if(in_array($examen->id, $examenesIds)&&!in_array($examen->id, $examenesImpresos)){
                    //Pintamos el examen
                    array_push($examenesImpresos, $examen->id);
                    if($examen->id!=$idExamen){
                    $this->SetFont('Arial','B',8);
                    $this->SetFillColor(213, 224, 241);
                    $this->Cell(19.5,$y, $examen->tecnica==null?'"'.$examen->nombre.'"':'"'.$examen->nombre.'"  (Técnica empleada: '.$examen->tecnica.')',1, 1 ,'C', true);
                    }

                    $rango=$ordenExamen->detalleExamen->rango_inferior.'-'.$ordenExamen->detalleExamen->rango_promedio.'-'.$ordenExamen->detalleExamen->rango_superior;
                    $heightRow = $this->GetMultiCellHeight(5,$y, $rango,1, 'C');
                    $this->Cell(9,$heightRow,$ordenExamen->detalleExamen->descripcion ,1, 0 , 'C');
                    if($ordenExamen->resultado > $ordenExamen->detalleExamen->rango_superior || $ordenExamen->resultado < $ordenExamen->detalleExamen->rango_inferior){
                        $this->SetFont('Times','BI',8);
                        $this->SetTextColor(255, 0, 0);
                    }
                    $this->Cell(3.5,$heightRow,$ordenExamen->resultado,1, 0 , 'C');
                    $this->SetTextColor(0, 0, 0);
                    $this->SetFont('Arial','B',8);
                    $this->Cell(2,$heightRow, $ordenExamen->detalleExamen->unidadesMedida->abreviatura,1, 0 , 'C');
                    $this->MultiCell(5,$y, $rango,1, 'C');
                }
                $idExamen = $examen->id;
            }
            if($grupo->comentarios!=null){
             $this->Cell(19.5,$y, 'Comentarios: '.$grupo->comentarios ,1, 1, 'L', false);
            }
        }

        if(sizeof($idsExamenes)!=sizeof($examenesImpresos)){
            $this->SetFillColor(117, 163, 240);
            $this->Cell(19.5,$y, "EXÁMENES INDIVIDUALES" ,1, 1, 'C', true);
        }
        $idExamenExiste = 0;
        $examen = null;

        //return;
        foreach ($idsExamenes as $idExamen) {
            if(!in_array($idExamen,$examenesImpresos)){
                $examen=Examenes::model()->findByPk($idExamen);
                if($examen->id!=$idExamenExiste){
                    $this->SetFont('Arial','B',8);
                    $this->SetFillColor(213, 224, 241);
                    $this->Cell(19.5,$y, $examen->tecnica==null?'"'.$examen->nombre.'"':'"'.$examen->nombre.'"  (Técnica empleada: '.$examen->tecnica.')',1, 1 ,'C', true);
                }

                $this->Cell(9,$y,$ordenExamen->detalleExamen->descripcion ,1, 0 , 'C');
                if($ordenExamen->resultado > $ordenExamen->detalleExamen->rango_superior || $ordenExamen->resultado < $ordenExamen->detalleExamen->rango_inferior){
                    $this->SetFont('Times','BI',8);
                    $this->SetTextColor(255, 0, 0);
                }
                $this->Cell(3.5,$y,$ordenExamen->resultado,1, 0 , 'C');
                $this->SetTextColor(0, 0, 0);
                $this->SetFont('Arial','B',8);
                $this->Cell(2,$y, $ordenExamen->detalleExamen->unidadesMedida->abreviatura,1, 0 , 'C');
                $rango=$ordenExamen->detalleExamen->rango_inferior.'-'.$ordenExamen->detalleExamen->rango_promedio.'-'.$ordenExamen->detalleExamen->rango_superior;
                $this->Cell(5,$y, $rango,1, 1 , 'C');
                $idExamenExiste = $examen->id;
            }

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