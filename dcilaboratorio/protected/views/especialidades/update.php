<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */

$this->breadcrumbs=array(
	'Especialidades'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Especialidades', 'url'=>array('index')),
	array('label'=>'Create Especialidades', 'url'=>array('create')),
	array('label'=>'View Especialidades', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Especialidades', 'url'=>array('admin')),
);
?>

<h1>Update Especialidades <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>