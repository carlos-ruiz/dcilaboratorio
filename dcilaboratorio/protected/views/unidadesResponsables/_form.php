<?php
/* @var $this UnidadesResponsablesController */
/* @var $model UnidadesResponsables */
/* @var $form CActiveForm */
	Yii::app()->clientScript->registerScript('timepicker', "ComponentsPickers.init();");
?>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Unidad Responsable
		</div>		
	</div>
	<div class="portlet-body form" style="display: block;">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'unidades-responsables-form',
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// There is a call to performAjaxValidation() commented in generated controller code.
// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
			)); ?>

		<div class="form-body">

			<section id="general" class="overflow-auto">
				<div class="form-group col-md-6 <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
					<div class="input-group" >
						<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'nombre', array('class'=>'help-block')); ?>
					</div>
				</div>
				<div class="form-group col-md-6 <?php if($form->error($model,'clave')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'clave', array('class'=>'control-label')); ?>
					<div class="input-group" >
						<?php echo $form->textField($model,'clave',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'clave', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($model,'hora_inicial')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'hora_inicial', array('class'=>'control-label')); ?>
					<div class="input-group bootstrap-timepicker">
						<?php echo $form->textField($model,'hora_inicial',array('size'=>45,'maxlength'=>45, 'class'=>'form-control timepicker timepicker-no-seconds')); ?>
						<span class="input-group-btn fix-clock-icon">
							<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
						</span>
						<?php echo $form->error($model,'hora_inicial', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($model,'hora_final')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'hora_final', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($model,'hora_final',array('size'=>45,'maxlength'=>45, 'class'=>'form-control timepicker timepicker-no-seconds')); ?>
						<span class="input-group-btn fix-clock-icon">
							<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
						</span>

						<?php echo $form->error($model,'hora_final', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($model,'responsable_sanitario')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'responsable_sanitario', array('class'=>'control-label')); ?>
					<div class="input-group" >
						<?php echo $form->textField($model,'responsable_sanitario',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'responsable_sanitario', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($model,'responsable_administrativo')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'responsable_administrativo', array('class'=>'control-label')); ?>
					<div class="input-group" >
						<?php echo $form->textField($model,'responsable_administrativo',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'responsable_administrativo', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($model,'sugerencias')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($model,'sugerencias', array('class'=>'control-label')); ?>
					<div class="input-group" >
						<?php echo $form->textArea($model,'sugerencias',array('rows'=>3, 'cols'=>45, 'class'=>'form-control')); ?>
						<?php echo $form->error($model,'sugerencias', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($contacto,'contacto')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($contacto,'contacto', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->textField($contacto,'contacto',array('size'=>45,'maxlength'=>45, 'class'=>'form-control')); ?>
						<?php echo $form->error($contacto,'contacto', array('class'=>'help-block')); ?>
					</div>
				</div>

			</section>

			<section id="direccion" class="overflow-auto">
				<div class="heading text-center">
					<h3 style="color:#1e90ff">Dirección</h3>
					<hr/>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($direccion,'id_estados')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'id_estados', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php
						$htmlOptions=array("ajax"=>array(
							"url"=>$this->createUrl("direcciones/municipiosPorEstado"),
							"type"=>"POST",
							"update"=>"#Direcciones_id_municipios",
							),
						'class' => 'form-control',"empty"=>"Seleccione una opci&oacute;n")

						?>
						<?php echo $form->dropDownList($direccion,'id_estados',$direccion->obtenerEstados(),$htmlOptions); ?>
						<?php echo $form->error($direccion,'id_estados', array('class'=>'help-block')); ?>
					</div>
				</div>

				<div class="form-group col-md-6 <?php if($form->error($direccion,'id_municipios')!=''){ echo 'has-error'; }?>">
					<?php echo $form->labelEx($direccion,'id_municipios', array('class'=>'control-label')); ?>
					<div class="input-group">
						<?php echo $form->dropDownList($direccion,'id_municipios',$direccion->obtenerMunicipios(), array('class' => 'form-control',"empty"=>"Seleccione una opci&oacute;n")); ?>
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

				<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$contacto)); ?>
			</section>

			<div class="form-actions" >
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
			</div>
		</div>
		<?php $this->endWidget(); ?>
	</div>

</div><!-- form -->