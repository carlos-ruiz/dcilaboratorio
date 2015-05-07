<?php
/* @var $this ExamenesController */
/* @var $model Examenes */
/* @var $form CActiveForm */
?>

<br />
<br />
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Examen
		</div>		
	</div>
	<div class="portlet-body form" style="display: block;">
	


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'examenes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div class="form-body">
	
	<div class="form-group <?php if($form->error($model,'clave')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'clave', array('class'=>'control-label')); ?>
			<div class="input-group" >
				<?php echo $form->textField($model,'clave',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'clave', array('class'=>'help-block')); ?>
			</div>
	</div>

	<div class="form-group <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
			<div class="input-group" >
				<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'nombre', array('class'=>'help-block')); ?>
			</div>
	</div>


	<div class="form-group <?php if($form->error($model,'descripcion')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'descripcion', array('class'=>'control-label')); ?>
			<div class="input-group" >
			<?php echo $form->textArea($model,'descripcion',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'descripcion', array('class'=>'help-block')); ?>
			</div>
	</div>

	<div class="form-group <?php if($form->error($model,'duracion_dias')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'duracion_dias', array('class'=>'control-label')); ?>
			<div class="input-group" >
			<?php echo $form->textField($model,'duracion_dias', array('class'=>'form-control')); ?>
		 	<?php echo $form->error($model,'duracion_dias', array('class'=>'help-block')); ?>
			</div>
	</div>

	<div class="form-group <?php if($form->error($model,'indicaciones_paciente')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'indicaciones_paciente', array('class'=>'control-label')); ?>
		<div class="input-group" >
			<?php echo $form->textArea($model,'indicaciones_paciente',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'indicaciones_paciente', array('class'=>'help-block')); ?>
		</div>
	</div>

	<div class="form-group <?php if($form->error($model,'indicaciones_laboratorio')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'indicaciones_laboratorio', array('class'=>'control-label')); ?>
			<div class="input-group" >
			<?php echo $form->textArea($model,'indicaciones_laboratorio',array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'indicaciones_laboratorio', array('class'=>'help-block')); ?>
			</div>
	</div>

	<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>


	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->