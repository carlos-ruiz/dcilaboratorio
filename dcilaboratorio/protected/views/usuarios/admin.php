<?php
/* @var $this UsersController */
/* @var $model Users */

$this->pageTitle="Usuarios";

?>

<h1>Administrar Usuarios</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'usuario',
		'contrasena',
		/*
		'photo',
		'log',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
