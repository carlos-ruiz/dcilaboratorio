<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */
/* @var $form CActiveForm */
?>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-gift"></i> Nuevo grupo de examenes
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
	'id'=>'grupos-examenes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div class="form-body">

	<div class="form-group <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
		<div class="input-group">
			<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>250, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'nombre', array('class'=>'help-block')); ?>
		</div>
	</div>

	<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>
	Seleccione los examenes pertenecientes al grupo. <br />
	<input type="hidden" value="" name="Grupos[tiene]" id="idsTiene" />
	<div class="form-group <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
		<div class="input-group">
			<?php foreach ($examenes as $examen) {
				echo '<input type="checkbox" class="examen" value="'.$examen->id.'" '.(in_array($examen->id, $tiene)?'checked':'').' /> '.$examen->nombre.'<br />';
			}?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn green')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	var checks="";
	$( "input[type=checkbox]" ).each(function(){
		if($(this).is(':checked')){
			checks+=$(this).val()+",";
		}
	});
	$("#idsTiene").val(checks.replace(/on,/g, ''));

	$( "input[type=checkbox]" ).click(function(){
		var checks="";
		$( "input[type=checkbox]" ).each(function(){
			if($(this).is(':checked')){
				checks+=$(this).val()+",";
			}
		});
		$("#idsTiene").val(checks.replace(/on,/g, ''));
	});
</script>