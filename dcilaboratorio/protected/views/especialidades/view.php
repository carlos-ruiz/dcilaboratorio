<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */

$this->breadcrumbs=array(
	'Especialidades'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Especialidades', 'url'=>array('index')),
	array('label'=>'Create Especialidades', 'url'=>array('create')),
	array('label'=>'Update Especialidades', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Especialidades', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Especialidades', 'url'=>array('admin')),
);
?>

<h1>View Especialidades #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'ultima_edicion',
		'usuario_ultima_edicion',
		'creacion',
		'usuario_creacion',
	),
)); ?>
