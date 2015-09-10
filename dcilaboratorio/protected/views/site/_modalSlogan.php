<script type="text/javascript">

	$("#modalTitle").text("Edita tu Slogan");
</script>
<section id="modal" class="overflow-auto">
	<div class="form-group <?php if($form->error($slogan,'slogan')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($slogan,'slogan', array('class'=>'control-label')); ?>
		<div class="input-group">
			<?php echo $form->textArea($slogan,'slogan',array('rows'=>3, 'cols'=>85, 'class'=>'form-control')); ?>
			<?php echo $form->error($slogan,'slogan', array('class'=>'help-block')); ?>
		</div>
		<br/>
		<div class="form-actions text-right">
			<?php echo CHtml::submitButton('Actualizar', array('class'=>'btn blue-stripe')); ?>
		</div>
	</div>
</section>