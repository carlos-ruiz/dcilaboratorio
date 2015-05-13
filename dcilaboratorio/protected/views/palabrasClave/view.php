<?php
/* @var $this PalabrasClaveController */
/* @var $model PalabrasClave */
?>

<h1>Palabra clave: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
