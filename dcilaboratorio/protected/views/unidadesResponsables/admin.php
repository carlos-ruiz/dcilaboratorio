<?php
/* @var $this UnidadesResponsablesController */
/* @var $model UnidadesResponsables */

?>

<h1>Administrar unidades responsables</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'unidades-responsables-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		/*
		'id_usuarios',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
