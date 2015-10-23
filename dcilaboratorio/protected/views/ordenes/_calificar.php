<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */
?>
<div class="portlet light">
	<div class="row">
		<h1>Orden con folio: <?php echo $model->id; ?></h1>
		<div class="form-group col-md-4">

			<div class="heading text-center">
				<h3 style="color:#1e90ff ">Datos de la orden</h3>
			</div>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
			'attributes'=>array(		
				array('name' => 'Fecha',
		            'value' => date("j/m/Y H:i", strtotime($model->fecha_captura))
		        ),
		        array(
		            'label'=>'Paciente',
		            'type'=>'raw',
		            'value'=>$this->obtenerPaciente($model, $this),
		        ), 
		        array(
		            'label'=>'Doctor',
		            'type'=>'raw',
		            'value'=>($model->id_doctores!=null)?$this->obtenerNombreCompletoDoctor($model, $this):"No asignado",
		        ),
				
			),
		)); ?>
		</div>

		<div class="portlet-body form" style="display: block;">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'resultados-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
		)); ?>

			<div class="form-group col-md-8">

			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption text-center">
						Resultados de examenes			
					</div>		
				</div>
			</div>
				
			<?php

			$anterior=0;
			echo '<table class="table table-striped table-bordered dataTable">';

			foreach ($ordenExamenesModel as $i => $ordenExamen){
				$detalleExamen=$ordenExamen->detalleExamen;
				$examen=$detalleExamen->examenes;
				if($examen->id!=$anterior){
					echo '
					<thead>
						<tr>
							<th colspan="4" style="color:#1e90ff ">'.$examen->nombre.'</th>
						</tr>
					</thead>
					<tr>
						<td>Descripción</td>
						<td>Resultado</td>
						<td>Unidad Medida</td>
						<td>Rango normal</td>
					</tr>';
				}

				echo '
					<tr>
						<td>'.$detalleExamen->descripcion.'</td>'.
						'<td>'.$form->textField($ordenExamen,"[$i]resultado",array('size'=>25,'maxlength'=>25,'class'=>'form-control')).'</td>
						<td>'.$detalleExamen->unidadesMedida->nombre.'</td>
						<td>'.$detalleExamen->rango_inferior.'-'.$detalleExamen->rango_superior.'</td>
					</tr>';
				$anterior=$examen->id;
			};
			 echo'</table>';

			 ?>

				<?php $this->renderPartial('/umodif/_modifandcreate', array('form'=>$form, 'model'=>$model)); ?>
				<br />
				<div class="row">
					<div class="form-group col-md-12 <?php if($form->error($model,'comentarios_resultados')!=''){ echo 'has-error'; }?>">
						<?php echo $form->labelEx($model,'comentarios_resultados', array('class'=>'control-label')); ?>
						<div class="input-group width-all">
							<?php echo $form->textArea($model,'comentarios_resultados',array('rows'=>3, 'cols'=>45, 'class'=>'form-control width-all')); ?>
							<?php echo $form->error($model,'comentarios_resultados', array('class'=>'help-block')); ?>
						</div>
					</div>
				</div>

				<div class="form-actions" >
						<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn blue-stripe')); ?>
					</div>

				</div>
				<?php $this->endWidget(); ?>

		</div><!-- form -->
	</div>
</div>
