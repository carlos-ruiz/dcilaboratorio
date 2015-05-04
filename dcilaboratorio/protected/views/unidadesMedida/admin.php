<?php
/* @var $this UnidadesMedidaController */
/* @var $model UnidadesMedida */

$this->breadcrumbs=array(
	'Unidades Medidas'=>array('index'),
	'Administración',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#unidades-medida-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Unidades Medidas</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'unidades-medida-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		'abreviatura',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
