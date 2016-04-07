<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirResultadosEmail extends FPDF{

    public $model;
    public $ordenGrupos = array();
    public $ordenExamenes = array();
    public $examenesImpresos=array();
    public $nivelImpresionSubgrupo=0;

    public function init($model){
        $this->model=$model;

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
                $this->addPage();
                $this->setXY(1,6);
            }
            $this->SetFillColor(117, 163, 240);
            $this->SetFont('Arial','B',8);
            $this->SetTextColor(0,0,0);
            $this->Cell(19.5,$y, $grupo->nombre ,1, 1, 'C', true);
            $this->SetFont('Arial','',7.5);

            //IMPRIME NORMALES
            foreach ($grupo->grupoTiene as $grupoExamen) {
                $this->ln($y);
                $this->SetTextColor(0,0,0);
                $this->SetFillColor(117, 163, 240);
                if($grupoExamen->examen->detallesExamenes[0]->tipo=="Normal"){
                    $this->Cell(19.5,$y, $grupoExamen->examen->nombre ,1, 1, 'C', true);
                    $this->cabeceraTabla('Normal');
                }
                //CONFIGURA TEST DE LOS NORMALES
                $agregarAImpresos=false;
                foreach ($grupoExamen->examen->detallesExamenes as $detalleExamen) {
                    if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos)&&$detalleExamen->tipo=="Normal"){
                        $agregarAImpresos=true;
                        $ordenExamen = OrdenTieneExamenes::model()->find('id_ordenes=? AND id_detalles_examen=?', array($this->model->id, $detalleExamen->id));
                        if(isset($ordenExamen)){
                            $rango=$ordenExamen->rango_inferior.'-'.$ordenExamen->rango_promedio.'-'.$ordenExamen->rango_superior;
                            $heightRow = $this->GetMultiCellHeight(5,$y, $rango,1, 'C');
                            $this->Cell(9,$heightRow,$detalleExamen->descripcion ,1, 0 , 'C');
                            
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

                            $this->Cell(3.5,$heightRow,$resultado,1, 0 , 'C');
                            $this->SetTextColor(0, 0, 0);
                            $this->SetFont('Arial','',7.5);
                            $this->Cell(2,$heightRow, $detalleExamen->unidadesMedida->abreviatura,1, 0 , 'C');
                            $this->MultiCell(5,$y, $rango,1, 'C');
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
                $this->MultiCell(19.5,$y, 'Método: '.$grupo->comentarios ,1, 'L', false);
            }
            $ordenTieneGrupos = OrdenTieneGrupos::model()->find('id_ordenes=? AND id_grupos=?',array($idOrden,$grupo->id));
            if(isset($ordenTieneGrupos)){
                if($ordenTieneGrupos->comentarios_perfil!=null){
                    $this->MultiCell(19.5,$y, 'Comentarios: '.$ordenTieneGrupos->comentarios_perfil ,1, 'L', false);
                }
            }
            
        }else{
            $this->SetFillColor(117, 163, 240);
            $this->SetFont('Arial','B',8);
            $this->SetTextColor(0,0,0);
            $this->Cell(19.5,$y, $grupo->nombre ,1, 1, 'C', true);
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
                $this->addPage();
                $this->setXY(1,6);
                $this->SetFillColor(117, 163, 240);
                $this->SetFont('Arial','B',8);
                $this->ln($y);
                $this->Cell(19.5,$y, "OTROS" ,1, 1, 'C', true);
                $this->SetFont('Arial','',7.5);
                foreach ($grupo->grupoTiene as $grupoExamen) {
                    if(!in_array($grupoExamen->examen, $examenesEnGruposHijo) && !in_array($grupoExamen->examen->id, $this->examenesImpresos)){
                        $this->ln($y);
                        $this->SetTextColor(0,0,0);
                        $this->SetFillColor(117, 163, 240);
                        if($grupoExamen->examen->detallesExamenes[0]->tipo=="Normal"){
                            $this->Cell(19.5,$y, $grupoExamen->examen->nombre ,1, 1, 'C', true);
                            $this->cabeceraTabla('Normal');
                        }
                        foreach ($grupoExamen->examen->detallesExamenes as $detalleExamen) {
                            $agregarAImpresos=false;
                            if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos)&&$detalleExamen->tipo == "Normal"){
                                $agregarAImpresos=true;
                                $ordenExamen = OrdenTieneExamenes::model()->find('id_ordenes=? AND id_detalles_examen=?', array($this->model->id, $detalleExamen->id));
                                if(isset($ordenExamen)){
                                    $rango=$ordenExamen->rango_inferior.'-'.$ordenExamen->rango_promedio.'-'.$ordenExamen->rango_superior;
                                    $heightRow = $this->GetMultiCellHeight(5,$y, $rango,1, 'C');
                                    $this->Cell(9,$heightRow,$detalleExamen->descripcion ,1, 0 , 'C');
                                    
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
                                    $this->Cell(3.5,$heightRow,$resultado,1, 0 , 'C');
                                    $this->SetTextColor(0, 0, 0);
                                    $this->SetFont('Arial','',7.5);
                                    $this->Cell(2,$heightRow, $detalleExamen->unidadesMedida->abreviatura,1, 0 , 'C');
                                    $this->MultiCell(5,$y, $rango,1, 'C');
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
                $this->ln();
                $this->MultiCell(19.5,$y, 'Método de '.$grupo->nombre.': '.$grupo->comentarios ,1, 'L', false);
            }
            $ordenTieneGrupos = OrdenTieneGrupos::model()->find('id_ordenes=? AND id_grupos=?',array($idOrden,$grupo->id));

            if(isset($ordenTieneGrupos) && $ordenTieneGrupos->comentarios_perfil!=null && $this->nivelImpresionSubgrupo==0){
                $this->MultiCell(19.5,$y, 'Comentarios: '.$ordenTieneGrupos->comentarios_perfil ,1, 'L', false);
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
            $this->addPage();
            $this->setXY(1,6);
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
                        $this->Cell(12,$y,$detalleExamen->examenes->nombre,'LT',0,'C',1);
                        $this->Cell(7.5,$y,'Fecha Resultado:'.$this->obtenerFecha($ordenTieneExamen->ultima_edicion),'TR',1,'C',1);
                        $this->Cell(19.5,$y,$detalleExamen->examenes->nombre,1,1,'C',1);
                        $this->cabeceraTabla("Antibiótico");
                        
                    }
                    $anterior=$detalleExamen->examenes->id;
                    if(isset($orden->ordenTieneExamenes[$ind+1]))
                        $siguiente = $orden->ordenTieneExamenes[$ind+1]->detalleExamen->id_examenes;
                    else
                        $siguiente=0;
                    if($anterior!=$siguiente)
                        array_push($this->examenesImpresos,$detalleExamen->examenes->id);
                        
                    $heightRow = $this->GetMultiCellHeight(5,$y, $ordenTieneExamen->rango_inferior,1, 'C');
                    $this->Cell(5.5,$heightRow,$detalleExamen->descripcion ,1, 0 , 'C');
                    $this->Cell(2.5,$heightRow,$detalleExamen->concentracion ,1, 0 , 'C');
                    
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
                    }elseif($ordenTieneExamen->resultado > $ordenTieneExamen->rango_superior || $ordenTieneExamen->resultado < $detalleExamen->rango_inferior){
                        $resultado=$ordenTieneExamen->resultado;
                        $interpretacion=$ordenTieneExamen->interpretacion;
                        $this->SetFont('Times','BI',8);
                        $this->SetTextColor(255, 0, 0);
                    }else{
                        $resultado=$ordenTieneExamen->resultado;
                        $interpretacion=$ordenTieneExamen->interpretacion;
                    }

                    $this->Cell(2,$heightRow,$resultado,1, 0 , 'C');
                    $this->Cell(3.5,$heightRow,$interpretacion,1, 0 , 'C');
                    $this->SetTextColor(0, 0, 0);
                    $this->SetFont('Arial','',7.5);
                    $this->Cell(2,$y, $ordenTieneExamen->rango_inferior,1,0, 'C');
                    $this->Cell(2,$y, $ordenTieneExamen->rango_promedio,1,0, 'C');
                    $this->Cell(2,$y, $ordenTieneExamen->rango_superior,1,1, 'C');

                    
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
            $this->addPage();
            $this->setXY(1,6);
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
                        $this->Cell(19.5,$y,$detalleExamen->examenes->nombre,1,1,'C',1);
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
                    $this->Cell(5,$alto,$detalleExamen->descripcion,1, 0 , 'C');

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
                    $this->Cell(4,$alto,$resultado,1, 0 , 'C');
                    $this->Cell(4,$alto,$interpretacion,1, 0 , 'C');
                    $x_multirango = $this->getX();

                    foreach($ordenTieneExamen->multirango as $ind => $multirango){
                        if ($ind == 0) {
                            $borde = 'LTR';
                        }else if($ind == $numeroMultirangos-1){
                            $borde = 'LBR';
                        }else{
                            $borde = 'LR';
                        }
                        $this->Cell(6.5,$y,$multirango->multirango->nombre.': '.$multirango->rango_inferior." - ".$multirango->rango_superior,1, 1 , 'C');
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
                        $this->Cell(19.5,$y,$detalleExamen->examenes->nombre,1,1,'C',1);
                        $this->cabeceraTabla("Microorganismo");
                        
                    }
                    $anterior=$detalleExamen->examenes->id;
                    if(isset($orden->ordenTieneExamenes[$ind+1]))
                        $siguiente = $orden->ordenTieneExamenes[$ind+1]->detalleExamen->id_examenes;
                    else
                        $siguiente=0;
                    if($anterior!=$siguiente)
                        array_push($this->examenesImpresos,$detalleExamen->examenes->id);
                        
                    $this->Cell(5,$y,$detalleExamen->descripcion ,1, 0 , 'C');
                    
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

                    $this->Cell(4,$y,$resultado,1, 0 , 'C');
                    $this->Cell(4,$y,$desarrollo,1, 0 , 'C');
                    $this->Cell(6.5,$y,$observaciones,1, 1, 'C');
                    $this->SetTextColor(0, 0, 0);
                    $this->SetFont('Arial','',7.5);
                }
            }

        }
    }

    function Header(){
        $y = 0.5;
        $this->SetFont('Arial','B',18);
        $this->Image(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../../css/layout/img/logoNuevo.png',1,1.7,2.3,2.3);
        $this->SetXY(4, .75);
        $this->Cell(0,2.54,'DIAGNOSTICO CLÍNICO INTEGRAL',0,0,'C');
        $this->ln(0.75);
        $this->SetFont('Times','B',8);
        $this->SetXY(4, 2.75);
        $this->Cell(4, $y, 'UNIDAD CHAPULTEPEC', 0, 0, 'C');
        $this->Cell(6.9, $y, 'UNIDAD AMADO NERVO', 0, 0, 'C');
        $this->Cell(5, $y, 'UNIDAD DE CANCEROLOGÍA', 0, 1, 'C');
        $this->SetX(4);
        $this->SetFont('Times','',8);
        $y = 0.4;
        $this->Cell(4.3, $y, 'General Nicolás Bravo #170', 0, 0, 'C');
        $this->Cell(6.5, $y, 'Amado Nervo #392-A', 0, 0, 'C');
        $this->Cell(5, $y, 'Francisco M. Díaz #145', 0, 1, 'C');
        $this->SetX(4);
        $this->Cell(4.3, $y, 'Colonia Chapultepec Norte', 0, 0, 'C');
        $this->Cell(6.5, $y, 'Colonia Centro', 0, 0, 'C');
        $this->Cell(5, $y, 'Fracc. Ex Gobernador Gildardo Magaña', 0, 1, 'C');
        $this->SetX(4);
        $this->Cell(4.3, $y, 'C.P. 58260', 0, 0, 'C');
        $this->Cell(6.5, $y, 'C.P. 58000', 0, 0, 'C');
        $this->Cell(5, $y, 'C.P. 58149', 0, 1, 'C');
        $this->SetX(4);
        $this->Cell(4.3, $y, 'Tel.(443)232-0166', 0, 0, 'C');
        $this->Cell(6.5, $y, 'Tel.(443)312-3490', 0, 0, 'C');
        $this->Cell(5, $y, 'Tel.(443)232-0165', 0, 1, 'C');
        $this->SetX(4);
        $this->Cell(4.3, $y, 'Lunes-Viernes 07:00 a 20:00', 0, 0, 'C');
        $this->Cell(6.5, $y, 'Lunes-Sábado 07:00 a 15:00', 0, 0, 'C');
        $this->Cell(5, $y, 'Lunes-Sábado 07:00 a 15:00', 0, 1, 'C');
        $this->setX(4);
        $this->Cell(4.3, $y, 'Domingo 08:00 a 14:00', 0, 0, 'C');
        $this->ln();   
    }

    function cabeceraHorizontal($model)
    {
        $y = 0.5;
        $this->SetXY(-6, 6);
        $this->SetFont('Arial','',8);
        $this->Cell(2,$y,'Fecha de toma:', 0, 0);
        $this->SetFont('Arial','B',8);
        $fecha = explode('-', $model->fecha_captura);
        $dia= substr($fecha[2], 0, 2);
        $hora = explode(' ', $fecha[2]);
        $hora = explode(':', $hora[1]);


        $fecha = $dia.'/'.$fecha[1].'/'.$fecha[0].'   '. $hora[0].':'.$hora[1];
        $this->Cell(2,$y,$fecha, 0, 1);
        $this->setY(6);
        $this->setX(1);
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
        $this->setXY(-6, 6.5);
        $ordenTieneExamen = $model->ordenTieneExamenes[0];
        $this->Cell(2,$y,'Fecha Resultado: '.$this->obtenerFecha($ordenTieneExamen->ultima_edicion), 0, 0);
        $this->setXY(-6, 7);
        $this->SetFont('Arial','',8);
        $this->Cell(1,$y,'Sexo:', 0, 0);
        $this->SetFont('Arial','B',8);
        $this->Cell(2,$y,$model->ordenFacturacion->paciente->sexo==0?'Masculino':'Femenino', 0, 0);
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

    public function cabeceraTabla($tipo){
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(75, 141, 248);//Fondo azul de celda
        $y=0.5;
        switch ($tipo) {
            case 'Normal':
                $this->Cell(9,$y, 'Descripción',1, 0 , 'C', true);
                $this->Cell(3.5,$y, 'Resultado',1, 0 , 'C', true);
                $this->Cell(2,$y, 'U. medida',1, 0 , 'C', true);
                $this->Cell(5,$y, 'Parámetros de referencia',1, 1 , 'C', true);
                break;
            case 'Antibiótico':
                $this->Cell(5.5,$y, 'Antibiótico',1, 0 , 'C', true);
                $this->Cell(2.5,$y, 'Concentración',1, 0 , 'C', true);
                $this->Cell(2,$y, 'Resultado',1, 0 , 'C', true);
                $this->Cell(3.5,$y, 'Interpretación',1, 0 , 'C', true);
                $this->Cell(2,$y, 'Sensible',1, 0 , 'C', true);
                $this->Cell(2,$y, 'Intermedio',1, 0 , 'C', true);
                $this->Cell(2,$y, 'Resistente',1, 1 , 'C', true);
                break;
            case 'Multirango':
                $this->Cell(5,$y, 'Parámetro',1, 0 , 'C', true);
                $this->Cell(4,$y, 'Resultado',1, 0 , 'C', true);
                $this->Cell(4,$y, 'Interpretación',1, 0 , 'C', true);
                $this->Cell(6.5,$y, 'Multirangos',1, 1 , 'C', true);
                break;
            case 'Microorganismo':
                $this->Cell(5,$y, 'Parámetro',1, 0 , 'C', true);
                $this->Cell(4,$y, 'Resultado',1, 0 , 'C', true);
                $this->Cell(4,$y, 'Desarrollo',1, 0 , 'C', true);
                $this->Cell(6.5,$y, 'Observaciones',1, 1 , 'C', true);
                break;
            
            default:
                # code...
                break;
        }
        $this->SetFont('Arial','',8);
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

    public function obtenerFecha($fecha)
    {
        $fecha = explode('-', $fecha);
        $dia= substr($fecha[2], 0, 2);
        
        $fecha = $dia.'/'.$fecha[1].'/'.$fecha[0];
        return $fecha;
    }
}