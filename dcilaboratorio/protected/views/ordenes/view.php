<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */

$this->breadcrumbs=array(
	'Ordenes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Ordenes', 'url'=>array('index')),
	array('label'=>'Create Ordenes', 'url'=>array('create')),
	array('label'=>'Update Ordenes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Ordenes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ordenes', 'url'=>array('admin')),
);
?>

<h1>View Ordenes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'id',
		'id_doctores',
		'id_pacientes',
		'id_status',
		'id_unidades_responsables',
		'fecha_captura',
		'informacion_clinica_y_terapeutica',
		'comentarios',
		'requiere_factura',
		'descuento',
		'id_multitarifarios',
		'compartir_con_doctor',
		'ultima_edicion',
		'usuario_ultima_edicion',
		'creacion',
		'usuario_creacion',
	),
)); ?>
