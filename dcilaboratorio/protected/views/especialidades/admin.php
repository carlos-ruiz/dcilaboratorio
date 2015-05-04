<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */
$this->breadcrumbs=array(
	'Especialidades'=>array('index'),
	'Administrar especialidades',
);

$this->pageTitle="Especialidades";
?>

<h1>Administrar especialidades</h1>

<?php echo CHtml::button('Nueva especialidad', array('class'=>'btn btn-sm green','submit'=>array('especialidades/create'))); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'especialidades-grid',
	'itemsCssClass'=>'table table-hover',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
