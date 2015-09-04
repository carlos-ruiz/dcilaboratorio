<?php
/* @var $this ExamenesController */
/* @var $model Examenes */
?>

<h1>Determinación: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'clave',
		'nombre',
		'descripcion',
		'tecnica',
		'duracion_dias',
		'indicaciones_paciente',
		'indicaciones_laboratorio'
	),
)); ?>
