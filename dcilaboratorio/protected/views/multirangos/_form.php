<?php
/* @var $this MultirangosController */
/* @var $model Multirangos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'multirangos-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rango_inferior'); ?>
		<?php echo $form->textField($model,'rango_inferior',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'rango_inferior'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rango_superior'); ?>
		<?php echo $form->textField($model,'rango_superior',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'rango_superior'); ?>
	</div>
		<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->