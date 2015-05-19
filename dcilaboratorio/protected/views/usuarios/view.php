<?php
/* @var $this UsersController */
/* @var $model Users */


?>

<h1>Usuario: <?php echo $model->usuario; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'usuario',

	),
)); ?>
