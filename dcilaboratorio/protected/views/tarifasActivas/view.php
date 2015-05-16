<?php
/* @var $this TarifasActivasController */
/* @var $model TarifasActivas */
?>

<h1>Tarifa activa: <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'examen.nombre',
		'multitarifario.nombre',
		'precio',
	),
)); ?>
