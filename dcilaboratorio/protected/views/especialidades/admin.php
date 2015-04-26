<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */

$this->pageTitle="Especialidades";
?>

<h1>Administrar especialidades</h1>

<?php echo CHtml::button('Nueva especialidad', array('class'=>'btn btn-sm green','submit'=>array('especialidades/create'))); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'especialidades-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		'ultima_edicion',
		'usuario_ultima_edicion',
		'creacion',
		'usuario_creacion',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
