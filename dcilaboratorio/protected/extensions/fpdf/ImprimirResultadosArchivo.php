<?php
class ImprimirResultadosArchivo extends FPDF{
    public $model;
    public $ordenGrupos = array();
    public $ordenExamenes = array();
    public $examenesImpresos=array();
    public $nivelImpresionSubgrupo=0;
    public $numeroColumna;

    public $limiteY;

    public function init($model){
        $this->model=$model;

        $this->limiteY = $this->h-$this->bMargin-2; //Límite de impresión abajo
        $this->numeroColumna = 1;
        $ordenTieneExamenes = $model->ordenTieneExamenes;
        foreach ($ordenTieneExamenes as $ordenExamen) {
            if($ordenExamen->detalleExamen->activo==1)
                array_push($this->ordenExamenes, $ordenExamen);
        }
        //Para que nos se impriman los grupitos pertenecientes a los grupotes de la orden
        $ordenTieneGrupos = $model->ordenTieneGrupos;
        foreach ($ordenTieneGrupos as $ordenGrupo) {
            $grupitos=GruposPerfiles::model()->findAll("id_grupo_hijo=?",array($ordenGrupo->id_grupos)); 
            if(isset($grupitos)){
                $papaEstaEnLaOrden=false;
                foreach ($grupitos as $grupito) {
                    $papa=OrdenTieneGrupos::model()->find("id_grupos=? AND id_ordenes=?",array($grupito->id_grupo_padre,$model->id));
                    if(isset($papa)){
                        $papaEstaEnLaOrden=true;
                    }
                }
                if(!$papaEstaEnLaOrden){
                    array_push($this->ordenGrupos, $ordenGrupo);
                }
            }else{
                array_push($this->ordenGrupos, $ordenGrupo);
            }
            
        }
        $this->addPage();
    }

    public function posicionarCursor()
    {
        if($this->numeroColumna==1 && $this->y>$this->limiteY){
            $this->numeroColumna = 2;
            $this->SetLeftMargin(11);
            $this->SetY(4.5);
        }
        if($this->numeroColumna==2 && $this->y>$this->limiteY){
            $this->numeroColumna = 1;
            $this->SetLeftMargin(1);
            $this->setY(2);
            $this->addPage();
        }
    }
    
    function imprimirGrupos(){
        foreach ($this->ordenGrupos as $ordenTieneGrupo) {
            $this->imprimirGrupo($ordenTieneGrupo->id_grupos);
        }
    }

