<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */
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
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_unidades_medida'); ?>
		<?php echo $form->textField($model,'id_unidades_medida'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_examenes'); ?>
		<?php echo $form->textField($model,'id_examenes'); ?>
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