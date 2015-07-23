<?php
/* @var $this FacturacionController */
/* @var $form CActiveForm */
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
				</section>

				<section id="conceptos">
					<div class="heading text-center">
						<h3 style="color:#1e90ff ">Conceptos</h3>
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
									<td class="precioExamen" data-val="<?php echo isset($tarifaExamen->precio)?$tarifaExamen->precio:0; ?>">

									<?php echo isset($tarifaExamen->precio)?
										"$ ".$tarifaExamen->precio:
										"<div style='margin:0px;' class='form-group ".($form->error($tarifaExamen,'precio')!=''?"has-error":"")."'>".
											"<div class='row' style='margin-left:5px'>No hay precio para el tarifario seleccionado ".
											"<a href='js:void(0)' data-id='$tarifaExamen->id_examenes' class='btn default blue-stripe agregarPrecio' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;'>Agregar precio</a> ".
											"<input type='text' class='form-control input-small' id='addPrecio_$tarifaExamen->id_examenes' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />".
											"</div><div class='help-block row' style='float:right; margin:0px;'>Debe agregar un precio para el examen en el multitarifario seleccionado.</div>".
										"</div>"; ?>
									</td>

									<td><a href='js:void(0)' data-id='<?php echo $tarifaExamen->id_examenes;?>' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</section>

				<div class="form-actions">
					<?php echo CHtml::submitButton('Guardar', array('class'=>'btn blue-stripe')); ?>
				</div>
			</div>

		<?php $this->endWidget(); ?>
