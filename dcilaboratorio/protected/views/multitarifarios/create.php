<?php
/* @var $this MultitarifariosController */
/* @var $model Multitarifarios */

$this->breadcrumbs=array(
	'Multitarifarios'=>array('admin'),
	'Nuevo',
);

?>

<h1>Nuevo Multitarifario</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>