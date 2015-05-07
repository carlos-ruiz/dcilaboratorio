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

<?php echo CHtml::link('<i class="icon-plus"></i> Nueva especialidad', array('especialidades/create'), array('class'=>'btn text-right')); ?>

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
