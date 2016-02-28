<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */

//$nivelImpresionSubgrupo=0;


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

			$examenesImpresos=array();
			foreach ($ordenGruposModel as $grupote) {
				echo '<table class="table table-striped table-bordered dataTable">';
							echo '
				   		<thead class="encabezados" ><tr><td style="color:#04C !important">Descripción</td>
				   		<td style="color:#04C !important">Resultado</td>
				   		<td style="color:#04C !important">Unidad de medida</td>
				   		<td colspan="3" style="color:#04C !important">Parámetros de referencia</td></tr></thead>';
				   		
				$examenesImpresos=$this->imprimirGrupo($grupote->id_grupos,$model->id);

				echo "</table>";
			}
			echo "<br />";
			// Muestra los examenes individuales normales

			$this->imprimirNormal($model,$examenesImpresos,true);

			 echo "<br />";
			// Muestra los examenes individuales antibioticos

			$this->imprimirAntibiotico($model,$examenesImpresos,true);

			 echo "<br />";
			// Muestra los examenes individuales multirangos

			$this->imprimirMultirango($model,$examenesImpresos,true);

			echo "<br />";
			// Muestra los examenes individuales microorganismos

			$this->imprimirMicroorganismo($model,$examenesImpresos, true);

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
