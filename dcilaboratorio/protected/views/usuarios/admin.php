<h1>Administrar usuarios</h1>
<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Usuarios',
		'columnas'=>array('usuario')
	)
); 
?>
