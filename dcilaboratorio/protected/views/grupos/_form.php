<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */
/* @var $form CActiveForm */
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Perfil
		</div>
	</div>
	<div class="portlet-body form" style="display: block;">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'grupos-examenes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div class="form-body">

	<div class="form-group <?php if($form->error($model,'clave')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'clave', array('class'=>'control-label')); ?>
		<div class="input-group">
			<?php echo $form->textField($model,'clave',array('size'=>45,'maxlength'=>250, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'clave', array('class'=>'help-block')); ?>
		</div>
	</div>

	<div class="form-group <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
		<div class="input-group">
			<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>250, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'nombre', array('class'=>'help-block')); ?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label" for="isPerfilote">¿Es perfil de perfiles?.</label>
		<div class="input-group">
			<input type="checkbox" id="isPerfilote" value="0" <?php echo sizeof($model->grupos)>0?"checked":"";?>/>
		</div>
	</div>

	<div class="form-group <?php if($form->error($model,'examenes')!=''){ echo 'has-error'; }?>">
		<label class="control-label" for="Grupos_examenes">Seleccione los examenes pertenecientes al perfil.</label>
		<div class="input-group">
			<?php echo $form->dropDownList($model,'examenes',Examenes::model()->selectListMultipleWithClave(), array("class" => "form-control select2","multiple"=>"multiple")); ?>
		</div>
	</div>

	<div class="form-group" id="perfilote">
		<label class="control-label" for="Grupos_grupos">Seleccione los perfiles pertenecientes al perfil.</label>
		<div class="input-group">
			<?php echo $form->dropDownList($model,'grupos',Grupos::model()->selectListMultiple($model->id), array("class" => "form-control select2","multiple"=>"multiple")); ?>
		</div>
	</div>
	<div class="form-group <?php if($form->error($model,'comentarios')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'comentarios', array('class'=>'control-label')); ?>
		<div class="input-group">
			<?php echo $form->textArea($model,'comentarios',array('rows'=>3, 'cols'=>45, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'comentarios', array('class'=>'help-block')); ?>
		</div>
	</div>

	<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>


	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Nuevo' : 'Actualizar',array('class'=>'btn blue-stripe')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">

	$( "input[type=checkbox]" ).each(function(){
		if($(this).is(':checked')){
			$("#perfilote").show(400);
		}else{
			$("#perfilote").hide(400);
		}
	});
	$( "input[type=checkbox]" ).click(function(){
		if($(this).is(':checked')){
			$("#perfilote").show(400);
		}else{
			$("#perfilote").hide(400);
		}
	});



</script>