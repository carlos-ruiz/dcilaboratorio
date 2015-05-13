<?php
/* @var $this TitulosFormController */
/* @var $model TitulosForm */

?>

<h1>Título: <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'nombre'
	),
)); ?>
