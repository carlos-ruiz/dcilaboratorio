<?php
/* @var $this TarifasActivasController */
/* @var $model TarifasActivas */

$this->breadcrumbs=array(
	'Tarifas Activas'=>array('admin'),
	$model->id,
);
?>

<h1>Datos de la tarifa: <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_examenes',
		'id_multitarifarios',
		'precio',
	),
)); ?>
