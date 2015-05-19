<?php
/* @var $this TarifasActivasController */
/* @var $model TarifasActivas */
/* @var $form CActiveForm */
?>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Tarifa activa
		</div>
		
	</div>
	<div class="portlet-body form" style="display: block;">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'tarifas-activas-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
			)); ?>
			<div class="form-body">		
				

				<div class="form-group  <?php if($form->error($model,'id_examenes')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'id_examenes', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->dropDownList($model,'id_examenes',$model->obtenerExamenes(), array('class' => 'form-control',"empty"=>"Seleccione una opci&oacute;n")); ?>
						<?php echo $form->error($model,'id_examenes', array('class'=>'help-block')); ?>
					</div>
				</div>
<div class="form-group  <?php if($form->error($model,'id_multitarifarios')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'id_multitarifarios', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->dropDownList($model,'id_multitarifarios',$model->obtenerMultitarifarios(), array('class' => 'form-control',"empty"=>"Seleccione una opci&oacute;n")); ?>
						<?php echo $form->error($model,'id_multitarifarios', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group  <?php if($form->error($model,'precio')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'precio', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($model,'precio',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
						<?php echo $form->error($model,'precio', array('class'=>'help-block')); ?>
					</div>
				</div>

				<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>

						
				<section class="overflow-auto">
				<div class="form-actions">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
				</div>
				</section>

			</div>

			<?php $this->endWidget(); ?>
		</div>
</div><!-- form -->