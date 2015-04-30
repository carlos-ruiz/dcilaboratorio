<?php
/* @var $this TitulosFormController */
/* @var $model TitulosForm */

$this->breadcrumbs=array(
	'Titulos'=>array('index'),
	'Administración',
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#titulos-form-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar de Títulos</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'titulos-form-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
			
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
