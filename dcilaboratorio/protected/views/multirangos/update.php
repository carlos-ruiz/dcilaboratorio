<?php
/* @var $this MultirangosController */
/* @var $model Multirangos */

$this->breadcrumbs=array(
	'Multirangoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Multirangos', 'url'=>array('index')),
	array('label'=>'Create Multirangos', 'url'=>array('create')),
	array('label'=>'View Multirangos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Multirangos', 'url'=>array('admin')),
);
?>

<h1>Update Multirangos <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>