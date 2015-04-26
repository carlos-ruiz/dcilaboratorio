<?php
/* @var $this DoctoresController */
/* @var $data Doctores */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('a_paterno')); ?>:</b>
	<?php echo CHtml::encode($data->a_paterno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('a_materno')); ?>:</b>
	<?php echo CHtml::encode($data->a_materno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('correo_electronico')); ?>:</b>
	<?php echo CHtml::encode($data->correo_electronico); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora_consulta_de')); ?>:</b>
	<?php echo CHtml::encode($data->hora_consulta_de); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hora_consulta_hasta')); ?>:</b>
	<?php echo CHtml::encode($data->hora_consulta_hasta); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('porcentaje')); ?>:</b>
	<?php echo CHtml::encode($data->porcentaje); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('calle')); ?>:</b>
	<?php echo CHtml::encode($data->calle); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ciudad')); ?>:</b>
	<?php echo CHtml::encode($data->ciudad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('colonia')); ?>:</b>
	<?php echo CHtml::encode($data->colonia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo_postal')); ?>:</b>
	<?php echo CHtml::encode($data->codigo_postal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numero_ext')); ?>:</b>
	<?php echo CHtml::encode($data->numero_ext); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numero_int')); ?>:</b>
	<?php echo CHtml::encode($data->numero_int); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_especialidades')); ?>:</b>
	<?php echo CHtml::encode($data->id_especialidades); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_titulos')); ?>:</b>
	<?php echo CHtml::encode($data->id_titulos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usuarios')); ?>:</b>
	<?php echo CHtml::encode($data->id_usuarios); ?>
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

	*/ ?>

</div>