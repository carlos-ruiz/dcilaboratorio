<?php
/* @var $this DetallesExamenController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Detalles Examens',
);

$this->menu=array(
	array('label'=>'Create DetallesExamen', 'url'=>array('create')),
	array('label'=>'Manage DetallesExamen', 'url'=>array('admin')),
);
?>

<h1>Detalles Examens</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
