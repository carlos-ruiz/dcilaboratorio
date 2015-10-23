<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirResultados extends FPDF{
    public $model;
    public $examenesImpresos = array();
    public $nivelImpresionSubgrupo=0;

	function Header(){
        if(Yii::app()->user->getState('perfil')=='Administrador')
            $this->ln(4);
        if(Yii::app()->user->getState('perfil')=='Doctor' || Yii::app()->user->getState('perfil')=='Paciente'){
            $y = 0.5;
            $this->SetFont('Arial','B',18);
            $this->Image(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../css/layout/img/logoNuevo.png',1,1.7,2.3,2.3);
            $this->SetXY(4, .75);
            $this->Cell(0,2.54,'DIAGNOSTICO CLÍNICO INTEGRAL',0,0,'C');
            $this->ln(0.75);
            $this->SetFont('Times','B',8);
            $this->SetXY(4, 2.75);
            $this->Cell(4, $y, 'UNIDAD CHAPULTPEC', 0, 0, 'C');
            $this->Cell(6.9, $y, 'UNIDAD AMADO NERVO', 0, 0, 'C');
            $this->Cell(5, $y, 'UNIDAD DE CANCEROLOGÍA', 0, 1, 'C');
            $this->SetX(4);
            $this->SetFont('Times','',8);
            $y = 0.4;
            $this->Cell(4.3, $y, 'Gnl.Bravo #170', 0, 0, 'C');
            $this->Cell(6.5, $y, 'Amado Nervo #392-A', 0, 0, 'C');
            $this->Cell(5, $y, 'Francisco Madero #145', 0, 1, 'C');
            $this->SetX(4);
            $this->Cell(4.3, $y, 'Col. Chapultepec Nte. C.P. 58260', 0, 0, 'C');
            $this->Cell(6.5, $y, 'Col. Centro', 0, 0, 'C');
            $this->Cell(5, $y, 'Fracc. Ex Gob. Gildardo Magaña', 0, 1, 'C');
            $this->SetX(4);
            $this->Cell(4.3, $y, 'Tel.(443)232-0166', 0, 0, 'C');
            $this->Cell(6.5, $y, 'C.P. 58000', 0, 0, 'C');
            $this->Cell(5, $y, 'C.P. 58149', 0, 1, 'C');
            $this->SetX(4);
            $this->Cell(4.3, $y, 'Lun-Vie 07:00 a 20:00', 0, 0, 'C');
            $this->Cell(6.5, $y, 'Tel.(443)312-3490', 0, 0, 'C');
            $this->Cell(5, $y, 'Tel.(443)232-0165', 0, 1, 'C');
            $this->SetX(4);
            $this->Cell(4.3, $y, 'Domingo 08:00 a 14:00', 0, 0, 'C');
            $this->Cell(6.5, $y, 'Lun-Sab 07:00 a 15:00', 0, 0, 'C');
            $this->Cell(5, $y, 'Lun-Sab 07:00 a 15:00', 0, 1, 'C');
            $this->ln();
        }
	}

	function cabeceraHorizontal($model)
	{
        $y = 0.5;
        $this->SetXY(-5, 5.1);
        if(Yii::app()->user->getState('perfil')=='Doctor' || Yii::app()->user->getState('perfil')=='Paciente'){
            $this->SetXY(-5, 7.1);
        }
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
        if(Yii::app()->user->getState('perfil')=='Doctor' || Yii::app()->user->getState('perfil')=='Paciente'){
            $this->setXY(1.5, 6.1);
        }
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
        if(Yii::app()->user->getState('perfil')=='Doctor' || Yii::app()->user->getState('perfil')=='Paciente'){
            $this->SetXY(1, 8.5);
        }
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
        if(Yii::app()->user->getState('perfil')=='Doctor' || Yii::app()->user->getState('perfil')=='Paciente'){
            $this->setXY(1,9);
        }
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

        //grupos de la orden de acuerdo a los examenes que tiene la orden
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
                $this->nivelImpresionSubgrupo++;
                array_push($gruposExistentesEnOrden,$grupo->id);
                $this->nivelImpresionSubgrupo--;
            }
        }

//        $this->examenesImpresos=array();

        //AQUI VA  A EMPEZAR LA IMPRESION DE RESULTADOS
        $ordenTieneGrupos = OrdenTieneGrupos::model()->findAll('id_ordenes=?',array($model->id));
        $gruposExistentesEnOrden=array();
        foreach ($ordenTieneGrupos as $ordenTieneGrupo) {
            array_push($gruposExistentesEnOrden,$ordenTieneGrupo->id_grupos);
        }

        foreach ($gruposExistentesEnOrden as $grupo) {
            $this->imprimirGrupo($grupo);
        }

/*
        foreach ($gruposExistentesEnOrden as $grupo) {

            $grupo = Grupos::model()->findByPk($grupo);
            $examenesEnGrupo=GrupoExamenes::model()->findAll('id_grupos_examenes=?',array($grupo->id));
            $examenesIds=array();

            foreach ($examenesEnGrupo as $grupoExamen) {
                array_push($examenesIds, $grupoExamen->id_examenes);
            }
            if(sizeof($idsExamenes)!=sizeof($examenesImpresos)){
                $this->SetFillColor(117, 163, 240);
                $ordenTieneGrupo = OrdenTieneGrupos::model()->find("id_ordenes=? AND id_grupos=?", array($model->id, $grupo->id));
                if(isset($ordenTieneGrupo)){
                    $this->Cell(19.5,$y, $grupo->nombre ,1, 1, 'C', true);
                }
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
                        $ordenTieneGrupo = OrdenTieneGrupos::model()->find("id_ordenes=? AND id_grupos=?", array($model->id, $grupoY->id));
                        if(isset($ordenTieneGrupo)){
                            $this->Cell(19.5,$y, $grupoY->nombre ,1, 1, 'C', true);
                        }
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
                    //$this->Cell(19.5,$y, $examen->tecnica==null?'"'.$examen->nombre.'"':'"'.$examen->nombre.'"  (Técnica empleada: '.$examen->tecnica.')',1, 1 ,'C', true);
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
             $this->Cell(19.5,$y, 'Método: '.$grupo->comentarios ,1, 1, 'L', false);
            }this->
        }
*/
        if(sizeof($idsExamenes)!=sizeof($this->examenesImpresos)){
            $this->SetFillColor(117, 163, 240);
            $this->Cell(19.5,$y, "EXÁMENES INDIVIDUALES" ,1, 1, 'C', true);
        }
        $idExamenExiste = 0;
        $examen = null;

        //return;
        foreach ($idsExamenes as $idExamen) {
            if(!in_array($idExamen,$this->examenesImpresos)){
                $examen=Examenes::model()->findByPk($idExamen);
                if($examen->id!=$idExamenExiste){
                    $this->SetFont('Arial','B',8);
                    $this->SetFillColor(213, 224, 241);
                    $this->Cell(19.5,$y, $examen->tecnica==null?'"'.$examen->nombre.'"':'"'.$examen->nombre.'"  (Método empleado: '.$examen->tecnica.')',1, 1 ,'C', true);
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
        $this->ln(1);
        if($model->comentarios_resultados)
            $this->Cell(19.5,$y,"COMENTARIOS: ".$model->comentarios_resultados, 0, 1, 'L');
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

    function imprimirGrupo($idGrupo){
        $y = 0.5;
        $grupo = Grupos::model()->findByPk($idGrupo);
        $this->SetFillColor(117, 163, 240);
        $this->Cell(19.5,$y, $grupo->nombre ,1, 1, 'C', true);
        
        $perfilDePerfiles = GruposPerfiles::model()->findAll('id_grupo_padre=?', array($idGrupo));
        if(empty($perfilDePerfiles)){
            foreach ($grupo->grupoTiene as $grupoExamen) {
                foreach ($grupoExamen->examen->detallesExamenes as $detalleExamen) {
                    if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos)){
                        //Pintamos el examen
                        array_push($this->examenesImpresos, $detalleExamen->id_examenes);
      
                        $rango=$detalleExamen->rango_inferior.'-'.$detalleExamen->rango_promedio.'-'.$detalleExamen->rango_superior;
                        $heightRow = $this->GetMultiCellHeight(5,$y, $rango,1, 'C');
                        $this->Cell(9,$heightRow,$detalleExamen->descripcion ,1, 0 , 'C');
                        $ordenExamen = OrdenTieneExamenes::model()->find('id_ordenes=? AND id_detalles_examen=?', array($this->model->id, $detalleExamen->id));
                        if($ordenExamen->resultado > $detalleExamen->rango_superior || $ordenExamen->resultado < $detalleExamen->rango_inferior){
                            $this->SetFont('Times','BI',8);
                            $this->SetTextColor(255, 0, 0);
                        }
                        $this->Cell(3.5,$heightRow,$ordenExamen->resultado,1, 0 , 'C');
                        $this->SetTextColor(0, 0, 0);
                        $this->SetFont('Arial','B',8);
                        $this->Cell(2,$heightRow, $detalleExamen->unidadesMedida->abreviatura,1, 0 , 'C');
                        $this->MultiCell(5,$y, $rango,1, 'C');
                    }
                }
            }
            if($grupo->comentarios!=null && $this->nivelImpresionSubgrupo==0){
                $this->Cell(19.5,$y, 'Método: '.$grupo->comentarios ,1, 1, 'L', false);
            }
        }else{
            $hijos = GruposPerfiles::model()->findAll('id_grupo_padre=?', array($idGrupo));
            
            foreach ($hijos as $grupoHijo) {
                $this->nivelImpresionSubgrupo++;
                $this->imprimirGrupo($grupoHijo->id_grupo_hijo);
                $this->nivelImpresionSubgrupo--;
            }

            $examenesEnGruposHijo=array();
            foreach ($hijos as $grupoHijo) {
                $grupoExamenes=GrupoExamenes::model()->findAll('id_grupos_examenes=?',array($grupoHijo->id_grupo_hijo));
                foreach ($grupoExamenes as $grupoExamen) {
                    array_push($examenesEnGruposHijo, $grupoExamen->examen);
                }
            }
            if(sizeof($grupo->grupoTiene)>sizeof($examenesEnGruposHijo)){
                $this->SetFillColor(117, 163, 240);
                $this->Cell(19.5,$y, "OTROS" ,1, 1, 'C', true);
                foreach ($grupo->grupoTiene as $grupoExamen) {
                    if(!in_array($grupoExamen->examen, $examenesEnGruposHijo) && !in_array($grupoExamen->examen->id, $this->examenesImpresos)){
                        
                        array_push($this->examenesImpresos, $grupoExamen->examen->id);
                        foreach ($grupoExamen->examen->detallesExamenes as $detalleExamen) {                        
                            $rango=$detalleExamen->rango_inferior.'-'.$detalleExamen->rango_promedio.'-'.$detalleExamen->rango_superior;
                            $heightRow = $this->GetMultiCellHeight(5,$y, $rango,1, 'C');
                            $this->Cell(9,$heightRow,$detalleExamen->descripcion ,1, 0 , 'C');
                            $ordenExamen = OrdenTieneExamenes::model()->find('id_ordenes=? AND id_detalles_examen=?', array($this->model->id, $detalleExamen->id));
                            if($ordenExamen->resultado > $detalleExamen->rango_superior || $ordenExamen->resultado < $detalleExamen->rango_inferior){
                                $this->SetFont('Times','BI',8);
                                $this->SetTextColor(255, 0, 0);
                            }
                            $this->Cell(3.5,$heightRow,$ordenExamen->resultado,1, 0 , 'C');
                            $this->SetTextColor(0, 0, 0);
                            $this->SetFont('Arial','B',8);
                            $this->Cell(2,$heightRow, $detalleExamen->unidadesMedida->abreviatura,1, 0 , 'C');
                            $this->MultiCell(5,$y, $rango,1, 'C');
                        }
                    }
                }
            }
            if($grupo->comentarios!=null && $this->nivelImpresionSubgrupo==0){
                $this->Cell(19.5,$y, 'Método: '.$grupo->comentarios ,1, 1, 'L', false);
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