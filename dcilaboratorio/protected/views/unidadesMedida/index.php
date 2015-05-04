<?php
/* @var $this UnidadesMedidaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Unidades Medidas',
);

$this->menu=array(
	array('label'=>'Create UnidadesMedida', 'url'=>array('create')),
	array('label'=>'Manage UnidadesMedida', 'url'=>array('admin')),
);
?>

<h1>Unidades Medidas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
