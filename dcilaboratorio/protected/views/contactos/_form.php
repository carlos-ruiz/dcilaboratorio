<?php
/* @var $this ContactosController */
/* @var $model Contactos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contactos-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'contacto'); ?>
		<?php echo $form->textField($model,'contacto',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'contacto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_tipos_contacto'); ?>
		<?php echo $form->textField($model,'id_tipos_contacto'); ?>
		<?php echo $form->error($model,'id_tipos_contacto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ultima_edicion'); ?>
		<?php echo $form->textField($model,'ultima_edicion',array('size'=>45,'maxlength'=>45)); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'id_persona'); ?>
		<?php echo $form->textField($model,'id_persona'); ?>
		<?php echo $form->error($model,'id_persona'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_perfiles'); ?>
		<?php echo $form->textField($model,'id_perfiles'); ?>
		<?php echo $form->error($model,'id_perfiles'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->