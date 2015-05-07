<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<br />
<br />
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-gift"></i> Usuario
		</div>
		<div class="tools">
			<a href="" class="collapse" data-original-title="" title="">
			</a>
			<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="">
			</a>
			<a href="" class="reload" data-original-title="" title="">
			</a>
			<a href="" class="remove" data-original-title="" title="">
			</a>
		</div>
	</div>
	<div class="portlet-body form" style="display: block;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">


		<div class="form-group <?php if($form->error($model,'usuario')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'usuario', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'usuario',array('size'=>60,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'usuario', array('class'=>'help-block')); ?>
			</div>
		</div>

		<div class="form-group <?php if($form->error($model,'contrasena')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'contrasena', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->passwordField($model,'contrasena',array('size'=>60,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'contrasena', array('class'=>'help-block')); ?>
			</div>
		</div>

		<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>
		

		<div class="form-actions">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'btn green')); ?>
		</div>
		
	</div>
<?php $this->endWidget(); ?>
	</div>
</div><!-- form -->