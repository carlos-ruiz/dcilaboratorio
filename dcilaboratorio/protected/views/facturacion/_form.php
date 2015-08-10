<?php
/* @var $this FacturacionController */
/* @var $form CActiveForm */
$total = 0;
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
					<div class="form-group col-md-6 <?php if($form->error($model,'fecha')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'fecha', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'fecha',array('size'=>16,'maxlength'=>45,'class'=>'form-control form-control-inline date-picker','data-date-format'=>'yyyy-mm-dd','data-date-language'=>'es')); ?>
							<?php echo $form->error($model,'fecha', array('class'=>'help-block')); ?>
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
								<a href="javascript:void(0);" class="btn default blue-stripe" id="agregarConcepto">Agregar concepto</a>
							</div>
						</div>
						<?php if(isset($conceptosConError)) { ?>
						<div class="form-group col-md-6 has-error" >
							<div class="input-group">
								<div class="help-block"><?php echo $conceptosConError; ?></div>
							</div>
						</div>
						<?php } ?>
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
							<?php foreach ($conceptos as $index => $numeroConcepto): 
							$total += $numeroConcepto->precio;
							echo "
								<tr class='row_$index' data-id='$index'>
									<td>
										<input type='hidden' name='conceptos[$index]' value='$index' />
										<input type='text' class='form-control' id='clave_$index' name='clave_$index' value='$numeroConcepto->clave' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;'/>
									</td>
									<td>
										<input type='text' class='form-control' id='concepto_$index' name='concepto_$index' value='$numeroConcepto->concepto' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />
									</td>
									<td class='precioConcepto'>
										<input type='text' class='form-control' id='precio_$index' name='precio_$index' value='$numeroConcepto->precio' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />
									</td>
									<td>
										<a href='javascript:void(0)' data-id='$index' class='eliminarConcepto'><span class='fa fa-trash'></span></a>
									</td>
								</tr>
								";
							endforeach; ?>
						</tbody>
					</table>
				</section>
				<section id="sumatorias">
					<div class="row">
						<div class="form-group col-md-7"></div>
						<div class="form-group col-md-3 align-right">
							<label class="control-label" for="subtotal">Subtotal $</label>
						</div>
						<div class="form-group col-md-2 ">
							<div class="input-group">
								<input size="45" maxlength="45" class="form-control" id="subtotal" type="text" readonly>
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col-md-7"></div>
						<div class="form-group col-md-3 align-right <?php if($form->error($model,'descuento')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($model,'descuento'.' (%)', array('class'=>'control-label')); ?>
						</div>
						<div class="form-group col-md-2 ">	
							<div class="input-group">
								<?php echo $form->textField($model,'descuento',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
								<?php echo $form->error($model,'descuento', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-7"></div>
						<div class="form-group col-md-3 align-right">
							<label class="control-label" for="FacturacionForm_subtotal_descuento">Subtotal con descuento</label>
						</div>
						<div class="form-group col-md-2 ">	
							<div class="input-group">
								<input size="45" maxlength="45" class="form-control" name="FacturacionForm[subtotal_descuento]" id="FacturacionForm_subtotal_descuento" type="text" value="" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-7"></div>
						<div class="form-group col-md-3 align-right">
							<label class="control-label" for="FacturacionForm_iva">IVA 16.00%</label>
						</div>
						<div class="form-group col-md-2 ">	
							<div class="input-group">
								<input size="45" maxlength="45" class="form-control" name="FacturacionForm[iva]" id="FacturacionForm_iva" type="text" value="" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-7"></div>
						<div class="form-group col-md-3 align-right">
							<label class="control-label" for="FacturacionForm_total">Total</label>	
						</div>
						<div class="form-group col-md-2 ">	
							<div class="input-group">
								<input size="45" maxlength="45" class="form-control" name="FacturacionForm[total]" id="FacturacionForm_total" type="text" value="" readonly>
							</div>
						</div>
					</div>
				</section>

				<div class="form-actions">
					<?php echo CHtml::submitButton('Generar PDF', array('class'=>'btn blue-stripe')); ?>
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
				activarScripts();
				calcularSubTotal();
				// granTotal=calcularGranTotal();
				// setGranTotal(granTotal);
				// debe=calcularDebe();
				// setDebe(debe);
			}
		);
	});

	function activarScripts(){
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
			calcularSubTotal();
			// granTotal=calcularGranTotal();
			// setGranTotal(granTotal);
			// debe=calcularDebe();
			// setDebe(debe);
		});

		$(".precioConcepto input").change(function() {
			total = calcularSubTotal();
		});
	}

	function calcularSubTotal() {
		var suma=0;
		$(".precioConcepto input").each(function(){
			precio=parseFloat($(this).val());
			if (!isNaN(precio)) {
				suma += precio;
			}
		});
		suma=Number((suma).toFixed(2));
		$('#subtotal').val(suma);
		calcularSubtotalConDescuento();
		calcularIva();
		calcularTotal();
	}

	function getDescuento(){
		descuento = parseFloat($('#FacturacionForm_descuento').val());
		if(isNaN(descuento)){
			descuento = 0;
			$('#FacturacionForm_descuento').val(descuento);
		}
		return descuento;
	}

	function calcularSubtotalConDescuento(){
		subtotal = $('#subtotal').val();
		descuento = getDescuento();
		subtotalConDescuento = subtotal*(100-descuento)/100;
		$("#FacturacionForm_subtotal_descuento").val(subtotalConDescuento);
	}

	function calcularIva(){
		subtotalConDescuento = $("#FacturacionForm_subtotal_descuento").val();
		iva = subtotalConDescuento*0.16;
		$("#FacturacionForm_iva").val(iva);
	}

	function calcularTotal(){
		subtotalConDescuento = parseFloat($("#FacturacionForm_subtotal_descuento").val());
		iva = parseFloat($("#FacturacionForm_iva").val());
		total = (subtotalConDescuento+iva);
		$("#FacturacionForm_total").val(total);
	}

	activarScripts();
	calcularSubTotal();
	$("#FacturacionForm_descuento").change(function() {
		descuento = getDescuento();
		if(descuento>100 || descuento<0){
			alerta("El descuento debe ser un número entre 0 y 100", "Error");
		}
		else{
			total = calcularSubTotal();
		}
	});
</script>