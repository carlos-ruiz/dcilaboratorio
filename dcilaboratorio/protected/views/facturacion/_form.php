<?php
/* @var $this FacturacionController */
/* @var $form CActiveForm */
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Facturación
		</div>		
	</div>
	<div class="portlet-body form" style="display: block;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'factura-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div class="form-body">
	
	<div class="form-group">
		<?php echo CHtml::label('id','Id', array('class'=>'control-label')); ?>
			<div class="input-group" >
				<?php echo CHtml::textField('idInput','',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
			</div>
	</div>
	<div class="form-group">
		<?php echo CHtml::label('clave','clave', array('class'=>'control-label')); ?>
			<div class="input-group" >
				<?php echo CHtml::textField('claveInput','',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
			</div>
	</div>

	<div class="form-actions">
		<?php echo CHtml::submitButton('Guardar', array('class'=>'btn blue-stripe')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>