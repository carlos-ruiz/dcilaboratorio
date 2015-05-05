<?php
/* @var $this UnidadesMedidaController */
/* @var $model UnidadesMedida */

$this->breadcrumbs=array(
	'Unidades Medidas'=>array('admin'),
	'Nueva',
);
?>

<h1>Nueva Unidad de Medida</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>