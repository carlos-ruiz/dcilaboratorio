<script type="text/javascript">
	$("#modalGuardar").hide();
	$("#modalCancelar").show();
	$("#modalAceptar").show();
	$("#modalTitle").text("Enviar por correo");
</script>
<section id="modal" class="overflow-auto">
<div class="form-group <?php if($form->error($model,'email')!=''){ echo 'has-error'; }?>">
	<?php echo $form->labelEx($model,'email', array('class'=>'control-label label-black')); ?>
	<div class="input-group">
		<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
		<?php echo $form->error($model,'email', array('class'=>'help-block')); ?>
	</div>
</div>
<div class="form-group)">
	<?php echo $form->labelEx($model,'comentarios', array('class'=>'control-label label-black')); ?>
	<div class="input-group">
		<?php echo $form->textArea($model,'comentarios',array('rows'=>3, 'cols'=>45, 'class'=>'form-control')); ?>
	</div>
</div>
<div class="form-group <?php if($form->error($model,'resultados_archivo')!=''){ echo 'has-error'; }?>">
	<?php echo $form->labelEx($model,'resultados_archivo', array('class'=>'control-label label-black')); ?>
	<div class="input-group" >
		<?php echo $form->checkBox($model,'resultados_archivo',array('size'=>45,'maxlength'=>45,'class'=>'form-control checkbox-resultados-archivo')); ?>
		<?php echo $form->error($model,'resultados_archivo', array('class'=>'help-block')); ?>
	</div>
</div>


</section>
<script>
function send()
	{
	    var data=$("#email-form").serialize();
	    //block("#modal-body");
	  	$.ajax({
		    type: 'POST',
		    url: $("#email-form").attr('action'),
		    data:data,
			success:function(data){		
								
		                
		                $("#modal").modal("hide");
		              },
		    error: function(data,status,message) { 
		         html=data.responseText.replace('<h1>Exception</h1>','').replace('<p>','').replace('</p>','');
		         html=html.substring(0,html.indexOf("(C:")-1);
		         $(".modal-body").html(html);
		    },
		 
		  	dataType:'html'
	  	});
	}

	$("#modalAceptar").click(function(evt) {
		send();
	});
</script>