<?php
/* @var $this DoctoresController */
/* @var $model Doctores */

$this->breadcrumbs=array(
	'Doctores'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Doctores', 'url'=>array('index')),
	array('label'=>'Manage Doctores', 'url'=>array('admin')),
);
?>

<h1>Create Doctores</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>