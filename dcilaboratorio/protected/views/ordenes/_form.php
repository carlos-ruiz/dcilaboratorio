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
				<section id="general" class="overflow-auto">

					<div class="heading text-center">
						<h3 style="color:#1e90ff ">Datos del paciente</h3>
						<hr/>
					</div>

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
							<?php 
							$this->widget("zii.widgets.jui.CJuiDatePicker",array(
								"attribute"=>"fecha_nacimiento",
								"model"=>$paciente,
								"language"=>"es",
								"options"=>array(
								"dateFormat"=>"dd-mm-yy",
								"showButtonPanel"=>true,
								"changeYear"=>true,
								"dateFormat"=>"dd-mm-yy",
								"yearRange" => "-110:-0",
								'class'=>'form-control'
							)
							));
							?>							
							<?php echo $form->error($paciente,'fecha_nacimiento', array('class'=>'help-block')); ?>
						</div>
					</div>
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

					<div class="form-group col-md-6 <?php if($form->error($model,'requiere_factura')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'requiere_factura', array('class'=>'control-label')); ?>
						<div class="input-group" >
							<?php echo $form->checkBox($model,'requiere_factura',array('size'=>45,'maxlength'=>45,'class'=>'form-control',  'onchange' => 'javascript:$("#datosFacturacion").toggle()')); ?>
							<?php echo $form->error($model,'requiere_factura', array('class'=>'help-block')); ?>
						</div>
					</div>
				</section>



				<div id="datosFacturacion" style="display:none;">
					<section id="facturacion" class="overflow-auto">

					<div class="heading text-center">
						<h3 style="color:#1e90ff ">Datos de Facturación</h3>
						<hr/>
					</div>

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

					<div class="form-group col-md-6  <?php if($form->error($datosFacturacion,'estado')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($datosFacturacion,'estado', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($datosFacturacion,'estado',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
							<?php echo $form->error($datosFacturacion,'estado', array('class'=>'help-block')); ?>
						</div>
					</div>


					<div class="form-group col-md-6  <?php if($form->error($datosFacturacion,'ciudad')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($datosFacturacion,'ciudad', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($datosFacturacion,'ciudad',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
							<?php echo $form->error($datosFacturacion,'ciudad', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6  <?php if($form->error($datosFacturacion,'colonia')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($datosFacturacion,'colonia', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($datosFacturacion,'colonia',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
							<?php echo $form->error($datosFacturacion,'colonia', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6  <?php if($form->error($datosFacturacion,'calle')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($datosFacturacion,'calle', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($datosFacturacion,'calle',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
							<?php echo $form->error($datosFacturacion,'calle', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6  <?php if($form->error($datosFacturacion,'num_ext')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($datosFacturacion,'num_ext', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($datosFacturacion,'num_ext',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
							<?php echo $form->error($datosFacturacion,'num_ext', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6  <?php if($form->error($datosFacturacion,'num_int')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($datosFacturacion,'num_int', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($datosFacturacion,'num_int',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>							
							<?php echo $form->error($datosFacturacion,'num_int', array('class'=>'help-block')); ?>
						</div>
					</div>


					</section>					    
				</div>

				<section id="drs" class="overflow-auto">

					<div class="form-group col-md-6 <?php if($form->error($model,'id_doctores')!=''){ echo 'has-error'; }?>">
								<?php echo $form->labelEx($model,'id_doctores', array('class'=>'control-label')); ?>
								<div class="input-group">
									<?php echo $form->dropDownList($model,'id_doctores',$model->obtenerDoctores(), array("empty"=>"Seleccione una opción", 'class'=>'form-control','onchange' => 'javascript:$("#compartirDr").toggle()')); ?>
									
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

				</section>

				<section id="comentarios" class="overflow-auto">

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

					<div class="form-group col-md-6 <?php if($form->error($model,'id_multitarifarios')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'id_multitarifarios', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->dropDownList($model,'id_multitarifarios',$model->obtenerMultitarifarios(), array("empty"=>"Seleccione una opción", 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'id_multitarifarios', array('class'=>'help-block')); ?>
						</div>
					</div>

				</section>

				<section id="orden" class="overflow-auto">

					<div class="heading text-center">
						<h3 style="color:#1e90ff ">¿Qué estudios necesita?</h3>
						<hr/>
					</div>
					<div class="form-group col-md-8">
					<div class="form-group col-md-4">
						<?php echo "<label class='control-label'>Clave de examen</label>"?>
						<div class="input-group">
							<?php echo $form->dropDownList($examenes,'clave', $model->obtenerExamenesClave(), array("empty"=>"Seleccione una opción", 'class'=>'form-control')); ?>
						</div>
					</div>

					<div class="form-group col-md-4">
						<?php echo "<label class='control-label'>Exámenes</label>"?>
						<div class="input-group">
							<?php echo $form->dropDownList($examenes,'id', $model->obtenerExamenes(), array("empty"=>"Seleccione una opción", 'class'=>'form-control')); ?>
						</div>
					</div>

					<div class="form-group col-md-4">
						<?php echo "<label class='control-label'>Clave de Grupo de exámenes</label>"?>
						<div class="input-group">
							<?php echo $form->dropDownList($examenes,'clave', $model->obtenerGrupoExamenes(), array("empty"=>"Seleccione una opción", 'class'=>'form-control')); ?>
						</div>
					</div>
					</div>

					<div class="form-group  col-md-4" >
						<div class="input-group">
						<?php echo CHtml::submitButton( 'Agregar' , array('class'=>'btn blue-stripe')); ?>
						</div>
					</div>

				</section>

				<section id="examenes" >

					<?php 
						$this->renderPartial(
							'/comunes/_comunAdmin', 
							array(
								'model'=>$model,
								'titulo'=>'Examenes',
								'columnas'=>array(
									'nombre'
								)
							)
						); ?>

				</section>

				<section id="sumatorias" class="overflow-auto">

					<div class="form-group col-md-8"></div>
					<div class="form-group col-md-4">
						

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
						
							<div class="form-group col-md-6 "> <center> Total $</center></div>
							<div class="form-group col-md-6 align-right">999.00 <?php $total ?></div>						
						

							<div id="descuentoAplicado" style="display:none;">	
								<div class="form-group col-md-6"> <center> Con descuento $</center></div>
								<div class="col-md-6 align-right"> 888.00<?php $totalDesc ?></div>
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
<a class="btn red" href="<?php echo CController::createUrl('ordenes/loadModalContent',array('id'=>''));?>" data-target="#modal" data-toggle="modal">modal</a>
	
</div><!-- form -->

