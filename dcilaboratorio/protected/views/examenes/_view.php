<?php
/* @var $this ExamenesController */
/* @var $data Examenes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clave')); ?>:</b>
	<?php echo CHtml::encode($data->clave); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('duracion_dias')); ?>:</b>
	<?php echo CHtml::encode($data->duracion_dias); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('indicaciones_paciente')); ?>:</b>
	<?php echo CHtml::encode($data->indicaciones_paciente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('indicaciones_laboratorio')); ?>:</b>
	<?php echo CHtml::encode($data->indicaciones_laboratorio); ?>
	<br />

	

</div>