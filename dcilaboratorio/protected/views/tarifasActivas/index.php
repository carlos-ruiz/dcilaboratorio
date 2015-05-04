<?php
/* @var $this TarifasActivasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tarifas Activases',
);

$this->menu=array(
	array('label'=>'Create TarifasActivas', 'url'=>array('create')),
	array('label'=>'Manage TarifasActivas', 'url'=>array('admin')),
);
?>

<h1>Tarifas Activases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