    function imprimirGrupo($idGrupo){
        
        $idOrden=$this->model->id;
        $y = 0.5;
        $grupo = Grupos::model()->findByPk($idGrupo);
        

        $perfilDePerfiles = GruposPerfiles::model()->findAll('id_grupo_padre=?', array($idGrupo));
        if(empty($perfilDePerfiles)){
            if(sizeof($this->examenesImpresos)>0){
                // $this->addPage();
                // $this->setXY(1,6);
            }
            $this->SetFillColor(117, 163, 240);
            $this->SetFont('Arial','B',8);
            $this->SetTextColor(0,0,0);
            $this->posicionarCursor();
            $this->Cell(9.71,$y, $grupo->nombre ,1, 1, 'C', true);
            $this->SetFont('Arial','',7.5);

            //IMPRIME NORMALES
            foreach ($grupo->grupoTiene as $grupoExamen) {
                $this->ln($y);
                $this->SetTextColor(0,0,0);
                $this->SetFillColor(117, 163, 240);
                if($grupoExamen->examen->detallesExamenes[0]->tipo=="Normal"){
                    $this->posicionarCursor();
                    $this->Cell(9.71,$y, $grupoExamen->examen->nombre ,1, 1, 'C', true);
                    $this->cabeceraTabla('Normal');
                }
                $agregarAImpresos=false;
                foreach ($grupoExamen->examen->detallesExamenes as $detalleExamen) {
                    if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos)&&$detalleExamen->tipo=="Normal"){
                        $agregarAImpresos=true;
                        $ordenExamen = OrdenTieneExamenes::model()->find('id_ordenes=? AND id_detalles_examen=?', array($this->model->id, $detalleExamen->id));
                        if(isset($ordenExamen)){
                            $rango=$ordenExamen->rango_inferior.'-'.$ordenExamen->rango_promedio.'-'.$ordenExamen->rango_superior;
                            $heightRow = $this->GetMultiCellHeight(2.39,$y, $rango,1, 'C');
                            $heightRowName = $this->GetMultiCellHeight(4.39, $y, $detalleExamen->descripcion, 1 , 'C');
                            $nameBig = false;
                            $esIgual = false;
                            if ($heightRowName > $heightRow) {
                                $heightRow = $heightRowName;
                                $nameBig = true;
                            }
                            if ($heightRowName == $heightRow) {
                                $esIgual = true;
                            }
                            $this->posicionarCursor();
                            $currentX = $this->getX();
                            $currentY = $this->getY();
                            $heightCellName = $y;
                            if(!$nameBig){
                                $heightCellName = $heightRow/$this->obtenerNumeroDeLineas($detalleExamen->descripcion, 30);
                            }
                            if ($esIgual) {
                                $heightCellName = $y;
                            }
                            $this->MultiCell(4.39,$heightCellName,$detalleExamen->descripcion, 'B', 'C');
                            $this->setXY($currentX+4.39, $currentY);
                            
                            $checaColor=substr($ordenExamen->resultado, 0,1);
                            if(!isset($ordenExamen->resultado)||strlen(trim($ordenExamen->resultado))==0){
                                $resultado="s/r";
                            }elseif($checaColor=="*"){//color negro y negritas
                                $resultado=substr($ordenExamen->resultado, 1);
                            }elseif($checaColor=="#"){//color rojo
                                $this->SetFont('Times','BI',8);
                                $this->SetTextColor(255, 0, 0);
                                $resultado=substr($ordenExamen->resultado, 1);
                            }elseif($ordenExamen->resultado > $ordenExamen->rango_superior || $ordenExamen->resultado < $detalleExamen->rango_inferior){
                                $resultado=$ordenExamen->resultado;
                                $this->SetFont('Times','BI',8);
                                $this->SetTextColor(255, 0, 0);
                                 $resultado=$ordenExamen->resultado;
                            }

                            $this->Cell(1.74,$heightRow,$resultado,'B', 0 , 'C');
                            $this->SetTextColor(0, 0, 0);
                            $this->SetFont('Arial','',7.5);
                            $this->Cell(1.19,$heightRow, $detalleExamen->unidadesMedida->abreviatura,'B', 0 , 'C');
                            $heightCellRange = $y;
                            if($nameBig){
                                $heightCellRange = $heightRow/$this->obtenerNumeroDeLineas($rango, 15);
                            }
                            if ($esIgual) {
                                $heightCellRange = $y;
                            }
                            $this->MultiCell(2.39,$heightCellRange, $rango,'B', 'C');
                        }
                    }
                }
                if($agregarAImpresos)
                    array_push($this->examenesImpresos, $detalleExamen->id_examenes);
            }
            $this->imprimirMicroorganismo($idGrupo);
            $this->imprimirAntibioticos($idGrupo);
            $this->imprimirMultirango($idGrupo);

