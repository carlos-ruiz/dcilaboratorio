<?php
/* @var $this PalabrasClaveController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Palabras Claves',
);

$this->menu=array(
	array('label'=>'Create PalabrasClave', 'url'=>array('create')),
	array('label'=>'Manage PalabrasClave', 'url'=>array('admin')),
);
?>

<h1>Palabras Claves</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
