<?php
/* @var $this UnidadesResponsablesController */
/* @var $model UnidadesResponsables */

?>

<h1>Administrar unidades responsables</h1>

<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Unidades responsables',
		'columnas'=>array('nombre')
	)
); 
?>


