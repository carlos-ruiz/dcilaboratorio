<?php
/* @var $this ProfilesController */
/* @var $data Profiles */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('dateLastEdit')); ?>:</b>
	<?php echo CHtml::encode($data->dateLastEdit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userLastEdit')); ?>:</b>
	<?php echo CHtml::encode($data->userLastEdit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dateCreate')); ?>:</b>
	<?php echo CHtml::encode($data->dateCreate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userCreate')); ?>:</b>
	<?php echo CHtml::encode($data->userCreate); ?>
	<br />
	*/?>

</div>