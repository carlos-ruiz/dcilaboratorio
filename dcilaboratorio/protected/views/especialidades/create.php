<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */
$this->breadcrumbs=array(
	'Especialidades'=>array('index'),
	'Nueva especialidad',
);

$this->pageTitle="Especialidades";
?>

<h1>Nueva especialidad</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>