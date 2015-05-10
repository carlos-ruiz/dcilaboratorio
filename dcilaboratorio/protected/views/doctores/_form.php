<?php
/* @var $this DoctoresController */
/* @var $model Doctores */
/* @var $form CActiveForm */

?>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Doctor
		</div>
		
	</div>
	<div class="portlet-body form" style="display: block;">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'doctores-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
			)); ?>

			<div class="form-body">
				<section id="general" class="overflow-auto">

					<div class="form-group col-md-6 <?php if($form->error($model,'id_especialidades')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'id_especialidades', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->dropDownList($model,'id_especialidades',$model->obtenerEspecialidades(), array('class' => 'form-control')); ?>
							<?php echo $form->error($model,'id_especialidades', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'id_titulos')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'id_titulos', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->dropDownList($model,'id_titulos',$model->obtenerTitulos(), array('class' => 'form-control')); ?>
							<?php echo $form->error($model,'id_titulos', array('class'=>'help-block')); ?>
						</div>
					</div>
					
					<div class="form-group col-md-6 <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'nombre', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'a_paterno')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'a_paterno', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'a_paterno',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'a_paterno', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'a_materno')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'a_materno', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'a_materno',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'a_materno', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'correo_electronico')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'correo_electronico', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'correo_electronico',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'correo_electronico', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'hora_consulta_de')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'hora_consulta_de', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'hora_consulta_de',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'hora_consulta_de', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'hora_consulta_hasta')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'hora_consulta_hasta', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'hora_consulta_hasta',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'hora_consulta_hasta', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'porcentaje')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'porcentaje', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'porcentaje',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'porcentaje', array('class'=>'help-block')); ?>
						</div>
					</div>

				</section>

				<section id="contacto" class="overflow-auto">
					<div class="heading text-center">
						<h3>Teléfonos</h3>
						<hr/>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($contacto,'contacto')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($contacto,'Casa', array('class'=>'control-label')); ?>
						<div class="input-group">
							<input size="45" maxlength="45" class="form-control" name="Contactos[contactoCasa]" id="Contactos_casa" type="text">
							<?php echo $form->error($contacto,'contacto', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($contacto,'contacto')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($contacto,'Consultorio', array('class'=>'control-label')); ?>
						<div class="input-group">
							<input size="45" maxlength="45" class="form-control" name="Contactos[contactoConsultorio]" id="Contactos_consultorio" type="text">
							<?php echo $form->error($contacto,'contacto', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($contacto,'contacto')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($contacto,'Celular', array('class'=>'control-label')); ?>
						<div class="input-group">
							<input size="45" maxlength="45" class="form-control" name="Contactos[contactoCelular]" id="Contactos_celular" type="text">
							<?php echo $form->error($contacto,'contacto', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($contacto,'contacto')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($contacto,'Celular', array('class'=>'control-label')); ?>
						<div class="input-group">
							<input size="45" maxlength="45" class="form-control" name="Contactos[contactoCelular]" id="Contactos_celular" type="text">
							<?php echo $form->error($contacto,'contacto', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($contacto,'contacto')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($contacto,'Correo electrónico', array('class'=>'control-label')); ?>
						<div class="input-group">
							<input size="45" maxlength="45" class="form-control" name="Contactos[contactoCorreo]" id="Contactos_correo" type="text">
							<?php echo $form->error($contacto,'contacto', array('class'=>'help-block')); ?>
						</div>
					</div>
				</section>

				<section id="direccion" class="overflow-auto">
					<div class="heading text-center">
						<h3>Dirección</h3>
						<hr/>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'calle')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'calle', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'calle',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'calle', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'ciudad')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'ciudad', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'ciudad',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'ciudad', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'colonia')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'colonia', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'colonia',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'colonia', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'estado')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'estado', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'estado',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'estado', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'codigo_postal')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'codigo_postal', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'codigo_postal',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'codigo_postal', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'numero_ext')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'numero_ext', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'numero_ext',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'numero_ext', array('class'=>'help-block')); ?>
						</div>
					</div>

					<div class="form-group col-md-6 <?php if($form->error($model,'numero_int')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'numero_int', array('class'=>'control-label')); ?>
						<div class="input-group">
							<?php echo $form->textField($model,'numero_int',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
							<?php echo $form->error($model,'numero_int', array('class'=>'help-block')); ?>
						</div>
					</div>

					<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>
				</section>

				<?php echo $form->errorSummary($model); ?>

				<div class="form-actions">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
				</div>

			</div>

			<?php $this->endWidget(); ?>
		</div>
</div><!-- form -->