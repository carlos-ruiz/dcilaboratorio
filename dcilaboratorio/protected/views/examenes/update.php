<?php
/* @var $this ExamenesController */
/* @var $model Examenes */

$this->breadcrumbs=array(
	'Examenes'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);
?>

<h1>Modificar Examen: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>