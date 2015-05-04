<?php
/* @var $this DoctoresController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle="Doctores";

$this->breadcrumbs=array(
	'Doctores',
);
?>

<h1>Doctores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
