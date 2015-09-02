<?php
/* @var $this ExamenesController */
/* @var $model Examenes */

?>

<h1>Administrar pacientes</h1>
<?php
$this->renderPartial(
	'/comunes/_comunAdmin',
	array(
		'model'=>$model,
		'titulo'=>'Pacientes',
		'columnas'=>array(
			'nombre',
			'a_paterno',
			'a_materno',
			'fecha_nacimiento',
			'telefono',
		),
		'buttonsTemplate'=>'{view} {update}'
	)
);