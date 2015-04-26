<?php
/* @var $this DoctoresController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Doctores',
);

$this->menu=array(
	array('label'=>'Create Doctores', 'url'=>array('create')),
	array('label'=>'Manage Doctores', 'url'=>array('admin')),
);
?>

<h1>Doctores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
