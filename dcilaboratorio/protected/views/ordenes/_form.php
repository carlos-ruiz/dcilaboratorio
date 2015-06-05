<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */
/* @var $form CActiveForm */
?>
<style type="text/css">
	.debe{
		color:#FE2E64;
	}
	.no-debe{
		color:#07E023;
	}
</style>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Orden
		</div>		
	</div>
	<div class="portlet-body form" style="display: block;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ordenes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<?php 
/*
echo $form->errorSummary($model);
echo "<br /><br />";
echo $form->errorSummary($paciente);
echo "<br /><br />";
echo $form->errorSummary($direccion);
echo "<br /><br />";
echo $form->errorSummary($pagos);
echo "<br /><br />";
echo $form->errorSummary($datosFacturacion);
*/
?>

	<div class="form-body">

	<div class="form-body">
				<section id="general">
					<div class="heading text-center">
						<h3 style="color:#1e90ff ">Datos del paciente</h3>
						<hr/>
					</div>
					<div class="heading">
						<h5 style="color:#1e90ff ">Seleccione un paciente existente</h5>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="input-group">
								<?php echo $form->dropDownList($paciente,'id',Pacientes::model()->selectListWithMail(), array("empty"=>"Seleccione un paciente", 'class'=>'form-control input-medium select2me')); ?>
							</div>
						</div>
					</div>
					<hr/>
					<div class="heading">
						<h5 style="color:#1e90ff ">O agregue uno nuevo</h5>
					</div>
					<div class="row">
						<div class="form-group col-md-6  <?php if($form->error($paciente,'nombre')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($paciente,'nombre', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($paciente,'nombre',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($paciente,'nombre', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6  <?php if($form->error($paciente,'a_paterno')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($paciente,'a_paterno', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($paciente,'a_paterno',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($paciente,'a_paterno', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6  <?php if($form->error($paciente,'a_materno')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($paciente,'a_materno', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($paciente,'a_materno',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($paciente,'a_materno', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6  <?php if($form->error($paciente,'fecha_nacimiento')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($paciente,'fecha_nacimiento', array('class'=>'control-label')); ?>
							<div class="input-group">	
								<?php echo $form->textField($paciente,'fecha_nacimiento',array('size'=>16,'maxlength'=>45,'class'=>'form-control form-control-inline date-picker','data-date-format'=>'yyyy-mm-dd','data-date-language'=>'es')); ?>													
								<?php echo $form->error($paciente,'fecha_nacimiento', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6  <?php if($form->error($paciente,'sexo')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($paciente,'sexo', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php $accountStatus = array('0'=>'Hombre', '1'=>'Mujer');
	              				  echo $form->radioButtonList($paciente,'sexo',$accountStatus,array('separator'=>'   ','class'=>'form-control' ));?>						
								<?php echo $form->error($paciente,'sexo', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6 <?php if($form->error($paciente,'email')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($paciente,'email', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($paciente,'email',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
								<?php echo $form->error($paciente,'email', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$paciente)); ?>
				</section>
				<br />
				<section id="drs">
					<div class="row">
						<div class="form-group col-md-6 <?php if($form->error($model,'id_doctores')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'id_doctores', array('class'=>'control-label')); ?>
									<div class="input-group">
										<?php echo $form->dropDownList($model,'id_doctores',$model->obtenerDoctores(), array("empty"=>"Seleccione una opción", 'class'=>'form-control input-medium select2me','onchange' => 'javascript:$("#compartirDr").toggle()')); ?>
										<?php echo $form->error($model,'id_doctores', array('class'=>'help-block')); ?>
									</div>
						</div>

						<div id="compartirDr" style="display:none;">
							<div class="form-group col-md-6 <?php if($form->error($model,'compartir_con_doctor')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'compartir_con_doctor', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'compartir_con_doctor',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'compartir_con_doctor', array('class'=>'help-block')); ?>
									</div>
							</div>
						</div>
					</div>
				</section>
				<br />
				<section id="comentarios">

					<div class="row">
						<div class="form-group col-md-6 <?php if($form->error($model,'informacion_clinica_y_terapeutica')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'informacion_clinica_y_terapeutica', array('class'=>'control-label')); ?>
							<div class="input-group" >
								<?php echo $form->textArea($model,'informacion_clinica_y_terapeutica',array('rows'=>3, 'cols'=>45, 'class'=>'form-control')); ?>
								<?php echo $form->error($model,'informacion_clinica_y_terapeutica', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6 <?php if($form->error($model,'comentarios')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'comentarios', array('class'=>'control-label')); ?>
							<div class="input-group" >
								<?php echo $form->textArea($model,'comentarios',array('rows'=>3, 'cols'=>45, 'class'=>'form-control')); ?>
								<?php echo $form->error($model,'comentarios', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6 <?php if($form->error($model,'id_multitarifarios')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($model,'id_multitarifarios', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->dropDownList($model,'id_multitarifarios',$model->obtenerMultitarifarios(), array("empty"=>"Seleccione una opción", 'class'=>'form-control input-medium select2me')); ?>
								<?php echo $form->error($model,'id_multitarifarios', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6 <?php if($form->error($model,'requiere_factura')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($model,'requiere_factura', array('class'=>'control-label')); ?>
							<div class="input-group" >
								<?php echo $form->checkBox($model,'requiere_factura',array('size'=>45,'maxlength'=>45,'class'=>'form-control',  'onchange' => 'javascript:$("#facturacion").toggle(500)')); ?>
								<?php echo $form->error($model,'requiere_factura', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
				</section>
				<br />
				<section id="facturacion" style="display:<?php echo $model->requiere_factura==0?'none':'normal';?>;">

					<div class="heading text-center">
						<h3 style="color:#1e90ff ">Datos de Facturación</h3>
						<hr/>
					</div>
					<div class="row">
						<div class="form-group col-md-6  <?php if($form->error($datosFacturacion,'razon_social')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($datosFacturacion,'razon_social', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($datosFacturacion,'razon_social',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($datosFacturacion,'razon_social', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6  <?php if($form->error($datosFacturacion,'RFC')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($datosFacturacion,'RFC', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($datosFacturacion,'RFC',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($datosFacturacion,'RFC', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<div class="form-group col-md-6 <?php if($form->error($direccion,'id_estados')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'id_estados', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php
							$htmlOptions = array(
								"ajax"=>array(
									"url"=>$this->createUrl("direcciones/municipiosPorEstado"),
									"type"=>"POST",
									"update"=>"#Direcciones_id_municipios"
								),
								"class" => "form-control",
								"empty"=>"Seleccione una opci&oacute;n",
							);
						?>
						<?php echo $form->dropDownList($direccion,'id_estados',$direccion->obtenerEstados(), $htmlOptions); ?>
						<?php echo $form->error($direccion,'id_estados', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($direccion,'id_municipios')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'id_municipios', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->dropDownList($direccion,'id_municipios',$direccion->obtenerMunicipios(isset($direccion->id_estados)?$direccion->id_estados:0), array('class' => 'form-control',"empty"=>"Seleccione una opci&oacute;n")); ?>
						<?php echo $form->error($direccion,'id_municipios', array('class'=>'help-block')); ?>
					</div>
				</div>
					<div class="row">
						<div class="form-group col-md-6 <?php if($form->error($direccion,'colonia')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($direccion,'colonia', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($direccion,'colonia',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
								<?php echo $form->error($direccion,'colonia', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6 <?php if($form->error($direccion,'calle')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($direccion,'calle', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($direccion,'calle',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
								<?php echo $form->error($direccion,'calle', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6 <?php if($form->error($direccion,'numero_ext')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($direccion,'numero_ext', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($direccion,'numero_ext',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
								<?php echo $form->error($direccion,'numero_ext', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6 <?php if($form->error($direccion,'num_int')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($direccion,'num_int', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($direccion,'num_int',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
								<?php echo $form->error($direccion,'num_int', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6 <?php if($form->error($direccion,'codigo_postal')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($direccion,'codigo_postal', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($direccion,'codigo_postal',array('size'=>45,'maxlength'=>5, 'class'=>'form-control')); ?>
								<?php echo $form->error($direccion,'codigo_postal', array('class'=>'help-block')); ?>
							</div>
						</div>
						<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$direccion)); ?>
					</div>
				</section>					    
				<br />
				<section id="orden">

					<div class="heading text-center">
						<h3 style="color:#1e90ff ">¿Qué estudios necesita?</h3>
						<hr/>
					</div>
					<div class="row">
						<div class="form-group col-md-9">
							<div class="form-group col-md-6">
								<?php echo "<label class='control-label'>Examen</label>"?>
								<div class="input-group">
									<?php echo $form->dropDownList($examenes,'clave', Examenes::model()->selectListWithClave(), array('class'=>'form-control input-medium select2me')); ?>
								</div>
							</div>

							<div class="form-group col-md-6">
								<?php echo "<label class='control-label'>Grupo de exámenes</label>"?>
								<div class="input-group">
									<?php echo $form->dropDownList($examenes,'nombre', Grupos::model()->selectList(), array('class'=>'form-control input-medium select2me')); ?>
								</div>
							</div>
						</div>
					
						<div class="form-group col-md-3" >
							<div class="input-group">
								<input type="hidden" id="examenesIds" name="Examenes[ids]" value />
								<a href="js:void(0);" class="btn default blue-stripe" id="agregarExamen">Agregar</a>
							</div>
						</div>
					</div>
				</section>
				<section id="examenes" >
					<table class="table table-striped table-bordered dataTable">
						<thead >
							<tr>
								<th>Clave</th>
								<th>Examen</th>
								<th>Precio</th>
							</tr>
						</thead>
						<tbody id="examenesAgregados">
							<?php foreach ($listaTarifasExamenes as $tarifaExamen): ?>
								<tr class='row_<?php echo $tarifaExamen->id_examenes;?>' data-id='<?php echo $tarifaExamen->id_examenes;?>'>
									<td><?php echo $tarifaExamen->examen->clave; ?></td>
									<td><?php echo $tarifaExamen->examen->nombre; ?></td>
									<td class="precioExamen" data-val="<?php echo $tarifaExamen->precio; ?>">$ <?php echo $tarifaExamen->precio; ?></td>
									<td><a href='js:void(0)' data-id='<?php echo $tarifaExamen->id_examenes;?>' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</section>
				<br />
				<section id="sumatorias">
					<div class="row">
						<div class="form-group col-md-8"></div>
						<div class="form-group col-md-4">
							<div class="row">
								<div class="form-group col-md-6 "> <center> Subtotal $</center></div>
								<div class="form-group col-md-6 align-right total">0.00 <?php $total ?></div>						
							</div>
							<div class="row">
								<div class="form-group col-md-6  <?php if($form->error($model,'descuento')!=''){ echo 'has-error'; }?>">
										<?php echo $form->labelEx($model,'descuento', array('class'=>'control-label')); ?>
								</div>
								<div class="form-group col-md-6  <?php if($form->error($model,'costo_emergencia')!=''){ echo 'has-error'; }?>">
										<div class="input-group">
											<?php echo $form->textField($model,'descuento',array('size'=>45,'maxlength'=>45,'class'=>'form-control', 'onchange' => 'javascript:$("#descuentoAplicado").toggle()')); ?>							
											<?php echo $form->error($model,'descuento', array('class'=>'help-block')); ?>
										</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6  <?php if($form->error($model,'descuento')!=''){ echo 'has-error'; }?>">
										<?php echo $form->labelEx($model,'costo_emergencia', array('class'=>'control-label')); ?>
								</div>
								<div class="form-group col-md-6  <?php if($form->error($model,'costo_emergencia')!=''){ echo 'has-error'; }?>">
										<div class="input-group">
											<?php echo $form->textField($model,'costo_emergencia',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
											<?php echo $form->error($model,'costo_emergencia', array('class'=>'help-block')); ?>
										</div>
								</div>
							</div>
							
						</div>
					</div>
				</section>
				<br />
				<section id="pagos" >

					<div class="heading text-center">
						<h3 style="color:#1e90ff ">Métodos de pago</h3>
						<hr/>
					</div>
					<div class="row">
						<div class="form-group col-md-8 text-right" > <h3 style="color:#1e90ff">Total </h3></div>
						<div class="form-group col-md-4"><h3 style="color:#1e90ff" id="granTotal" class="total"> $ 1111.00</h3></div>
					</div>
					<div class="row">
						<div class="form-group col-md-8 text-right <?php if($form->error($pagos,'tarjeta')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($pagos,'efectivo', array('class'=>'control-label ')); ?>
							
						</div>
						<div class="form-group col-md-4 <?php if($form->error($pagos,'cheque')!=''){ echo 'has-error'; }?>">
							<div class="input-group">
								<?php echo $form->textField($pagos,'efectivo',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($pagos,'efectivo', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8 text-right <?php if($form->error($pagos,'tarjeta')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($pagos,'tarjeta', array('class'=>'control-label')); ?>
							
						</div>
						<div class="form-group col-md-4 <?php if($form->error($pagos,'cheque')!=''){ echo 'has-error'; }?>">
							<div class="input-group">
								<?php echo $form->textField($pagos,'tarjeta',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($pagos,'tarjeta', array('class'=>'help-block')); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8 text-right <?php if($form->error($pagos,'tarjeta')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($pagos,'cheque', array('class'=>'control-label')); ?>
							
						</div>
						<div class="form-group col-md-4 <?php if($form->error($pagos,'cheque')!=''){ echo 'has-error'; }?>">
							<div class="input-group">
								<?php echo $form->textField($pagos,'cheque',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($pagos,'cheque', array('class'=>'help-block')); ?>
							</div>
							<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$pagos)); ?>
						</div>
					</div>
		
					<div class="row">
						<div class="form-group col-md-8 text-right" > <h3 style="color:#1e90ff">Pago </h3></div>
						<div class="form-group col-md-4"><h3 style="color:#1e90ff" id="pagoTotal"> $999.00</h3></div>
					</div>
					<div class="row">
						<div class="form-group col-md-8 text-right" > <h3 class="debe">Debe </h3></div>
						<div class="form-group col-md-4"><h3 class="debe" id="debe"> $50.00</h3></div>
					</div>

					
				</section>

	
	
	<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>

	
		<div class="form-actions" >
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
		</div>

	</div>
	<?php $this->endWidget(); ?>
</div>

</div><!-- form -->

<script type="text/javascript">
	examenesIds=[];

	function setExamenesIds(){
		var ids=examenesIds.join();
		$("#examenesIds").val(ids);
	}

	function setColorDebe(){
		granTotal=calcularGranTotal();
		pago=calcularPago();
		if(pago>=granTotal)
			$(".debe").addClass("no-debe").removeClass('debe');
		else
			$(".no-debe").addClass("debe").removeClass('no-debe');
	}

	function activarEliminacion(){
		$(".eliminarExamen").click(function(){
			$(".row_"+$(this).data('id')).hide(400);
			$(".row_"+$(this).data('id')).html("");
			aux=[];
			var ids="";
			for (var i = 0; i < examenesIds.length; i++) {
				if(examenesIds[i]!=$(this).data('id')){
					aux.push(examenesIds[i]);
					ids+=examenesIds[i]+",";
				}
			};
			examenesIds=aux;
			$("#examenesIds").val(ids);
			total=calcularTotal();
			setTotal(total);
		});
	}

	function calcularTotal(){
		var suma=0;
		$(".precioExamen").each(function(){
			suma +=$(this).data('val');
		});
		return suma;
	}

	function setTotal(total){
		$(".total").text("$ "+total);
	}

	function calcularGranTotal(){

		var descuento = $("#Ordenes_descuento").val();
		if(descuento=="")
			descuento=0;
		var costo_emergencia=$("#Ordenes_costo_emergencia").val();
		if(costo_emergencia=="")
			costo_emergencia=0;
		var granTotal=0;
		if($.isNumeric( descuento) && descuento<=100){
			var desc = descuento/100;
			var subtotal = calcularTotal();
			var granTotal = subtotal*(1-desc);
		}
		else{
			alerta("El descuento debe ser un número entre 0 y 100","Error");
		}
		if($.isNumeric(costo_emergencia)){
			granTotal=parseFloat(granTotal) + parseFloat(costo_emergencia);
		}
		return granTotal;
	}

	function setGranTotal(granTotal){
		$("#granTotal").text("$ "+granTotal);
	}

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
		return efectivo+tarjeta+cheque;
	}

	function setPago(pago){
		$("#pagoTotal").text("$ "+pago);
		setColorDebe();
	}

	function calcularDebe(){
		granTotal=calcularGranTotal();
		pago=calcularPago();
		debe=granTotal-pago;
		return debe;
	}

	function setDebe(debe){
		$("#debe").text("$ "+debe);
		setColorDebe();
	}

	//Inicializamos los ids por si viene una lista de examenes
	$(".eliminarExamen").each(function(){
		examenesIds.push($(this).data('id'));
	});
	activarEliminacion();
	setExamenesIds();
	total=calcularTotal();
	setTotal(total);
	granTotal=calcularGranTotal();
	setGranTotal(granTotal);
	pago=calcularPago();
	setPago(pago);
	debe=calcularDebe();
	setDebe(debe);
	


	$("#Examenes_nombre").change(function(){
		$("#Examenes_clave").select2('val',null);
	});

	$("#Examenes_clave").change(function(){
		$("#Examenes_nombre").select2('val',null);
	});

	$("#agregarExamen").click(function(){
		var idMultitarifario = $("#Ordenes_id_multitarifarios").val();
		var idExamen = $("#Examenes_clave").val();
		var idGrupo = $("#Examenes_nombre").val();
		if(idMultitarifario>0){
			if(idExamen>0){
				for(var i=0;i<examenesIds.length;i++){
					if(idExamen==examenesIds[i]){
						alerta("El examen seleccionado ya se encuentra en la lista de examenes a realizar");
						return;
					}
				}
				$.post(
					"<?php echo $this->createUrl('ordenes/agregarExamen/');?>",
					{
						id:idExamen,
						tarifa:idMultitarifario
					},
					function(data){
						$("#examenesAgregados").append(data);
						examenesIds.push(idExamen);
						activarEliminacion();
						setExamenesIds();
						total=calcularTotal();
						setTotal(total);
						debe=calcularDebe();
						setDebe(debe);
					}
				);
			}
			else{ 
				if(idGrupo>0){
					$.post(
						"<?php echo $this->createUrl('ordenes/agregarGrupoExamen/');?>",
						{
							id:idGrupo,
							tarifa:idMultitarifario
						},
						function(data){
							for(var i=0;i<examenesIds.length;i++){
								$(".row_"+examenesIds[i]).hide(400);
								$(".row_"+examenesIds[i]).html("");
								examenesIds=[];
								$("#examenesAgregados").html("");
							}
							$("#examenesAgregados").html(data);
							$(".eliminarExamen").each(function(){
								examenesIds.push($(this).data('id'));
							});
							activarEliminacion();
							setExamenesIds();
							total=calcularTotal();
							setTotal(total);
							debe=calcularDebe();
							setDebe(debe);
						}
					);
				}
				else{
					alerta("Debe seleccionar un examen o grupo de examenes");
				}
			}
		}
		else{
			alerta("Debe seleccionar un multitarifario","Aviso");
		}
	});

	$("#Ordenes_id_multitarifarios").change(function(){
		var ids="";
		var idMultitarifario = $(this).val();
		if(examenesIds.length>0){
			ids=examenesIds.join();
			$.post(
					"<?php echo $this->createUrl('ordenes/actualizarPrecios/');?>",
					{
						examenes:ids,
						tarifa:idMultitarifario
					},
					function(data){
						$("#examenesAgregados").html(data);
						activarEliminacion();
						total=calcularTotal();
						setTotal(total);
					}
				);
		}
	});

	$("#Ordenes_descuento").change(function(){
		granTotal=calcularGranTotal();
		$("#granTotal").text("$ "+granTotal);
		debe=calcularDebe();
		setDebe(debe);
	});

	$("#Ordenes_costo_emergencia").change(function(){
		granTotal=calcularGranTotal();
		$("#granTotal").text("$ "+granTotal);
		debe=calcularDebe();
		setDebe(debe);
	});

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

	$("#Pacientes_id").change(function(){
		var idPaciente=$(this).val();
		if(idPaciente>0){
			$.post(
					"<?php echo $this->createUrl('ordenes/datosPacienteExistente/');?>",
					{
						id:idPaciente,
					},
					function(data){
						paciente=JSON.parse(data);
						
						$("#Pacientes_nombre").val(paciente.nombre);
						$("#Pacientes_a_paterno").val(paciente.a_paterno);
						$("#Pacientes_a_materno").val(paciente.a_materno);
						$("#Pacientes_email").val(paciente.email);
						$("#Pacientes_fecha_nacimiento").val(paciente.fecha_nacimiento);
						if(paciente.sexo==0)
							$("#Pacientes_sexo_0").parent().addClass("checked");
						else
							$("#Pacientes_sexo_1").parent().addClass("checked");
						
					}
				);
		}
	});

	$("#Pacientes_nombre").change(function(){$("#Pacientes_id").select2('val',null);});
	$("#Pacientes_a_paterno").change(function(){$("#Pacientes_id").select2('val',null);});
	$("#Pacientes_a_materno").change(function(){$("#Pacientes_id").select2('val',null);});
	$("#Pacientes_email").change(function(){$("#Pacientes_id").select2('val',null);});
	$("#Pacientes_fecha_nacimiento").change(function(){$("#Pacientes_id").select2('val',null);});
	$("#Pacientes_sexo_0").click(function(){$("#Pacientes_id").select2('val',null);});
	$("#Pacientes_sexo_1").click(function(){$("#Pacientes_id").select2('val',null);});

</script>

