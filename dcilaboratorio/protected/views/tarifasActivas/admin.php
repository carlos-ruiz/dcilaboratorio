<?php
/* @var $this TarifasActivasController */
/* @var $model TarifasActivas */

$this->breadcrumbs=array(
	'Exámenes'=>array('examenes/admin'),
	'Administrar tarifas activas',
);
?>

<h1>Administrar tarifas activas</h1>

<?php echo CHtml::button('Nueva tarifa activa', array('class'=>'btn btn-sm green','submit'=>array('tarifasActivas/create'))); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tarifas-activas-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'id_examenes',
		'id_multitarifarios',
		'precio',
		'ultima_edicion',
		'usuario_ultima_edicion',
		/*
		'creacion',
		'usuario_creacion',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
