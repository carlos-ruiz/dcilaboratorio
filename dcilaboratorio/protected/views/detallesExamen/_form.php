<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */
/* @var $form CActiveForm */
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			Parámetro de determinación
		</div>
	</div>
	<div class="portlet-body form" style="display: block;">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'detalles-examen-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">

	<div class="form-group <?php if($form->error($model,'id_examenes')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_examenes', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php 
					$htmlOptions = array(
						"ajax"=>array(
							"url"=>$this->createUrl("detallesExamen/obtenerTipoExamen"),
							"type"=>"POST",
							"success"=>"function(data)
                            {
                        		$('#DetallesExamen_tipo input').removeAttr('checked');
                        		$('#DetallesExamen_tipo input').attr('disabled', 'disabled');
	                        	$('#DetallesExamen_tipo span').removeClass('checked');

                        		mostrarCamposRespectoTipo(data);

                        		if (data === 'ninguno') {
                            		$('#DetallesExamen_tipo input').removeAttr('disabled');
                            	}
                            	if (data === 'Normal' || data === 'ninguno') {
                            		$('#DetallesExamen_tipo_0').attr('checked', 'checked');
                            		$('#DetallesExamen_tipo_0').parent().addClass('checked');
                            	}
                            	else if (data === 'Antibiótico') {
                            		$('#DetallesExamen_tipo_1').attr('checked', 'checked');
                            		$('#DetallesExamen_tipo_1').parent().addClass('checked');
                            	}
                            	else if (data === 'Multirango') {
                            		$('#DetallesExamen_tipo_2').attr('checked', 'checked');
                            		$('#DetallesExamen_tipo_2').parent().addClass('checked');
                            	}
                            	else if (data === 'Microorganismo') {
                            		$('#DetallesExamen_tipo_3').attr('checked', 'checked');
                            		$('#DetallesExamen_tipo_3').parent().addClass('checked');
                            	}
                            }"
						),
						"class" => "form-control select2me",
						"empty"=>array(''=>"Seleccione una opci&oacute;n"),
					);
					?>
					<?php echo $form->dropDownList($model,'id_examenes',$model->obtenerExamenes(), $htmlOptions); ?>

					<?php echo $form->error($model,'id_examenes', array('class'=>'help-block')); ?>
				</div>
	</div>

	<div class="form-group <?php if($form->error($model,'descripcion')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'descripcion', array('class'=>'control-label')); ?>
			<div class="input-group" >
				<?php echo $form->textArea($model,'descripcion',array('rows'=>2, 'cols'=>45,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'descripcion', array('class'=>'help-block')); ?>
			</div>
	</div>

	<div class="form-group <?php if($form->error($model,'id_unidades_medida')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_unidades_medida', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php $idUnidadMedida=UnidadesMedida::model()->find('nombre="No Aplica"')->id;?>
					<?php echo $form->dropDownList($model,'id_unidades_medida',$model->obtenerUnidadesMedida(), array('options'=>array($idUnidadMedida=>array('selected'=>true)),'class'=>'form-control')); ?>
					<?php echo $form->error($model,'id_unidades_medida', array('class'=>'help-block')); ?>
				</div>
	</div>

	<div class="form-group <?php if($form->error($model,'genero')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'genero', array('class'=>'control-label')); ?>
		<div class="input-group">
			<?php $generos = array('Indistinto'=>'Indistinto','Hombre'=>'Hombre', 'Mujer'=>'Mujer');
				  echo $form->radioButtonList($model,'genero',$generos,array('separator'=>'   ','class'=>'form-control'));?>
			<?php echo $form->error($model,'genero', array('class'=>'help-block')); ?>
		</div>
	</div>

	<div class="form-group <?php if($form->error($model,'edad_minima')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'edad_minima', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'edad_minima',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'edad_minima', array('class'=>'help-block')); ?>
			</div>
	</div>

	<div class="form-group <?php if($form->error($model,'edad_maxima')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'edad_maxima', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'edad_maxima',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'edad_maxima', array('class'=>'help-block')); ?>
			</div>
	</div>

	<div class="form-group <?php if($form->error($model,'tipo')!=''){ echo 'has-error'; }?>">
		<?php echo $form->labelEx($model,'tipo', array('class'=>'control-label')); ?>
		<div class="input-group">
			<?php $tipos = array('Normal'=>'Normal','Antibiótico'=>'Antibiótico', 'Multirango'=>'Multirango', 'Microorganismo'=>'Microorganismo');
				$htmlOption = array('separator'=>'   ','class'=>'form-control tipo-test');
				if (!$model->isNewRecord) {
					$htmlOption['disabled'] = 'disabled';
				}
				  echo $form->radioButtonList($model,'tipo',$tipos,$htmlOption);?>
			<?php echo $form->error($model,'tipo', array('class'=>'help-block')); ?>
		</div>
	</div>

	<div id="camposAntibiotico" class="row" style="display:<?php echo $model->tipo=='Antibiótico'?'block':'none'; ?>">
		
		<div class="form-group col-md-4 <?php if($form->error($model,'rango_inferior')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'rango_inferior', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'rango_inferior',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'rango_inferior', array('class'=>'help-block')); ?>
			</div>
		</div>

		<div class="form-group col-md-4 <?php if($form->error($model,'rango_promedio')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'rango_promedio', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'rango_promedio',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'rango_promedio', array('class'=>'help-block')); ?>
			</div>
		</div>

		<div class="form-group col-md-4 <?php if($form->error($model,'rango_superior')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'rango_superior', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'rango_superior',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'rango_superior', array('class'=>'help-block')); ?>
			</div>
		</div>

		<div class="form-group col-md-4 <?php if($form->error($model,'concentracion')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'concentracion', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'concentracion',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'concentracion', array('class'=>'help-block')); ?>
			</div>
		</div>		
	</div>

	<div id="camposNormal" style="display:<?php echo $model->tipo=='Normal'?'block':'none'; ?>">
		<div class="form-group col-md-4 <?php if($form->error($model,'rango_inferior')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'rango_inferior', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'rango_inferior',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'rango_inferior', array('class'=>'help-block')); ?>
			</div>
		</div>

		<div class="form-group col-md-4 <?php if($form->error($model,'rango_promedio')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'rango_promedio', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'rango_promedio',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'rango_promedio', array('class'=>'help-block')); ?>
			</div>
		</div>

		<div class="form-group col-md-4 <?php if($form->error($model,'rango_superior')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'rango_superior', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php echo $form->textField($model,'rango_superior',array('size'=>45,'maxlength'=>65, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'rango_superior', array('class'=>'help-block')); ?>
			</div>
		</div>
	</div>

	<div id="camposMultirangos" style="display:<?php echo $model->tipo=='Multirango'?'block':'none'; ?>">
		<div class="form-group <?php if($form->error($model,'multirangos')!=''){ echo 'has-error'; }?>">
			<label class="control-label" for="DetallesExamen_multirangos">Seleccione los multirangos.</label>
			<div class="input-group">
				<?php echo $form->dropDownList($model,'multirangos',multirangos::model()->selectListMultiple(), array("class" => "form-control select2","multiple"=>"multiple")); ?>
			</div>
		</div>
	</div>
	<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>


	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
	$(".tipo-test").click(function(){
		mostrarCamposRespectoTipo($(this).val());
	});

	function mostrarCamposRespectoTipo(tipo){
		if(tipo=="Normal" || tipo == "ninguno"){
			$("#camposAntibiotico").hide();
			$("#camposMultirangos").hide();
			$("#camposNormal").show(400);
		}
		else if(tipo=="Antibiótico"){
			$("#camposNormal").hide();
			$("#camposMultirangos").hide();
			$("#camposAntibiotico").show(400);
		}
		else if(tipo=="Multirango"){
			$("#camposAntibiotico").hide();
			$("#camposNormal").hide();
			$("#camposMultirangos").show(400);
		}
		else if(tipo=="Microorganismo"){
			$("#camposAntibiotico").hide(400);
			$("#camposNormal").hide(400);
			$("#camposMultirangos").hide(400);
		}
	}
</script>
