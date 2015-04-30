<?php
/* @var $this UnidadesResponsablesController */
/* @var $model UnidadesResponsables */
/* @var $form CActiveForm */
$usuarios = CHtml::listData(Usuarios::model()->findAll(), 'id', 'usuario');
?>
<br />
<br />
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-gift"></i> Unidad Responsable
		</div>		
	</div>
	<div class="portlet-body form" style="display: block;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'unidades-responsables-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div class="form-body">

	

	<div class="form-group <?php if($form->error($model,'id_usuarios')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_usuarios', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_usuarios',$model->obtenerUsuarios(), array("empty"=>"Seleccione una opción"));  ?>
					
					<?php echo $form->error($model,'id_usuarios', array('class'=>'help-block')); ?>
				</div>
	</div>

	<div class="form-group <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
			<div class="input-group" >
				<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45,'requear')); ?>
				<?php echo $form->error($model,'nombre'); ?>
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