<?php
/* @var $this UnidadesResponsablesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Unidades Responsables',
);
?>

<h1>Unidades Responsables</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
