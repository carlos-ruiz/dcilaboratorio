<?php
/* @var $this UsersController */
/* @var $model Users */


?>

<h1>Usuario #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'usuario',
		'contrasena',

	),
)); ?>
