<?php
/* @var $this MultitarifariosController */
/* @var $model Multitarifarios */

$this->breadcrumbs=array(
	'Multitarifarios'=>array('admin'),
	$model->nombre,
);

?>

<h1> Multitarifario: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'descripcion'
	),
)); ?>