            if($grupo->comentarios!=null && $this->nivelImpresionSubgrupo==0){
                $this->posicionarCursor();
                $this->MultiCell(9.71,$y, 'Método: '.$grupo->comentarios ,1, 'L', false);
            }
            $ordenTieneGrupos = OrdenTieneGrupos::model()->find('id_ordenes=? AND id_grupos=?',array($idOrden,$grupo->id));
            if(isset($ordenTieneGrupos)){
                if($ordenTieneGrupos->comentarios_perfil!=null){
                    $this->posicionarCursor();
                    $this->MultiCell(9.71,$y, 'Comentarios: '.$ordenTieneGrupos->comentarios_perfil ,1, 'L', false);
                }
            }
            
        }else{
            $this->SetFillColor(117, 163, 240);
            $this->SetFont('Arial','B',8);
            $this->SetTextColor(0,0,0);
            $this->posicionarCursor();
            $this->Cell(9.71,$y, $grupo->nombre ,1, 1, 'C', true);
            $this->SetFont('Arial','',7.5);


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
            $contMicroorganismos = Examenes::model()->with(
                                                            array(
                                                                'detallesExamenes'=>array('alias'=>'de','joinType'=>'INNER JOIN','select'=>array()),
                                                                'detallesExamenes.ordenTieneExamenes'=>array('alias'=>'ote','select'=>array(),'joinType'=>'INNER JOIN'),
                                                                'detallesExamenes.ordenTieneExamenes.orden'=>array('alias'=>'o','joinType'=>'INNER JOIN','select'=>array()),
                                                                'detallesExamenes.ordenTieneExamenes.orden.ordenTieneGrupos'=>array('joinType'=>'INNER JOIN','alias'=>'otg','select'=>array()))
                                                        )->count(
                                                            array(
                                                                'select'=>array('t.id'),
                                                                'condition'=>'o.id=? AND de.tipo="Microorganismo" AND otg.id_grupos=?',
                                                                'params'=>array($this->model->id,$grupo->id)
                                                                )
                                                        );
            $contAntibioticos = Examenes::model()->with(
                                                            array(
                                                                'detallesExamenes'=>array('alias'=>'de','joinType'=>'INNER JOIN','select'=>array()),
                                                                'detallesExamenes.ordenTieneExamenes'=>array('alias'=>'ote','select'=>array(),'joinType'=>'INNER JOIN'),
                                                                'detallesExamenes.ordenTieneExamenes.orden'=>array('alias'=>'o','joinType'=>'INNER JOIN','select'=>array()),
                                                                'detallesExamenes.ordenTieneExamenes.orden.ordenTieneGrupos'=>array('joinType'=>'INNER JOIN','alias'=>'otg','select'=>array()))
                                                        )->count(
                                                            array(
                                                                'select'=>array('t.id'),
                                                                'condition'=>'o.id=? AND de.tipo="Antibiótico" AND otg.id_grupos=?',
                                                                'params'=>array($this->model->id,$grupo->id)
                                                                )
                                                        );
            $contMultirangos = Examenes::model()->with(
                                                            array(
                                                                'detallesExamenes'=>array('alias'=>'de','joinType'=>'INNER JOIN','select'=>array()),
                                                                'detallesExamenes.ordenTieneExamenes'=>array('alias'=>'ote','select'=>array(),'joinType'=>'INNER JOIN'),
                                                                'detallesExamenes.ordenTieneExamenes.orden'=>array('alias'=>'o','joinType'=>'INNER JOIN','select'=>array()),
                                                                'detallesExamenes.ordenTieneExamenes.orden.ordenTieneGrupos'=>array('joinType'=>'INNER JOIN','alias'=>'otg','select'=>array()))
                                                        )->count(
                                                            array(
                                                                'select'=>array('t.id'),
                                                                'condition'=>'o.id=? AND de.tipo="Multirango" AND otg.id_grupos=?',
                                                                'params'=>array($this->model->id,$grupo->id)
                                                                )
                                                        );

            $totalExamenesEspeciales=($contMultirangos+$contAntibioticos+$contMicroorganismos);
            if((sizeof($grupo->grupoTiene)-$totalExamenesEspeciales)>sizeof($examenesEnGruposHijo)){
                // $this->addPage();
                // $this->setXY(1,6);
                $this->SetFillColor(117, 163, 240);
                $this->SetFont('Arial','B',8);
                $this->ln($y);
                $this->posicionarCursor();
                $this->Cell(9.71,$y, "OTROS" ,1, 1, 'C', true);
                $this->SetFont('Arial','',7.5);
                foreach ($grupo->grupoTiene as $grupoExamen) {
                    if(!in_array($grupoExamen->examen, $examenesEnGruposHijo) && !in_array($grupoExamen->examen->id, $this->examenesImpresos)){
                        $this->ln($y);
                        $this->SetTextColor(0,0,0);
                        $this->SetFillColor(117, 163, 240);
                        if($grupoExamen->examen->detallesExamenes[0]->tipo=="Normal"){
                            $this->posicionarCursor();
                            $this->Cell(9.71,$y, $grupoExamen->examen->nombre ,1, 1, 'C', true);
                            $this->cabeceraTabla('Normal');
                        }
                        foreach ($grupoExamen->examen->detallesExamenes as $detalleExamen) {
                            $agregarAImpresos=false;
                            if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos)&&$detalleExamen->tipo == "Normal"){
                                $agregarAImpresos=true;
                                $ordenExamen = OrdenTieneExamenes::model()->find('id_ordenes=? AND id_detalles_examen=?', array($this->model->id, $detalleExamen->id));
                                if(isset($ordenExamen)){
                                    $rango=$ordenExamen->rango_inferior.'-'.$ordenExamen->rango_promedio.'-'.$ordenExamen->rango_superior;
                                    $heightRow = $this->GetMultiCellHeight(2.39,$y, $rango,1, 'C');
                                    $heightRowName = $this->GetMultiCellHeight(4.39, $y, $detalleExamen->descripcion, 1 , 'C');
                                    $nameBig = false;
                                    $esIgual = false;
                                    if ($heightRowName > $heightRow) {
                                        $heightRow = $heightRowName;
                                        $nameBig = true;
                                    }
                                    else if($heightRow == $heightRowName){
                                        $esIgual = true;
                                    }

                                    $this->posicionarCursor();
                                    $currentX = $this->getX();
                                    $currentY = $this->getY();
                                    $heightCellName = $y;
                                    if(!$nameBig){
                                        $heightCellName = $heightRow/$this->obtenerNumeroDeLineas($detalleExamen->descripcion, 30);
                                    }
                                    if ($esIgual) {
                                        $heightCellName = $y;
                                    }
                                    $this->MultiCell(4.39,$heightCellName,$detalleExamen->descripcion, 'B', 'C');
                                    $this->setXY($currentX+4.39, $currentY);
                                    
                                    $checaColor=isset($ordenExamen->resultado)?substr($ordenExamen->resultado, 0,1):"";
                                    if(!isset($ordenExamen->resultado)||strlen(trim($ordenExamen->resultado))==0){
                                        $resultado="s/r";
                                    }elseif($checaColor=="*"){//color negro y negritas
                                        $resultado=substr($ordenExamen->resultado, 1);
                                    }elseif($checaColor=="#"){//color rojo
                                        $this->SetFont('Times','BI',8);
                                        $this->SetTextColor(255, 0, 0);
                                        $resultado=substr($ordenExamen->resultado, 1);
                                    }elseif($ordenExamen->resultado > $ordenExamen->rango_superior || $ordenExamen->resultado < $detalleExamen->rango_inferior){
                                        $resultado=$ordenExamen->resultado;
                                        $this->SetFont('Times','BI',8);
                                        $this->SetTextColor(255, 0, 0);
                                    }else{
                                        $resultado=$ordenExamen->resultado;
                                    }
                                    $this->Cell(1.74,$heightRow,$resultado,'B', 0 , 'C');
                                    $this->SetTextColor(0, 0, 0);
                                    $this->SetFont('Arial','',7.5);
                                    $this->Cell(1.19,$heightRow, $detalleExamen->unidadesMedida->abreviatura,'B', 0 , 'C');
                                    $heightCellRange = $y;
                                    if($nameBig){
                                        $heightCellRange = $heightRow/$this->obtenerNumeroDeLineas($rango, 15);
                                    }
                                    if($esIgual){
                                        $heightCellRange = $y;
                                    }
                                    $this->MultiCell(2.39,$heightCellRange, $rango,'B', 'C');
                                }
                            }
                        }
                        if($agregarAImpresos)
                            array_push($this->examenesImpresos, $grupoExamen->examen->id);
                        
                    }
                }
                
            }
            $this->imprimirMicroorganismo($idGrupo);
            $this->imprimirAntibioticos($idGrupo);
            $this->imprimirMultirango($idGrupo);

            if($grupo->comentarios!=null && $this->nivelImpresionSubgrupo==0){
                $this->posicionarCursor();
                $this->MultiCell(9.71,$y, 'Método: '.$grupo->comentarios ,1, 'L', false);
            }
            $ordenTieneGrupos = OrdenTieneGrupos::model()->find('id_ordenes=? AND id_grupos=?',array($idOrden,$grupo->id));

            if(isset($ordenTieneGrupos) && $ordenTieneGrupos->comentarios_perfil!=null && $this->nivelImpresionSubgrupo==0){
                $this->posicionarCursor();
                $this->MultiCell(9.71,$y, 'Comentarios: '.$ordenTieneGrupos->comentarios_perfil ,1, 'L', false);
            }
        }
    
        //imprimirAntibioticos($idGrupo);
    }

    function imprimirAntibioticos($idGrupo=0){

        $anterior=0;
        $detallesExamenDelGrupo=array();
        $orden=$this->model;
        $y=0.5;
        $hayAntibioticos=false;
        $todosLosAntibioticosYaImpresos=true;
        if($idGrupo>0){
            $grupoTiene = Grupos::model()->findByPk($idGrupo)->grupoTiene;
            foreach ($grupoTiene as $grupoExamen) {
                $examen=$grupoExamen->examen;
                foreach ($examen->detallesExamenes as $detalleExamen) {
                    array_push($detallesExamenDelGrupo, $detalleExamen->id);
                    if($detalleExamen->tipo==="Antibiótico"){
                        $hayAntibioticos=true;
                        if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos))
                            $todosLosAntibioticosYaImpresos=false;
                    }
                }
            }
        }else{
            foreach ($orden->ordenTieneExamenes as $ordenTieneExamen) {
                if($ordenTieneExamen->detalleExamen->tipo==="Antibiótico"){
                    $hayAntibioticos=true;
                    if(!in_array($ordenTieneExamen->detalleExamen->id_examenes, $this->examenesImpresos))
                            $todosLosAntibioticosYaImpresos=false;
                }
            }
        }

        if(!$hayAntibioticos){
            return;
        }elseif(sizeof($this->examenesImpresos)>0 && !$todosLosAntibioticosYaImpresos){
            // $this->addPage();
            // $this->setXY(1,6);
        }
        if (sizeof($orden->ordenTieneExamenes)>0) {
            foreach ($orden->ordenTieneExamenes as $ind=>$ordenTieneExamen) {
                //foreach ($ordenTieneExamen->detalleExamen->examenes->detallesExamenes as $detalleExamen) {
                $detalleExamen = $ordenTieneExamen->detalleExamen;

                if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos )&&$detalleExamen->tipo=="Antibiótico" && (in_array($detalleExamen->id, $detallesExamenDelGrupo) || $idGrupo==0)){

                    if($detalleExamen->examenes->id!=$anterior){
                        $this->SetFillColor(117, 163, 240);
                        $this->SetFont('Arial','B',8);
                        $this->SetTextColor(0,0,0);
                        $this->Cell(9.71,$y,$detalleExamen->examenes->nombre,1,1,'C',1);
                        $this->cabeceraTabla("Antibiótico");
                        $this->SetFont('Arial','',7);
                        
                    }
                    $anterior=$detalleExamen->examenes->id;
                    if(isset($orden->ordenTieneExamenes[$ind+1]))
                        $siguiente = $orden->ordenTieneExamenes[$ind+1]->detalleExamen->id_examenes;
                    else
                        $siguiente=0;
                    if($anterior!=$siguiente)
                        array_push($this->examenesImpresos,$detalleExamen->examenes->id);
                    
                    $this->posicionarCursor();
                    $heightRow = $this->GetMultiCellHeight(1,$y, $ordenTieneExamen->rango_inferior,1, 'C');
                    $this->Cell(2.73,$heightRow,$detalleExamen->descripcion ,'B', 0 , 'C');
                    $this->Cell(1.24,$heightRow,$detalleExamen->concentracion ,'B', 0 , 'C');
                    
                    $checaColor=substr($ordenTieneExamen->resultado, 0,1);
                    if(!isset($ordenTieneExamen->resultado)||strlen(trim($ordenTieneExamen->resultado))==0){
                        $resultado="s/r";
                        $interpretacion="s/i";
                    }elseif($checaColor=="*"){//color negro y negritas
                        $resultado=substr($ordenTieneExamen->resultado, 1);
                        $interpretacion=($ordenTieneExamen->interpretacion);
                    }elseif($checaColor=="#"){//color rojo
                        $this->SetFont('Times','BI',7);
                        $this->SetTextColor(255, 0, 0);
                        $resultado=substr($ordenTieneExamen->resultado, 1);
                        $interpretacion=$ordenTieneExamen->interpretacion;
                    }elseif($ordenTieneExamen->resultado > $ordenTieneExamen->rango_superior || $ordenTieneExamen->resultado < $detalleExamen->rango_inferior){
                        $resultado=$ordenTieneExamen->resultado;
                        $interpretacion=$ordenTieneExamen->interpretacion;
                        $this->SetFont('Times','BI',7);
                        $this->SetTextColor(255, 0, 0);
                    }else{
                        $resultado=$ordenTieneExamen->resultado;
                        $interpretacion=$ordenTieneExamen->interpretacion;
                    }

                    $this->Cell(1,$heightRow,$resultado,'B', 0 , 'C');
                    $this->Cell(1.74,$heightRow,$interpretacion,'B', 0 , 'C');
                    $this->SetTextColor(0, 0, 0);
                    $this->SetFont('Arial','',7);
                    $this->Cell(1,$y, $ordenTieneExamen->rango_inferior,'B',0, 'C');
                    $this->Cell(1,$y, $ordenTieneExamen->rango_promedio,'B',0, 'C');
                    $this->Cell(1,$y, $ordenTieneExamen->rango_superior,'B',1, 'C');

                    
                }
            }

        }
    }

    function imprimirMultirango($idGrupo=0){
        $anterior=0;
        $detallesExamenDelGrupo=array();
        $orden = $this->model;
        $y = 0.5;
        $hayMultirangos = false;
        $todosLosMultirangosImpresos = true;

        if($idGrupo>0){
            $grupoTiene = Grupos::model()->findByPk($idGrupo)->grupoTiene;
            foreach ($grupoTiene as $grupoExamen) {
                $examen=$grupoExamen->examen;
                foreach ($examen->detallesExamenes as $detalleExamen) {
                    array_push($detallesExamenDelGrupo, $detalleExamen->id);
                    if($detalleExamen->tipo==="Multirango"){
                        $hayMultirangos=true;
                        if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos))
                            $todosLosMultirangosImpresos=false;
                    }
                }
            }
        }else{
            foreach ($orden->ordenTieneExamenes as $ordenTieneExamen) {
                if($ordenTieneExamen->detalleExamen->tipo==="Multirango"){
                    $hayMultirangos=true;
                    if(!in_array($ordenTieneExamen->detalleExamen->id_examenes, $this->examenesImpresos))
                            $todosLosMultirangosImpresos=false;
                }
            }
        }

        if(!$hayMultirangos){
            return;
        }elseif(sizeof($this->examenesImpresos)>0 && !$todosLosMultirangosImpresos){
            // $this->addPage();
            // $this->setXY(1,6);
        }

        if (sizeof($orden->ordenTieneExamenes)>0) {
            
            foreach ($orden->ordenTieneExamenes as $ind => $ordenTieneExamen) {
                //foreach ($ordenTieneExamen->detalleExamen->examenes->detallesExamenes as $detalleExamen) {
                $detalleExamen = $ordenTieneExamen->detalleExamen;

                if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos)&&$detalleExamen->tipo=="Multirango" && (in_array($detalleExamen->id, $detallesExamenDelGrupo) || $idGrupo == 0)){
                    
                    if($detalleExamen->examenes->id!=$anterior){
                        if ($anterior != 0) {
                            $this->ln($y);
                        }
                        $this->SetFillColor(117, 163, 240);
                        $this->SetFont('Arial','B',8);
                        $this->SetTextColor(0,0,0);
                        $this->Cell(9.71,$y,$detalleExamen->examenes->nombre,1,1,'C',1);
                        $this->cabeceraTabla("Multirango");
                    }

                    $anterior=$detalleExamen->examenes->id;
                    if(isset($orden->ordenTieneExamenes[$ind+1]))
                        $siguiente = $orden->ordenTieneExamenes[$ind+1]->detalleExamen->id_examenes;
                    else
                        $siguiente=0;

                    if($anterior!=$siguiente)
                        array_push($this->examenesImpresos,$detalleExamen->examenes->id);

                    $numeroMultirangos = sizeof($ordenTieneExamen->multirango);
                    $alto = $y * $numeroMultirangos;
                    $this->posicionarCursor();
                    $this->Cell(2.50,$alto,$detalleExamen->descripcion,'B', 0 , 'C');

                    $checaColor=substr($ordenTieneExamen->resultado, 0,1);
                    if(!isset($ordenTieneExamen->resultado)||strlen(trim($ordenTieneExamen->resultado))==0){
                        $resultado="s/r";
                        $interpretacion="s/i";
                    }elseif($checaColor=="*"){//color negro y negritas
                        $resultado=substr($ordenTieneExamen->resultado, 1);
                        $interpretacion=($ordenTieneExamen->interpretacion);
                    }elseif($checaColor=="#"){//color rojo
                        $this->SetFont('Times','BI',8);
                        $this->SetTextColor(255, 0, 0);
                        $resultado=substr($ordenTieneExamen->resultado, 1);
                        $interpretacion=$ordenTieneExamen->interpretacion;
                    }else{
                        $resultado=$ordenTieneExamen->resultado;
                        $interpretacion=$ordenTieneExamen->interpretacion;
                    }
                    $this->Cell(1.99,$alto,$resultado,'B', 0 , 'C');
                    $this->Cell(1.99,$alto,$interpretacion,'B', 0 , 'C');
                    $x_multirango = $this->getX();

                    foreach($ordenTieneExamen->multirango as $ind => $multirango){
                        if ($ind == 0) {
                            $borde = 'LTR';
                        }else if($ind == $numeroMultirangos-1){
                            $borde = 'LBR';
                        }else{
                            $borde = 'LR';
                        }
                        $this->Cell(3.23,$y,$multirango->multirango->nombre.': '.$multirango->rango_inferior." - ".$multirango->rango_superior,'B', 1 , 'C');
                        $this->setX($x_multirango);
                    }
                    $this->setX(1);
                }
            }
        }
    }

    function imprimirMicroorganismo($idGrupo=0){

        $anterior=0;
        $detallesExamenDelGrupo=array();
        $orden=$this->model;
        $y=0.5;
        $hayMicroorganismos=false;
        $todosLosMicroorganismosYaImpresos=true;
        if($idGrupo>0){
            $grupoTiene = Grupos::model()->findByPk($idGrupo)->grupoTiene;
            foreach ($grupoTiene as $grupoExamen) {
                $examen=$grupoExamen->examen;
                foreach ($examen->detallesExamenes as $detalleExamen) {
                    array_push($detallesExamenDelGrupo, $detalleExamen->id);
                    if($detalleExamen->tipo==="Microorganismo"){
                        $hayMicroorganismos=true;
                        if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos))
                            $todosLosMicroorganismosYaImpresos=false;
                    }
                }
            }
        }else{
            foreach ($orden->ordenTieneExamenes as $ordenTieneExamen) {
                if($ordenTieneExamen->detalleExamen->tipo==="Microorganismo"){
                    $hayMicroorganismos=true;
                    if(!in_array($ordenTieneExamen->detalleExamen->id_examenes, $this->examenesImpresos))
                            $todosLosMicroorganismosYaImpresos=false;
                }
            }
        }

        if(!$hayMicroorganismos){
            return;
        }elseif(sizeof($this->examenesImpresos)>0 && !$todosLosMicroorganismosYaImpresos){
            $this->ln($y);
            //$this->addPage();
            //$this->setXY(1,6);
        }
        if (sizeof($orden->ordenTieneExamenes)>0) {
            foreach ($orden->ordenTieneExamenes as $ind=>$ordenTieneExamen) {
                //foreach ($ordenTieneExamen->detalleExamen->examenes->detallesExamenes as $detalleExamen) {
                $detalleExamen = $ordenTieneExamen->detalleExamen;

                if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos )&&$detalleExamen->tipo=="Microorganismo" && (in_array($detalleExamen->id, $detallesExamenDelGrupo) || $idGrupo==0)){

                    if($detalleExamen->examenes->id!=$anterior){
                        $this->SetFillColor(117, 163, 240);
                        $this->SetFont('Arial','B',8);
                        $this->SetTextColor(0,0,0);
                        $this->Cell(9.71,$y,$detalleExamen->examenes->nombre,1,1,'C',1);
                        $this->cabeceraTabla("Microorganismo");
                        
                    }
                    $anterior=$detalleExamen->examenes->id;
                    if(isset($orden->ordenTieneExamenes[$ind+1]))
                        $siguiente = $orden->ordenTieneExamenes[$ind+1]->detalleExamen->id_examenes;
                    else
                        $siguiente=0;
                    if($anterior!=$siguiente)
                        array_push($this->examenesImpresos,$detalleExamen->examenes->id);
                        
                    $this->posicionarCursor();
                    $this->Cell(2.50,$y,$detalleExamen->descripcion ,'B', 0 , 'C');
                    
                    $checaColor=substr($ordenTieneExamen->resultado, 0,1);
                    if(!isset($ordenTieneExamen->resultado)||strlen(trim($ordenTieneExamen->resultado))==0){
                        $resultado="s/r";
                        $desarrollo="s/d";
                        $observaciones="s/o";
                    }elseif($checaColor=="*"){//color negro y negritas
                        $resultado=substr($ordenTieneExamen->resultado, 1);
                        $desarrollo=$ordenTieneExamen->interpretacion;
                        $observaciones=$ordenTieneExamen->comentarios;
                    }elseif($checaColor=="#"){//color rojo
                        $this->SetFont('Times','BI',8);
                        $this->SetTextColor(255, 0, 0);
                        $resultado=substr($ordenTieneExamen->resultado, 1);
                        $desarrollo=$ordenTieneExamen->interpretacion;
                        $observaciones=$ordenTieneExamen->comentarios;
                    }else{
                        $resultado=$ordenTieneExamen->resultado;
                        $desarrollo=$ordenTieneExamen->interpretacion;
                        $observaciones=$ordenTieneExamen->comentarios;
                    }

                    $this->Cell(1.99,$y,$resultado,'B', 0 , 'C');
                    $this->Cell(1.99,$y,$desarrollo,'B', 0 , 'C');
                    $this->Cell(3.23,$y,$observaciones,'B', 1, 'C');
                    $this->SetTextColor(0, 0, 0);
                    $this->SetFont('Arial','',7.5);
                }
            }

        }
    }

	function Header(){
        $this->ln(2);
	}

	function cabeceraHorizontal($model)
	{
        $y = 0.5;
        $this->SetXY(-5, 2);
        $this->SetFont('Arial','',8);
        $this->Cell(1,$y,'Fecha:', 0, 0);
        $this->SetFont('Arial','B',8);
        $fecha = explode('-', $model->fecha_captura);
        $dia= substr($fecha[2], 0, 2);
        $hora = explode(' ', $fecha[2]);
        $hora = explode(':', $hora[1]);


        $fecha = $dia.'/'.$fecha[1].'/'.$fecha[0].'   '. $hora[0].':'.$hora[1];
        $this->Cell(2,$y,$fecha, 0, 1);
        $this->setXY(1,2);
        $this->SetFont('Arial','B',12);
        $this->SetTextColor(75, 141, 248);
        // $this->Cell(10,$y,'Orden de Trabajo', 0, 1);
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(3,$y,'Folio:', 0, 0);
        $this->SetFont('Arial','B',8);
        $this->Cell(3,$y,(isset($model->folio)&&strlen($model->folio)>0)?$model->folio:$model->id, 0, 1);
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
        // $this->Cell(3,$y,'Estudios Solicitados', 0, 1);

        //Atención!! el parámetro true rellena la celda con el color elegido
        //$this->Cell(120,7, utf8_decode("hola mundo"),1, 0 , 'C', true);
        //$this->Cell(20,7, utf8_decode($cabecera[2]),1, 0 , 'C', true);
    }

    function contenidoViejo($model)
    {
        $this->cabeceraHorizontal($model);
    	$this->SetTextColor(0, 0, 0); //Letra color blanco
    	$this->SetFont('Arial','',8);
    	$this->setXY(1,5);
        $y = 0.5;
        $this->limiteY = $this->h-$this->bMargin-4.5; //Límite de impresión abajo
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
                    $papa=OrdenTieneGrupos::model()->find("id_grupos=? AND id_ordenes=?",array($grupito->id_grupo_padre,$model->id));
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
            if($numeroColumna==1 && $this->y>$this->limiteY){
                $numeroColumna = 2;
                $this->SetLeftMargin(11);
                $this->setY(4.5);
                $this->Cell(4.39,$y, 'Determinación Análitica',1, 0 , 'C', true);
                $this->Cell(1.74,$y, 'Resultado',1, 0 , 'C', true);
                $this->Cell(1.19,$y, 'Unidad',1, 0 , 'C', true);
                $this->Cell(2.39,$y, 'Rango Normal',1, 1 , 'C', true);
            }
            if($numeroColumna==2 && $this->y>$this->limiteY){
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
                        $checaColor=substr($ordenExamen->resultado, 0,1);
                        if(!isset($ordenExamen->resultado)||strlen(trim($ordenExamen->resultado))==0){
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
                        }else{
                            $resultado=$ordenExamen->resultado;
                        }

                        $this->Cell(1.74,$heightRow,$resultado,'B', 0 , 'C');
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
        if($numeroColumna==1 && $this->y>$this->limiteY-4.5){
            $numeroColumna = 2;
            $this->SetLeftMargin(11);
            $this->setY(4.5);
        }
        if($numeroColumna==2 && $this->y>$this->limiteY-4.5){
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

    function imprimirGrupoViejo($idGrupo,$idOrden){
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
                            if(!isset($ordenExamen->resultado)||strlen(trim($ordenExamen->resultado))==0){
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
                            }else{
                                $resultado=$ordenExamen->resultado;
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
                                if(!isset($ordenExamen->resultado)||strlen(trim($ordenExamen->resultado))==0){
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
                                }else{
                                    $resultado=$ordenExamen->resultado;
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

    public function cabeceraTabla($tipo){
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial','B',7);
        $this->SetFillColor(75, 141, 248);//Fondo azul de celda
        $y=0.5;
        $this->posicionarCursor();
        switch ($tipo) {
            case 'Normal':
                $this->Cell(4.39,$y, 'Descripción',1, 0 , 'C', true);
                $this->Cell(1.74,$y, 'Resultado',1, 0 , 'C', true);
                $this->Cell(1.19,$y, 'U. medida',1, 0 , 'C', true);
                $this->Cell(2.39,$y, 'Parámetros',1, 1 , 'C', true);
                break;
            case 'Antibiótico':
                $this->SetFont('Arial','B',6);
                $this->Cell(2.73,$y, 'Antibiótico',1, 0 , 'C', true);
                $this->Cell(1.24,$y, 'Conce',1, 0 , 'C', true);
                $this->Cell(1,$y, 'Result',1, 0 , 'C', true);
                $this->Cell(1.74,$y, 'Interpret',1, 0 , 'C', true);
                $this->Cell(1,$y, 'Sens',1, 0 , 'C', true);
                $this->Cell(1,$y, 'Inter',1, 0 , 'C', true);
                $this->Cell(1,$y, 'Resist',1, 1 , 'C', true);
                break;
            case 'Multirango':
                $this->Cell(2.50,$y, 'Parámetro',1, 0 , 'C', true);
                $this->Cell(1.99,$y, 'Resultado',1, 0 , 'C', true);
                $this->Cell(1.99,$y, 'Interpretación',1, 0 , 'C', true);
                $this->Cell(3.23,$y, 'Multirangos',1, 1 , 'C', true);
                break;
            case 'Microorganismo':
                $this->Cell(2.50,$y, 'Parámetro',1, 0 , 'C', true);
                $this->Cell(1.99,$y, 'Resultado',1, 0 , 'C', true);
                $this->Cell(1.99,$y, 'Desarrollo',1, 0 , 'C', true);
                $this->Cell(3.23,$y, 'Observaciones',1, 1 , 'C', true);
                break;
        }
        $this->SetFont('Arial','',7);
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

    public function obtenerNumeroDeLineas($cadena, $caracateresPorLinea)
    {
        $totalCaracateres = strlen($cadena);
        return ceil($totalCaracateres/$caracateresPorLinea);
    }
}