<?php
/* @var $this UnidadesResponsablesController */
/* @var $model UnidadesResponsables */

$this->breadcrumbs=array(
	'Unidades Responsables'=>array('admin'),
	$model->id,
);
?>

<h1>Unidades Responsables: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'id_usuarios',
	),
)); ?>
