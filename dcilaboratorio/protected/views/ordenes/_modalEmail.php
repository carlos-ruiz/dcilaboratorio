<script type="text/javascript">
	$("#modalGuardar").hide();
	$("#modalCancelar").show();
	$("#modalAceptar").show();
	$("#modalTitle").text("Enviar por correo");
</script>
<section id="modal" class="overflow-auto">
<div class="form-group <?php if($form->error($model,'email')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'email', array('class'=>'control-label')); ?>
		<div class="input-group">
			<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
			<?php echo $form->error($model,'email', array('class'=>'help-block')); ?>
		</div>
	</div>

</section>
<script>
$("#modalAceptar").click(function(evt) {
		evt.preventDefault();
		
		$("#email-form").submit();

	});
</script>