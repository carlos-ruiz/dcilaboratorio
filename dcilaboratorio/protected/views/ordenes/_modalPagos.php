<script type="text/javascript">
	$("#modalCancelar").show();
	$("#modalGuardar").show();
	$("#modalTitle").text("Agregar pago");
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
	<?php
	$aux=$orden->ordenTieneExamenes;
	$anterior=0;
	$totalOrden=0;
	$pagosOrden=$orden->pagos;
	$pagado=0;
	$sumatoria=0;
	foreach ($aux as $ordenExamen){
		$detalleExamen=$ordenExamen->detalleExamen;
		$examen=$detalleExamen->examenes;
		if($examen->id!=$anterior){
			$tarifaActiva=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?', array($examen->id,$orden->id_multitarifarios));
			$totalOrden+=$tarifaActiva->precio;
		}
		$anterior=$examen->id;
	}
	foreach ($pagosOrden as $pago) {
		$pagado += $pago->cheque;
		$pagado += $pago->tarjeta;
		$pagado += $pago->efectivo; 
	}

	$adeudo = $totalOrden-$pagado;
	?>
	<table class="table table-striped table-bordered dataTable paymentDetailsTable">
		<tr>
			<th>Detalle</th>
			<th>Importe</th>
		</tr>
		<tr>
			<td>
				<div> Total de la órden:</div>
			</td>
			<td>
				$ <div id="granTotal" class="inline-block"><?php echo $totalOrden; ?></div>
			</td>
		</tr>
		<tr>
			<td>		
				<div>Pagado:</div>
			</td>
			<td>
				$ <div class="inline-block color-green" id="pagado"><?php echo $pagado; ?></div>
			</td>
		</tr>
		<tr>
			<td>
				<div>Pago actual:</div>
			</td>
			<td>
				<div class="inline-block" id="pagoActual">$ 0</div>
			</td>
		</tr>
		<tr>
			<td>
				<div>Adeudo:</div>
			</td>
			<td>
				<div class="inline-block color-red" id="adeudo">$<?php echo $adeudo; ?></div>
			</td>
		</tr>
	</table>

</section>

<script type="text/javascript">
	$("#Pagos_efectivo").change(function(){
		pago=calcularPago();
		setPago(pago);
		debe=calcularDebe();
		setDebe(debe);
	});

	$("#Pagos_tarjeta").change(function(){
		pago=calcularPago();
		setPago(pago);
		debe=calcularDebe();
		setDebe(debe);
	});

	$("#Pagos_cheque").change(function(){
		pago=calcularPago();
		setPago(pago);
		debe=calcularDebe();
		setDebe(debe);
	});

	function calcularPago(){
		efectivo = parseFloat($("#Pagos_efectivo").val());
		if(isNaN(efectivo))
			efectivo=0;
		tarjeta = parseFloat($("#Pagos_tarjeta").val());
		if(isNaN(tarjeta))
			tarjeta=0;
		cheque = parseFloat($("#Pagos_cheque").val());
		if(isNaN(cheque))
			cheque=0;
		granTotal = parseFloat($("#granTotal").text());
		if(isNaN(granTotal))
			granTotal=0;
		if (cheque > granTotal) {
			alerta("El monto del cheque no debe ser mayor al costo de la orden","Aviso");
			$("#Pagos_cheque").val("");
			cheque = 0;
		}
		return efectivo+tarjeta+cheque;
	}

	function calcularDebe(){
		granTotal = parseFloat($("#granTotal").text());
		if(isNaN(granTotal))
			granTotal=0;
		pagado = parseFloat($("#pagado").text());
		if(isNaN(pagado))
			pagado=0;
		pago=calcularPago();
		debe=granTotal-pagado-pago;
		return debe;
	}

	function setPago(pago){
		pago=Number((pago).toFixed(2));
		$("#pagoActual").text("$ "+pago);
	}

	function setDebe(debe){
		debe=Number((debe).toFixed(2));
		$("#adeudo").text("$ "+debe);
	}

	$("#modalGuardar").click(function(evt) {
		evt.preventDefault();
		efectivo = parseFloat($("#Pagos_efectivo").val());
		if(isNaN(efectivo))
			efectivo=0;
		tarjeta = parseFloat($("#Pagos_tarjeta").val());
		if(isNaN(tarjeta))
			tarjeta=0;
		cheque = parseFloat($("#Pagos_cheque").val());
		if(isNaN(cheque))
			cheque=0;
		if (efectivo>0 || tarjeta>0 || cheque>0) {
			if (calcularDebe()>=0) {
				$("#pagos-form").submit();
			}
			else{
				alerta("Su cambio es: $"+calcularDebe()*-1,"Cambio");
				$("#pagos-form").submit();	
			}
		}
		else{
			alerta("Escriba el monto de pago en al menos una forma de pago","Aviso");
			$("#modal .form-group").addClass("has-error");
			return false;
		}
	});
</script>