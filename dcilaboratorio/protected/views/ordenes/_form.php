<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */
/* @var $form CActiveForm */
?>
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

	<div class="form-body">

	<div class="form-body">
				<section id="general">
					<div class="heading text-center">
						<h3 style="color:#1e90ff ">Datos del paciente</h3>
						<hr/>
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
								<?php echo $form->textField($paciente,'fecha_nacimiento',array('size'=>16,'maxlength'=>45,'class'=>'form-control form-control-inline date-picker')); ?>													
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
										<?php echo $form->dropDownList($model,'id_doctores',$model->obtenerDoctores(), array("empty"=>"Seleccione una opción", 'class'=>'form-control medium-field select2me','onchange' => 'javascript:$("#compartirDr").toggle()')); ?>
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
								<?php echo $form->dropDownList($model,'id_multitarifarios',$model->obtenerMultitarifarios(), array("empty"=>"Seleccione una opción", 'class'=>'form-control select2me')); ?>
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
				<section id="facturacion" style="display:none;">

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
					<div class="row">
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
										"class" => "form-control select2me",
										"empty"=>"Seleccione una opci&oacute;n",
										"data-placeholder"=>"--Seleccione--",
									);
								?>
								<?php echo $form->dropDownList($direccion,'id_estados',$direccion->obtenerEstados(), $htmlOptions); ?>
								<?php echo $form->error($direccion,'id_estados', array('class'=>'help-block')); ?>
							</div>
						</div>

						<div class="form-group col-md-6 <?php if($form->error($direccion,'id_municipios')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($direccion,'id_municipios', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->dropDownList($direccion,'id_municipios',$direccion->obtenerMunicipios(), array('class' => 'form-control select2me',"empty"=>"Seleccione una opci&oacute;n")); ?>
								<?php echo $form->error($direccion,'id_municipios', array('class'=>'help-block')); ?>
							</div>
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
						<div class="form-group col-md-8">
							<div class="form-group col-md-8">
								<?php echo "<label class='control-label'>Examen</label>"?>
								<div class="input-group">
									<?php echo $form->dropDownList($examenes,'clave', Examenes::model()->selectListWithClave(), array('class'=>'form-control select2me')); ?>
								</div>
							</div>

							<div class="form-group col-md-4">
								<?php echo "<label class='control-label'>Grupo de exámenes</label>"?>
								<div class="input-group">
									<?php echo $form->dropDownList($examenes,'nombre', Grupos::model()->selectList(), array('class'=>'form-control select2me')); ?>
								</div>
							</div>
						</div>
					
						<div class="form-group  col-md-4" >
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
						</tbody>
					</table>
				</section>
				<br />
				<section id="sumatorias">
					<div class="row">
						<div class="form-group col-md-8"></div>
						<div class="form-group col-md-4">
							<div class="row">
								<div class="form-group col-md-6  <?php if($form->error($model,'descuento')!=''){ echo 'has-error'; }?>">
										<?php echo $form->labelEx($model,'descuento', array('class'=>'control-label')); ?>
										<div class="input-group">
											<?php echo $form->textField($model,'descuento',array('size'=>45,'maxlength'=>45,'class'=>'form-control', 'onchange' => 'javascript:$("#descuentoAplicado").toggle()')); ?>							
											<?php echo $form->error($model,'descuento', array('class'=>'help-block')); ?>
										</div>
								</div>
								<div class="form-group col-md-6  <?php if($form->error($model,'costo_emergencia')!=''){ echo 'has-error'; }?>">
										<?php echo $form->labelEx($model,'costo_emergencia', array('class'=>'control-label')); ?>
										<div class="input-group">
											<?php echo $form->textField($model,'costo_emergencia',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
											<?php echo $form->error($model,'costo_emergencia', array('class'=>'help-block')); ?>
										</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6 "> <center> Total $</center></div>
								<div class="form-group col-md-6 align-right">999.00 <?php $total ?></div>						
							</div>
							<div class="row">
								<div id="descuentoAplicado" style="display:none;">	
									<div class="form-group col-md-6"> <center> Con descuento $</center></div>
									<div class="col-md-6 align-right"> 888.00<?php $totalDesc ?></div>
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
						<div class="form-group  col-md-4 <?php if($form->error($pagos,'efectivo')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($pagos,'efectivo', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($pagos,'efectivo',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($pagos,'efectivo', array('class'=>'help-block')); ?>
							</div>
						</div>
						<div class="form-group   col-md-4 <?php if($form->error($pagos,'tarjeta')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($pagos,'tarjeta', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($pagos,'tarjeta',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($pagos,'tarjeta', array('class'=>'help-block')); ?>
							</div>
						</div>
						<div class="form-group  col-md-4 <?php if($form->error($pagos,'cheque')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($pagos,'cheque', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->textField($pagos,'cheque',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
								<?php echo $form->error($pagos,'cheque', array('class'=>'help-block')); ?>
							</div>
							<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$pagos)); ?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8"></div>
						<div class="form-group col-md-4">
							<div class="form-group "> <h3 style="color:#1e90ff ">Total $ 1111.00 <? //$total?></h3></div>
							<div class="form-group align-right"><h3 style="color:#1e90ff ">Pago $999.00 <?php $sumatoria ?></h3></div>
							<!-- Sólo si no paga completo-->
							<div class="form-group align-right"><h3 style="color:#FE2E64 ">Debe<?php $sumatoria ?></h3></div>
						</div>
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

	function activarEliminacion(){
		$(".eliminarExamen").click(function(){
			$(".row_"+$(this).data('id')).hide(400);
			$(".row_"+$(this).data('id')).html("");
			aux=[];
			for (var i = examenesIds.length - 1; i >= 0; i--) {
				if(examenesIds[i]!=$(this).data('id'))
				aux.push(examenesIds[i]);
			};
			examenesIds=aux;
		});
	}

	$("#Examenes_nombre").change(function(){
		$("#Examenes_clave").val(0);
	});

	$("#Examenes_clave").change(function(){
		$("#Examenes_nombre").val(0);
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
							examenesIds.push(idExamen);
							activarEliminacion();
						}
					);
				}
				else{
					alerta("Debe seleccionar un examen o grupo de examenes");
				}
			}
		}
		else{
			alerta("Debe seleccionar un multitarifario");
		}
	});



</script>

