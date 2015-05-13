<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */
/* @var $form CActiveForm */
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Multitarifario
		</div>		
	</div>
	<div class="portlet-body form" style="display: block;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ordenes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">

	<div class="form-group <?php if($form->error($model,'id_doctores')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_doctores', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_doctores',$model->obtenerDoctores(), array("empty"=>"Seleccione una opción", 'class'=>'form-control')); ?>
					
					<?php echo $form->error($model,'id_doctores', array('class'=>'help-block')); ?>
				</div>
	</div>

	

	<div class="row">
		<?php echo $form->labelEx($model,'id_pacientes'); ?>
		<?php echo $form->textField($model,'id_pacientes'); ?>
		<?php echo $form->error($model,'id_pacientes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_status'); ?>
		<?php echo $form->textField($model,'id_status'); ?>
		<?php echo $form->error($model,'id_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_unidades_responsables'); ?>
		<?php echo $form->textField($model,'id_unidades_responsables'); ?>
		<?php echo $form->error($model,'id_unidades_responsables'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_captura'); ?>
		<?php echo $form->textField($model,'fecha_captura'); ?>
		<?php echo $form->error($model,'fecha_captura'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'informacion_clinica_y_terapeutica'); ?>
		<?php echo $form->textField($model,'informacion_clinica_y_terapeutica',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'informacion_clinica_y_terapeutica'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comentarios'); ?>
		<?php echo $form->textField($model,'comentarios',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'comentarios'); ?>
	</div>

	<div class="form-group <?php if($form->error($model,'requiere_factura')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'requiere_factura', array('class'=>'control-label')); ?>
			<div class="input-group" >
				<?php echo $form->checkBox($model,'requiere_factura',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'requiere_factura', array('class'=>'help-block')); ?>
			</div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descuento'); ?>
		<?php echo $form->textField($model,'descuento'); ?>
		<?php echo $form->error($model,'descuento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_multitarifarios'); ?>
		<?php echo $form->textField($model,'id_multitarifarios'); ?>
		<?php echo $form->error($model,'id_multitarifarios'); ?>
	</div>


	<div class="form-group <?php if($form->error($model,'compartir_con_doctor')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'compartir_con_doctor', array('class'=>'control-label')); ?>
			<div class="input-group" >
				<?php echo $form->checkBox($model,'compartir_con_doctor',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'compartir_con_doctor', array('class'=>'help-block')); ?>
			</div>
	</div>
	
<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>

	
	<div class="form-actions" >
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
		</div>

	</div>
	<?php $this->endWidget(); ?>
</div>

</div><!-- form -->