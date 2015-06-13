<?php
/* @var $this UsersController */
/* @var $model Users */


?>

<h1>Usuario: <?php echo $model->usuario; ?></h1>
<?php
	$array = array(
		'id',
		'usuario',
		'perfil.nombre',
	);
	$perfilDoctor = Perfiles::model()->findByName("Doctor");
	$perfilPaciente = Perfiles::model()->findByName("Paciente");
	if ($model->perfil->id == $perfilPaciente->id) {
		$paciente = $model->ordenFacturacion->paciente;
		$nombre = $paciente->obtenerNombreCompleto();

		array_push($array, array(
			'label'=>'Nombre',
			'type'=>'raw',
			'value'=>$nombre,
			));
	}

	elseif ($model->perfil->id == $perfilDoctor->id) {
		$doctor = $model->doctor;
		$nombre = $doctor->obtenerNombreCompleto();

		array_push($array, array(
			'label'=>'Nombre',
			'type'=>'raw',
			'value'=>$nombre,
			));
	}
	
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped table-bordered dataTable'),
	'attributes'=>$array,
)); ?>
