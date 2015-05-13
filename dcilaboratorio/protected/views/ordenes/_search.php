<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */
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
		<?php echo $form->label($model,'id_doctores'); ?>
		<?php echo $form->textField($model,'id_doctores'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_pacientes'); ?>
		<?php echo $form->textField($model,'id_pacientes'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_status'); ?>
		<?php echo $form->textField($model,'id_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_unidades_responsables'); ?>
		<?php echo $form->textField($model,'id_unidades_responsables'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_captura'); ?>
		<?php echo $form->textField($model,'fecha_captura'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'informacion_clinica_y_terapeutica'); ?>
		<?php echo $form->textField($model,'informacion_clinica_y_terapeutica',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comentarios'); ?>
		<?php echo $form->textField($model,'comentarios',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requiere_factura'); ?>
		<?php echo $form->textField($model,'requiere_factura'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descuento'); ?>
		<?php echo $form->textField($model,'descuento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_multitarifarios'); ?>
		<?php echo $form->textField($model,'id_multitarifarios'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'compartir_con_doctor'); ?>
		<?php echo $form->textField($model,'compartir_con_doctor'); ?>
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