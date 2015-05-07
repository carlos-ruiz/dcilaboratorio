<?php
/* @var $this DoctoresController */
/* @var $model Doctores */
$this->breadcrumbs=array(
	'Doctores'=>array('admin'),
	'Administrar doctores',
);

$this->pageTitle="Doctores";
?>

<h1>Administrar doctores</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'doctores-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'name'=>'id_especialidades',
			'value'=>array($this, 'obtenerNombreEspecialidad'),
			),
		array(
			'name'=>'nombre',
			'value'=>array($this, 'obtenerNombreCompletoConTitulo'),
			),
		'correo_electronico',
		'id_usuarios',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
