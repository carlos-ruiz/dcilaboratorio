<?php
/* @var $this ExamenesController */
/* @var $model Examenes */

?>

<h1>Administrar determinaciones</h1>
<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Determinaciones',
		'columnas'=>array(
			'clave',
			'nombre',
			'tecnica',
			'duracion_dias'
		)
	)
); 

