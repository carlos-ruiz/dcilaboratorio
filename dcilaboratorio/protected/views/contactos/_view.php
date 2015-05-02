<?php
/* @var $this ContactosController */
/* @var $data Contactos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contacto')); ?>:</b>
	<?php echo CHtml::encode($data->contacto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_tipos_contacto')); ?>:</b>
	<?php echo CHtml::encode($data->id_tipos_contacto); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_creacion')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_creacion); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_persona')); ?>:</b>
	<?php echo CHtml::encode($data->id_persona); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_perfiles')); ?>:</b>
	<?php echo CHtml::encode($data->id_perfiles); ?>
	<br />

	*/ ?>

</div>