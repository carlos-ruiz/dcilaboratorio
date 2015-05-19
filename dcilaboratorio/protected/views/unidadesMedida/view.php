<?php
/* @var $this UnidadesMedidaController */
/* @var $model UnidadesMedida */

?>

<h1>Unidad de medida: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'nombre',
		'abreviatura'
	),
)); ?>
