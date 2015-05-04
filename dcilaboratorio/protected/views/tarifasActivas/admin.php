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
		array(
			'name'=>"id_examenes",
			'header'=>'Exámen',
			'value'=>array($this, 'obtenerNombreExamen'),
			),
		array(
			'name'=>'id_multitarifarios',
			'header'=>'Multitarifario',
			'value'=>array($this, 'obtenerNombreMultitarifario'),
			),
		array(
			'name'=>'precio',
			'value'=>array($this, 'obtenerPrecioConFormato'),
			),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
