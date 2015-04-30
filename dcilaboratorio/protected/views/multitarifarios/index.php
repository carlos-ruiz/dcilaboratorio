<?php
/* @var $this MultitarifariosController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Multitarifarioses',
);

$this->menu=array(
	array('label'=>'Create Multitarifarios', 'url'=>array('create')),
	array('label'=>'Manage Multitarifarios', 'url'=>array('admin')),
);
?>

<h1>Multitarifarioses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
