<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */

?>

<h1>Especialidad: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
