<h1>Administrar usuarios</h1>
<?php 
$columnas = array('usuario','perfil.nombre');
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

