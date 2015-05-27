<div style="overflow:auto; width:100%; height:350px;">
<h1>Contenido del modal</h1>
</div>
<script type="text/javascript">
	$("#modalCancelar").show();
	$("#modalGuardar").show();
	$("#modalTitle").text("Ejemplo de Modal");

	
</script>
	<section id="modal" class="overflow-auto">

				
					<div class="form-group <?php if($form->error($pagos,'efectivo')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($pagos,'efectivo', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($pagos,'efectivo',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
							<?php echo $form->error($pagos,'efectivo', array('class'=>'help-block')); ?>
						</div>
					</div>
					<div class="form-group <?php if($form->error($pagos,'tarjeta')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($pagos,'tarjeta', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($pagos,'tarjeta',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
							<?php echo $form->error($pagos,'tarjeta', array('class'=>'help-block')); ?>
						</div>
					</div>
					<div class="form-group <?php if($form->error($pagos,'cheque')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($pagos,'cheque', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($pagos,'cheque',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
							<?php echo $form->error($pagos,'cheque', array('class'=>'help-block')); ?>
						</div>
					</div>
					<div class="form-group "> Total $ 1111.00 <? //$total?></div>
					<div class="form-group align-right">Pago $999.00 <?php $sumatoria ?></div>
					<?php /*if ($total>$sumatoria)
							{
								echo "<div class='form-group align-right'>Debe " ;
								$total-$sumatoria;
								echo "</div>";
							}*/
					?>
					

				

				<div class"form-group col-md-4">

				</div>

				</section>