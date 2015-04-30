<?php
/* @var $this TitulosFormController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle="Titulo";
$this->breadcrumbs=array(
	'Titulos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Create TitulosForm', 'url'=>array('create')),
	array('label'=>'Manage TitulosForm', 'url'=>array('admin')),
);
?>

<h1>Titulos Forms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
