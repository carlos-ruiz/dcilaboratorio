
<h1>Administrar ordenes</h1>

<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'paciente'=>$paciente,
		'titulo'=>'Ordenes',
		'columnas'=>array(
			'id',
			'status.descripcion',
			'fecha_captura',
			array(	
				'name'=>'paciente',			
				'value'=>array($this, 'obtenerPaciente'),
			),
			
			)
	)
); 

?>


		



