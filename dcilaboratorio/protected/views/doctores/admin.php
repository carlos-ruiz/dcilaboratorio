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
			'id',
			'especialidad.nombre',
			array(
				'name'=>'nombre',
				'value'=>array($this, 'obtenerNombreCompletoConTitulo'),
			),
			'correo_electronico',
			'id_usuarios'
		)
	)
); 

?>
