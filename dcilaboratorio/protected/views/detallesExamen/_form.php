<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */
/* @var $form CActiveForm */
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Resultado de examen
		</div>
	</div>
	<div class="portlet-body form" style="display: block;">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'detalles-examen-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">

	<div class="form-group <?php if($form->error($model,'id_examenes')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_examenes', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_examenes',$model->obtenerExamenes(), array("empty"=>"Seleccione una opción", 'class'=>'form-control select2me')); ?>

					<?php echo $form->error($model,'id_examenes', array('class'=>'help-block')); ?>
				</div>
	</div>

	<div class="form-group <?php if($form->error($model,'descripcion')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'descripcion', array('class'=>'control-label')); ?>
			<div class="input-group" >
				<?php echo $form->textArea($model,'descripcion',array('rows'=>2, 'cols'=>45,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'descripcion', array('class'=>'help-block')); ?>
			</div>
	</div>

	<div class="form-group <?php if($form->error($model,'id_unidades_medida')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_unidades_medida', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_unidades_medida',$model->obtenerUnidadesMedida(), array("empty"=>"Seleccione una opción", 'class'=>'form-control')); ?>

					<?php echo $form->error($model,'id_unidades_medida', array('class'=>'help-block')); ?>
				</div>
	</div>

	<div class="form-group <?php if($form->error($model,'rango_inferior')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'rango_inferior', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'rango_inferior',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'rango_inferior', array('class'=>'help-block')); ?>
			</div>
	</div>

	<div class="form-group <?php if($form->error($model,'rango_promedio')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'rango_promedio', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'rango_promedio',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'rango_promedio', array('class'=>'help-block')); ?>
			</div>
	</div>

	<div class="form-group <?php if($form->error($model,'rango_superior')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'rango_superior', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'rango_superior',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'rango_superior', array('class'=>'help-block')); ?>
			</div>
	</div>

	<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>


	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
	</div>

<?php $this->endWidget(); ?>
