<?php
/* @var $this DoctoresController */
/* @var $model Doctores */

$this->breadcrumbs=array(
	'Doctores'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Doctores', 'url'=>array('index')),
	array('label'=>'Create Doctores', 'url'=>array('create')),
	array('label'=>'View Doctores', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Doctores', 'url'=>array('admin')),
);
?>

<h1>Update Doctores <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>