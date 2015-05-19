<?php
/* @var $this ProfilesController */
/* @var $model Profiles */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dateLastEdit'); ?>
		<?php echo $form->textField($model,'dateLastEdit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'userLastEdit'); ?>
		<?php echo $form->textField($model,'userLastEdit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dateCreate'); ?>
		<?php echo $form->textField($model,'dateCreate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'userCreate'); ?>
		<?php echo $form->textField($model,'userCreate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->