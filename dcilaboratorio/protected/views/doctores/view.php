<?php
/* @var $this DoctoresController */
/* @var $model Doctores */

?>

<h1>Doctor: <?php echo $model->nombre.' '.$model->a_paterno.' '.$model->a_materno; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>array(
		'usuarios.usuario',
		'titulos.nombre',
		'nombre',
		'a_paterno',
		'a_materno',
		'especialidades.nombre',
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
	),
)); ?>
