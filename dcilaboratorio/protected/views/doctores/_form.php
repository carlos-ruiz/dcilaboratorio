
<?php
/* @var $this DoctoresController */
/* @var $model Doctores */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerScript('timepicker', "
	ComponentsPickers.init();
");

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
						<?php echo $form->dropDownList($model,'id_especialidades',$model->obtenerEspecialidades(), array('class' => 'form-control',"empty"=>"Seleccione una opci&oacute;n")); ?>
						<?php echo $form->error($model,'id_especialidades', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($model,'id_titulos')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'id_titulos', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->dropDownList($model,'id_titulos',$model->obtenerTitulos(), array('class' => 'form-control',"empty"=>"Seleccione una opci&oacute;n")); ?>
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
					<div class="input-group bootstrap-timepicker">
						<?php echo $form->textField($model,'hora_consulta_de',array('size'=>45,'maxlength'=>45, 'class'=>'form-control timepicker timepicker-no-seconds')); ?>
						<span class="input-group-btn fix-clock-icon">
							<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
						</span>
						<?php echo $form->error($model,'hora_consulta_de', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($model,'hora_consulta_hasta')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'hora_consulta_hasta', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($model,'hora_consulta_hasta',array('size'=>45,'maxlength'=>45, 'class'=>'form-control timepicker timepicker-no-seconds')); ?>
						<span class="input-group-btn fix-clock-icon">
							<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
						</span>

						<?php echo $form->error($model,'hora_consulta_hasta', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($unidad,'id_unidades_responsables')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($unidad,'Unidad enlace', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->listBox($unidad,'id_unidades_responsables',CHtml::listData($urs,'id','nombre'), array('class' => 'form-control', 'multiple'=>'true', 'options'=>$unidadesSeleccionadas)); ?>
						<?php echo $form->error($unidad,'id_unidades_responsables', array('class'=>'help-block')); ?>
					</div>
				</div>

			</section>

			<section id="contacto" class="overflow-auto">
				<div class="heading text-center">
					<h3 style="color:#1e90ff ">Tel??fonos</h3>
					<hr/>
				</div>

				<?php foreach ($contactos as $i => $contact) { ?>
				<div class="form-group col-md-6">
					<?php echo $form->labelEx($contact,$i==0?'Casa':($i==1?'Consultorio':'Celular'), array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($contact,"[$i]contacto",array('size'=>45,'maxlength'=>20, 'class'=>'form-control')); ?>
					</div>
				</div>
				<?php } ?>
			</section>

			<section id="direccion" class="overflow-auto">
				<div class="heading text-center">
					<h3 style="color:#1e90ff">Direcci??n</h3>
					<hr/>
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

				<div class="form-group col-md-6 <?php if($form->error($direccion,'codigo_postal')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'codigo_postal', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($direccion,'codigo_postal',array('size'=>45,'maxlength'=>5, 'class'=>'form-control')); ?>
						<?php echo $form->error($direccion,'codigo_postal', array('class'=>'help-block')); ?>
					</div>
				</div>

				<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>

				<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$direccion)); ?>
			</section>

			<div class="form-actions">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
			</div>
		</div>
		<?php $this->endWidget(); ?>
	</div>
</div><!-- form -->
