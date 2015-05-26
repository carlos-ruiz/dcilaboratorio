<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */
?>


<h1>Orden con folio: <?php echo $model->id; ?></h1>
<div class="form-group col-md-4">

	<div class="heading text-center">
		<h3 style="color:#1e90ff ">Datos de la orden</h3>
		<hr/>
	</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'status.descripcion',
		'fecha_captura',
		'multitarifarios.nombre',
		'descuento',
	),
)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(		
		array(
            'label'=>'Nombre del paciente',
            'type'=>'raw',
            'value'=>$this->obtenerPaciente($model, $this),
        ),
        'pacientes.fecha_nacimiento',
        array(
            'label'=>'Sexo',
            'type'=>'raw',
            'value'=>$this->obtenerGenero($model, $this),
        ),
        

	),
)); 


?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		array(
            'label'=>'Doctor',
            'type'=>'raw',
            'value'=>$this->obtenerNombreCompletoDoctor($model, $this),
        ),
		array(
            'label'=>'Comparte inf. con Dr.',
            'type'=>'raw',
            'value'=>$this->obtenerSioNoComparteDr($model, $this),
        ),
		'informacion_clinica_y_terapeutica',
		'comentarios',        
	),
)); ?>
</div>

<div class="form-group col-md-4">

	<div class="heading text-center">
		<h3 style="color:#1e90ff ">Examenes</h3>
		<hr/>
	</div>

	<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'examenes.nombre',
		      
	),
)); ?>


</div>

<div class="form-group col-md-4">
	
<?php 

/*$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pagos-grid',
	'dataProvider'=>$pagos->search(),
	'columns'=>array(
		'efectivo',
		'tarjeta',
		'cheque',
		'fecha',
	),
)); */

$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$pagos,
		'titulo'=>'Pagos',
		'columnas'=>array(
			'efectivo',
			'tarjeta',
			'cheque',
			'fecha',
		)
	)
); ?>


</div>


