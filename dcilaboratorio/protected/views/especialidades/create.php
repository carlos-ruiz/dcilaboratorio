<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */

$this->breadcrumbs=array(
	'Especialidades'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Especialidades', 'url'=>array('index')),
	array('label'=>'Manage Especialidades', 'url'=>array('admin')),
);
?>

<h1>Create Especialidades</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>