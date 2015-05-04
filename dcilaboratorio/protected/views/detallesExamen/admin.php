<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */

$this->breadcrumbs=array(
	'Resultados de Examens'=>array('index'),
	'Administración',
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#detalles-examen-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Resultados de Exámenes</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detalles-examen-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_examenes',
		'descripcion',
		'id_unidades_medida',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
