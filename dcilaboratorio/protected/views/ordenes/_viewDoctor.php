<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */
	
	$totalOrden=0;
	$precios = $model->precios;
	foreach ($precios as $precio) {
	 	$totalOrden += $precio->precio;
	}
	if($model->descuento !=0) {
    	$totalOrden=($totalOrden-($totalOrden*$model->descuento)/100);
    }
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
	<h1>Orden con folio: <?php echo $model->id; ?></h1>
	<div class="form-group col-md-4">

		<div class="heading text-center">
			
			<h3 style="color:#1e90ff ">Datos del Paciente</h3>
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
	)); ?>
	</div>


	<div class="form-group col-md-8">

	

		<div class="heading text-center">
			<h3 style="color:#1e90ff ">Examenes</h3>
		</div>

	
		<?php 
		$entrega=1;
		if($total>=$totalOrden){ ?>
			<?php
			$aux=$model->ordenTieneExamenes;
			$anterior=0;
			
			echo '<table class="table table-striped table-bordered dataTable">';
			   		
			 foreach ($aux as $ordenExamen): 
				$detalleExamen=$ordenExamen->detalleExamen;
				$examen=$detalleExamen->examenes;
				if($examen->id!=$anterior){
					if($examen->duracion_dias>$entrega)
						$entrega=$examen->duracion_dias;

					echo '<thead><tr><th colspan="3" style="color:#1e90ff ">'.$examen->nombre.'</th></tr></thead>		
			   		<tr><td>Descripción</td>
			   		<td>Resultado</td>
			   		<td>R. I.</td>
			   		<td>R. P.</td>
			   		<td>R. S.</td></tr>';
				}

				echo '<tr><td>'.$detalleExamen->descripcion.' </td><td>';
				if ($ordenExamen->resultado=='') {
					echo "Sin resultado";
				}
				else{
					echo $ordenExamen->resultado.' '.$detalleExamen->unidadesMedida->abreviatura;
				}

				echo '</td><td>'.$detalleExamen->rango_inferior.'</td>
				<td>'.$detalleExamen->rango_promedio.'</td>
				<td>'.$detalleExamen->rango_superior.'</td>
				</tr>';

				$anterior=$examen->id;
			 endforeach;
			 echo'</table>';
			 ?>
			<?php }else{ ?>
				<div style="width:100%" class="text-center">
					<h1>Resultados no disponibles</h1>
				</div>
			<?php } ?>

			</div>

	    <?php

	    //Aqui que solo aparezca los botones si esta pagado

		if($total>=$totalOrden){ 
	    	echo CHtml::link('<i class="icon-printer"></i> Imprimir resultados',Yii::app()->createUrl('ordenes/imprimirResultadosPdf',array('id'=>$model->id)), array('class'=>'btn')); 
		} ?>
	</div>
</div>
</div>