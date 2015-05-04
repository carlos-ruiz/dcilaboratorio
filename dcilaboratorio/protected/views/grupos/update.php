<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */

$this->breadcrumbs=array(
	'Grupos Examenes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GruposExamenes', 'url'=>array('index')),
	array('label'=>'Create GruposExamenes', 'url'=>array('create')),
	array('label'=>'View GruposExamenes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GruposExamenes', 'url'=>array('admin')),
);
?>

<h1>Update GruposExamenes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model,'examenes'=>$examenes,'tiene'=>$tiene)); ?>