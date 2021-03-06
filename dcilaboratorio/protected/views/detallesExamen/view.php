<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */

$this->breadcrumbs=array(
	'Resultado de Examens'=>array('admin'),
	$model->id,
);
?>

<h1>Resultado de examen: <?php echo $model->descripcion; ?></h1>
<div class="text-right">
	<?php echo CHtml::link('<i class="icon-plus"></i> Nueva configuración test', array('detallesExamen/create'), array('class'=>'btn')); ?>
</div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'examenes.nombre',
		'descripcion',
		'unidadesMedida.nombre',
		'rango_inferior',
		'rango_promedio',
		'rango_superior',		
	),
)); ?>
