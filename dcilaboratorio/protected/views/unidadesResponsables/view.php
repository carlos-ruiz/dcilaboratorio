<?php
/* @var $this UnidadesResponsablesController */
/* @var $model UnidadesResponsables */

?>

<h1>Unidades Responsables: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'nombre',
		
	),
)); ?>
