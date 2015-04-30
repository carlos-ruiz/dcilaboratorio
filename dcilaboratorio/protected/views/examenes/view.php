<?php
/* @var $this ExamenesController */
/* @var $model Examenes */

$this->breadcrumbs=array(
	'Examenes'=>array('index'),
	$model->id,
);
?>

<h1>Examen: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'clave',
		'nombre',
		'descripcion',
		'duracion_dias',
		'indicaciones_paciente',
		'indicaciones_laboratorio'
	),
)); ?>
