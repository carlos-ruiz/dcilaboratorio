<?php
/* @var $this TitulosFormController */
/* @var $model TitulosForm */

$this->breadcrumbs=array(
	'Titulos Forms'=>array('admin'),
	$model->id,
);

?>

<h1>Datos del título: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre'
	),
)); ?>
