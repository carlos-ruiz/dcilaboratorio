<?php
/* @var $this FacturacionController */
/* @var $form CActiveForm */
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Facturación
		</div>
	</div>
	<div class="portlet-body form" style="display: block;">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'factura-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
			)); ?>

			<div class="form-body">
				<section id="datos-contribuyente" class="overflow-auto">
					<div class="heading text-center">
						<h3 style="color:#1e90ff ">Datos del contribuyente</h3>
						<hr/>
					</div>
					<div class="form-group col-md-6 <?php if($form->error($model,'razon_social')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'razon_social', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'razon_social',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'razon_social', array('class'=>'help-block')); ?>
						</div>
					</div>
					<div class="form-group col-md-6 <?php if($form->error($model,'rfc')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'rfc', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'rfc',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'rfc', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="heading text-center">
						<h4 style="color:#1e90ff ">Dirección fiscal</h4>
					</div>
					<div class="form-group col-md-6 <?php if($form->error($model,'calle')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'calle', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'calle',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'calle', array('class'=>'help-block')); ?>
						</div>
					</div>
					<div class="form-group col-md-6 <?php if($form->error($model,'numero')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'numero', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'numero',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'numero', array('class'=>'help-block')); ?>
						</div>
					</div>
					<div class="form-group col-md-6 <?php if($form->error($model,'colonia')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'colonia', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'colonia',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'colonia', array('class'=>'help-block')); ?>
						</div>
					</div>
					<div class="form-group col-md-6 <?php if($form->error($model,'codigo_postal')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'codigo_postal', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'codigo_postal',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'codigo_postal', array('class'=>'help-block')); ?>
						</div>
					</div>
					<div class="form-group col-md-6 <?php if($form->error($model,'localidad')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'localidad', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'localidad',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'localidad', array('class'=>'help-block')); ?>
						</div>
					</div>
					<div class="form-group col-md-6 <?php if($form->error($model,'municipio')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'municipio', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'municipio',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'municipio', array('class'=>'help-block')); ?>
						</div>
					</div>
					<div class="form-group col-md-6 <?php if($form->error($model,'estado')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'estado', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'estado',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'estado', array('class'=>'help-block')); ?>
						</div>
					</div>
				</section>

				<section id="conceptos">
					<div class="heading text-center">
						<h3 style="color:#1e90ff ">Conceptos</h3>
						<hr/>
					</div>
					<div class="row">
						<div class="form-group col-md-3" >
							<div class="input-group">
								<input type="hidden" id="listaConceptos" name="conceptos[ids]" value />
								<a href="javascript:void(0);" class="btn default blue-stripe" id="agregarConcepto">Agregar concepto</a>
							</div>
						</div>
					</div>

					<table class="table table-striped table-bordered dataTable" id="tablaConceptos">
						<thead >
							<tr>
								<th>Clave</th>
								<th>Concepto</th>
								<th>Precio</th>
							</tr>
						</thead>
						<tbody id="examenesAgregados">
							
						</tbody>
					</table>
				</section>

				<div class="form-actions">
					<?php echo CHtml::submitButton('Guardar', array('class'=>'btn blue-stripe')); ?>
				</div>
			</div>

		<?php $this->endWidget(); ?>
<script type="text/javascript">
	var numeroConcepto = 0;
	var conceptosIds = [];

	function setConceptosIds(){
		var ids=conceptosIds.join();
		$("#conceptosIds").val(ids);
	}

	$("#agregarConcepto").click(function(){
		numeroConcepto = $('#tablaConceptos tr').length;
		$.post(
			"<?php echo $this->createUrl('facturacion/agregarConcepto/');?>",
			{
				id:numeroConcepto,
			},
			function(data){
				$("#examenesAgregados").append(data);
				setConceptosIds();
				activarEliminacion();
				// total=calcularTotal();
				// setTotal(total);
				// granTotal=calcularGranTotal();
				// setGranTotal(granTotal);
				// debe=calcularDebe();
				// setDebe(debe);
			}
		);
	});

	function activarEliminacion(){
		$(".eliminarConcepto").click(function(){
			$(".row_"+$(this).data('id')).hide(400);
			$(".row_"+$(this).data('id')).html("");
			aux=[];
			for (var i = 0; i < conceptosIds.length; i++) {
				if(conceptosIds[i]!=$(this).data('id')){
					aux.push(conceptosIds[i]);
				}
			};
			conceptosIds=aux;
			// setConceptosIds();
			// total=calcularTotal();
			// setTotal(total);
			// granTotal=calcularGranTotal();
			// setGranTotal(granTotal);
			// debe=calcularDebe();
			// setDebe(debe);
		});
	}
</script>