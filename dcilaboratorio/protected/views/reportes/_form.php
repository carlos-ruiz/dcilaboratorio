<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */
/* @var $form CActiveForm */
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Parámetros de búsqueda
		</div>		
	</div>
	<div class="portlet-body form" style="display: block;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reportes-form',
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
echo $form->errorSummary($model);
echo "<br /><br />";
echo $form->errorSummary($direccion);
echo "<br /><br />";
echo $form->errorSummary($pagos);
echo "<br /><br />";
echo $form->errorSummary($datosFacturacion);
*/
?>

	<div class="form-body">
					
	
	
		
				<div class="row">
					<div class="form-group col-md-4  <?php if($form->error($model,'fecha_inicial')!=''){ echo 'has-error'; }?>">
								<?php echo $form->labelEx($model,'fecha_inicial', array('class'=>'control-label')); ?>
								<div class="input-group">	
									<?php echo $form->textField($model,'fecha_inicial',array('size'=>16,'maxlength'=>45,'class'=>'form-control form-control-inline date-picker','data-date-format'=>'yyyy-mm-dd','data-date-language'=>'es')); ?>													
									<?php echo $form->error($model,'fecha_inicial', array('class'=>'help-block')); ?>
								</div>
							</div>
							<div class="form-group col-md-4  <?php if($form->error($model,'fecha_final')!=''){ echo 'has-error'; }?>">
								<?php echo $form->labelEx($model,'fecha_final', array('class'=>'control-label')); ?>
								<div class="input-group">	
									<?php echo $form->textField($model,'fecha_final',array('size'=>16,'maxlength'=>45,'class'=>'form-control form-control-inline date-picker','data-date-format'=>'yyyy-mm-dd','data-date-language'=>'es')); ?>													
									<?php echo $form->error($model,'fecha_final', array('class'=>'help-block')); ?>
								</div>
							</div>
						
					</div>
					<div class="row">
						<div class="form-group col-md-4 <?php if($form->error($model,'id_multitarifarios')!=''){ echo 'has-error'; }?>">
							<?php echo $form->labelEx($model,'id_multitarifarios', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->dropDownList($model,'id_multitarifarios',Multitarifarios::model()->selectList(), array('class'=>'form-control input-medium select2me')); ?>
								<?php echo $form->error($model,'id_multitarifarios', array('class'=>'help-block')); ?>
							</div>
						</div>
						<div class="col-md-4">
							<?php echo $form->labelEx($model,'id_pacientes', array('class'=>'control-label')); ?>
							<div class="input-group">
								<?php echo $form->dropDownList($model,'id_pacientes',Pacientes::model()->selectListWithMail(), array("empty"=>"Seleccione un paciente", 'class'=>'form-control input-medium select2me')); ?>
							</div>
						</div>				

						<div class="form-group col-md-4 <?php if($form->error($model,'id_doctores')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'id_doctores', array('class'=>'control-label')); ?>
									<div class="input-group">
										<?php echo $form->dropDownList($model,'id_doctores',Doctores::model()->selectList(), array('class'=>'form-control input-medium select2me','onchange' => 'javascript:$("#compartirDr").toggle()')); ?>
										<?php echo $form->error($model,'id_doctores', array('class'=>'help-block')); ?>
									</div>
						</div>
					</div>
					<div class="row">
						
							<div class="form-group col-md-4">
								<?php echo "<label class='control-label'>Examen</label>"?>
								<div class="input-group">
									<?php echo $form->dropDownList($model,'clave_examen', Examenes::model()->selectListWithClave(), array('class'=>'form-control input-medium select2me')); ?>
								</div>
							</div>

							<div class="form-group col-md-4">
								<?php echo "<label class='control-label'>Grupo de exámenes</label>"?>
								<div class="input-group">
									<?php echo $form->dropDownList($model,'grupo_examen', Grupos::model()->selectList(), array('class'=>'form-control input-medium select2me')); ?>
								</div>
							</div>
					
					</div>
					<hr/>
					<div class="heading">
						<h5 style="color:#1e90ff ">¿Qué resultados va a tener?</h5>
					</div>
					<div class="row">
							<div class="form-group col-md-2 <?php if($form->error($model,'diadia')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'dia', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'dia',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'dia', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'mes')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'mes', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'mes',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'mes', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'año')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'año', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'año',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'año', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'semana')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'semana', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'semana',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'semana', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'hora')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'hora', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'hora',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'hora', array('class'=>'help-block')); ?>
									</div>
							</div>
					</div>

					<div class="row">
							<div class="form-group col-md-2 <?php if($form->error($model,'folio')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'folio', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'folio',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'folio', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'id_paciente')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'id_paciente', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'id_paciente',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'id_paciente', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'nombre_paciente')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'nombre_paciente', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'nombre_paciente',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'nombre_paciente', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'unidad')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'unidad', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'unidad',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'unidad', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'doctor')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'doctor', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'doctor',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'doctor', array('class'=>'help-block')); ?>
									</div>
							</div>
					</div>
					<div class="row">
							<div class="form-group col-md-2 <?php if($form->error($model,'clave_examen')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'clave_examen', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'clave_examen',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'clave_examen', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'costo')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'costo', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'costo',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'costo', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'porcentaje_descuento')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'porcentaje_descuento', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'porcentaje_descuento',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'porcentaje_descuento', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'monto_descuento')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'monto_descuento', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'monto_descuento',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'monto_descuento', array('class'=>'help-block')); ?>
									</div>
							</div>
							<div class="form-group col-md-2 <?php if($form->error($model,'tarifa')!=''){ echo 'has-error'; }?>">
									<?php echo $form->labelEx($model,'tarifa', array('class'=>'control-label')); ?>
									<div class="input-group" >
										<?php echo $form->checkBox($model,'tarifa',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
										<?php echo $form->error($model,'tarifa', array('class'=>'help-block')); ?>
									</div>
							</div>
					</div>
				
<div class="form-actions" >
			<?php echo CHtml::submitButton( 'Buscar' , array('class'=>'btn blue-stripe')); ?>
		</div>

	

	</div>
	<?php $this->endWidget(); ?>
</div>

</div><!-- form -->



