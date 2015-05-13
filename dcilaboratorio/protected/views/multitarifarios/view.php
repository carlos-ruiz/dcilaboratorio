<?php
/* @var $this MultitarifariosController */
/* @var $model Multitarifarios */

?>

<h1> Multitarifario: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'nombre',
		'descripcion'
	),
)); ?>
