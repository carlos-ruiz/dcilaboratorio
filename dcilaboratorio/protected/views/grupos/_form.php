<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'grupos-examenes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>
	Seleccione los examenes pertenecientes al grupo. <br />
	<input type="hidden" value="" name="Grupos[tiene]" id="idsTiene" />
	<?php foreach ($examenes as $examen) {
		echo '<input type="checkbox" class="examen" value="'.$examen->id.'" '.(in_array($examen->id, $tiene)?'checked':'').' /> '.$examen->nombre.'<br />';
	}?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
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