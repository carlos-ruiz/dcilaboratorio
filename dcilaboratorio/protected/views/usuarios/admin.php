<h1>Administrar usuarios</h1>
<?php 
$columnas = array('perfil.nombre', 'usuario');
array_push($columnas, array(
				'header'=>'Contraseña',
				'value'=>array($this, 'obtenerContrasena'),
			));
array_push($columnas, array(
				'header'=>'Nombre',
				'value'=>array($this, 'obtenerNombre'),
			));
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Usuarios',
		'columnas'=>$columnas
	)
); 
?>

