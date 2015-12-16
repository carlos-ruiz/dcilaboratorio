<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'FPDF.php');
class ImprimirOrden extends FPDF{

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
        $this->SetTextColor(0, 0, 0);


        $this->SetXY(1, 8.5);
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(75, 141, 248);//Fondo azul de celda
        $this->SetTextColor(0, 0, 0); //Letra color blanco
        $x = 2;
        $this->Cell(3.5,$y, 'Clave',1, 0 , 'C', true);
        $this->Cell(12,$y, 'Descripción',1, 0 , 'C', true);
        $this->Cell(4,$y, 'Costo',1, 0 , 'C', true);
        //Atención!! el parámetro true rellena la celda con el color elegido
		//$this->Cell(120,7, utf8_decode("hola mundo"),1, 0 , 'C', true);
		//$this->Cell(20,7, utf8_decode($cabecera[2]),1, 0 , 'C', true);
    }

    function contenido($model){
    	$this->SetTextColor(0, 0, 0); //Letra color blanco
    	$this->SetFont('Arial','',8);
    	$posYOriginal = 7;
    	$posYIncremento = 1.5;
    	$this->setXY(1,9);
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

        //Para quitar los grupitos de los grupotes existetes en la orden y que no se impriman
        $gruposExistentesEnOrdenAux=array();
        foreach ($gruposExistentesEnOrden as $filtroOrdenTieneGrupos) {
            $grupitos=GruposPerfiles::model()->findAll("id_grupo_hijo=?",array($filtroOrdenTieneGrupos)); 
            if(isset($grupitos)){
                $papaEstaEnLaOrden=false;
                foreach ($grupitos as $grupito) {
                    $papa=OrdenTieneGrupos::model()->find("id_grupos=?",array($grupito->id_grupo_padre));
                    if(isset($papa)){
                        $papaEstaEnLaOrden=true;
                    }
                }
                if(!$papaEstaEnLaOrden){
                    array_push($gruposExistentesEnOrdenAux, $filtroOrdenTieneGrupos);
                }
            }else{
                array_push($gruposExistentesEnOrdenAux, $filtroOrdenTieneGrupos);
            }
        }
        $gruposExistentesEnOrden=$gruposExistentesEnOrdenAux;

        $examenesImpresos=array();
        foreach ($gruposExistentesEnOrden as $grupo) {
            $grupo = Grupos::model()->findByPk($grupo);
            $ordenTieneGrupo = OrdenTieneGrupos::model()->find("id_ordenes=? AND id_grupos=?", array($model->id, $grupo->id));
            if (isset($ordenTieneGrupo)) {
                $examenesEnGrupo=GrupoExamenes::model()->findAll('id_grupos_examenes=?',array($grupo->id));
                $examenesIds=array();
                $this->SetFillColor(213, 224, 241);

                foreach ($examenesEnGrupo as $grupoExamen) {
                    array_push($examenesIds, $grupoExamen->id_examenes);
                }
                $totalPrecioGrupo = 0;
                foreach ($ordenTieneExamenes as $ordenExamen) {
                    $examen = $ordenExamen->detalleExamen->examenes;
                    if(in_array($examen->id, $examenesIds)&&!in_array($examen->id, $examenesImpresos)){
                        //Pintamos el examen
                        array_push($examenesImpresos, $examen->id);
                        if($examen->id!=$idExamen){
                            // $this->Cell(3.5,$y, $examen->clave,1, 0);
                            // $this->Cell(12,$y, $examen->nombre,1, 0 );
                            $precio = OrdenPrecioExamen::model()->findByAttributes(array('id_ordenes'=>$model->id, 'id_examenes'=>$examen->id));
                            // $this->Cell(4,$y, '$ '.$precio->precio,1, 1, 'R');
                            $totalOrden += $precio->precio;
                            $totalPrecioGrupo += $precio->precio;
                            if ($examen->duracion_dias > $duracion) {
                                $duracion = $examen->duracion_dias;
                            }
                        }
                        $idExamen = $examen->id;
                    }
                }
                $this->Cell(3.5,$y, $grupo->clave,1, 0);
                $this->Cell(12,$y, $grupo->nombre ,1, 0, 'C', false);
                $this->Cell(4,$y, '$ '.number_format($totalPrecioGrupo, 2),1, 1, 'R');
            }
        }

       /* if(sizeof($idsExamenes)!=sizeof($examenesImpresos)){
            $this->Cell(19.5,$y, "Exámenes individuales" ,1, 1, 'C', true);
        }*/
        $idExamenExiste = 0;
        foreach ($idsExamenes as $idExamen) {
            if(!in_array($idExamen,$examenesImpresos)){
                $examen=Examenes::model()->findByPk($idExamen);
                if($examen->id!=$idExamenExiste){
                    $this->Cell(3.5,$y, $examen->clave,1, 0);
                    $this->Cell(12,$y, $examen->nombre,1, 0, 'C' );
                    $precio = OrdenPrecioExamen::model()->findByAttributes(array('id_ordenes'=>$model->id, 'id_examenes'=>$examen->id));
                    $this->Cell(4,$y, '$ '.number_format($precio->precio, 2),1, 1, 'R');
                    $totalOrden += $precio->precio;
                    if ($examen->duracion_dias > $duracion) {
                        $duracion = $examen->duracion_dias;
                    }
                }
                $idExamenExiste = $examen->id;
            }
        }

        $this->setX(12.5);
        $this->SetFont('Arial','B',8);
        $this->Cell(4,$y,'Total orden', 0, 0, 'R');
        $this->Cell(4,$y,'$'.number_format($totalOrden, 2), 'B', 1, 'R');
        $this->setX(12.5);
        $this->Cell(4,$y,'Descuento', 0, 0, 'R');
        $this->Cell(4,$y,(isset($model->descuento)?$model->descuento:'0').' %', 'B', 1, 'R');
        $this->setX(12.5);
        $this->Cell(4,$y,'Total con descuento', 0, 0, 'R');
        $this->Cell(4,$y,'$'.number_format($totalOrden*(1-($model->descuento/100)), 2), 'B', 1, 'R');
        $this->setX(12.5);
        $this->Cell(4,$y,'Costo emergencia', 0, 0, 'R');
        $this->Cell(4,$y,'$'.number_format($model->costo_emergencia, 2), 'B', 1, 'R');
        $this->setX(12.5);
        $total = $totalOrden*(1-($model->descuento/100)) + $model->costo_emergencia;
        $this->Cell(4,$y,'Total', 0, 0, 'R');
        $this->Cell(4,$y,'$'.number_format($total, 2), 'B', 1, 'R');
        $pagos = $model->pagos;
        $totalPagado = 0;
        foreach ($pagos as $pago) {
            $totalPagado +=  $pago->efectivo + $pago->cheque + $pago->tarjeta;
        }
        $this->setX(12.5);
        $this->Cell(4,$y,'Pago', 0, 0, 'R');
        $this->Cell(4,$y,'$'.number_format($totalPagado, 2), 'B', 1, 'R');
        $this->setX(12.5);
        $this->Cell(4,$y,(($total-$totalPagado)>0?'Saldo':'Cambio'), 0, 0, 'R');
        $this->Cell(4,$y,'$'.number_format(abs($total-$totalPagado), 2), 'B', 1, 'R');

        //Observaciones
        $this->ln(1);
        $this->SetFont('Arial','',8);
        $this->Cell(4,$y,'Observaciones:', 0, 1);
        $this->SetFont('Arial','B',8);
        $this->Cell(10,$y,$model->comentarios, 0, 1);
        $this->ln(1);
        $this->SetFont('Arial','B',8);
        $this->Cell(8.75,$y,'Puede consultar sus resultados por Internet en la siguente liga:', 0, 0);
        $this->SetFillColor(75, 141, 248);
        $this->SetFont('Arial','U',8);
        $this->Cell(5,$y,'www.dcilaboratorio.com', 0, 1);
        $this->SetFont('Arial','B',10);
        $this->Cell(10,$y,'Usuario: '.$model->ordenFacturacion->usuario->usuario, 0, 1);
        $this->Cell(10,$y,'Contraseña: '.base64_decode($model->ordenFacturacion->usuario->contrasena), 0, 1);

        $this->ln(1);
        $this->SetFont('Arial','B',8);
        $this->Cell(10,$y,'Sus resultados estarán listos en '.$duracion.' días.', 0, 1);

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