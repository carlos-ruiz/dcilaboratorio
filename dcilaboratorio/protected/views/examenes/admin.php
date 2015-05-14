<?php
/* @var $this ExamenesController */
/* @var $model Examenes */

?>

<h1>Administrar exámenes</h1>
<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Exámenes',
		'columnas'=>array(
			'clave',
			'nombre',
			'duracion_dias'
		)
	)
); 

