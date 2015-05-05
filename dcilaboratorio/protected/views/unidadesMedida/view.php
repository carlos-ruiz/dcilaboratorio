<?php
/* @var $this UnidadesMedidaController */
/* @var $model UnidadesMedida */

$this->breadcrumbs=array(
	'Unidades Medidas'=>array('admin'),
	$model->id,
);
?>

<h1>Unidad de Medida: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'abreviatura'
	),
)); ?>
