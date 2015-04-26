<?php
/* @var $this DoctoresController */
/* @var $model Doctores */

$this->breadcrumbs=array(
	'Doctores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Doctores', 'url'=>array('index')),
	array('label'=>'Create Doctores', 'url'=>array('create')),
	array('label'=>'Update Doctores', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Doctores', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Doctores', 'url'=>array('admin')),
);
?>

<h1>View Doctores #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'a_paterno',
		'a_materno',
		'correo_electronico',
		'hora_consulta_de',
		'hora_consulta_hasta',
		'porcentaje',
		'calle',
		'ciudad',
		'colonia',
		'estado',
		'codigo_postal',
		'numero_ext',
		'numero_int',
		'id_especialidades',
		'id_titulos',
		'id_usuarios',
		'ultima_edicion',
		'usuario_ultima_edicion',
		'creacion',
		'usuario_creacion',
	),
)); ?>
