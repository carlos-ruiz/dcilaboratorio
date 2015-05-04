<?php
/* @var $this DoctoresController */
/* @var $model Doctores */

$this->pageTitle="Doctores";

$this->breadcrumbs=array(
	'Doctores'=>array('admin'),
	'Doctor '.$model->id,
);
?>

<h1>Datos del doctor: <?php echo $model->nombre.' '.$model->a_paterno.' '.$model->a_materno; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
//		array(
//			'label'=>'Especialidad',
//			'type'=>'raw',
//			'value'=>'Hola',
//			),
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
	),
)); ?>
