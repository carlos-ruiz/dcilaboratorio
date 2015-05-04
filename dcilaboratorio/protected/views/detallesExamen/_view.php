<?php
/* @var $this DetallesExamenController */
/* @var $data DetallesExamen */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_unidades_medida')); ?>:</b>
	<?php echo CHtml::encode($data->id_unidades_medida); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_examenes')); ?>:</b>
	<?php echo CHtml::encode($data->id_examenes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ultima_edicion')); ?>:</b>
	<?php echo CHtml::encode($data->ultima_edicion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_ultima_edicion')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_ultima_edicion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creacion')); ?>:</b>
	<?php echo CHtml::encode($data->creacion); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_creacion')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_creacion); ?>
	<br />

	*/ ?>

</div>