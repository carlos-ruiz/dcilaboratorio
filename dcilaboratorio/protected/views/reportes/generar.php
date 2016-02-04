<?php
/* @var $this UsersController */
/* @var $model Users */
?>

<h1>Reportes</h1>
<div class="col-md-12">
	<div class="col-md-9">
		<div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">Resultados</div>
            </div>
            <div class="portlet-body flip-scroll">
                <table class="table table-bordered table-striped table-condensed flip-content">
                    <thead class="flip-content">
                        <tr>
                            <?php foreach ($resultadosMostrar as $resultadoMostrar) { ?>
                                <th><?= utf8_decode($resultadoMostrar['nombre']) ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php 
                        foreach ($resultados as $resultado) { 
                            $orden = Ordenes::model()->findByPk($resultado['id']);
                            if (isset($orden)) { ?>
                            <tr>

                        <?php   foreach ($resultadosMostrar as $resultadoMostrar) { 
                                    if ($resultadoMostrar['id']=='day') {
                                        $fecha = explode('-', $orden->fecha_captura);
                                        $fecha = explode(' ', $fecha[2]);
                                        echo "<td>".$fecha[0]."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='month') {
                                        $fecha = explode('-', $orden->fecha_captura);
                                        echo "<td>".$fecha[1]."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='year') {
                                        $fecha = explode('-', $orden->fecha_captura);
                                        echo "<td>".$fecha[0]."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='week') {
                                        $fecha = new DateTime($orden->fecha_captura);
                                        $week = $fecha->format("W");
                                        echo "<td>".$week."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='hr') {
                                        $fecha = explode('-', $orden->fecha_captura);
                                        $fecha = explode(' ', $fecha[2]);
                                        $fecha = explode(':', $fecha[1]);
                                        $fecha = $fecha[0].':'.$fecha[1];
                                        echo "<td>".$fecha."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='folio') {
                                        echo "<td>$orden->id</td>";
                                    }
                                    if ($resultadoMostrar['id']=='idp') {
                                        $paciente = $orden->ordenFacturacion->id_pacientes;
                                        echo "<td>".$paciente."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='namep') {
                                        $paciente = $orden->ordenFacturacion->paciente;
                                        $nombre = $paciente->nombre.' '.$paciente->a_paterno.' '.$paciente->a_materno;
                                        // $nombre = substr($nombre, 0, 29);
                                        echo "<td>".$nombre."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='ur') {
                                        $ur = $orden->idUnidadesResponsables;
                                        $ur = isset($ur)?$ur->nombre:'';
                                        // $ur = substr($ur, 0, 19);
                                        echo "<td>".$ur."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='dr') {
                                        $dr = $orden->doctor;
                                        $dr = isset($dr)?$dr->titulo->nombre.' '.$dr->nombre.' '.$dr->a_paterno:'';
                                        // $dr = substr($dr, 0, 29);
                                        echo "<td>".$dr."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='exam') {
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
                                        echo "<td>".$examenes."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='cost') {
                                        $ordenPreciosExamen = $orden->precios;
                                        $costoTotal = 0;
                                        foreach ($ordenPreciosExamen as $precioExamen) {
                                            $costoTotal += $precioExamen->precio;
                                        }
                                        echo "<td>$".$costoTotal."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='discp') {
                                        echo "<td>".$orden->descuento."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='disa') {
                                        $ordenPreciosExamen = $orden->precios;
                                        $costoTotal = 0;
                                        foreach ($ordenPreciosExamen as $precioExamen) {
                                            $costoTotal += $precioExamen->precio;
                                        }
                                        $costoTotal = $costoTotal*$orden->descuento/100;
                                        echo "<td>$".$costoTotal."</td>";
                                    }
                                    if ($resultadoMostrar['id']=='tarifa') {
                                        $multitarifario = $orden->multitarifarios;
                                        echo "<td>".$multitarifario->nombre."</td>";
                                    }
                                } ?>
                            </tr>
                        <?php
                            }
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
	<div class="col-md-3">
		<?php $this->renderPartial("_form",array('model'=>$model)); ?>
	</div>
</div>
