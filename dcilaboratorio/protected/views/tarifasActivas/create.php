<?php
/* @var $this TarifasActivasController */
/* @var $model TarifasActivas */
$this->pageTitle="Tarifas activas";
$this->breadcrumbs=array(
	'Tarifas Activas'=>array('index'),
	'Nueva tarifa',
);
?>

<h1>Nueva Tarifa Activa</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>