<?php
/* @var $this DoctoresController */
/* @var $model Doctores */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'doctores-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'a_paterno'); ?>
		<?php echo $form->textField($model,'a_paterno',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'a_paterno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'a_materno'); ?>
		<?php echo $form->textField($model,'a_materno',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'a_materno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'correo_electronico'); ?>
		<?php echo $form->textField($model,'correo_electronico',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'correo_electronico'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hora_consulta_de'); ?>
		<?php echo $form->textField($model,'hora_consulta_de',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'hora_consulta_de'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hora_consulta_hasta'); ?>
		<?php echo $form->textField($model,'hora_consulta_hasta',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'hora_consulta_hasta'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'porcentaje'); ?>
		<?php echo $form->textField($model,'porcentaje'); ?>
		<?php echo $form->error($model,'porcentaje'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'calle'); ?>
		<?php echo $form->textField($model,'calle',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'calle'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ciudad'); ?>
		<?php echo $form->textField($model,'ciudad',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'ciudad'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'colonia'); ?>
		<?php echo $form->textField($model,'colonia',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'colonia'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codigo_postal'); ?>
		<?php echo $form->textField($model,'codigo_postal',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'codigo_postal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'numero_ext'); ?>
		<?php echo $form->textField($model,'numero_ext'); ?>
		<?php echo $form->error($model,'numero_ext'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'numero_int'); ?>
		<?php echo $form->textField($model,'numero_int',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'numero_int'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_especialidades'); ?>
		<?php echo $form->textField($model,'id_especialidades'); ?>
		<?php echo $form->error($model,'id_especialidades'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_titulos'); ?>
		<?php echo $form->textField($model,'id_titulos'); ?>
		<?php echo $form->error($model,'id_titulos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_usuarios'); ?>
		<?php echo $form->textField($model,'id_usuarios'); ?>
		<?php echo $form->error($model,'id_usuarios'); ?>
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