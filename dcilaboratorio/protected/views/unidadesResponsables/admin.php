<?php
/* @var $this UnidadesResponsablesController */
/* @var $model UnidadesResponsables */

$this->breadcrumbs=array(
	'Unidades Responsables'=>array('admin'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#unidades-responsables-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Unidades Responsables</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'unidades-responsables-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		/*
		'id_usuarios',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
