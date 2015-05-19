<?php
/* @var $this MultitarifariosController */
/* @var $model Multitarifarios */

?>

<h1>Administrar  multitarifarios</h1>

<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Multitarifarios',
		'columnas'=>array(
			'nombre',
			'descripcion'
		)
	)
); 
?>

