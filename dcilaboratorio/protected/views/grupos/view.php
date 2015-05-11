<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */
?>

<h1>Grupo de examenes: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre'
	),
)); ?>


