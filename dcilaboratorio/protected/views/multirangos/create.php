<?php
/* @var $this MultirangosController */
/* @var $model Multirangos */

$this->breadcrumbs=array(
	'Multirangoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Multirangos', 'url'=>array('index')),
	array('label'=>'Manage Multirangos', 'url'=>array('admin')),
);
?>

<h1>Create Multirangos</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>