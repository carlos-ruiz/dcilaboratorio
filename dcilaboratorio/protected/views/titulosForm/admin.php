<?php
/* @var $this TitulosFormController */
/* @var $model TitulosForm */

?>

<h1>Administrar títulos</h1>
<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'T&iacute;tulos',
		'columnas'=>array(
			'nombre'
		)
	)
); 
?>

