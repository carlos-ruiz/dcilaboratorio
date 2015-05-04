<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */

$this->breadcrumbs=array(
	'Grupos Examenes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GruposExamenes', 'url'=>array('index')),
	array('label'=>'Create GruposExamenes', 'url'=>array('create')),
	array('label'=>'Update GruposExamenes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GruposExamenes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GruposExamenes', 'url'=>array('admin')),
);
?>

<h1>View GruposExamenes #<?php echo $model->id; ?></h1>

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
