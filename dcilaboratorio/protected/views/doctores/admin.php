<?php
/* @var $this DoctoresController */
/* @var $model Doctores */
?>

<h1>Administrar doctores</h1>

<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Doctores',
		'columnas'=>array(
			'especialidades.nombre',
			array(
				'name'=>'nombre',
				'value'=>array($this, 'obtenerNombreCompletoConTitulo'),
			),
			array(
				'name'=>'Tel. consultorio',
				'value'=>array($this, 'obtenerTelefonoConsultorio'),
			),
			array(
				'name'=>'Tel. casa',
				'value'=>array($this, 'obtenerTelefonoCasa'),
			),
			array(
				'name'=>'Tel. celular',
				'value'=>array($this, 'obtenerTelefonoCelular'),
			),
			'correo_electronico',
		)
	)
); 

?>
