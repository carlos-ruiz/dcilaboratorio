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
			'correo_electronico',
			
		)
	)
); 

?>
