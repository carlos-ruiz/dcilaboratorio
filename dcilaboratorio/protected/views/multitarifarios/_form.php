<?php
/* @var $this MultitarifariosController */
/* @var $model Multitarifarios */
/* @var $form CActiveForm */
?>
<br />
<br />
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-gift"></i> Multitarifario
		</div>		
	</div>
	<div class="portlet-body form" style="display: block;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'multitarifarios-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div class="form-body">

	<div class="form-group <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
			<div class="input-group" >
				<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45,'requear')); ?>
				<?php echo $form->error($model,'nombre'); ?>
			</div>
	</div>

	<div class="form-group <?php if($form->error($model,'descripcion')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'descripcion', array('class'=>'control-label')); ?>
			<div class="input-group" >
			<?php echo $form->textArea($model,'descripcion',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'descripcion'); ?>
			</div>
	</div>

	<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>

	
	<div class="form-actions" >
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn green')); ?>
		</div>

	</div>
	<?php $this->endWidget(); ?>
</div>

</div><!-- form -->