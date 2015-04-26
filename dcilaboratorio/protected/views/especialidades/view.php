<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */

$this->pageTitle="Especialidades";
?>

<h1>View Especialidades #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'ultima_edicion',
		'usuario_ultima_edicion',
		'creacion',
		'usuario_creacion',
	),
)); ?>
