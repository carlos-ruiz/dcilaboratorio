<?php
/* @var $this PalabrasClaveController */
/* @var $model PalabrasClave */
?>

<h1>Palabra clave: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
