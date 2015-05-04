<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */
/* @var $form CActiveForm */
?>
<br />
<br />
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-gift"></i> Resultados de Examen
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
					<?php echo $form->dropDownList($model,'id_examenes',$model->obtenerExamenes(), array("empty"=>"Seleccione una opción", 'class'=>'form-control')); ?>
					
					<?php echo $form->error($model,'id_examenes', array('class'=>'help-block')); ?>
				</div>
	</div>

	<div class="form-group <?php if($form->error($model,'descripcion')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'descripcion', array('class'=>'control-label')); ?>
			<div class="input-group" >
				<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>250, 'class'=>'form-control')); ?>
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

	<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>


	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn green')); ?>
	</div>

<?php $this->endWidget(); ?>
