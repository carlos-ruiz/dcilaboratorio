<?php
/* @var $this TarifasActivasController */
/* @var $model TarifasActivas */

$this->breadcrumbs=array(
	'Tarifas Activas'=>array('admin'),
	$model->id,
);
?>

<h1>Tarifa activa: <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'id_examenes',
		'id_multitarifarios',
		'precio',
	),
)); ?>
