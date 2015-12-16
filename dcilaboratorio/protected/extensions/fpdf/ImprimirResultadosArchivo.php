<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirResultadosArchivo extends FPDF{

    public $model;
    public $examenesImpresos = array();
    public $nivelImpresionSubgrupo=0;

	function Header(){
        $this->ln(2);
	}

	function cabeceraHorizontal($model)
	{
        $y = 0.5;
        $this->SetXY(-5, 3.1);
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
        $this->setXY(1.5, 2.1);

        // $this->Cell(10,$y,'Resultados de Laboratorio', 0, 1);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(3,$y,'Folio:', 0, 0);
        $this->SetFont('Arial','B',8);
        $this->Cell(3,$y,(isset($model->folio)&&strlen($model->folio)>0)?$model->folio:$model->id, 0, 1);
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


        $this->SetXY(1, 4.5);

        $this->SetFont('Arial','B',8);
        $this->SetFillColor(75, 141, 248);//Fondo azul de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco
        $x = 2;
        $this->Cell(4.39,$y, 'Determinación Análitica',1, 0 , 'C', true);
        $this->Cell(1.74,$y, 'Resultado',1, 0 , 'C', true);
        $this->Cell(1.19,$y, 'Unidad',1, 0 , 'C', true);
        $this->Cell(2.39,$y, 'Rango Normal',1, 0 , 'C', true);
        // $this->SetFillColor(219,239,253);
        //Atención!! el parámetro true rellena la celda con el color elegido
		//$this->Cell(120,7, utf8_decode("hola mundo"),1, 0 , 'C', true);
		//$this->Cell(20,7, utf8_decode($cabecera[2]),1, 0 , 'C', true);
    }

    function contenido($model){
        $this->cabeceraHorizontal($model);
    	$this->SetTextColor(0, 0, 0); //Letra color blanco
    	$this->SetFont('Arial','',8);
    	$this->setXY(1,5);
        $y = 0.5;
        $limiteY = $this->h-$this->bMargin-4.5; //Límite de impresión abajo
        $numeroColumna = 1;
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

        //$this->examenesImpresos=array();
        $ordenTieneGrupos = OrdenTieneGrupos::model()->findAll('id_ordenes=?',array($model->id));
        $gruposExistentesEnOrden=array();
        foreach ($ordenTieneGrupos as $ordenGrupo) {
            $grupitos=GruposPerfiles::model()->findAll("id_grupo_hijo=?",array($ordenGrupo->id_grupos)); 
            if(isset($grupitos)){
                $papaEstaEnLaOrden=false;
                foreach ($grupitos as $grupito) {
                    $papa=OrdenTieneGrupos::model()->find("id_grupos=?",array($grupito->id_grupo_padre));
                    if(isset($papa)){
                        $papaEstaEnLaOrden=true;
                    }
                }
                if(!$papaEstaEnLaOrden){
                    array_push($gruposExistentesEnOrden, $ordenGrupo->id_grupos);
                }
            }else{
                array_push($gruposExistentesEnOrden, $ordenGrupo->id_grupos);
            }
        }

        foreach ($gruposExistentesEnOrden as $grupo) {
            $this->imprimirGrupo($grupo,$model->id);
        }

        if(sizeof($idsExamenes)!=sizeof($this->examenesImpresos)){
            //$this->SetFillColor(117, 163, 240);
            //$this->Cell(9.71,$y, "EXÁMENES INDIVIDUALES" ,1, 1, 'C', true);
        }
        $idExamenExiste = 0;
        $examen = null;

        //return;
        foreach ($idsExamenes as $idExamen) {
            if($numeroColumna==1 && $this->y>$limiteY){
                $numeroColumna = 2;
                $this->SetLeftMargin(11);
                $this->setY(4.5);
                $this->Cell(4.39,$y, 'Determinación Análitica',1, 0 , 'C', true);
                $this->Cell(1.74,$y, 'Resultado',1, 0 , 'C', true);
                $this->Cell(1.19,$y, 'Unidad',1, 0 , 'C', true);
                $this->Cell(2.39,$y, 'Rango Normal',1, 1 , 'C', true);
            }
            if($numeroColumna==2 && $this->y>$limiteY){
                $numeroColumna = 1;
                $this->Cell(4.39,$y, '',0, 0 , 'C', false);
                $this->SetLeftMargin(1);
                $this->setY(2);
                $this->Cell(4.39,$y, 'Determinación Análitica',1, 0 , 'C', true);
                $this->Cell(1.74,$y, 'Resultado',1, 0 , 'C', true);
                $this->Cell(1.19,$y, 'Unidad',1, 0 , 'C', true);
                $this->Cell(2.39,$y, 'Rango Normal',1, 1 , 'C', true);
            }
            if(!in_array($idExamen,$this->examenesImpresos)){
                $examen=Examenes::model()->findByPk($idExamen);
                /*if($examen->id!=$idExamenExiste){
                    $this->SetFont('Arial','B',8);
                    $this->SetFillColor(213, 224, 241);
                    $this->Cell(9.71,$y, $examen->tecnica==null?'"'.$examen->nombre.'"':'"'.$examen->nombre.'"  (Técnica empleada: '.$examen->tecnica.')',1, 1 ,'C', true);
                }*/
                foreach ($examen->detallesExamenes as $detalleExamen) {
                    
                    $ordenExamen=OrdenTieneExamenes::model()->find("id_detalles_examen=? AND id_ordenes=?",array($detalleExamen->id,$model->id));
                    if(isset($ordenExamen)){
                        $rango=$ordenExamen->detalleExamen->rango_inferior.'-'.$ordenExamen->detalleExamen->rango_promedio.'-'.$ordenExamen->detalleExamen->rango_superior;
                        $heightRow = $this->GetMultiCellHeight(4.39,$y,$ordenExamen->detalleExamen->descripcion,1, 'C');
                        $heightRowRango = $this->GetMultiCellHeight(2.39,$y,$rango,1, 'C');
                        $rangoMasAlto=$heightRow>$heightRowRango?false:true;
                        $heightRow=$heightRow>$heightRowRango?$heightRow:$heightRowRango;

                        if($rangoMasAlto)
                            $this->Cell(4.39,$heightRow,$ordenExamen->detalleExamen->descripcion ,'B', 0 , 'C');
                        else{
                            $xActual=$this->x;
                            $this->MultiCell(4.39,$y,$ordenExamen->detalleExamen->descripcion , 'B' , 'C');
                            $this->setXY($xActual+4.39,$this->y-$heightRow);
                        }
                        if($ordenExamen->resultado > $ordenExamen->detalleExamen->rango_superior || $ordenExamen->resultado < $ordenExamen->detalleExamen->rango_inferior){
                            $this->SetFont('Times','BI',8);
                            $this->SetTextColor(255, 0, 0);
                        }
                        $this->Cell(1.74,$heightRow,$ordenExamen->resultado,'B', 0 , 'C');
                        $this->SetTextColor(0, 0, 0);
                        $this->SetFont('Arial','B',8);
                        $this->Cell(1.19,$heightRow, $ordenExamen->detalleExamen->unidadesMedida->abreviatura,'B', 0 , 'C');
                        if(!$rangoMasAlto)
                            $this->Cell(2.39,$heightRow,$rango ,'B', 1 , 'C');
                        else{
                            //$xActual=$this->x;
                            $this->MultiCell(2.39,$y, $rango,'B', 'C');
                            //$this->setXY($xActual+4.39,$this->y-$heightRow);
                        }

                        //$this->Cell(2.39,$y, $rango,1, 1 , 'C');
                        $idExamenExiste = $examen->id;
                    }
                }
                if($examen->tecnica!=null){
                    //$this->SetFont('Arial','',7.5);
                    $this->MultiCell(9.71,$y, 'Método: '.$examen->tecnica,'B', 'L', false);
                }
            }

        }

        //Observaciones
        if($numeroColumna==1 && $this->y>$limiteY-4.5){
            $numeroColumna = 2;
            $this->SetLeftMargin(11);
            $this->setY(4.5);
        }
        if($numeroColumna==2 && $this->y>$limiteY-4.5){
            $numeroColumna = 1;
            $this->Cell(4.39,5, '',0, 0 , 'C', false);
            $this->SetLeftMargin(1);
            $this->setY(4.5);
        }

        if($model->comentarios_resultados)
            $this->MultiCell(9.71,$y,"COMENTARIOS: ".$model->comentarios_resultados, 0,'L' );

        // $this->ln(1);
        // $this->ln(1);
        // $this->SetFont('Arial','B',8);
        // $this->Cell(9.71,$y,'RESPONSABLE:', 0, 1, 'C');
        // $this->Cell(9.71,$y,'QFB. MARCO ANTONIO URTIS GARCÍA', 0, 1, 'C');
        // $this->Cell(9.71,$y,'CED. PROF. 1269174', 0, 1, 'C');
        $this->ln(1);
        $this->SetFont('Arial','B',8);
        $fecha = date("d/m/y  H:i");
        $this->Cell(10,$y,'Impresión en Morelia, Mich. a '.$fecha, 0, 1);

    }

    function imprimirGrupo($idGrupo,$idOrden){
        $y = 0.5;
        $grupo = Grupos::model()->findByPk($idGrupo);
        $this->SetFillColor(117, 163, 240);
        $this->SetFont('Arial','B',8);
        $this->Cell(9.71,$y, $grupo->nombre ,1, 1, 'C', true);
        
        $perfilDePerfiles = GruposPerfiles::model()->findAll('id_grupo_padre=?', array($idGrupo));
        if(empty($perfilDePerfiles)){
            foreach ($grupo->grupoTiene as $grupoExamen) {
                foreach ($grupoExamen->examen->detallesExamenes as $detalleExamen) {
                    
                    if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos)){
                        //Pintamos el examen
                        array_push($this->examenesImpresos, $detalleExamen->id_examenes);
                        $ordenExamen = OrdenTieneExamenes::model()->find('id_ordenes=? AND id_detalles_examen=?', array($this->model->id, $detalleExamen->id));
                        if(isset($ordenExamen)){
                            $rango=$detalleExamen->rango_inferior.'-'.$detalleExamen->rango_promedio.'-'.$detalleExamen->rango_superior;
                            $heightRow = $this->GetMultiCellHeight(4.39,$y, $rango,1, 'C');
                            $heightRowRango = $this->GetMultiCellHeight(2.39,$y,$rango,1, 'C');
                            $rangoMasAlto=$heightRow>$heightRowRango?false:true;
                            $heightRow=$heightRow>$heightRowRango?$heightRow:$heightRowRango;

                            if(!$rangoMasAlto)
                                $this->Cell(4.39,$heightRow,$detalleExamen->descripcion ,'B', 0 , 'C');
                            else{
                                $xActual=$this->x;
                                $this->MultiCell(4.39,$y,$detalleExamen->descripcion , 'B' , 'C');
                                $this->setXY($xActual+4.39,$this->y-$heightRow);
                            }
                            

                            
                            $checaColor=substr($ordenExamen->resultado, 0,1);
                            if(!isset($ordenExamen->resultado)){
                                $resultado=$ordenExamen->resultado;
                            }elseif($checaColor=="*"){//color negro y negritas
                                $resultado=substr($ordenExamen->resultado, 1);
                            }elseif($checaColor=="#"){//color rojo
                                $this->SetFont('Times','BI',8);
                                $this->SetTextColor(255, 0, 0);
                                $resultado=substr($ordenExamen->resultado, 1);
                            }elseif($ordenExamen->resultado > $detalleExamen->rango_superior || $ordenExamen->resultado < $detalleExamen->rango_inferior){
                                $resultado=$ordenExamen->resultado;
                                $this->SetFont('Times','BI',8);
                                $this->SetTextColor(255, 0, 0);
                            }
                            $this->Cell(1.74,$heightRow,$resultado,'B', 0 , 'C');
                            $this->SetTextColor(0, 0, 0);
                            $this->SetFont('Arial','B',8);
                            $this->Cell(1.19,$heightRow, $detalleExamen->unidadesMedida->abreviatura,'B', 0 , 'C');
                            if($rangoMasAlto)
                                $this->Cell(2.39,$heightRow,$rango ,'B', 1 , 'C');
                            else{
                                //$xActual=$this->x;
                                $this->MultiCell(2.39,$y, $rango,'B', 'C');
                                //$this->setXY($xActual+4.39,$this->y-$heightRow);
                            }

                        }
                    }
                }
            }
            if($grupo->comentarios!=null && $this->nivelImpresionSubgrupo==0){
                $this->MultiCell(9.71,$y, 'Método: '.$grupo->comentarios ,'B', 'L', false);
            }
            $ordenTieneGrupos = OrdenTieneGrupos::model()->find('id_ordenes=? AND id_grupos=?',array($idOrden,$grupo->id));
            if($ordenTieneGrupos->comentarios_perfil!=null){
                $this->MultiCell(9.71,$y, 'Comentarios: '.$ordenTieneGrupos->comentarios_perfil ,'B', 'L', false);
            }
        }else{
            $hijos = GruposPerfiles::model()->findAll('id_grupo_padre=?', array($idGrupo));
            
            foreach ($hijos as $grupoHijo) {
                $this->nivelImpresionSubgrupo++;
                $this->imprimirGrupo($grupoHijo->id_grupo_hijo,$idOrden);
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
                $this->Cell(9.71,$y, "OTROS" ,1, 1, 'C', true);
                foreach ($grupo->grupoTiene as $grupoExamen) {
                    if(!in_array($grupoExamen->examen, $examenesEnGruposHijo) && !in_array($grupoExamen->examen->id, $this->examenesImpresos)){
                        
                        array_push($this->examenesImpresos, $grupoExamen->examen->id);
                        foreach ($grupoExamen->examen->detallesExamenes as $detalleExamen) {                        
                            
                            $ordenExamen = OrdenTieneExamenes::model()->find('id_ordenes=? AND id_detalles_examen=?', array($this->model->id, $detalleExamen->id));
                            if(isset($ordenExamen)){
                                $rango=$detalleExamen->rango_inferior.'-'.$detalleExamen->rango_promedio.'-'.$detalleExamen->rango_superior;
                                $heightRow = $this->GetMultiCellHeight(4.39,$y, $rango,1, 'C');
                                $heightRowRango = $this->GetMultiCellHeight(2.39,$y,$rango,1, 'C');
                                $rangoMasAlto=$heightRow>$heightRowRango?false:true;
                                $heightRow=$heightRow>$heightRowRango?$heightRow:$heightRowRango;
                                $this->SetFont('Arial','B',8);
                                if($rangoMasAlto)
                                    $this->Cell(4.39,$heightRow,$detalleExamen->descripcion ,'B', 0 , 'C');
                                else{
                                    $xActual=$this->x;
                                    $this->MultiCell(4.39,$y,$detalleExamen->descripcion , 'B' , 'C');
                                    $this->setXY($xActual+4.39,$this->y-$heightRow);
                                }
                                
                                $checaColor=substr($ordenExamen->resultado, 0,1);
                                if(!isset($ordenExamen->resultado)){
                                    $resultado="s/r";
                                }elseif($checaColor=="*"){//color negro y negritas
                                    $resultado=substr($ordenExamen->resultado, 1);
                                }elseif($checaColor=="#"){//color rojo
                                    $this->SetFont('Times','BI',8);
                                    $this->SetTextColor(255, 0, 0);
                                    $resultado=substr($ordenExamen->resultado, 1);
                                }elseif($ordenExamen->resultado > $detalleExamen->rango_superior || $ordenExamen->resultado < $detalleExamen->rango_inferior){
                                    $resultado=$ordenExamen->resultado;
                                    $this->SetFont('Times','BI',8);
                                    $this->SetTextColor(255, 0, 0);
                                }
                          
                                $this->Cell(1.74,$heightRow,$resultado,'B', 0 , 'C');
                                $this->SetTextColor(0, 0, 0);
                                $this->SetFont('Arial','B',8);
                                $this->Cell(1.19,$heightRow, $detalleExamen->unidadesMedida->abreviatura,'B', 0 , 'C');
                                if(!$rangoMasAlto)
                                    $this->Cell(2.39,$heightRow,$rango ,'B', 1 , 'C');
                                else{
                                    //$xActual=$this->x;
                                    $this->MultiCell(2.39,$y, $rango,'B', 'C');
                                    //$this->setXY($xActual+4.39,$this->y-$heightRow);
                                }
                            }
                        }
                    }
                }
            }
            if($grupo->comentarios!=null && $this->nivelImpresionSubgrupo==0){
                $this->MultiCell(9.71,$y, 'Método: '.$grupo->comentarios ,'B', 'L', false);
            }
            $ordenTieneGrupos = OrdenTieneGrupos::model()->find('id_ordenes=? AND id_grupos=?',array($idOrden,$grupo->id));
            if($ordenTieneGrupos->comentarios_perfil!=null){
                $this->MultiCell(9.71,$y, 'Comentarios: '.$ordenTieneGrupos->comentarios_perfil ,'B', 'L', false);
            }
        }
    }

    function Footer()
	{
	    $this->SetXY(1,-4);
    //Arial italic 8
    $y=0.5;
    $this->SetFont('Arial','B',8);
    $this->Cell(0,$y,'RESPONSABLE:', 0, 1, 'C');
    $this->setX(1);
    $this->Cell(0,$y,'QFB. MARCO ANTONIO URTIS GARCÍA', 0, 1, 'C');
    $this->setX(1);
    $this->Cell(0,$y,'CED. PROF. 1269174', 0, 1, 'C');
    $this->SetFont('Arial','I',8);
    //Page number
    $this->setX(1);
    $this->Cell(0,$y*4,'Página '.$this->PageNo(),0,0,'C');
	}
}