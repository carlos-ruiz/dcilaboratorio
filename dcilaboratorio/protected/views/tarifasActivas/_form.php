<?php
/* @var $this TarifasActivasController */
/* @var $model TarifasActivas */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tarifas-activas-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_examenes'); ?>
		<?php echo $form->textField($model,'id_examenes'); ?>
		<?php echo $form->error($model,'id_examenes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_multitarifarios'); ?>
		<?php echo $form->textField($model,'id_multitarifarios'); ?>
		<?php echo $form->error($model,'id_multitarifarios'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'precio'); ?>
		<?php echo $form->textField($model,'precio'); ?>
		<?php echo $form->error($model,'precio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ultima_edicion'); ?>
		<?php echo $form->textField($model,'ultima_edicion'); ?>
		<?php echo $form->error($model,'ultima_edicion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario_ultima_edicion'); ?>
		<?php echo $form->textField($model,'usuario_ultima_edicion'); ?>
		<?php echo $form->error($model,'usuario_ultima_edicion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creacion'); ?>
		<?php echo $form->textField($model,'creacion'); ?>
		<?php echo $form->error($model,'creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario_creacion'); ?>
		<?php echo $form->textField($model,'usuario_creacion'); ?>
		<?php echo $form->error($model,'usuario_creacion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->