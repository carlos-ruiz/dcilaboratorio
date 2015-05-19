<?php
/* @var $this OrdenesController */
/* @var $data Ordenes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_doctores')); ?>:</b>
	<?php echo CHtml::encode($data->id_doctores); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pacientes')); ?>:</b>
	<?php echo CHtml::encode($data->id_pacientes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_status')); ?>:</b>
	<?php echo CHtml::encode($data->id_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_unidades_responsables')); ?>:</b>
	<?php echo CHtml::encode($data->id_unidades_responsables); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_captura')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_captura); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('informacion_clinica_y_terapeutica')); ?>:</b>
	<?php echo CHtml::encode($data->informacion_clinica_y_terapeutica); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('comentarios')); ?>:</b>
	<?php echo CHtml::encode($data->comentarios); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requiere_factura')); ?>:</b>
	<?php echo CHtml::encode($data->requiere_factura); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descuento')); ?>:</b>
	<?php echo CHtml::encode($data->descuento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_multitarifarios')); ?>:</b>
	<?php echo CHtml::encode($data->id_multitarifarios); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('compartir_con_doctor')); ?>:</b>
	<?php echo CHtml::encode($data->compartir_con_doctor); ?>
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