<?php
/* @var $this MultirangosController */
/* @var $model Multirangos */

$this->breadcrumbs=array(
	'Multirangoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Multirangos', 'url'=>array('index')),
	array('label'=>'Create Multirangos', 'url'=>array('create')),
	array('label'=>'Update Multirangos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Multirangos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Multirangos', 'url'=>array('admin')),
);
?>

<h1>View Multirangos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'rango_inferior',
		'rango_superior',
	),
)); ?>
