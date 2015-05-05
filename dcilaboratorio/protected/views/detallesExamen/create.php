<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */

$this->breadcrumbs=array(
	'Resultados de Exámenes'=>array('admin'),
	'Nuevo',
);
?>

<h1>Nuevo Resultados de Exámenes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>