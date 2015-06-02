
<h1>Administrar ordenes</h1>

<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Ordenes',
		'columnas'=>array(
			'id',
			'status.nombre',
			array(
				'name'=>'Paciente',
				'value'=>array($this, 'obtenerPaciente'),
				),
			'fecha_captura',
		),
		'buttonsTemplate'=>'{view} {rate}'
	)
); 

?>


		



