<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */

$totalOrden=0;
$totalSinDescuento = 0;
$totalConDescuento = 0;
$precios = $model->precios;
foreach ($precios as $precio) {
	$totalOrden += $precio->precio;
}
$totalSinDescuento = $totalOrden;
if($model->descuento !=0) {
	$totalOrden=($totalOrden-($totalOrden*$model->descuento)/100);
}
$totalConDescuento = $totalOrden;
if($model->costo_emergencia !=0) {
	$totalOrden=$totalOrden +$model->costo_emergencia;
}

$pagos=$model->pagos;
$total=0;
foreach ($pagos as $pago):
	$total = $total + $pago->efectivo+$pago->tarjeta+$pago->cheque;
endforeach;

$pagado=$totalOrden-$total;

?>
<div class="portlet light">
	<div class="row">
		<h1>Orden con folio: <?php echo (isset($model->folio)&&strlen($model->folio)>0)?$model->folio:$model->id; ?></h1>
		
		<div class="form-group col-md-3">
						<?php
							echo CHtml::link('<i class="icon-printer"></i> Recibo',Yii::app()->createUrl('ordenes/generarPdf',array('id'=>$model->id)), array('class'=>'btn', 'target'=>'_blank'));
							echo CHtml::link('<i class="icon-printer"></i> Imprimir resultados',Yii::app()->createUrl('ordenes/imprimirResultadosPdf',array('id'=>$model->id)), array('class'=>'btn', 'target'=>'_blank'));
							echo CHtml::link('<i class="icon-printer"></i> Imprimir resultados columnas',Yii::app()->createUrl('ordenes/imprimirResultadosArchivo',array('id'=>$model->id)), array('class'=>'btn', 'target'=>'_blank'));
							echo CHtml::link('<i class="icon-envelope-letter"></i> Enviar por correo electrónico',Yii::app()->createUrl('ordenes/loadModalEmail',array('id_ordenes'=>$model->id)), array('id'=>'linkEnviarCorreo','class'=>'btn', 'target'=>'_blank','data-target'=>"#modal", 'data-toggle'=>"modal"));
																
							if (($model->status->nombre == 'Pagada' || $model->status->nombre == 'Finalizada') && $model->requiere_factura == 1) {
								echo CHtml::link('<i class="icon-printer"></i> Imprimir factura',Yii::app()->createUrl('facturacion/generarFactura',array('id'=>$model->id)), array('class'=>'btn', 'target'=>'_blank'));
							}
						?>

			<div class="heading text-center">
				<h3 style="color:#1e90ff ">Datos de la orden</h3>
			</div>

			<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
				'attributes'=>array(
					'status.nombre',
					'status.descripcion',
					array('name' => 'Fecha',
						'value' => date("j/m/Y H:i", strtotime($model->fecha_captura))
						),
					'multitarifarios.nombre',
					'descuento',
					),
					)); ?>

					<div class="heading text-center">

						<h5 style="color:#1e90ff ">Datos del Paciente</h5>

					</div>

					<?php $this->widget('zii.widgets.CDetailView', array(
						'data'=>$model,
						'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
						'attributes'=>array(
							array(
								'label'=>'Paciente',
								'type'=>'raw',
								'value'=>$this->obtenerPaciente($model, $this),
								),
							),
							)); ?>

							<div class="heading text-center">
								<h5 style="color:#1e90ff ">Datos del Doctor</h5>
							</div>

							<?php $this->widget('zii.widgets.CDetailView', array(
								'data'=>$model,
								'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
								'attributes'=>array(
									array(
										'label'=>'Doctor',
										'type'=>'raw',
										'value'=>($model->id_doctores!=null)?$this->obtenerNombreCompletoDoctor($model, $this):"No asignado",
										),
									array(
										'label'=>'Comparte inf. con Dr.',
										'type'=>'raw',
										'value'=>$this->obtenerSioNoComparteDr($model, $this),
										),
									'informacion_clinica_y_terapeutica',
									'comentarios',
									),
								));

							$aux=$model->ordenTieneExamenes;
							$anterior=0;
							$entrega=1;
							foreach ($aux as $ordenExamen){
								$detalleExamen=$ordenExamen->detalleExamen;
								$examen=$detalleExamen->examenes;
								if($examen->id!=$anterior){
									if($examen->duracion_dias>$entrega)
										$entrega=$examen->duracion_dias;
								}
							}
							?>

							<div class="heading text-center">
								<h3 style="color:#1e90ff ">Pagos</h3>
							</div>

							<?php

							$aux=$model->pagos;
							echo '<table class="table table-striped table-bordered dataTable">';
								foreach ($aux as $pago):
									echo '<tr><td>Fecha</td><td>'.date("d/m/Y H:i", strtotime($pago->fecha)).'</td></tr>';
								echo '<tr><td>Efectivo</td><td> $'.$pago->efectivo.'</td></tr>';
								echo '<tr><td>Tarjeta</td><td> $'.$pago->tarjeta.'</td></tr>';
								echo '<tr><td>Cheque</td><td> $'.$pago->cheque.'</td></tr>';
								endforeach;
								echo'</table>';

								if($model->costo_emergencia !=0 || $model->descuento !=0) {
									echo '<table class="table table-striped table-bordered dataTable"><tr>
									<td>Total de exámenes </td><td>$ '.$totalSinDescuento.'</td><tr> </table>';
								}

								if($model->descuento !=0) {
									echo   '<table class="table table-striped table-bordered dataTable"><tr>
									<td>Descuento </td><td> '.$model->descuento.'%</td></<tr> </table>';
									if($model->costo_emergencia != 0){
										echo '<table class="table table-striped table-bordered dataTable"><tr>
										<td>Total con descuento </td><th colspan="3" style="color:#1e90ff ">$ '.$totalConDescuento.'</th></<tr> </table>';
									}
								}

								if($model->costo_emergencia !=0) {
									echo   '<table class="table table-striped table-bordered dataTable"><tr>
									<td>Costo emergencia</td><td>$'.$model->costo_emergencia.'</td></<tr> </table>';
								}

								echo '<table class="table table-striped table-bordered dataTable"><tr>
								<td>Total de la Orden </td><th colspan="3" style="color:#1e90ff ">$ '.number_format($totalOrden, 2).'</th></<tr> </table>';


								echo '<table class="table table-striped table-bordered dataTable"><tr>
								<td>Total pagado </td><td>$ '.number_format($total, 2).'</td></<tr> </table>';

								$pagado=$totalOrden-$total;

								echo '<table class="table table-striped table-bordered dataTable"><tr>
								<td>'.($pagado>=0?"Total por pagar":"Cambio").'</td><td>$ '.number_format(($pagado>=0?$pagado:$pagado*-1), 2).'</td></<tr> </table>';


								echo '<table class="table table-striped table-bordered dataTable"><tr>
								<th colspan="3" style="color:#1e90ff "> <center>Tarda '.$entrega.' día(s) para entregarse</center></th></<tr>'; ?>
							
							</table>
						</div>


						<div class="form-group col-md-9">
						<div class="col-md-4">
						<?php
								if($total<$totalOrden) { ?>							
									<div class="col-md-12">
										<a class="btn red" style="width:100%;" href="<?php echo CController::createUrl('ordenes/loadModalContent',array('id_ordenes'=>"$model->id"));?>" data-target="#modal" data-toggle="modal">Agregar pago</a>
									</div>					
								<?php } ?>
						</div>

							<div class="heading text-center">
								<h3 style="color:#1e90ff ">Examenes</h3>
							</div>
							<?php

	// Aqui la leyenda de que pague.

							$aux=$model->ordenTieneExamenes;
							$anterior=0;
							$entrega=1;

							
			// Muestra los examenes que perteneces a algun grupo
			
			foreach ($ordenGruposModel as $grupote) {
				echo '<table class="table table-striped table-bordered dataTable">';
							echo '
				   		<thead class="encabezados" ><tr><td style="color:#04C !important">Descripción</td>
				   		<td style="color:#04C !important">Resultado</td>
				   		<td style="color:#04C !important">Unidad de medida</td>
				   		<td colspan="3" style="color:#04C !important">Parámetros de referencia</td></tr></thead>';
				   		
				$this->imprimirGrupo($grupote->id_grupos,$model->id, false);

				echo "</table>";
			}
			// Muestra los examenes individuales normales

			$this->imprimirNormal($model);

			// Muestra los examenes individuales antibioticos
			$this->imprimirAntibiotico($model);

			// Muestra los examenes individuales multirangos
			$this->imprimirMultirango($model);

			// Muestra los examenes individuales microorganismos
			$this->imprimirMicroorganismo($model);

							?>
							<br />
							<?php if(isset($model->comentarios_resultados))
									echo "COMENTARIOS: ".$model->comentarios_resultados;
							 ?>
						</div>

					</div>
				</div>

		<script type="text/javascript">
		$("#linkEnviarCorreo").click(function(){
			block('modal-body');
		})
		</script>
