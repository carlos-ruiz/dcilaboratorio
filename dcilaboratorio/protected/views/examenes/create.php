<?php
/* @var $this ExamenesController */
/* @var $model Examenes */

$this->breadcrumbs=array(
	'Examenes'=>array('index'),
	'Nuevo',
);
?>

<h1>Nuevo Examen</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>