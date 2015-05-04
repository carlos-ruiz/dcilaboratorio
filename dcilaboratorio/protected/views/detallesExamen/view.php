<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */

$this->breadcrumbs=array(
	'Resultado de Examens'=>array('index'),
	$model->id,
);
?>

<h1>Resultado de Examen: <?php echo $model->descripcion; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'descripcion',
		'id_unidades_medida',
		'id_examenes',
	),
)); ?>
