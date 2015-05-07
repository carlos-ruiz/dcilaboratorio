<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */


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

<h1>Administrar resultados de exámenes</h1>
<?php echo CHtml::link('<i class="icon-plus"></i> Nuevo resultado de examen', array('detallesExamen/create'), array('class'=>'btn text-right')); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detalles-examen-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'examenes.nombre',
		'descripcion',
		'unidadesMedida.nombre',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
