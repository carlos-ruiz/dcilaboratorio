<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */
?>

<!--

<h1>Orden con folio: <?php echo $model->id; ?></h1>
<div class="form-group col-md-4">

	<div class="heading text-center">
		<h3 style="color:#1e90ff ">Datos de la orden</h3>
	</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
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
		'ordenesFacturacion.id_paciente'        
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

<div class="form-group col-md-4">

	<div class="heading text-center">
		<h3 style="color:#1e90ff ">Examenes</h3>
		<hr/>
	</div>
<?php

$orden = Ordenes::model()->findByPk($model->id);
$aux=$orden->ordenTieneExamenes;
$anterior=0;
echo '<table class="table table-striped table-bordered dataTable">
   		';
   		
 foreach ($aux as $ordenExamen): 
	$detalleExamen=$ordenExamen->detalleExamen;
	$examen=$detalleExamen->examenes;
	if($examen->id!=$anterior){
		echo '<tr><td style="color:#1e90ff ">'.$examen->nombre.'</td>
	
   		<tr><td>Descripción</td>
   		<td>Resultado</td>
   		<td>Rango normal</td></tr>';
	}

	echo '<tr><td>'.$detalleExamen->descripcion.' </td><td>'.$ordenExamen->resultado.' '.$detalleExamen->unidadesMedida->nombre.'</td><td>'.$detalleExamen->rango_inferior.'-'.$detalleExamen->rango_superior.'</td></tr>';
	$anterior=$examen->id;
 endforeach;
 echo'</table>';

 ?>


</div>

<div class="form-group col-md-4">
	<div class="heading text-center">
		<h3 style="color:#1e90ff ">Pagos</h3>
		<hr/>
	</div>

<?php
$orden =Ordenes::model()->findByPk($model->id);
$aux=$orden->pagos;
$total=0;
echo '<table class="table table-striped table-bordered dataTable">
   		<tr>
   		<td>Fecha</td>
   		<td>Efectivo</td>
   		<td>Tarjeta</td>
   		<td>Cheque</td>';
		 foreach ($aux as $pago):  
		 	echo '<tr><td>'.date("d/m/Y H:i", strtotime($pago->fecha)).'</td>';
			echo '<td> $'.$pago->efectivo.'</td>';
			echo '<td> $'.$pago->tarjeta.'</td>';
			echo '<td> $'.$pago->cheque.'</td></tr>';
			$total = $total + $pago->efectivo+$pago->tarjeta+$pago->cheque;
		 endforeach;
		echo'</table>';
		echo '<table class="table table-striped table-bordered dataTable"><tr>
			   <td>Total pagado </td><td>$ '.$total.'</td></<tr> </table>';
?>
</div>
-->
<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */
?>


<h1>Orden con folio: <?php echo $model->id; ?></h1>
<div class="form-group col-md-4">

	<div class="heading text-center">
		<h3 style="color:#1e90ff ">Datos de la orden</h3>
	</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(		
		array('name' => 'Fecha',
            'value' => date("j/m/Y H:i", strtotime($model->fecha_captura))
        ),
        array(
            'label'=>'Doctor',
            'type'=>'raw',
            'value'=>($model->id_doctores!=null)?$this->obtenerNombreCompletoDoctor($model, $this):"No asignado",
        ),
		
	),
)); ?>
</div>

<div class="portlet-body form" style="display: block;">


	

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'resultados-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div class="form-body">
<div class="form-group col-md-8">

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption text-center">
			Resultados de examenes			
		</div>		
	</div>
</div>
	
<?php

$orden = Ordenes::model()->findByPk($model->id);
$aux=$orden->ordenTieneExamenes;
$anterior=0;
echo '<table class="table table-striped table-bordered dataTable">
   		';
   		
 foreach ($aux as $ordenExamen): 
	$detalleExamen=$ordenExamen->detalleExamen;
	$examen=$detalleExamen->examenes;
	if($examen->id!=$anterior){
		echo '<tr><td style="color:#1e90ff ">'.$examen->nombre.'</td>
	
   		<tr><td>Descripción</td>
   		<td>Resultado</td>
   		<td>Unidad Medida</td>
   		<td>Rango normal</td></tr>';
	}

	echo '<tr><td>'.$detalleExamen->descripcion.' </td><td>';
	echo $form->textField($model,'id',array('size'=>25,'maxlength'=>25,'class'=>'form-control'));
	echo '</td><td>'
	.$detalleExamen->unidadesMedida->nombre.'</td><td>'
	.$detalleExamen->rango_inferior.'-'.$detalleExamen->rango_superior.'</td></tr>';
	$anterior=$examen->id;
 endforeach;
 echo'</table>';

 ?>



	<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>

	
	<div class="form-actions" >
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
		</div>

	</div>
	<?php $this->endWidget(); ?>
</div>

</div><!-- form -->
</div>






