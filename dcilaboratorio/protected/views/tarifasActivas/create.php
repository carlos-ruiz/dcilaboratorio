<?php
/* @var $this TarifasActivasController */
/* @var $model TarifasActivas */

$this->breadcrumbs=array(
	'Tarifas Activases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TarifasActivas', 'url'=>array('index')),
	array('label'=>'Manage TarifasActivas', 'url'=>array('admin')),
);
?>

<h1>Create TarifasActivas</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>