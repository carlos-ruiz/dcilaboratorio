<?php
/* @var $this MultirangosController */
/* @var $model Multirangos */

?>
<h1> Multirango: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'rango_inferior',
		'rango_superior',
	),
)); ?>
