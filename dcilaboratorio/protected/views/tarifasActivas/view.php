<?php
/* @var $this TarifasActivasController */
/* @var $model TarifasActivas */

$this->breadcrumbs=array(
	'Tarifas Activases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TarifasActivas', 'url'=>array('index')),
	array('label'=>'Create TarifasActivas', 'url'=>array('create')),
	array('label'=>'Update TarifasActivas', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TarifasActivas', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TarifasActivas', 'url'=>array('admin')),
);
?>

<h1>View TarifasActivas #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_examenes',
		'id_multitarifarios',
		'precio',
		'ultima_edicion',
		'usuario_ultima_edicion',
		'creacion',
		'usuario_creacion',
	),
)); ?>
