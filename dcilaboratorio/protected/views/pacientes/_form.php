<?php
/* @var $this PacientesController */
/* @var $model Pacientes */
/* @var $form CActiveForm */
?>
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
	
	<div class="row">
						<div class="form-group col-md-6  <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($model,'nombre', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6  <?php if($form->error($model,'a_paterno')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($model,'a_paterno', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($model,'a_paterno',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($model,'a_paterno', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6  <?php if($form->error($model,'a_materno')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($model,'a_materno', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($model,'a_materno',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($model,'a_materno', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6  <?php if($form->error($model,'fecha_nacimiento')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($model,'fecha_nacimiento', array('class'=>'control-label')); ?>
							<div class="input-group">	
								<?php echo $form->textField($model,'fecha_nacimiento',array('size'=>16,'maxlength'=>45,'class'=>'form-control form-control-inline date-picker','data-date-format'=>'yyyy-mm-dd','data-date-language'=>'es')); ?>													
								<?php echo $form->error($model,'fecha_nacimiento', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6  <?php if($form->error($model,'sexo')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($model,'sexo', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php $accountStatus = array('0'=>'Hombre', '1'=>'Mujer');
	              				  echo $form->radioButtonList($model,'sexo',$accountStatus,array('separator'=>'   ','class'=>'form-control' ));?>						
								<?php echo $form->error($model,'sexo', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6 <?php if($form->error($model,'email')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($model,'email', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
								<?php echo $form->error($model,'email', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>

				<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>


	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->