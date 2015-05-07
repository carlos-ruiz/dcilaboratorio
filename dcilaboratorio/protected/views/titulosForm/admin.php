<?php
/* @var $this TitulosFormController */
/* @var $model TitulosForm */

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

<h1>Administrar títulos</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'titulos-form-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',			
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
