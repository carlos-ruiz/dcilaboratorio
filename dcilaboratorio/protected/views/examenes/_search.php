<?php
/* @var $this ExamenesController */
/* @var $model Examenes */
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
		<?php echo $form->label($model,'clave'); ?>
		<?php echo $form->textField($model,'clave',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'duracion_dias'); ?>
		<?php echo $form->textField($model,'duracion_dias'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'indicaciones_paciente'); ?>
		<?php echo $form->textArea($model,'indicaciones_paciente',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'indicaciones_laboratorio'); ?>
		<?php echo $form->textArea($model,'indicaciones_laboratorio',array('rows'=>6, 'cols'=>50)); ?>
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