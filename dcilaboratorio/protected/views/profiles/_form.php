<?php
/* @var $this ProfilesController */
/* @var $model Profiles */
/* @var $form CActiveForm */
include_once(Yii::app()->basePath.'/views/lastEditAndCreate.php');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'profiles-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'dateLastEdit'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'userLastEdit'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'dateCreate'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'userCreate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->