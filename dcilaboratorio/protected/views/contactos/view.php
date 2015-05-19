<?php
/* @var $this ContactosController */
/* @var $model Contactos */

$this->breadcrumbs=array(
	'Contactoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Contactos', 'url'=>array('index')),
	array('label'=>'Create Contactos', 'url'=>array('create')),
	array('label'=>'Update Contactos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Contactos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Contactos', 'url'=>array('admin')),
);
?>

<h1>View Contactos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'contacto',
		'id_tipos_contacto',
		'ultima_edicion',
		'usuario_ultima_edicion',
		'creacion',
		'usuario_creacion',
		'id_persona',
		'id_perfiles',
	),
)); ?>
