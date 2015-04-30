<?php
/* @var $this UnidadesResponsablesController */
/* @var $model UnidadesResponsables */

$this->breadcrumbs=array(
	'Unidades Responsables'=>array('index'),
	'Nueva',
);
?>

<h1>Nueva Unidad Responsable</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>