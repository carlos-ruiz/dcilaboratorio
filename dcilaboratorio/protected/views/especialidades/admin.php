<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */

$this->breadcrumbs=array(
	'Especialidades'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Especialidades', 'url'=>array('index')),
	array('label'=>'Create Especialidades', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#especialidades-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Especialidades</h1>

<?php echo CHtml::button('Nueva especialidad', array('class'=>'btn btn-sm green','submit'=>array('especialidades/create'))); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'especialidades-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		'ultima_edicion',
		'usuario_ultima_edicion',
		'creacion',
		'usuario_creacion',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
