<?php
/* @var $this TitulosFormController */
/* @var $model TitulosForm */
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
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ultima_edicion'); ?>
		<?php echo $form->textField($model,'ultima_edicion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_ultima_edicion'); ?>
		<?php echo $form->textField($model,'usuario_ultima_edicion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creacion'); ?>
		<?php echo $form->textField($model,'creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_creacion'); ?>
		<?php echo $form->textField($model,'usuario_creacion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->